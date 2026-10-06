(function (root) {
    'use strict';

    function normalize(script) {
        if (!script || !Array.isArray(script.actions) || !script.actions.length) {
            throw new Error('Invalid funscript.');
        }
        var actions = script.actions.map(function (action) {
            if (!action || !Number.isSafeInteger(action.at) || action.at < 0 || !Number.isFinite(action.pos) || action.pos < 0 || action.pos > 100) {
                throw new Error('Invalid funscript action.');
            }
            return {at: action.at, pos: action.pos};
        }).sort(function (a, b) { return a.at - b.at; });
        return actions.filter(function (action, index) {
            return index === actions.length - 1 || action.at !== actions[index + 1].at;
        });
    }

    function sample(actions, time, rate) {
        if (!Number.isFinite(time) || !Number.isFinite(rate) || rate <= 0 || time < actions[0].at || time >= actions[actions.length - 1].at) {
            return null;
        }
        var low = 0;
        var high = actions.length;
        while (low < high) {
            var middle = Math.floor((low + high) / 2);
            if (actions[middle].at <= time) {
                low = middle + 1;
            } else {
                high = middle;
            }
        }
        var previous = actions[low - 1];
        var next = actions[low];
        // Short, finite movements also bound travel if the browser is suspended.
        var until = Math.min(next.at, time + 200 * rate);
        var position = previous.pos + (next.pos - previous.pos) * (until - previous.at) / (next.at - previous.at);
        return {position: position / 100, duration: Math.max(1, Math.round((until - time) / rate)), until: until};
    }

    function limitPosition(position, settings) {
        var min = Number.isFinite(settings.strokeMin) ? Math.max(0, Math.min(100, settings.strokeMin)) : 0;
        var max = Number.isFinite(settings.strokeMax) ? Math.max(min, Math.min(100, settings.strokeMax)) : 100;
        var speed = Number.isFinite(settings.speedLimit) ? Math.max(min, Math.min(100, settings.speedLimit)) : 100;
        var level = min + Math.max(0, Math.min(1, position)) * (max - min);
        // Match the output ceiling used by FapTap's Bluetooth / Intiface controls.
        level = Math.min(level, speed);
        return (settings.inverted ? 100 - level : level) / 100;
    }

    class Synchronizer {
        constructor(actions, device, onError) {
            this.actions = actions;
            this.device = device;
            this.onError = onError;
            this.inverted = false;
            this.strokeMin = 0;
            this.strokeMax = 100;
            this.speedLimit = 100;
            this.offset = 0;
            this.due = -Infinity;
            this.busy = false;
            this.moving = false;
            this.closed = false;
            this.pending = Promise.resolve();
            this.lastSent = -Infinity;
        }

        tick(time, rate, running) {
            if (this.closed) {
                return;
            }
            var command = running ? sample(this.actions, time * 1000 + this.offset, rate) : null;
            if (!command) {
                this.stop();
                return;
            }
            if (this.busy || time * 1000 + this.offset < this.due || Date.now() - this.lastSent < (this.device.timingGap || 0)) {
                return;
            }
            this.due = command.until;
            this.busy = true;
            this.moving = true;
            this.lastSent = Date.now();
            var pending = Promise.resolve().then(() => {
                if (!this.closed && this.moving) {
                    return this.device.move(limitPosition(command.position, this), command.duration);
                }
            }).catch(error => {
                this.closed = true;
                this.onError(error);
            }).finally(() => {
                if (this.pending === pending) {
                    this.busy = false;
                }
            });
            this.pending = pending;
        }

        stop() {
            this.due = -Infinity;
            if (!this.moving) {
                return this.pending;
            }
            this.moving = false;
            this.busy = true;
            // Stop follows the in-flight write; no old movement may overtake it.
            var pending = this.pending.then(() => this.device.stop()).catch(error => {
                this.closed = true;
                this.onError(error);
            }).finally(() => {
                if (this.pending === pending) {
                    this.busy = false;
                }
            });
            this.pending = pending;
            return this.pending;
        }

        close() {
            this.closed = true;
            return this.stop();
        }
    }

    // Keon GATT layout and position/speed mapping documented by Buttplug:
    // https://github.com/buttplugio/buttplug/tree/master/crates/buttplug_server/src/device/protocol_impl
    class Keon {
        constructor(onDisconnect) {
            this.onDisconnect = onDisconnect;
            this.device = null;
            this.characteristic = null;
            this.position = 0;
            this.timingGap = 50;
            this.keepalive = null;
            this.packet = null;
            this.writing = false;
            this.closed = false;
            this.queue = Promise.resolve();
        }

        async connect() {
            if (!root.isSecureContext || !root.navigator.bluetooth) {
                throw new Error('Bluetooth requires HTTPS and Web Bluetooth (Chrome or Edge). You can also use Intiface.');
            }
            // requestDevice must run directly inside the user's click handler.
            this.device = await root.navigator.bluetooth.requestDevice({
                filters: [{name: 'KEON'}, {name: 'Keon R2'}, {name: 'KEON WIFI'}, {name: 'Keon Wifi'}, {name: 'KEON2'}],
                optionalServices: [0x1900, 0x1400]
            });
            if (this.closed) {
                throw new Error('Connection cancelled.');
            }
            this.device.addEventListener('gattserverdisconnected', () => {
                clearInterval(this.keepalive);
                this.characteristic = null;
                this.onDisconnect();
            });
            try {
                var server = await this.device.gatt.connect();
                var newer = ['KEON WIFI', 'Keon Wifi', 'KEON2'].includes(this.device.name);
                var service = await server.getPrimaryService(this.device.name === 'KEON2' ? 0x1400 : 0x1900);
                this.characteristic = await service.getCharacteristic(this.device.name === 'KEON2' ? 0x1801 : (newer ? 0x1800 : 0x1902));
                if (this.closed) {
                    throw new Error('Connection cancelled.');
                }
                if (!newer) {
                    await this.write(new Uint8Array([3, 0, 100, 25]), true);
                    await this.write(new Uint8Array([3, 0, 100, 0]), true);
                }
                this.keepalive = setInterval(() => {
                    if (!this.writing && this.packet && !this.closed) {
                        this.write(null).catch(() => this.disconnect());
                    }
                }, 2000);
            } catch (error) {
                this.disconnect();
                throw error;
            }
        }

        write(packet, response) {
            this.queue = this.queue.then(async () => {
                if (!this.characteristic || !this.device.gatt.connected || this.closed) {
                    throw new Error('Bluetooth device disconnected.');
                }
                // Resolve keepalive data after earlier writes, never replay an old target.
                packet = packet || this.packet;
                this.writing = true;
                var timer;
                try {
                    var write = !response && this.characteristic.properties.writeWithoutResponse
                        ? this.characteristic.writeValueWithoutResponse(packet)
                        : this.characteristic.writeValueWithResponse(packet);
                    await Promise.race([write, new Promise((resolve, reject) => {
                        timer = setTimeout(() => reject(new Error('Bluetooth write timed out.')), 2500);
                    })]);
                    this.packet = packet;
                } catch (error) {
                    this.disconnect();
                    throw error;
                } finally {
                    clearTimeout(timer);
                    this.writing = false;
                }
            });
            return this.queue;
        }

        async move(position, duration) {
            var target = Math.round(Math.max(0, Math.min(1, position)) * 99);
            var distance = Math.abs(target - this.position) / 99;
            var speed = distance === 0 ? 0 : Math.min(99, Math.floor(250 * Math.pow(duration * 90 / (distance * 100), -1.05) * 99));
            await this.write(new Uint8Array([3, 0, speed, target]));
            this.position = target;
        }

        async stop() {
            // Keon has no independent emergency-stop opcode; cancel further movement
            // and replace its speed with zero. Scheduled movements are at most 200ms.
            if (this.characteristic && !this.closed) {
                await this.write(new Uint8Array([3, 0, 0, this.position]));
            }
        }

        disconnect() {
            this.closed = true;
            clearInterval(this.keepalive);
            if (this.device && this.device.gatt.connected) {
                this.device.gatt.disconnect();
            }
            this.characteristic = null;
        }
    }

    // Intiface negotiates the documented Buttplug v3 JSON protocol over WebSocket.
    // https://buttplug.io/docs/spec-v3/
    class Intiface {
        constructor(onDevices, onDisconnect, socketFactory) {
            this.onDevices = onDevices;
            this.onDisconnect = onDisconnect;
            this.socketFactory = socketFactory || (address => new root.WebSocket(address));
            this.socket = null;
            this.devices = new Map();
            this.requests = new Map();
            this.id = 0;
            this.ping = null;
            this.scanTimer = null;
            this.scanning = false;
            this.scanPending = null;
            this.closed = false;
        }

        async connect(address) {
            var url = new URL(address);
            if (!['ws:', 'wss:'].includes(url.protocol) || url.username || url.password) {
                throw new Error('Enter a ws:// or wss:// Intiface server address.');
            }
            this.socket = this.socketFactory(url.href);
            this.socket.addEventListener('message', event => this.receive(event.data));
            this.socket.addEventListener('close', () => this.disconnected());
            try {
                await new Promise((resolve, reject) => {
                    var timer = setTimeout(() => reject(new Error('Intiface connection timed out.')), 8000);
                    var finish = error => {
                        clearTimeout(timer);
                        error ? reject(error) : resolve();
                    };
                    this.socket.addEventListener('open', () => finish());
                    this.socket.addEventListener('error', () => finish(new Error('Cannot connect to Intiface. Check its server address and browser network permissions.')));
                    this.socket.addEventListener('close', () => finish(new Error('Intiface disconnected.')));
                });
                var server = await this.request('RequestServerInfo', {ClientName: 'ClipBucket', MessageVersion: 3}, 'ServerInfo');
                if (server.MessageVersion !== 3) {
                    throw new Error('Intiface must support Buttplug protocol v3.');
                }
                if (server.MaxPingTime > 0) {
                    this.ping = setInterval(() => {
                        this.request('Ping').catch(() => this.disconnect());
                    }, Math.max(1, Math.floor(server.MaxPingTime / 2)));
                }
                var list = await this.request('RequestDeviceList', {}, 'DeviceList');
                list.Devices.forEach(device => this.devices.set(device.DeviceIndex, device));
                this.onDevices(Array.from(this.devices.values()));
            } catch (error) {
                this.disconnect();
                throw error;
            }
        }

        request(type, data, expected) {
            if (this.closed || !this.socket || this.socket.readyState !== 1) {
                return Promise.reject(new Error('Intiface disconnected.'));
            }
            var id = ++this.id;
            return new Promise((resolve, reject) => {
                var timer = setTimeout(() => {
                    this.requests.delete(id);
                    reject(new Error('Intiface did not acknowledge ' + type + '.'));
                }, 5000);
                this.requests.set(id, {resolve: resolve, reject: reject, timer: timer, expected: expected || 'Ok'});
                try {
                    this.socket.send(JSON.stringify([{[type]: Object.assign({}, data, {Id: id})}]));
                } catch (error) {
                    clearTimeout(timer);
                    this.requests.delete(id);
                    reject(error);
                }
            });
        }

        receive(data) {
            try {
                var messages = JSON.parse(data);
                messages.forEach(message => {
                    var type = Object.keys(message)[0];
                    var body = message[type];
                    var request = this.requests.get(body.Id);
                    if (request) {
                        clearTimeout(request.timer);
                        this.requests.delete(body.Id);
                        if (type === request.expected) {
                            request.resolve(body);
                        } else {
                            request.reject(new Error(type === 'Error' ? body.ErrorMessage : 'Unexpected Intiface response: ' + type));
                        }
                    } else if (type === 'ScanningFinished') {
                        this.scanning = false;
                        clearTimeout(this.scanTimer);
                    } else if (type === 'DeviceAdded' || type === 'DeviceRemoved') {
                        if (type === 'DeviceAdded') {
                            this.devices.set(body.DeviceIndex, body);
                        } else {
                            this.devices.delete(body.DeviceIndex);
                        }
                        this.onDevices(Array.from(this.devices.values()));
                    }
                });
            } catch (error) {
                this.disconnect();
            }
        }

        async scan() {
            if (this.scanning || this.scanPending) {
                return this.scanPending;
            }
            this.scanning = true;
            this.scanPending = this.request('StartScanning').then(() => {
                if (this.closed || !this.scanning) {
                    return;
                }
                this.scanTimer = setTimeout(() => {
                    this.request('StopScanning').then(() => {
                        this.scanning = false;
                    }).catch(() => this.disconnect());
                }, 20000);
            }).catch(error => {
                this.scanning = false;
                throw error;
            }).finally(() => { this.scanPending = null; });
            return this.scanPending;
        }

        device(info) {
            var messages = info.DeviceMessages || {};
            var linear = messages.LinearCmd || [];
            var scalar = (messages.ScalarCmd || []).map((item, index) => ({index: index, type: item.ActuatorType}))
                .filter(item => ['Vibrate', 'Oscillate'].includes(item.type));
            var rotate = messages.RotateCmd || [];
            if (!linear.length && !scalar.length && !rotate.length) {
                return null;
            }
            return {
                timingGap: info.DeviceMessageTimingGap || 0,
                move: (position, duration) => {
                    if (linear.length) {
                        return this.request('LinearCmd', {
                            DeviceIndex: info.DeviceIndex,
                            Vectors: linear.map((item, index) => ({Index: index, Duration: duration, Position: position}))
                        });
                    }
                    if (scalar.length) {
                        return this.request('ScalarCmd', {
                            DeviceIndex: info.DeviceIndex,
                            Scalars: scalar.map(item => ({Index: item.index, Scalar: position, ActuatorType: item.type}))
                        });
                    }
                    return this.request('RotateCmd', {
                        DeviceIndex: info.DeviceIndex,
                        Rotations: rotate.map((item, index) => ({Index: index, Speed: position, Clockwise: true}))
                    });
                },
                stop: () => this.request('StopDeviceCmd', {DeviceIndex: info.DeviceIndex})
            };
        }

        disconnected() {
            if (this.closed) {
                return;
            }
            this.closed = true;
            clearInterval(this.ping);
            clearTimeout(this.scanTimer);
            this.scanning = false;
            this.requests.forEach(request => {
                clearTimeout(request.timer);
                request.reject(new Error('Intiface disconnected.'));
            });
            this.requests.clear();
            this.devices.clear();
            this.onDisconnect();
        }

        disconnect() {
            if (this.socket) {
                this.socket.close();
            }
            this.disconnected();
        }
    }

    var api = {normalize: normalize, sample: sample, limitPosition: limitPosition, Synchronizer: Synchronizer, Keon: Keon, Intiface: Intiface};
    if (typeof module !== 'undefined' && module.exports) {
        module.exports = api;
    } else {
        root.CBFunscript = api;
    }
})(typeof window !== 'undefined' ? window : globalThis);
