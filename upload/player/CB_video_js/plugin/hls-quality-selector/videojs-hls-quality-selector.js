// https://www.npmjs.com/package/jb-videojs-hls-quality-selector
// https://github.com/jb-alvarado/videojs-hls-quality-selector

/*! @name jb-videojs-hls-quality-selector @version 2.0.2 @license MIT */
(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory(require('video.js')) :
      typeof define === 'function' && define.amd ? define(['video.js'], factory) :
          (global = typeof globalThis !== 'undefined' ? globalThis : global || self, global.jbVideojsHlsQualitySelector = factory(global.videojs));
}(this, (function (videojs) { 'use strict';

  function _interopDefaultLegacy (e) { return e && typeof e === 'object' && 'default' in e ? e : { 'default': e }; }

  var videojs__default = /*#__PURE__*/_interopDefaultLegacy(videojs);

  var version = "2.0.2";

  const VideoJsButtonClass = videojs__default['default'].getComponent('MenuButton');
  const VideoJsMenuClass = videojs__default['default'].getComponent('Menu');
  const VideoJsComponent = videojs__default['default'].getComponent('Component');
  const Dom = videojs__default['default'].dom;
  /**
   * Convert string to title case.
   *
   * @param {string} string - the string to convert
   * @return {string} the returned titlecase string
   */

  function toTitleCase(string) {
    if (typeof string !== 'string') {
      return string;
    }

    return string.charAt(0).toUpperCase() + string.slice(1);
  }
  /**
   * Extend vjs button class for quality button.
   */


  class ConcreteButton extends VideoJsButtonClass {
    /**
     * Button constructor.
     *
     * @param {Player} player - videojs player instance
     */
    constructor(player) {
      super(player, {
        title: player.localize('Quality'),
        name: 'QualityButton'
      });
    }
    /**
     * Creates button items.
     *
     * @return {Array} - Button items
     */


    createItems() {
      return [];
    }
    /**
     * Create the menu and add all items to it.
     *
     * @return {Menu}
     *         The constructed menu
     */


    createMenu() {
      const menu = new VideoJsMenuClass(this.player_, {
        menuButton: this
      });
      menu.addClass('hls-quality-button');
      this.hideThreshold_ = 0; // Add a title list item to the top

      if (this.options_.title) {
        const titleEl = Dom.createEl('li', {
          className: 'vjs-menu-title',
          innerHTML: toTitleCase(this.options_.title),
          tabIndex: -1
        });
        const titleComponent = new VideoJsComponent(this.player_, {
          el: titleEl
        });
        this.hideThreshold_ += 1;
        menu.addItem(titleComponent);
      }

      this.items = this.createItems();

      if (this.items) {
        // Add menu items to the menu
        for (let i = 0; i < this.items.length; i++) {
          menu.addItem(this.items[i]);
        }
      }

      return menu;
    }

  }

  const VideoJsMenuItemClass = videojs__default['default'].getComponent('MenuItem');
  /**
   * Extend vjs menu item class.
   */

  class ConcreteMenuItem extends VideoJsMenuItemClass {
    /**
     * Menu item constructor.
     *
     * @param {Player} player - vjs player
     * @param {Object} item - Item object
     * @param {ConcreteButton} qualityButton - The containing button.
     * @param {HlsQualitySelectorPlugin} plugin - This plugin instance.
     */
    constructor(player, item, qualityButton, plugin) {
      super(player, {
        label: item.label,
        selectable: true,
        selected: item.selected || false
      });
      this.item = item;
      this.qualityButton = qualityButton;
      this.plugin = plugin;
    }
    /**
     * Click event for menu item.
     */


    handleClick() {
      // Reset other menu items selected status.
      for (let i = 0; i < this.qualityButton.items.length; ++i) {
        this.qualityButton.items[i].selected(false);
      } // Set this menu item to selected, and set quality.


      this.plugin.setQuality(this.item.value);
      this.selected(true);
    }

  }

  const defaults = {}; // Cross-compatibility for Video.js 5 and 6.

  const registerPlugin = videojs__default['default'].registerPlugin || videojs__default['default'].plugin; // const dom = videojs.dom || videojs;

  /**
   * VideoJS HLS Quality Selector Plugin class.
   */

  class HlsQualitySelectorPlugin {
    /**
     * Plugin Constructor.
     *
     * @param {Player} player - The videojs player instance.
     * @param {Object} options - The plugin options.
     */
    constructor(player, options) {
      this.player = player;
      this.config = options; // If there is quality levels plugin and the HLS tech exists
      // then continue.

      if (this.player.qualityLevels) {
        // Create the quality button.
        this.createQualityButton();
        this.bindPlayerEvents();
      }
    }
    /**
     * Returns HLS Plugin
     *
     * @return {*} - videojs-hls-contrib plugin.
     */


    getHls() {
      return this.player.tech({
        IWillNotUseThisInPlugins: true
      }).vhs;
    }
    /**
     * Binds listener for quality level changes.
     */


    bindPlayerEvents() {
      this.player.qualityLevels().on('addqualitylevel', this.onAddQualityLevel.bind(this));
    }
    /**
     * Adds the quality menu button to the player control bar.
     */


    createQualityButton() {
      const player = this.player;
      this._qualityButton = new ConcreteButton(player);
      const placementIndex = player.controlBar.children().length - 2;
      const concreteButtonInstance = player.controlBar.addChild(this._qualityButton, {
        componentClass: 'qualitySelector'
      }, this.config.placementIndex || placementIndex);
      concreteButtonInstance.addClass('vjs-quality-selector');

      if (!this.config.displayCurrentQuality) {
        const icon = ` ${this.config.vjsIconClass || 'vjs-icon-hd'}`;
        concreteButtonInstance.menuButton_.$('.vjs-icon-placeholder').className += icon;
      } else {
        this.setButtonInnerText(this.player.localize('Auto'));
      }

      concreteButtonInstance.removeClass('vjs-hidden');
    }
    /**
     *Set inner button text.
     *
     * @param {string} text - the text to display in the button.
     */


    setButtonInnerText(text) {
      this._qualityButton.menuButton_.$('.vjs-icon-placeholder').innerHTML = text;
    }
    /**
     * Builds individual quality menu items.
     *
     * @param {Object} item - Individual quality menu item.
     * @return {ConcreteMenuItem} - Menu item
     */


    getQualityMenuItem(item) {
      const player = this.player;
      return new ConcreteMenuItem(player, item, this._qualityButton, this);
    }
    /**
     * Executed when a quality level is added from HLS playlist.
     */


    onAddQualityLevel() {
      const player = this.player;
      const qualityList = player.qualityLevels();
      const levels = qualityList.levels_ || [];
      const levelItems = [];

      for (let i = 0; i < levels.length; ++i) {
        const {
          width,
          height
        } = levels[i];
        const pixels = width > height ? height : width;

        if (!pixels) {
          continue;
        }

        if (!levelItems.filter(_existingItem => {
          return _existingItem.item && _existingItem.item.value === pixels;
        }).length) {
          const levelItem = this.getQualityMenuItem.call(this, {
            label: pixels + 'p',
            value: pixels
          });
          levelItems.push(levelItem);
        }
      }

      levelItems.sort((current, next) => {
        if (typeof current !== 'object' || typeof next !== 'object') {
          return -1;
        }

        if (current.item.value < next.item.value) {
          return -1;
        }

        if (current.item.value > next.item.value) {
          return 1;
        }

        return 0;
      });
      levelItems.push(this.getQualityMenuItem.call(this, {
        label: player.localize('Auto'),
        value: 'auto',
        selected: true
      }));

      if (this._qualityButton) {
        this._qualityButton.createItems = function () {
          return levelItems;
        };

        this._qualityButton.update();
      }
    }
    /**
     * Sets quality (based on media short side)
     *
     * @param {number} quality - A number representing HLS playlist.
     */


    setQuality(quality) {
      const qualityList = this.player.qualityLevels(); // Set quality on plugin

      this._currentQuality = quality;

      if (this.config.displayCurrentQuality) {
        this.setButtonInnerText(quality === 'auto' ? this.player.localize('Auto') : `${quality}p`);
      }

      for (let i = 0; i < qualityList.length; ++i) {
        const {
          width,
          height
        } = qualityList[i];
        const pixels = width > height ? height : width;
        qualityList[i].enabled = pixels === quality || quality === 'auto';
      }

      this._qualityButton.unpressButton();
    }
    /**
     * Return the current set quality or 'auto'
     *
     * @return {string} the currently set quality
     */


    getCurrentQuality() {
      return this._currentQuality || 'auto';
    }

  }
  /**
   * Function to invoke when the player is ready.
   *
   * This is a great place for your plugin to initialize itself. When this
   * function is called, the player will have its DOM and child components
   * in place.
   *
   * @function onPlayerReady
   * @param    {Player} player
   *           A Video.js player object.
   *
   * @param    {Object} [options={}]
   *           A plain object containing options for the plugin.
   */


  const onPlayerReady = (player, options) => {
    player.addClass('vjs-hls-quality-selector');
    player.hlsQualitySelector = new HlsQualitySelectorPlugin(player, options);
  };
  /**
   * A video.js plugin.
   *
   * In the plugin function, the value of `this` is a video.js `Player`
   * instance. You cannot rely on the player being in a 'ready' state here,
   * depending on how the plugin is invoked. This may or may not be important
   * to you; if not, remove the wait for 'ready'!
   *
   * @function hlsQualitySelector
   * @param    {Object} [options={}]
   *           An object of options left to the plugin author to define.
   */


  const hlsQualitySelector = function (options) {
    this.ready(() => {
      onPlayerReady(this, videojs__default['default'].obj.merge(defaults, options));
    });
  }; // Register the plugin with video.js.


  registerPlugin('hlsQualitySelector', hlsQualitySelector); // Include the version number.

  hlsQualitySelector.VERSION = version;

  return hlsQualitySelector;

})));
