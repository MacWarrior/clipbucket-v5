$(function () {
    'use strict';

    var data = document.getElementById('video-funscript');
    var modal = $('#funscript-modal');
    if (!data || !modal.length || !window.CBFunscript) {
        return;
    }

    var script;
    var actions;
    try {
        script = JSON.parse(data.textContent);
        actions = CBFunscript.normalize(script);
    } catch (error) {
        $('#funscript-connect').prop('disabled', true);
        return;
    }

    var connection = null;
    var synchronizer = null;
    var selected = null;
    var selectionVersion = 0;
    var video = null;
    var buffering = false;
    var connecting = false;
    var previousTime = null;
    var lastProgress = 0;
    var bindings = [];
    $('#funscript-invert').prop('checked', script.inverted === true);

    function status(message, error) {
        $('#funscript-status').text(message).toggleClass('text-danger', !!error);
    }

    function refresh() {
        $('#funscript-connect-label').text(synchronizer ? 'Connected' : 'Connect');
        $('#funscript-connect').toggleClass('funscript-connected', !!synchronizer);
        $('#funscript-settings').toggle(!!connection);
        $('#funscript-bluetooth-connect, #funscript-intiface-connect').prop('disabled', !!connection || connecting);
        $('#funscript-scan').prop('disabled', !(connection instanceof CBFunscript.Intiface) || connecting);
        $('#funscript-intiface-address').prop('disabled', !!connection || connecting);
        if (!window.isSecureContext || !navigator.bluetooth) {
            $('#funscript-bluetooth-connect').prop('disabled', true);
        }
    }

    async function disconnect(message, error) {
        var oldConnection = connection;
        var oldSynchronizer = synchronizer;
        connection = null;
        synchronizer = null;
        selected = null;
        selectionVersion++;
        connecting = true;
        $('#funscript-devices').empty();
        refresh();
        try {
            if (oldSynchronizer) {
                await oldSynchronizer.close();
            }
        } finally {
            if (oldConnection) {
                oldConnection.disconnect();
            }
            connecting = false;
            refresh();
            status(message || 'Disconnected.', error);
        }
    }

    function lost(transport) {
        if (connection === transport && !connecting) {
            disconnect('Device disconnected. Connect again to resume.', true);
        }
    }

    function settings() {
        var min = Number($('#funscript-stroke-min').val());
        var max = Number($('#funscript-stroke-max').val());
        var speed = Number($('#funscript-speed-limit').val());
        min = Number.isFinite(min) ? Math.max(0, Math.min(100, min)) : 0;
        max = Number.isFinite(max) ? Math.max(0, Math.min(100, max)) : 100;
        speed = Number.isFinite(speed) ? Math.max(0, Math.min(100, speed)) : 100;
        if (min > max) {
            if (this && this.id === 'funscript-stroke-min') {
                max = min;
            } else {
                min = max;
            }
        }
        $('#funscript-stroke-min').val(min).attr('aria-valuetext', min + '%');
        $('#funscript-stroke-max').val(max).attr('aria-valuetext', max + '%');
        $('#funscript-speed-limit').val(speed).attr('aria-valuetext', speed + '%');
        $('#funscript-stroke-value').text(min + '–' + max + '%');
        $('#funscript-speed-value').text(speed + '%');
        if (synchronizer) {
            synchronizer.stop();
            synchronizer.inverted = $('#funscript-invert').prop('checked');
            synchronizer.strokeMin = min;
            synchronizer.strokeMax = max;
            synchronizer.speedLimit = speed;
            var offset = Number($('#funscript-offset').val());
            synchronizer.offset = Number.isFinite(offset) ? Math.max(-10000, Math.min(10000, offset)) : 0;
        }
    }

    async function activate(device, name, index) {
        var transport = connection;
        var version = ++selectionVersion;
        var old = synchronizer;
        synchronizer = null;
        if (old) {
            await old.close();
        }
        if (connection !== transport || !connection || version !== selectionVersion) {
            return;
        }
        selected = index;
        var active = new CBFunscript.Synchronizer(actions, device, function (error) {
            if (connection === transport && synchronizer === active) {
                disconnect(error.message || 'Device communication failed.', true);
            }
        });
        synchronizer = active;
        settings();
        previousTime = null;
        refresh();
        status(name + ' connected. Playback is synchronized with the video.');
    }

    function devices(transport, list) {
        if (connection !== transport) {
            return;
        }
        var container = $('#funscript-devices').empty();
        if (selected !== null && !list.some(device => device.DeviceIndex === selected)) {
            var old = synchronizer;
            synchronizer = null;
            selected = null;
            selectionVersion++;
            if (old) {
                old.close();
            }
            refresh();
            status('Device removed. Select another device.', true);
        }
        list.forEach(function (info) {
            var device = transport.device(info);
            var name = info.DeviceDisplayName || info.DeviceName;
            var button = $('<button type="button" class="list-group-item"></button>')
                .text(name + (device ? '' : ' — unsupported movement type'))
                .prop('disabled', !device);
            button.on('click', async function () {
                container.find('button').prop('disabled', true);
                try {
                    await activate(device, name, info.DeviceIndex);
                } finally {
                    if (connection === transport) {
                        devices(transport, Array.from(transport.devices.values()));
                    }
                }
            });
            button.toggleClass('active', selected === info.DeviceIndex);
            $('<li class="list-unstyled"></li>').append(button).appendTo(container);
        });
    }

    $('[data-funscript-page]').on('click', function () {
        $('#funscript-menu, #funscript-bluetooth, #funscript-intiface').hide();
        $('#funscript-' + $(this).data('funscript-page')).show();
    });

    $('#funscript-bluetooth-connect').on('click', async function () {
        if (connection || connecting) {
            return;
        }
        var transport = new CBFunscript.Keon(() => lost(transport));
        connection = transport;
        connecting = true;
        refresh();
        status('Select your device in the Bluetooth dialog…');
        try {
            await transport.connect();
            if (connection === transport) {
                connecting = false;
                await activate(transport, transport.device.name || 'Bluetooth device', null);
            }
        } catch (error) {
            if (connection === transport) {
                await disconnect(error.name === 'NotFoundError' ? 'Bluetooth selection cancelled.' : error.message, error.name !== 'NotFoundError');
            }
        }
    });

    $('#funscript-intiface-connect').on('click', async function () {
        if (connection || connecting) {
            return;
        }
        var transport = new CBFunscript.Intiface(list => devices(transport, list), () => lost(transport));
        connection = transport;
        connecting = true;
        refresh();
        status('Connecting to Intiface…');
        try {
            await transport.connect($('#funscript-intiface-address').val().trim());
            if (connection !== transport) {
                return;
            }
            connecting = false;
            refresh();
            status('Intiface connected. Select a device below; use Scan if it is missing.');
            await transport.scan();
        } catch (error) {
            if (connection === transport) {
                if (connecting) {
                    await disconnect(error.message, true);
                } else {
                    status(error.message, true);
                }
            }
        }
    });

    $('#funscript-scan').on('click', async function () {
        if (!(connection instanceof CBFunscript.Intiface)) {
            return;
        }
        $(this).prop('disabled', true);
        try {
            await connection.scan();
            status('Scanning. Select your device when it appears.');
        } catch (error) {
            status(error.message, true);
        } finally {
            refresh();
        }
    });
    $('#funscript-disconnect').on('click', () => disconnect());
    $('#funscript-invert, #funscript-offset, #funscript-stroke-min, #funscript-stroke-max, #funscript-speed-limit').on('input change', settings);
    $('#funscript-stroke-reset').on('click', function () {
        $('#funscript-stroke-min').val(0);
        $('#funscript-stroke-max').val(100);
        settings();
    });
    $('#funscript-speed-reset').on('click', function () {
        $('#funscript-speed-limit').val(100);
        settings();
    });

    function stop() {
        if (synchronizer) {
            synchronizer.stop();
        }
    }

    function bindVideo() {
        var element = document.querySelector('#cb_player video');
        if (element === video) {
            return;
        }
        stop();
        bindings.forEach(binding => binding.element.removeEventListener(binding.event, binding.handler));
        bindings = [];
        video = element;
        previousTime = null;
        buffering = false;
        if (!video) {
            return;
        }
        function on(event, handler) {
            video.addEventListener(event, handler);
            bindings.push({element: video, event: event, handler: handler});
        }
        ['pause', 'seeking', 'ended', 'ratechange'].forEach(event => on(event, stop));
        ['waiting', 'stalled', 'emptied', 'error'].forEach(event => on(event, function () {
            buffering = true;
            stop();
        }));
        ['playing', 'canplay'].forEach(event => on(event, function () {
            buffering = false;
            previousTime = null;
        }));
    }

    var holder = document.querySelector('.player-holder');
    var observer = new MutationObserver(bindVideo);
    if (holder) {
        observer.observe(holder, {childList: true, subtree: true});
    }
    bindVideo();
    setInterval(function () {
        if (!video || !synchronizer) {
            return;
        }
        var now = Date.now();
        if (video.currentTime !== previousTime) {
            previousTime = video.currentTime;
            lastProgress = now;
        }
        var pane = video.closest('.tab-pane');
        var running = !document.hidden && !buffering && !video.paused && !video.ended && !video.seeking && video.readyState >= 3
            && (!pane || pane.classList.contains('active')) && now - lastProgress < 500;
        synchronizer.tick(video.currentTime, video.playbackRate, running);
    }, 25);
    document.addEventListener('visibilitychange', function () {
        stop();
        previousTime = null;
    });
    window.addEventListener('pagehide', function () {
        stop();
        // A page cannot await Bluetooth writes or WebSocket acknowledgements here.
        // Closing the transport prevents it from continuing to issue commands.
        if (connection) {
            connection.disconnect();
        }
    });
    refresh();
});
