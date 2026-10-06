const assert = require('node:assert/strict');
const {test} = require('node:test');
const {normalize, sample, limitPosition, Synchronizer, Keon, Intiface} = require('../../upload/styles/cb_28/theme/js/pages/watch_video/funscript.js');

const actions = normalize({actions: [{at: 1000, pos: 0}, {at: 2000, pos: 100}, {at: 3000, pos: 0}]});
const flush = () => new Promise(resolve => setImmediate(resolve));

test('validates actions, sorts them and keeps the last duplicate timestamp', () => {
    assert.deepEqual(normalize({actions: [{at: 20, pos: 0}, {at: 0, pos: 50}, {at: 20, pos: 100}]}), [{at: 0, pos: 50}, {at: 20, pos: 100}]);
    for (const action of [{at: -1, pos: 10}, {at: 0, pos: 101}, {at: 0, pos: NaN}, {at: '0', pos: 10}, {at: 1.5, pos: 10}]) {
        assert.throws(() => normalize({actions: [action]}), /Invalid/);
    }
    assert.throws(() => normalize({actions: []}), /Invalid/);
});

test('samples the video clock, limits travel to 200ms and accounts for playback speed', () => {
    assert.equal(sample(actions, 999, 1), null);
    assert.equal(sample(actions, 3000, 1), null);
    assert.equal(sample(actions, 1500, 0), null);
    assert.deepEqual(sample(actions, 1500, 1), {position: 0.7, duration: 200, until: 1700});
    assert.deepEqual(sample(actions, 1500, 2), {position: 0.9, duration: 200, until: 1900});
    assert.deepEqual(sample(actions, 1950, 0.5), {position: 1, duration: 100, until: 2000});
});

test('pause before a queued write cancels movement', async () => {
    const calls = [];
    const sync = new Synchronizer(actions, {move: () => calls.push('move'), stop: () => calls.push('stop')}, assert.fail);
    sync.tick(1, 1, true);
    await sync.stop();
    assert.deepEqual(calls, ['stop']);
    sync.tick(1.1, 1, false);
    await flush();
    assert.deepEqual(calls, ['stop']);
});

test('stroke maps the full script into the configured range', () => {
    const settings = {strokeMin: 25, strokeMax: 60, speedLimit: 100};
    assert.equal(limitPosition(0, settings), 0.25);
    assert.equal(limitPosition(0.5, settings), 0.425);
    assert.equal(limitPosition(1, settings), 0.6);
    assert.equal(limitPosition(0, {...settings, inverted: true}), 0.75);
    assert.equal(limitPosition(1, {...settings, inverted: true}), 0.4);
});

test('speed limit caps the mapped output before inversion, as on FapTap', () => {
    const settings = {strokeMin: 20, strokeMax: 80, speedLimit: 50};
    assert.equal(limitPosition(0, settings), 0.2);
    assert.equal(limitPosition(1, settings), 0.5);
    assert.equal(limitPosition(1, {...settings, inverted: true}), 0.5);
    assert.equal(limitPosition(1, {...settings, speedLimit: 10}), 0.2);
    assert.equal(limitPosition(1, {strokeMin: 0, strokeMax: 100, speedLimit: 0}), 0);
    assert.equal(limitPosition(0.5, {strokeMin: -10, strokeMax: 200, speedLimit: 200}), 0.5);
    assert.equal(limitPosition(1, {strokeMin: 60, strokeMax: 20, speedLimit: 100}), 0.6);
});

test('live settings replace pending targets without changing video timing', async () => {
    const calls = [];
    const sync = new Synchronizer(actions, {move: (pos, ms) => calls.push([pos, ms]), stop: () => calls.push('stop')}, assert.fail);
    sync.tick(1.5, 1, true);
    const stopped = sync.stop();
    Object.assign(sync, {strokeMin: 25, strokeMax: 75, speedLimit: 40, inverted: true});
    await stopped;
    assert.deepEqual(calls, ['stop']);
    sync.tick(1.5, 1, true);
    await sync.pending;
    assert.deepEqual(calls[1], [0.6, 200]);
    assert.equal(sync.due, 1700);
    await sync.close();
});

test('in-flight move and stop are serialized, including immediate resume', async () => {
    const calls = [];
    let finishMove;
    let finishStop;
    const sync = new Synchronizer(actions, {
        move: () => { calls.push('move'); return new Promise(resolve => { finishMove = resolve; }); },
        stop: () => { calls.push('stop'); return new Promise(resolve => { finishStop = resolve; }); }
    }, assert.fail);
    sync.tick(1, 1, true);
    await flush();
    const stopped = sync.stop();
    sync.tick(1.5, 1, true);
    assert.deepEqual(calls, ['move']);
    finishMove();
    await flush();
    sync.tick(1.5, 1, true);
    assert.deepEqual(calls, ['move', 'stop']);
    finishStop();
    await stopped;
    sync.tick(1.5, 1, true);
    await flush();
    assert.deepEqual(calls, ['move', 'stop', 'move']);
    finishMove();
    await sync.pending;
});

