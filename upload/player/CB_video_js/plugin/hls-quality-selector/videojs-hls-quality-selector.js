// https://www.npmjs.com/package/videojs-quality-selector-hls
// https://github.com/chrisboustead/videojs-hls-quality-selector/issues/106

/*! @name videojs-quality-selector-hls @version 1.1.1 @license MIT */
(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory(require('video.js')) :
      typeof define === 'function' && define.amd ? define(['video.js'], factory) :
          (global = typeof globalThis !== 'undefined' ? globalThis : global || self, global.videojsQualitySelectorHls = factory(global.videojs));
}(this, (function (videojs) { 'use strict';

  function _interopDefaultLegacy (e) { return e && typeof e === 'object' && 'default' in e ? e : { 'default': e }; }

  var videojs__default = /*#__PURE__*/_interopDefaultLegacy(videojs);

  var version = "1.1.1";

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
   * Convert string to title case.
   *
   * @param {Player} player - the string to convert
   * @return {MenuButton} the returned titlecase string
   */


  function ConcreteButton(player) {
    const ConcreteButtonInit = new VideoJsButtonClass(player, {
      title: player.localize('Quality'),
      name: 'QualityButton',
      createItems: () => {
        return [];
      },
      createMenu: () => {
        const menu = new VideoJsMenuClass(this.player_, {
          menuButton: this
        });
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
    });
    return ConcreteButtonInit;
  }

  const VideoJsMenuItemClass = videojs__default['default'].getComponent('MenuItem');
  /**
   * Create a QualitySelectorHls plugin instance.
   *
   * @param  {player} player
   *         A Video.js Player instance.
   *
   * @param  {item} [item]
   *         The Item Quality Item
   *
   * @param  {qualityButton} [qualityButton]
   *         ConcreteButton
   *
   * @param  {plugin} plugin
   *         Plugin
   *
   * @return {MenuItem} MenuItem
   *         VideoJS Menu Item Class
   */

  function ConcreteMenuItem(player, item, qualityButton, plugin) {
    const ConcreteMenuItemInit = new VideoJsMenuItemClass(player, {
      label: item.label,
      selectable: true,
      selected: item.selected || false
    });
    ConcreteMenuItemInit.item = item;
    ConcreteMenuItemInit.qualityButton = qualityButton;
    ConcreteMenuItemInit.plugin = plugin;

    ConcreteMenuItemInit.handleClick = function () {
      // Reset other menu items selected status.
      for (let i = 0; i < this.qualityButton.items.length; ++i) {
        this.qualityButton.items[i].selected(false);
      } // Set this menu item to selected, and set quality.


      this.plugin.setQuality(this.item.value);
      this.selected(true);
    };

    return ConcreteMenuItemInit;
  }

  // Default options for the plugin.

  const defaults = {
    vjsIconClass: 'vjs-icon-hd',
    displayCurrentQuality: false,
    placementIndex: 0
  };
  /**
   * An advanced Video.js plugin. For more information on the API
   *
   * See: https://blog.videojs.com/feature-spotlight-advanced-plugins/
   */

  class QualitySelectorHlsClass {
    /**
     * Create a QualitySelectorHls plugin instance.
     *
     * @param  {Player} player
     *         A Video.js Player instance.
     *
     * @param  {Object} [options]
     *         An optional options object.
     *
     *         While not a core part of the Video.js plugin architecture, a
     *         second argument of options is a convenient way to accept inputs
     *         from your plugin's caller.
     */
    constructor(player, options) {
      // the parent class will add player under this.player
      this.player = player;
      this.config = videojs__default['default'].obj.merge(defaults, options);
      player.ready(() => {
        this.player.addClass('vjs-quality-selector-hls');

        if (this.player.qualityLevels) {
          // Create the quality button.
          this.createQualityButton();
          this.bindPlayerEvents();
        }
      });
    }
    /**
     * Returns HLS Plugin
     *
     * @return {*} - videojs-hls-contrib plugin.
     */


    getHls() {
      return this.player.tech({
        IWillNotUseThisInPlugins: true
      }).hls;
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
        this.setButtonInnerText('auto');
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
      return ConcreteMenuItem(player, item, this._qualityButton, this);
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
        this.setButtonInnerText(quality === 'auto' ? quality : `${quality}p`);
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

  const initPlugin = function (player, options) {
    const QualitySelectorHls = new QualitySelectorHlsClass(player, options);
    player.QualitySelectorHlsVjs = true; // Define default values for the plugin's `state` object here.

    QualitySelectorHls.defaultState = {}; // Include the version number.

    QualitySelectorHls.VERSION = version;
    return QualitySelectorHls;
  };

  const QualitySelectorHls = function (options) {
    return initPlugin(this, videojs__default['default'].obj.merge({}, options));
  }; // Register the plugin with video.js.


  videojs__default['default'].registerPlugin('qualitySelectorHls', QualitySelectorHls);

  return QualitySelectorHls;

})));