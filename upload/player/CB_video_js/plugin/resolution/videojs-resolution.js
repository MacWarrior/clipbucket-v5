/*! videojs-resolution-switcher - 2015-7-26
* Copyright (c) 2016 Kasper Moskwiak
* Modified by Pierre Kraft, MacWarrior
* Licensed under the Apache-2.0 license. */

(function() {
    /* jshint eqnull: true*/
    /* global require */
    'use strict';
    var videojs = null;
    if(typeof window.videojs === 'undefined' && typeof require === 'function') {
        videojs = require('video.js');
    } else {
        videojs = window.videojs;
    }

    (function(window, videojs) {
        var defaults = {},
            videoJsResolutionSwitcher,
            currentResolution = {}, // stores current resolution
            menuItemsHolder = {}; // stores menuItems

        function setSourcesSanitized(player, sources, label, customSourcePicker) {
            currentResolution = {
                label: label,
                sources: sources
            };
            if(typeof customSourcePicker === 'function'){
                return customSourcePicker(player, sources, label);
            }

            player.src(sources.map(function(src) {
                return {src: src.src, type: src.type, res: src.res};
            }));

            return player;
        }

        /*
        * Resolution menu item
        */
        var MenuItem = videojs.getComponent('MenuItem');
        class ResolutionMenuItem extends MenuItem {
            constructor(player, options, onClickListener, label) {
                super(player, options);
                this.onClickListener = onClickListener;
                this.label = label;
                this.src = options.src;

                this.on('click', this.onClick);
                this.on('touchstart', this.onClick);

                if (options.initialySelected) {
                    this.showAsLabel();
                    this.selected(true);

                    this.addClass('vjs-selected');
                }
            }

            showAsLabel()
            {
                // Change menu button label to the label of this item if the menu button label is provided
                if(this.label) {
                    this.label.innerHTML = this.options_.label;
                }
            }

            onClick(customSourcePicker)
            {
                this.onClickListener(this);
                // Remember player state
                var currentTime = this.player_.currentTime();
                var isPaused = this.player_.paused();
                this.showAsLabel();

                // add .current class
                this.addClass('vjs-selected');

                if(typeof customSourcePicker !== 'function' && typeof this.options_.customSourcePicker === 'function'){
                    customSourcePicker = this.options_.customSourcePicker;
                }
                // Change player source and wait for loadeddata event, then play video
                // loadedmetadata doesn't work right now for flash.
                // Probably because of https://github.com/videojs/video-js-swf/issues/124
                // If player preload is 'none' and then loadeddata not fired. So, we need timeupdate event for seek handle (timeupdate doesn't work properly with flash)
                var handleSeekEvent = 'loadeddata';
                if(this.player_.preload() === 'none' && this.player_.techName_ !== 'Flash') {
                    handleSeekEvent = 'timeupdate';
                }

                setSourcesSanitized(this.player_, this.src, this.options_.label, customSourcePicker).one(handleSeekEvent, function() {
                    this.player_.currentTime(currentTime);
                    if(!isPaused){
                        this.player_.play();
                    }
                    this.player_.handleTechSeeked_();
                    this.player_.trigger('resolutionchange');

                    // TEMP fix
                    if( $('.vjs-menu-item.vjs-selected .vjs-menu-item-text').closest('.vjs-menu.vjs-hidden').first().length === 1 ) {
                        $('.vjs-menu-item.vjs-selected .vjs-menu-item-text').closest('.vjs-menu.vjs-hidden').first().removeClass('vjs-hidden');
                    }
                });
            }
        }
        videojs.registerComponent('ResolutionMenuItem', ResolutionMenuItem);

        /*
        * Resolution menu button
        */
        var MenuButton = videojs.getComponent('MenuButton');
        var sourcescb = '';
        class ResolutionMenuButton extends MenuButton {
            constructor(player, options, settings, label) {
                sourcescb = options.sources;

                super(player, options, options, settings);

                this.controlText(lang_quality);
                this.label = label;
                this.label.innerHTML = options.initialySelectedLabel;

                if(settings.dynamicLabel){
                    this.el().appendChild(label);
                }else{
                    var staticLabel = document.createElement('span');
                    videojs.dom.addClass(staticLabel, 'vjs-resolution-button-staticlabel');
                    this.el().appendChild(staticLabel);
                }
            }

            createItems()
            {
                var menuItems = [];
                var labels = (sourcescb && sourcescb.label) || {};
                var onClickUnselectOthers = function(clickedItem) {
                    menuItems.map(function(item) {
                        item.selected(item === clickedItem);
                        item.removeClass('vjs-selected');
                    });
                };

                for (var key in labels) {
                    if (labels.hasOwnProperty(key)) {
                        menuItems.push(new ResolutionMenuItem(
                            this.player_,
                            {
                                label: key,
                                src: labels[key],
                                initialySelected: key === this.options_.initialySelectedLabel,
                                customSourcePicker: this.options_.customSourcePicker
                            },
                            onClickUnselectOthers,
                            this.label));
                        // Store menu item for API calls
                        menuItemsHolder[key] = menuItems[menuItems.length - 1];
                    }
                }
                return menuItems;
            }
        }
        videojs.registerComponent('ResolutionMenuButton', ResolutionMenuButton);

        /**
         * Initialize the plugin.
         * @param {object} [options] configuration for the plugin
         */
        videoJsResolutionSwitcher = function(options) {
            var settings = videojs.obj.merge(defaults, options),
                player = this,
                label = document.createElement('span'),
                groupedSrc = {};

            videojs.dom.addClass(label, 'vjs-resolution-button-label');

            /**
             * Updates player sources or returns current source URL
             * @param   {Array}  [src] array of sources [{src: '', type: '', label: '', res: ''}]
             * @returns {Object|String|Array} videojs player object if used as setter or current source URL, object, or array of sources
             */
            player.updateSrc = function(src){
                //Return current src if src is not given
                if(!src){
                    return player.src();
                }
                // Dispose old resolution menu button before adding new sources
                if(player.controlBar.resolutionSwitcher){
                    player.controlBar.resolutionSwitcher.dispose();
                    delete player.controlBar.resolutionSwitcher;
                }
                //Sort sources
                src = src.sort(compareResolutions);
                groupedSrc = bucketSources(src);
                var choosen = chooseSrc(groupedSrc, src);
                var menuButton = new ResolutionMenuButton(player, { sources: groupedSrc, initialySelectedLabel: choosen.label, initialySelectedRes: choosen.res, customSourcePicker: settings.customSourcePicker}, settings, label);
                videojs.dom.addClass(menuButton.el(), 'vjs-resolution-button');
                player.controlBar.resolutionSwitcher = player.controlBar.el_.insertBefore(menuButton.el_, player.controlBar.getChild('fullscreenToggle').el_);
                player.controlBar.resolutionSwitcher.dispose = function(){
                    this.parentNode.removeChild(this);
                };
                return setSourcesSanitized(player, choosen.sources, choosen.label);
            };

            /**
             * Returns current resolution or sets one when label is specified
             * @param {String}   [label]         label name
             * @param {Function} [customSourcePicker] custom function to choose source. Takes 3 arguments: player, sources, label. Must return player object.
             * @returns {Object}   current resolution object {label: '', sources: []} if used as getter or player object if used as setter
             */
            player.currentResolution = function(label, customSourcePicker){
                if(label == null) {
                    return currentResolution;
                }
                if(menuItemsHolder[label] != null){
                    menuItemsHolder[label].onClick(customSourcePicker);
                }
                return player;
            };

            /**
             * Returns grouped sources by label, resolution and type
             * @returns {Object} grouped sources: { label: { key: [] }, res: { key: [] }, type: { key: [] } }
             */
            player.getGroupedSrc = function(){
                return groupedSrc;
            };

            /**
             * Method used for sorting list of sources
             * @param   {Object} a - source object with res property
             * @param   {Object} b - source object with res property
             * @returns {Number} result of comparation
             */
            function compareResolutions(a, b){
                if(!a.res || !b.res){
                    return 0;
                }
                return (+b.res)-(+a.res);
            }

            /**
             * Group sources by label, resolution and type
             * @param   {Array}  src Array of sources
             * @returns {Object} grouped sources: { label: { key: [] }, res: { key: [] }, type: { key: [] } }
             */
            function bucketSources(src){
                var resolutions = {
                    label: {},
                    res: {},
                    type: {}
                };
                src.map(function(source) {
                    initResolutionKey(resolutions, 'label', source);
                    initResolutionKey(resolutions, 'res', source);
                    initResolutionKey(resolutions, 'type', source);

                    appendSourceToKey(resolutions, 'label', source);
                    appendSourceToKey(resolutions, 'res', source);
                    appendSourceToKey(resolutions, 'type', source);
                });
                return resolutions;
            }

            function initResolutionKey(resolutions, key, source) {
                if(resolutions[key][source[key]] == null) {
                    resolutions[key][source[key]] = [];
                }
            }

            function appendSourceToKey(resolutions, key, source) {
                resolutions[key][source[key]].push(source);
            }

            /**
             * Choose src if option.default is specified
             * @param   {Object} groupedSrc {res: { key: [] }}
             * @param   {Array}  src Array of sources sorted by resolution used to find high and low res
             * @returns {Object} {res: string, sources: []}
             */
            function chooseSrc(groupedSrc, src){
                var selectedRes = settings['default']; // use array access as default is a reserved keyword
                var selectedLabel = '';
                if (selectedRes === 'high') {
                    selectedRes = src[0].res;
                    selectedLabel = src[0].label;
                } else if (selectedRes === 'low' || selectedRes == null || !groupedSrc.res[selectedRes]) {
                    // Select low-res if default is low or not set
                    selectedRes = src[src.length - 1].res;
                    selectedLabel = src[src.length -1].label;
                } else if (groupedSrc.res[selectedRes]) {
                    selectedLabel = groupedSrc.res[selectedRes][0].label;
                }

                return {res: selectedRes, label: selectedLabel, sources: groupedSrc.res[selectedRes]};
            }

            player.ready(function(){
                if(player.options_.sources.length > 1){
                    // tech: Html5 and Flash
                    // Create resolution switcher for videos form <source> tag inside <video>
                    player.updateSrc(player.options_.sources);
                }
            });

        };

        // register the plugin
        videojs.registerPlugin('videoJsResolutionSwitcher', videoJsResolutionSwitcher);
    })(window, videojs);
})();