test('seek, inversion, offset, end of script and disposal', async () => {
    const calls = [];
    const sync = new Synchronizer(actions, {move: (pos, ms) => calls.push([pos, ms]), stop: () => calls.push('stop')}, assert.fail);
    sync.tick(2.5, 1, true);
    await sync.pending;
    assert.deepEqual(calls[0], [0.3, 200]);
    await sync.stop();
    sync.inverted = true;
    sync.offset = 100;
    sync.tick(1, 1, true);
    await sync.pending;
    assert.deepEqual(calls[2], [0.7, 200]);
    sync.tick(4, 1, true);
    await sync.pending;
    assert.equal(calls[3], 'stop');
    await sync.close();
    sync.tick(1, 1, true);
    await flush();
    assert.equal(calls.length, 4);
});

test('write failure disables further synchronization', async () => {
    let errors = 0;
    let moves = 0;
    const sync = new Synchronizer(actions, {move: () => { moves++; throw new Error('gone'); }, stop: () => {}}, () => errors++);
    sync.tick(1, 1, true);
    await sync.pending;
    sync.tick(2, 1, true);
    assert.equal(moves, 1);
    assert.equal(errors, 1);
});

class FakeSocket extends EventTarget {
    constructor() {
        super();
        this.readyState = 0;
        this.sent = [];
        this.respond = true;
        queueMicrotask(() => { this.readyState = 1; this.dispatchEvent(new Event('open')); });
    }

    receive(type, body) {
        this.dispatchEvent(Object.assign(new Event('message'), {data: JSON.stringify([{[type]: body}])}));
    }

    send(data) {
        const message = JSON.parse(data)[0];
        this.sent.push(message);
        if (!this.respond) return;
        const type = Object.keys(message)[0];
        const Id = message[type].Id;
        queueMicrotask(() => {
            if (type === 'RequestServerInfo') this.receive('ServerInfo', {Id, MessageVersion: 3, MaxPingTime: 10000});
            else if (type === 'RequestDeviceList') this.receive('DeviceList', {Id, Devices: []});
            else this.receive('Ok', {Id});
        });
    }

    close() {
        this.readyState = 3;
        this.dispatchEvent(new Event('close'));
    }
}

test('Intiface negotiates v3, discovers devices and sends correct Keon vectors', async () => {
    let socket;
    let found;
    let disconnected = false;
    const client = new Intiface(list => { found = list; }, () => { disconnected = true; }, () => (socket = new FakeSocket()));
    await client.connect('ws://127.0.0.1:12345');
    try {
        assert.equal(socket.sent[0].RequestServerInfo.MessageVersion, 3);
        const info = {Id: 0, DeviceIndex: 7, DeviceName: 'Keon', DeviceMessages: {LinearCmd: [{StepCount: 99}]}};
        socket.receive('DeviceAdded', info);
        assert.equal(found[0].DeviceName, 'Keon');
        const device = client.device(info);
        await device.move(0.75, 200);
        const command = socket.sent.at(-1).LinearCmd;
        assert.equal(command.DeviceIndex, 7);
        assert.deepEqual(command.Vectors, [{Index: 0, Duration: 200, Position: 0.75}]);
        await device.stop();
        assert.equal(socket.sent.at(-1).StopDeviceCmd.DeviceIndex, 7);
        await client.scan();
        assert.ok(socket.sent.at(-1).StartScanning);
        socket.receive('DeviceRemoved', {Id: 0, DeviceIndex: 7});
        assert.deepEqual(found, []);
    } finally {
        client.disconnect();
    }
    assert.equal(disconnected, true);
    assert.equal(client.requests.size, 0);
});

test('Intiface rejects server errors and pending requests on connection loss', async () => {
    let socket;
    const client = new Intiface(() => {}, () => {}, () => (socket = new FakeSocket()));
    await client.connect('ws://localhost:12345');
    socket.respond = false;
    const rejected = client.request('StopDeviceCmd', {DeviceIndex: 9});
    socket.receive('Error', {Id: socket.sent.at(-1).StopDeviceCmd.Id, ErrorMessage: 'Device removed'});
    await assert.rejects(rejected, /Device removed/);
    const pending = client.request('Ping');
    client.disconnect();
    await assert.rejects(pending, /disconnected/);
    assert.equal(client.requests.size, 0);
});

test('stroke, speed limit and inversion reach the Intiface linear command', async () => {
    let socket;
    const client = new Intiface(() => {}, () => {}, () => (socket = new FakeSocket()));
    await client.connect('ws://localhost:12345');
    const device = client.device({DeviceIndex: 3, DeviceMessages: {LinearCmd: [{}]}});
    const sync = new Synchronizer(actions, device, assert.fail);
    try {
        Object.assign(sync, {strokeMin: 10, strokeMax: 60, speedLimit: 40, inverted: true});
        sync.tick(1.5, 1, true);
        await sync.pending;
        assert.deepEqual(socket.sent.at(-1).LinearCmd.Vectors, [{Index: 0, Duration: 200, Position: 0.6}]);
    } finally {
        await sync.close();
        client.disconnect();
    }
});

test('stroke and speed limit reach the direct Bluetooth position packet', async () => {
    const packets = [];
    const keon = new Keon(() => {});
    keon.device = {gatt: {connected: true}};
    keon.characteristic = {
        properties: {writeWithoutResponse: true},
        writeValueWithoutResponse: async value => packets.push(Array.from(value))
    };
    const sync = new Synchronizer(actions, keon, assert.fail);
    Object.assign(sync, {strokeMin: 25, strokeMax: 75, speedLimit: 40});
    sync.tick(1.5, 1, true);
    await sync.pending;
    assert.equal(packets[0][3], Math.round(0.4 * 99));
    await sync.close();
});

test('Intiface preserves scalar feature indexes and rejects unsupported devices', async () => {
    let socket;
    const client = new Intiface(() => {}, () => {}, () => (socket = new FakeSocket()));
    await client.connect('ws://localhost:12345');
    try {
        const device = client.device({DeviceIndex: 3, DeviceMessages: {ScalarCmd: [{ActuatorType: 'Inflate'}, {ActuatorType: 'Vibrate'}]}});
        await device.move(0.4, 100);
        assert.deepEqual(socket.sent.at(-1).ScalarCmd.Scalars, [{Index: 1, Scalar: 0.4, ActuatorType: 'Vibrate'}]);
        assert.equal(client.device({DeviceMessages: {}}), null);
    } finally {
        client.disconnect();
    }
});

test('repeated Intiface scans reuse the active scan and allow a new scan after completion', async () => {
    let socket;
    const client = new Intiface(() => {}, () => {}, () => (socket = new FakeSocket()));
    await client.connect('ws://localhost:12345');
    try {
        await Promise.all([client.scan(), client.scan()]);
        await client.scan();
        assert.equal(socket.sent.filter(message => message.StartScanning).length, 1);
        socket.receive('ScanningFinished', {Id: 0});
        await client.scan();
        assert.equal(socket.sent.filter(message => message.StartScanning).length, 2);
    } finally {
        client.disconnect();
    }
});

test('Keon keepalive repeats the latest completed write instead of a queued old target', async () => {
    const packets = [];
    const keon = new Keon(() => {});
    keon.device = {gatt: {connected: true}};
    keon.characteristic = {
        properties: {writeWithoutResponse: true},
        writeValueWithoutResponse: async value => packets.push(Array.from(value))
    };
    keon.packet = new Uint8Array([3, 0, 50, 99]);
    const stop = keon.stop();
    const keepalive = keon.write(null);
    await Promise.all([stop, keepalive]);
    assert.deepEqual(packets, [[3, 0, 0, 0], [3, 0, 0, 0]]);
});

test('Keon GATT discovery, initialization, position packet and disconnect', async () => {
    const previousNavigator = Object.getOwnPropertyDescriptor(globalThis, 'navigator');
    const previousSecure = globalThis.isSecureContext;
    const packets = [];
    const characteristic = {
        properties: {writeWithoutResponse: true},
        writeValueWithResponse: async value => packets.push(Array.from(value)),
        writeValueWithoutResponse: async value => packets.push(Array.from(value))
    };
    const hardware = new EventTarget();
    hardware.name = 'KEON';
    hardware.gatt = {
        connected: false,
        connect: async () => {
            hardware.gatt.connected = true;
            return {getPrimaryService: async uuid => {
                assert.equal(uuid, 0x1900);
                return {getCharacteristic: async uuid => { assert.equal(uuid, 0x1902); return characteristic; }};
            }};
        },
        disconnect: () => { hardware.gatt.connected = false; hardware.dispatchEvent(new Event('gattserverdisconnected')); }
    };
    Object.defineProperty(globalThis, 'navigator', {configurable: true, value: {bluetooth: {requestDevice: async options => {
        assert.ok(options.filters.some(filter => filter.name === 'KEON'));
        return hardware;
    }}}});
    globalThis.isSecureContext = true;
    let disconnected = false;
    const keon = new Keon(() => { disconnected = true; });
    try {
        await keon.connect();
        assert.deepEqual(packets, [[3, 0, 100, 25], [3, 0, 100, 0]]);
        await keon.move(1, 200);
        assert.equal(packets.at(-1)[3], 99);
        assert.ok(packets.at(-1)[2] <= 99);
        await keon.stop();
        assert.deepEqual(packets.at(-1), [3, 0, 0, 99]);
    } finally {
        keon.disconnect();
        if (previousNavigator) Object.defineProperty(globalThis, 'navigator', previousNavigator);
        else delete globalThis.navigator;
        globalThis.isSecureContext = previousSecure;
    }
    assert.equal(disconnected, true);
});
