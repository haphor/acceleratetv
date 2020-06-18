(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

var _DesignOptions = require("../components/DesignOptions");

var _ImageUpload = require("../components/ImageUpload");

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

var __ = wp.i18n.__;
var registerBlockType = wp.blocks.registerBlockType;
var InspectorControls = wp.editor.InspectorControls;
var Fragment = wp.element.Fragment;
var _wp$components = wp.components,
    ServerSideRender = _wp$components.ServerSideRender,
    Disabled = _wp$components.Disabled,
    PanelBody = _wp$components.PanelBody,
    TextControl = _wp$components.TextControl;
registerBlockType('vodi/landing-featured-section', {
  title: __('Landing Featured Section', 'vodi-extensions'),
  icon: 'format-image',
  category: 'vodi-blocks',
  edit: function edit(props) {
    var attributes = props.attributes,
        setAttributes = props.setAttributes;
    var section_title = attributes.section_title,
        section_subtitle = attributes.section_subtitle,
        section_desc = attributes.section_desc,
        featured_bg_image = attributes.featured_bg_image,
        action_text = attributes.action_text,
        action_link = attributes.action_link,
        featured_image = attributes.featured_image,
        featured_image_label = attributes.featured_image_label,
        design_options = attributes.design_options;

    var onChangeSectionTitle = function onChangeSectionTitle(newSectionTitle) {
      setAttributes({
        section_title: newSectionTitle
      });
    };

    var onChangeSectionSubtitle = function onChangeSectionSubtitle(newSectionSubtitle) {
      setAttributes({
        section_subtitle: newSectionSubtitle
      });
    };

    var onChangeSectionDesc = function onChangeSectionDesc(newSectionDesc) {
      setAttributes({
        section_desc: newSectionDesc
      });
    };

    var onChangeActionText = function onChangeActionText(newActionText) {
      setAttributes({
        action_text: newActionText
      });
    };

    var onChangeActionLink = function onChangeActionLink(newActionLink) {
      setAttributes({
        action_link: newActionLink
      });
    };

    var onChangeFeaturedBgImage = function onChangeFeaturedBgImage(media) {
      setAttributes({
        featured_bg_image: media.id
      });
    };

    var onChangeFeaturedImage = function onChangeFeaturedImage(media) {
      setAttributes({
        featured_image: media.id
      });
    };

    var onChangeDesignOptions = function onChangeDesignOptions(newDesignOptions) {
      setAttributes({
        design_options: _objectSpread({}, design_options, {}, newDesignOptions)
      });
    };

    var onChangeFeaturedImageLabel = function onChangeFeaturedImageLabel(newFeaturedImageLabel) {
      setAttributes({
        featured_image_label: newFeaturedImageLabel
      });
    };

    return wp.element.createElement(Fragment, null, wp.element.createElement(InspectorControls, null, wp.element.createElement(TextControl, {
      label: __('Section Title', 'vodi-extensions'),
      value: section_title,
      onChange: onChangeSectionTitle
    }), wp.element.createElement(TextControl, {
      label: __('Section Subtitle', 'vodi-extensions'),
      value: section_subtitle,
      onChange: onChangeSectionSubtitle
    }), wp.element.createElement(TextControl, {
      label: __('Section Desc', 'vodi-extensions'),
      value: section_desc,
      onChange: onChangeSectionDesc
    }), wp.element.createElement(TextControl, {
      label: __('Action Text', 'vodi-extensions'),
      value: action_text,
      onChange: onChangeActionText
    }), wp.element.createElement(TextControl, {
      label: __('Action Link', 'vodi-extensions'),
      value: action_link,
      onChange: onChangeActionLink
    }), wp.element.createElement(_ImageUpload.ImageUpload, {
      addImageLabel: __('Pick an Background Image', 'vodi-extensions'),
      replaceImageLabel: __('Replace Background Image', 'vodi-extensions'),
      removeImageLabel: __('Remove Background Image', 'vodi-extensions'),
      value: featured_bg_image,
      onSelect: onChangeFeaturedBgImage
    }), wp.element.createElement(_ImageUpload.ImageUpload, {
      addImageLabel: __('Pick an Image', 'vodi-extensions'),
      replaceImageLabel: __('Replace Image', 'vodi-extensions'),
      removeImageLabel: __('Remove Image', 'vodi-extensions'),
      value: featured_image,
      onSelect: onChangeFeaturedImage
    }), wp.element.createElement(TextControl, {
      label: __('Featured Image Label', 'vodi-extensions'),
      value: featured_image_label,
      onChange: onChangeFeaturedImageLabel
    }), wp.element.createElement(PanelBody, {
      title: __('Design Options', 'vodi-extensions'),
      initialOpen: false
    }, wp.element.createElement(_DesignOptions.DesignOptions, {
      attributes: _objectSpread({}, design_options),
      updateDesignOptions: onChangeDesignOptions
    }))), wp.element.createElement(Disabled, null, wp.element.createElement(ServerSideRender, {
      block: "vodi/landing-featured-section",
      attributes: attributes
    })));
  },
  save: function save() {
    // Rendering in PHP
    return null;
  }
});

},{"../components/DesignOptions":2,"../components/ImageUpload":3}],2:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.DesignOptions = void 0;

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

var __ = wp.i18n.__;
var Component = wp.element.Component;
var RangeControl = wp.components.RangeControl;
/**
 * DesignOptions Component
 */

var DesignOptions =
/*#__PURE__*/
function (_Component) {
  _inherits(DesignOptions, _Component);

  /**
   * Constructor for DesignOptions Component.
   * Sets up state, and creates bindings for functions.
   * @param object props - current component properties.
   */
  function DesignOptions(props) {
    var _this;

    _classCallCheck(this, DesignOptions);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(DesignOptions).apply(this, arguments));
    _this.props = props;
    _this.onChangePaddingTop = _this.onChangePaddingTop.bind(_assertThisInitialized(_this));
    _this.onChangePaddingBottom = _this.onChangePaddingBottom.bind(_assertThisInitialized(_this));
    _this.onChangePaddingLeft = _this.onChangePaddingLeft.bind(_assertThisInitialized(_this));
    _this.onChangePaddingRight = _this.onChangePaddingRight.bind(_assertThisInitialized(_this));
    _this.onChangeMarginTop = _this.onChangeMarginTop.bind(_assertThisInitialized(_this));
    _this.onChangeMarginBottom = _this.onChangeMarginBottom.bind(_assertThisInitialized(_this));
    return _this;
  }

  _createClass(DesignOptions, [{
    key: "onChangePaddingTop",
    value: function onChangePaddingTop(newonChangePaddingTop) {
      this.props.updateDesignOptions({
        padding_top: newonChangePaddingTop
      });
    }
  }, {
    key: "onChangePaddingBottom",
    value: function onChangePaddingBottom(newonChangePaddingBottom) {
      this.props.updateDesignOptions({
        padding_bottom: newonChangePaddingBottom
      });
    }
  }, {
    key: "onChangePaddingLeft",
    value: function onChangePaddingLeft(newonChangePaddingLeft) {
      this.props.updateDesignOptions({
        padding_left: newonChangePaddingLeft
      });
    }
  }, {
    key: "onChangePaddingRight",
    value: function onChangePaddingRight(newonChangePaddingRight) {
      this.props.updateDesignOptions({
        padding_right: newonChangePaddingRight
      });
    }
  }, {
    key: "onChangeMarginTop",
    value: function onChangeMarginTop(newonChangeMarginTop) {
      this.props.updateDesignOptions({
        margin_top: newonChangeMarginTop
      });
    }
  }, {
    key: "onChangeMarginBottom",
    value: function onChangeMarginBottom(newonChangeMarginBottom) {
      this.props.updateDesignOptions({
        margin_bottom: newonChangeMarginBottom
      });
    }
    /**
     * Renders the DesignOptions component.
     */

  }, {
    key: "render",
    value: function render() {
      var attributes = this.props.attributes;
      var padding_top = attributes.padding_top,
          padding_bottom = attributes.padding_bottom,
          padding_left = attributes.padding_left,
          padding_right = attributes.padding_right,
          margin_top = attributes.margin_top,
          margin_bottom = attributes.margin_bottom;
      return wp.element.createElement("div", null, wp.element.createElement(RangeControl, {
        label: __('Padding Top (px)', 'vodi-extensions'),
        value: padding_top,
        onChange: this.onChangePaddingTop,
        min: 0,
        max: 100
      }), wp.element.createElement(RangeControl, {
        label: __('Padding Bottom (px)', 'vodi-extensions'),
        value: padding_bottom,
        onChange: this.onChangePaddingBottom,
        min: 0,
        max: 100
      }), wp.element.createElement(RangeControl, {
        label: __('Padding Left (px)', 'vodi-extensions'),
        value: padding_left,
        onChange: this.onChangePaddingLeft,
        min: 0,
        max: 100
      }), wp.element.createElement(RangeControl, {
        label: __('Padding Right (px)', 'vodi-extensions'),
        value: padding_right,
        onChange: this.onChangePaddingRight,
        min: 0,
        max: 100
      }), wp.element.createElement(RangeControl, {
        label: __('Margin Top (px)', 'vodi-extensions'),
        value: margin_top,
        onChange: this.onChangeMarginTop,
        min: -100,
        max: 100
      }), wp.element.createElement(RangeControl, {
        label: __('Margin Bottom (px)', 'vodi-extensions'),
        value: margin_bottom,
        onChange: this.onChangeMarginBottom,
        min: -100,
        max: 100
      }));
    }
  }]);

  return DesignOptions;
}(Component);

exports.DesignOptions = DesignOptions;

},{}],3:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.ImageUpload = void 0;

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

var __ = wp.i18n.__;
var MediaUpload = wp.editor.MediaUpload;
var _wp$element = wp.element,
    Fragment = _wp$element.Fragment,
    Component = _wp$element.Component;
var Button = wp.components.Button;
/**
 * ImageUpload Component
 */

var ImageUpload =
/*#__PURE__*/
function (_Component) {
  _inherits(ImageUpload, _Component);

  /**
   * Constructor for ImageUpload Component.
   * Sets up state, and creates bindings for functions.
   * @param object props - current component properties.
   */
  function ImageUpload(props) {
    var _this;

    _classCallCheck(this, ImageUpload);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(ImageUpload).apply(this, arguments));
    _this.props = props;
    _this.onChangeImage = _this.onChangeImage.bind(_assertThisInitialized(_this));
    _this.onRemoveImage = _this.onRemoveImage.bind(_assertThisInitialized(_this));
    return _this;
  }

  _createClass(ImageUpload, [{
    key: "onChangeImage",
    value: function onChangeImage(media) {
      this.props.onSelect(media);
    }
  }, {
    key: "onRemoveImage",
    value: function onRemoveImage() {
      this.props.onSelect(0);
    }
    /**
     * Renders the ImageUpload component.
     */

  }, {
    key: "render",
    value: function render() {
      var _this$props = this.props,
          attributes = _this$props.attributes,
          addImageLabel = _this$props.addImageLabel,
          replaceImageLabel = _this$props.replaceImageLabel,
          removeImageLabel = _this$props.removeImageLabel,
          value = _this$props.value;
      return wp.element.createElement("div", {
        className: "components-base-control components-image-upload"
      }, wp.element.createElement("div", {
        className: "components-base-control__field"
      }, wp.element.createElement(MediaUpload, {
        onSelect: this.onChangeImage,
        type: "image",
        value: value,
        render: function render(_ref) {
          var open = _ref.open;
          return wp.element.createElement("div", {
            className: "button-container"
          }, wp.element.createElement(Button, {
            isLarge: true,
            onClick: open
          }, value ? replaceImageLabel : addImageLabel));
        }
      })), value ? wp.element.createElement("div", {
        className: "components-base-control__field"
      }, wp.element.createElement("div", {
        className: "button-container"
      }, wp.element.createElement(Button, {
        isLarge: true,
        onClick: this.onRemoveImage
      }, removeImageLabel))) : '');
    }
  }]);

  return ImageUpload;
}(Component);

exports.ImageUpload = ImageUpload;

},{}]},{},[1])
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9icm93c2VyLXBhY2svX3ByZWx1ZGUuanMiLCJzcmMvcGx1Z2lucy92b2RpLWV4dGVuc2lvbnMvYXNzZXRzL2VzbmV4dC9ibG9ja3MvbGFuZGluZy1mZWF0dXJlZC1zZWN0aW9uLmpzIiwic3JjL3BsdWdpbnMvdm9kaS1leHRlbnNpb25zL2Fzc2V0cy9lc25leHQvY29tcG9uZW50cy9EZXNpZ25PcHRpb25zLmpzIiwic3JjL3BsdWdpbnMvdm9kaS1leHRlbnNpb25zL2Fzc2V0cy9lc25leHQvY29tcG9uZW50cy9JbWFnZVVwbG9hZC5qcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQTs7O0FDQUE7O0FBQ0E7Ozs7Ozs7O0lBRVEsRSxHQUFPLEVBQUUsQ0FBQyxJLENBQVYsRTtJQUNBLGlCLEdBQXNCLEVBQUUsQ0FBQyxNLENBQXpCLGlCO0lBQ0EsaUIsR0FBc0IsRUFBRSxDQUFDLE0sQ0FBekIsaUI7SUFDQSxRLEdBQWEsRUFBRSxDQUFDLE8sQ0FBaEIsUTtxQkFDdUQsRUFBRSxDQUFDLFU7SUFBMUQsZ0Isa0JBQUEsZ0I7SUFBa0IsUSxrQkFBQSxRO0lBQVUsUyxrQkFBQSxTO0lBQVcsVyxrQkFBQSxXO0FBRS9DLGlCQUFpQixDQUFFLCtCQUFGLEVBQW1DO0FBQ2hELEVBQUEsS0FBSyxFQUFFLEVBQUUsQ0FBQywwQkFBRCxFQUE2QixpQkFBN0IsQ0FEdUM7QUFHaEQsRUFBQSxJQUFJLEVBQUUsY0FIMEM7QUFLaEQsRUFBQSxRQUFRLEVBQUUsYUFMc0M7QUFPaEQsRUFBQSxJQUFJLEVBQUksY0FBRSxLQUFGLEVBQWE7QUFBQSxRQUNULFVBRFMsR0FDcUIsS0FEckIsQ0FDVCxVQURTO0FBQUEsUUFDRyxhQURILEdBQ3FCLEtBRHJCLENBQ0csYUFESDtBQUFBLFFBRVQsYUFGUyxHQUU0SSxVQUY1SSxDQUVULGFBRlM7QUFBQSxRQUVNLGdCQUZOLEdBRTRJLFVBRjVJLENBRU0sZ0JBRk47QUFBQSxRQUV3QixZQUZ4QixHQUU0SSxV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QUMsV0FBRDtBQUNJLFFBQUEsUUFBUSxFQUFHLEtBQUssYUFEcEI7QUFFSSxRQUFBLElBQUksRUFBQyxPQUZUO0FBR0ksUUFBQSxLQUFLLEVBQUcsS0FIWjtBQUlJLFFBQUEsTUFBTSxFQUFHO0FBQUEsY0FBSSxJQUFKLFFBQUksSUFBSjtBQUFBLGlCQUNMO0FBQUssWUFBQSxTQUFTLEVBQUM7QUFBZixhQUNJLHlCQUFDLE1BQUQ7QUFBUSxZQUFBLE9BQU8sTUFBZjtBQUFnQixZQUFBLE9BQU8sRUFBRztBQUExQixhQUNRLEtBQUYsR0FBWSxpQkFBWixHQUFnQyxhQUR0QyxDQURKLENBREs7QUFBQTtBQUpiLFFBREosQ0FESixFQWVRLEtBQUYsR0FDRTtBQUFLLFFBQUEsU0FBUyxFQUFDO0FBQWYsU0FDSTtBQUFLLFFBQUEsU0FBUyxFQUFDO0FBQWYsU0FDSSx5QkFBQyxNQUFEO0FBQVEsUUFBQSxPQUFPLE1BQWY7QUFBZ0IsUUFBQSxPQUFPLEVBQUcsS0FBSztBQUEvQixTQUNNLGdCQUROLENBREosQ0FESixDQURGLEdBUUUsRUF2QlIsQ0FESjtBQTJCSDs7OztFQXZENEIsUyIsImZpbGUiOiJnZW5lcmF0ZWQuanMiLCJzb3VyY2VSb290IjoiIiwic291cmNlc0NvbnRlbnQiOlsiKGZ1bmN0aW9uKCl7ZnVuY3Rpb24gcihlLG4sdCl7ZnVuY3Rpb24gbyhpLGYpe2lmKCFuW2ldKXtpZighZVtpXSl7dmFyIGM9XCJmdW5jdGlvblwiPT10eXBlb2YgcmVxdWlyZSYmcmVxdWlyZTtpZighZiYmYylyZXR1cm4gYyhpLCEwKTtpZih1KXJldHVybiB1KGksITApO3ZhciBhPW5ldyBFcnJvcihcIkNhbm5vdCBmaW5kIG1vZHVsZSAnXCIraStcIidcIik7dGhyb3cgYS5jb2RlPVwiTU9EVUxFX05PVF9GT1VORFwiLGF9dmFyIHA9bltpXT17ZXhwb3J0czp7fX07ZVtpXVswXS5jYWxsKHAuZXhwb3J0cyxmdW5jdGlvbihyKXt2YXIgbj1lW2ldWzFdW3JdO3JldHVybiBvKG58fHIpfSxwLHAuZXhwb3J0cyxyLGUsbix0KX1yZXR1cm4gbltpXS5leHBvcnRzfWZvcih2YXIgdT1cImZ1bmN0aW9uXCI9PXR5cGVvZiByZXF1aXJlJiZyZXF1aXJlLGk9MDtpPHQubGVuZ3RoO2krKylvKHRbaV0pO3JldHVybiBvfXJldHVybiByfSkoKSIsImltcG9ydCB7IERlc2lnbk9wdGlvbnMgfSBmcm9tICcuLi9jb21wb25lbnRzL0Rlc2lnbk9wdGlvbnMnO1xuaW1wb3J0IHsgSW1hZ2VVcGxvYWQgfSBmcm9tICcuLi9jb21wb25lbnRzL0ltYWdlVXBsb2FkJztcblxuY29uc3QgeyBfXyB9ID0gd3AuaTE4bjtcbmNvbnN0IHsgcmVnaXN0ZXJCbG9ja1R5cGUgfSA9IHdwLmJsb2NrcztcbmNvbnN0IHsgSW5zcGVjdG9yQ29udHJvbHMgfSA9IHdwLmVkaXRvcjtcbmNvbnN0IHsgRnJhZ21lbnQgfSA9IHdwLmVsZW1lbnQ7XG5jb25zdCB7IFNlcnZlclNpZGVSZW5kZXIsIERpc2FibGVkLCBQYW5lbEJvZHksIFRleHRDb250cm9sIH0gPSB3cC5jb21wb25lbnRzO1xuXG5yZWdpc3RlckJsb2NrVHlwZSggJ3ZvZGkvbGFuZGluZy1mZWF0dXJlZC1zZWN0aW9uJywge1xuICAgIHRpdGxlOiBfXygnTGFuZGluZyBGZWF0dXJlZCBTZWN0aW9uJywgJ3ZvZGktZXh0ZW5zaW9ucycpLFxuXG4gICAgaWNvbjogJ2Zvcm1hdC1pbWFnZScsXG5cbiAgICBjYXRlZ29yeTogJ3ZvZGktYmxvY2tzJyxcblxuICAgIGVkaXQ6ICggKCBwcm9wcyApID0+IHtcbiAgICAgICAgY29uc3QgeyBhdHRyaWJ1dGVzLCBzZXRBdHRyaWJ1dGVzIH0gPSBwcm9wcztcbiAgICAgICAgY29uc3QgeyBzZWN0aW9uX3RpdGxlLCBzZWN0aW9uX3N1YnRpdGxlLCBzZWN0aW9uX2Rlc2MsIGZlYXR1cmVkX2JnX2ltYWdlLCBhY3Rpb25fdGV4dCwgYWN0aW9uX2xpbmssIGZlYXR1cmVkX2ltYWdlLCBmZWF0dXJlZF9pbWFnZV9sYWJlbCwgZGVzaWduX29wdGlvbnMgfSA9IGF0dHJpYnV0ZXM7XG5cbiAgICAgICAgY29uc3Qgb25DaGFuZ2VTZWN0aW9uVGl0bGUgPSBuZXdTZWN0aW9uVGl0bGUgPT4ge1xuICAgICAgICAgICAgc2V0QXR0cmlidXRlcyggeyBzZWN0aW9uX3RpdGxlOiBuZXdTZWN0aW9uVGl0bGUgfSApO1xuICAgICAgICB9O1xuXG4gICAgICAgIGNvbnN0IG9uQ2hhbmdlU2VjdGlvblN1YnRpdGxlID0gbmV3U2VjdGlvblN1YnRpdGxlID0+IHtcbiAgICAgICAgICAgIHNldEF0dHJpYnV0ZXMoIHsgc2VjdGlvbl9zdWJ0aXRsZTogbmV3U2VjdGlvblN1YnRpdGxlIH0gKTtcbiAgICAgICAgfTtcblxuICAgICAgICBjb25zdCBvbkNoYW5nZVNlY3Rpb25EZXNjID0gbmV3U2VjdGlvbkRlc2MgPT4ge1xuICAgICAgICAgICAgc2V0QXR0cmlidXRlcyggeyBzZWN0aW9uX2Rlc2M6IG5ld1NlY3Rpb25EZXNjIH0gKTtcbiAgICAgICAgfTtcblxuICAgICAgICBjb25zdCBvbkNoYW5nZUFjdGlvblRleHQgPSBuZXdBY3Rpb25UZXh0ID0+IHtcbiAgICAgICAgICAgIHNldEF0dHJpYnV0ZXMoIHsgYWN0aW9uX3RleHQ6IG5ld0FjdGlvblRleHQgfSApO1xuICAgICAgICB9O1xuXG4gICAgICAgIGNvbnN0IG9uQ2hhbmdlQWN0aW9uTGluayA9IG5ld0FjdGlvbkxpbmsgPT4ge1xuICAgICAgICAgICAgc2V0QXR0cmlidXRlcyggeyBhY3Rpb25fbGluazogbmV3QWN0aW9uTGluayB9ICk7XG4gICAgICAgIH07XG5cbiAgICAgICAgY29uc3Qgb25DaGFuZ2VGZWF0dXJlZEJnSW1hZ2UgPSBtZWRpYSA9PiB7XG4gICAgICAgICAgICBzZXRBdHRyaWJ1dGVzKCB7IGZlYXR1cmVkX2JnX2ltYWdlOiBtZWRpYS5pZCB9ICk7XG4gICAgICAgIH07XG5cbiAgICAgICAgIGNvbnN0IG9uQ2hhbmdlRmVhdHVyZWRJbWFnZSA9IG1lZGlhID0+IHtcbiAgICAgICAgICAgIHNldEF0dHJpYnV0ZXMoIHsgZmVhdHVyZWRfaW1hZ2U6IG1lZGlhLmlkIH0gKTtcbiAgICAgICAgfTtcblxuICAgICAgICBjb25zdCBvbkNoYW5nZURlc2lnbk9wdGlvbnMgPSBuZXdEZXNpZ25PcHRpb25zID0+IHtcbiAgICAgICAgICAgIHNldEF0dHJpYnV0ZXMoIHsgZGVzaWduX29wdGlvbnM6IHsgLi4uZGVzaWduX29wdGlvbnMsIC4uLm5ld0Rlc2lnbk9wdGlvbnMgfSB9ICk7XG4gICAgICAgIH07XG5cbiAgICAgICAgY29uc3Qgb25DaGFuZ2VGZWF0dXJlZEltYWdlTGFiZWwgPSBuZXdGZWF0dXJlZEltYWdlTGFiZWwgPT4ge1xuICAgICAgICAgICAgc2V0QXR0cmlidXRlcyggeyBmZWF0dXJlZF9pbWFnZV9sYWJlbDogbmV3RmVhdHVyZWRJbWFnZUxhYmVsIH0gKTtcbiAgICAgICAgfTtcblxuICAgICAgICByZXR1cm4gKFxuICAgICAgICAgICAgPEZyYWdtZW50PlxuICAgICAgICAgICAgICAgIDxJbnNwZWN0b3JDb250cm9scz5cbiAgICAgICAgICAgICAgICAgICAgPFRleHRDb250cm9sXG4gICAgICAgICAgICAgICAgICAgICAgICBsYWJlbD17X18oJ1NlY3Rpb24gVGl0bGUnLCAndm9kaS1leHRlbnNpb25zJyl9XG4gICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZT17IHNlY3Rpb25fdGl0bGUgfVxuICAgICAgICAgICAgICAgICAgICAgICAgb25DaGFuZ2U9eyBvbkNoYW5nZVNlY3Rpb25UaXRsZSB9XG4gICAgICAgICAgICAgICAgICAgIC8+XG4gICAgICAgICAgICAgICAgICAgIDxUZXh0Q29udHJvbFxuICAgICAgICAgICAgICAgICAgICAgICAgbGFiZWw9e19fKCdTZWN0aW9uIFN1YnRpdGxlJywgJ3ZvZGktZXh0ZW5zaW9ucycpfVxuICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWU9eyBzZWN0aW9uX3N1YnRpdGxlIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIG9uQ2hhbmdlPXsgb25DaGFuZ2VTZWN0aW9uU3VidGl0bGUgfVxuICAgICAgICAgICAgICAgICAgICAvPlxuICAgICAgICAgICAgICAgICAgICA8VGV4dENvbnRyb2xcbiAgICAgICAgICAgICAgICAgICAgICAgIGxhYmVsPXtfXygnU2VjdGlvbiBEZXNjJywgJ3ZvZGktZXh0ZW5zaW9ucycpfVxuICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWU9eyBzZWN0aW9uX2Rlc2MgfVxuICAgICAgICAgICAgICAgICAgICAgICAgb25DaGFuZ2U9eyBvbkNoYW5nZVNlY3Rpb25EZXNjIH1cbiAgICAgICAgICAgICAgICAgICAgLz5cbiAgICAgICAgICAgICAgICAgICAgPFRleHRDb250cm9sXG4gICAgICAgICAgICAgICAgICAgICAgICBsYWJlbD17X18oJ0FjdGlvbiBUZXh0JywgJ3ZvZGktZXh0ZW5zaW9ucycpfVxuICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWU9eyBhY3Rpb25fdGV4dCB9XG4gICAgICAgICAgICAgICAgICAgICAgICBvbkNoYW5nZT17IG9uQ2hhbmdlQWN0aW9uVGV4dCB9XG4gICAgICAgICAgICAgICAgICAgIC8+XG4gICAgICAgICAgICAgICAgICAgIDxUZXh0Q29udHJvbFxuICAgICAgICAgICAgICAgICAgICAgICAgbGFiZWw9e19fKCdBY3Rpb24gTGluaycsICd2b2RpLWV4dGVuc2lvbnMnKX1cbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlPXsgYWN0aW9uX2xpbmsgfVxuICAgICAgICAgICAgICAgICAgICAgICAgb25DaGFuZ2U9eyBvbkNoYW5nZUFjdGlvbkxpbmsgfVxuICAgICAgICAgICAgICAgICAgICAvPlxuICAgICAgICAgICAgICAgICAgICA8SW1hZ2VVcGxvYWRcbiAgICAgICAgICAgICAgICAgICAgICAgIGFkZEltYWdlTGFiZWw9eyBfXygnUGljayBhbiBCYWNrZ3JvdW5kIEltYWdlJywgJ3ZvZGktZXh0ZW5zaW9ucycpIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIHJlcGxhY2VJbWFnZUxhYmVsPXsgX18oJ1JlcGxhY2UgQmFja2dyb3VuZCBJbWFnZScsICd2b2RpLWV4dGVuc2lvbnMnKSB9XG4gICAgICAgICAgICAgICAgICAgICAgICByZW1vdmVJbWFnZUxhYmVsPXsgX18oJ1JlbW92ZSBCYWNrZ3JvdW5kIEltYWdlJywgJ3ZvZGktZXh0ZW5zaW9ucycpIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlPXsgZmVhdHVyZWRfYmdfaW1hZ2UgfVxuICAgICAgICAgICAgICAgICAgICAgICAgb25TZWxlY3Q9eyBvbkNoYW5nZUZlYXR1cmVkQmdJbWFnZSB9XG4gICAgICAgICAgICAgICAgICAgIC8+XG4gICAgICAgICAgICAgICAgICAgIDxJbWFnZVVwbG9hZFxuICAgICAgICAgICAgICAgICAgICAgICAgYWRkSW1hZ2VMYWJlbD17IF9fKCdQaWNrIGFuIEltYWdlJywgJ3ZvZGktZXh0ZW5zaW9ucycpIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIHJlcGxhY2VJbWFnZUxhYmVsPXsgX18oJ1JlcGxhY2UgSW1hZ2UnLCAndm9kaS1leHRlbnNpb25zJykgfVxuICAgICAgICAgICAgICAgICAgICAgICAgcmVtb3ZlSW1hZ2VMYWJlbD17IF9fKCdSZW1vdmUgSW1hZ2UnLCAndm9kaS1leHRlbnNpb25zJykgfVxuICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWU9eyBmZWF0dXJlZF9pbWFnZSB9XG4gICAgICAgICAgICAgICAgICAgICAgICBvblNlbGVjdD17IG9uQ2hhbmdlRmVhdHVyZWRJbWFnZSB9XG4gICAgICAgICAgICAgICAgICAgIC8+XG4gICAgICAgICAgICAgICAgICAgIDxUZXh0Q29udHJvbFxuICAgICAgICAgICAgICAgICAgICAgICAgbGFiZWw9e19fKCdGZWF0dXJlZCBJbWFnZSBMYWJlbCcsICd2b2RpLWV4dGVuc2lvbnMnKX1cbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlPXsgZmVhdHVyZWRfaW1hZ2VfbGFiZWwgfVxuICAgICAgICAgICAgICAgICAgICAgICAgb25DaGFuZ2U9eyBvbkNoYW5nZUZlYXR1cmVkSW1hZ2VMYWJlbCB9XG4gICAgICAgICAgICAgICAgICAgIC8+XG4gICAgICAgICAgICAgICAgICAgIDxQYW5lbEJvZHlcbiAgICAgICAgICAgICAgICAgICAgICAgIHRpdGxlPXtfXygnRGVzaWduIE9wdGlvbnMnLCAndm9kaS1leHRlbnNpb25zJyl9XG4gICAgICAgICAgICAgICAgICAgICAgICBpbml0aWFsT3Blbj17IGZhbHNlIH1cbiAgICAgICAgICAgICAgICAgICAgPlxuICAgICAgICAgICAgICAgICAgICAgICAgPERlc2lnbk9wdGlvbnNcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBhdHRyaWJ1dGVzID0geyB7IC4uLmRlc2lnbl9vcHRpb25zIH0gfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHVwZGF0ZURlc2lnbk9wdGlvbnMgPSB7IG9uQ2hhbmdlRGVzaWduT3B0aW9ucyB9XG4gICAgICAgICAgICAgICAgICAgICAgICAvPlxuICAgICAgICAgICAgICAgICAgICA8L1BhbmVsQm9keT5cbiAgICAgICAgICAgICAgICA8L0luc3BlY3RvckNvbnRyb2xzPlxuICAgICAgICAgICAgICAgIDxEaXNhYmxlZD5cbiAgICAgICAgICAgICAgICAgICAgPFNlcnZlclNpZGVSZW5kZXJcbiAgICAgICAgICAgICAgICAgICAgICAgIGJsb2NrPVwidm9kaS9sYW5kaW5nLWZlYXR1cmVkLXNlY3Rpb25cIlxuICAgICAgICAgICAgICAgICAgICAgICAgYXR0cmlidXRlcz17IGF0dHJpYnV0ZXMgfVxuICAgICAgICAgICAgICAgICAgICAvPlxuICAgICAgICAgICAgICAgIDwvRGlzYWJsZWQ+XG4gICAgICAgICAgICA8L0ZyYWdtZW50PlxuICAgICAgICApO1xuICAgIH0gKSxcblxuICAgIHNhdmUoKSB7XG4gICAgICAgIC8vIFJlbmRlcmluZyBpbiBQSFBcbiAgICAgICAgcmV0dXJuIG51bGw7XG4gICAgfSxcbn0gKTsiLCJjb25zdCB7IF9fIH0gPSB3cC5pMThuO1xuY29uc3QgeyBDb21wb25lbnQgfSA9IHdwLmVsZW1lbnQ7XG5jb25zdCB7IFJhbmdlQ29udHJvbCB9ID0gd3AuY29tcG9uZW50cztcblxuLyoqXG4gKiBEZXNpZ25PcHRpb25zIENvbXBvbmVudFxuICovXG5leHBvcnQgY2xhc3MgRGVzaWduT3B0aW9ucyBleHRlbmRzIENvbXBvbmVudCB7XG4gICAgLyoqXG4gICAgICogQ29uc3RydWN0b3IgZm9yIERlc2lnbk9wdGlvbnMgQ29tcG9uZW50LlxuICAgICAqIFNldHMgdXAgc3RhdGUsIGFuZCBjcmVhdGVzIGJpbmRpbmdzIGZvciBmdW5jdGlvbnMuXG4gICAgICogQHBhcmFtIG9iamVjdCBwcm9wcyAtIGN1cnJlbnQgY29tcG9uZW50IHByb3BlcnRpZXMuXG4gICAgICovXG4gICAgY29uc3RydWN0b3IocHJvcHMpIHtcbiAgICAgICAgc3VwZXIoLi4uYXJndW1lbnRzKTtcbiAgICAgICAgdGhpcy5wcm9wcyA9IHByb3BzO1xuXG4gICAgICAgIHRoaXMub25DaGFuZ2VQYWRkaW5nVG9wID0gdGhpcy5vbkNoYW5nZVBhZGRpbmdUb3AuYmluZCh0aGlzKTtcbiAgICAgICAgdGhpcy5vbkNoYW5nZVBhZGRpbmdCb3R0b20gPSB0aGlzLm9uQ2hhbmdlUGFkZGluZ0JvdHRvbS5iaW5kKHRoaXMpO1xuICAgICAgICB0aGlzLm9uQ2hhbmdlUGFkZGluZ0xlZnQgPSB0aGlzLm9uQ2hhbmdlUGFkZGluZ0xlZnQuYmluZCh0aGlzKTtcbiAgICAgICAgdGhpcy5vbkNoYW5nZVBhZGRpbmdSaWdodCA9IHRoaXMub25DaGFuZ2VQYWRkaW5nUmlnaHQuYmluZCh0aGlzKTtcbiAgICAgICAgdGhpcy5vbkNoYW5nZU1hcmdpblRvcCA9IHRoaXMub25DaGFuZ2VNYXJnaW5Ub3AuYmluZCh0aGlzKTtcbiAgICAgICAgdGhpcy5vbkNoYW5nZU1hcmdpbkJvdHRvbSA9IHRoaXMub25DaGFuZ2VNYXJnaW5Cb3R0b20uYmluZCh0aGlzKTtcbiAgICB9XG5cbiAgICBvbkNoYW5nZVBhZGRpbmdUb3AoIG5ld29uQ2hhbmdlUGFkZGluZ1RvcCApIHtcbiAgICAgICAgdGhpcy5wcm9wcy51cGRhdGVEZXNpZ25PcHRpb25zKHtcbiAgICAgICAgICAgIHBhZGRpbmdfdG9wOiBuZXdvbkNoYW5nZVBhZGRpbmdUb3BcbiAgICAgICAgfSk7XG4gICAgfVxuXG4gICAgb25DaGFuZ2VQYWRkaW5nQm90dG9tKCBuZXdvbkNoYW5nZVBhZGRpbmdCb3R0b20gKSB7XG4gICAgICAgIHRoaXMucHJvcHMudXBkYXRlRGVzaWduT3B0aW9ucyh7XG4gICAgICAgICAgICBwYWRkaW5nX2JvdHRvbTogbmV3b25DaGFuZ2VQYWRkaW5nQm90dG9tXG4gICAgICAgIH0pO1xuICAgIH1cblxuICAgIG9uQ2hhbmdlUGFkZGluZ0xlZnQoIG5ld29uQ2hhbmdlUGFkZGluZ0xlZnQgKSB7XG4gICAgICAgIHRoaXMucHJvcHMudXBkYXRlRGVzaWduT3B0aW9ucyh7XG4gICAgICAgICAgICBwYWRkaW5nX2xlZnQ6IG5ld29uQ2hhbmdlUGFkZGluZ0xlZnRcbiAgICAgICAgfSk7XG4gICAgfVxuXG4gICAgb25DaGFuZ2VQYWRkaW5nUmlnaHQoIG5ld29uQ2hhbmdlUGFkZGluZ1JpZ2h0ICkge1xuICAgICAgICB0aGlzLnByb3BzLnVwZGF0ZURlc2lnbk9wdGlvbnMoe1xuICAgICAgICAgICAgcGFkZGluZ19yaWdodDogbmV3b25DaGFuZ2VQYWRkaW5nUmlnaHRcbiAgICAgICAgfSk7XG4gICAgfVxuXG4gICAgb25DaGFuZ2VNYXJnaW5Ub3AoIG5ld29uQ2hhbmdlTWFyZ2luVG9wICkge1xuICAgICAgICB0aGlzLnByb3BzLnVwZGF0ZURlc2lnbk9wdGlvbnMoe1xuICAgICAgICAgICAgbWFyZ2luX3RvcDogbmV3b25DaGFuZ2VNYXJnaW5Ub3BcbiAgICAgICAgfSk7XG4gICAgfVxuXG4gICAgb25DaGFuZ2VNYXJnaW5Cb3R0b20oIG5ld29uQ2hhbmdlTWFyZ2luQm90dG9tICkge1xuICAgICAgICB0aGlzLnByb3BzLnVwZGF0ZURlc2lnbk9wdGlvbnMoe1xuICAgICAgICAgICAgbWFyZ2luX2JvdHRvbTogbmV3b25DaGFuZ2VNYXJnaW5Cb3R0b21cbiAgICAgICAgfSk7XG4gICAgfVxuXG4gICAgLyoqXG4gICAgICogUmVuZGVycyB0aGUgRGVzaWduT3B0aW9ucyBjb21wb25lbnQuXG4gICAgICovXG4gICAgcmVuZGVyKCkge1xuICAgICAgICBjb25zdCB7IGF0dHJpYnV0ZXMgfSA9IHRoaXMucHJvcHM7XG4gICAgICAgIGNvbnN0IHsgcGFkZGluZ190b3AsIHBhZGRpbmdfYm90dG9tLCBwYWRkaW5nX2xlZnQsIHBhZGRpbmdfcmlnaHQsIG1hcmdpbl90b3AsIG1hcmdpbl9ib3R0b20gfSA9IGF0dHJpYnV0ZXM7XG5cbiAgICAgICAgcmV0dXJuIChcbiAgICAgICAgICAgIDxkaXY+XG4gICAgICAgICAgICAgICAgPFJhbmdlQ29udHJvbFxuICAgICAgICAgICAgICAgICAgICBsYWJlbD17X18oJ1BhZGRpbmcgVG9wIChweCknLCAndm9kaS1leHRlbnNpb25zJyl9XG4gICAgICAgICAgICAgICAgICAgIHZhbHVlPXsgcGFkZGluZ190b3AgfVxuICAgICAgICAgICAgICAgICAgICBvbkNoYW5nZT17IHRoaXMub25DaGFuZ2VQYWRkaW5nVG9wIH1cbiAgICAgICAgICAgICAgICAgICAgbWluPXsgMCB9XG4gICAgICAgICAgICAgICAgICAgIG1heD17IDEwMCB9XG4gICAgICAgICAgICAgICAgLz5cbiAgICAgICAgICAgICAgICA8UmFuZ2VDb250cm9sXG4gICAgICAgICAgICAgICAgICAgIGxhYmVsPXtfXygnUGFkZGluZyBCb3R0b20gKHB4KScsICd2b2RpLWV4dGVuc2lvbnMnKX1cbiAgICAgICAgICAgICAgICAgICAgdmFsdWU9eyBwYWRkaW5nX2JvdHRvbSB9XG4gICAgICAgICAgICAgICAgICAgIG9uQ2hhbmdlPXsgdGhpcy5vbkNoYW5nZVBhZGRpbmdCb3R0b20gfVxuICAgICAgICAgICAgICAgICAgICBtaW49eyAwIH1cbiAgICAgICAgICAgICAgICAgICAgbWF4PXsgMTAwIH1cbiAgICAgICAgICAgICAgICAvPlxuICAgICAgICAgICAgICAgIDxSYW5nZUNvbnRyb2xcbiAgICAgICAgICAgICAgICAgICAgbGFiZWw9e19fKCdQYWRkaW5nIExlZnQgKHB4KScsICd2b2RpLWV4dGVuc2lvbnMnKX1cbiAgICAgICAgICAgICAgICAgICAgdmFsdWU9eyBwYWRkaW5nX2xlZnQgfVxuICAgICAgICAgICAgICAgICAgICBvbkNoYW5nZT17IHRoaXMub25DaGFuZ2VQYWRkaW5nTGVmdCB9XG4gICAgICAgICAgICAgICAgICAgIG1pbj17IDAgfVxuICAgICAgICAgICAgICAgICAgICBtYXg9eyAxMDAgfVxuICAgICAgICAgICAgICAgIC8+XG4gICAgICAgICAgICAgICAgPFJhbmdlQ29udHJvbFxuICAgICAgICAgICAgICAgICAgICBsYWJlbD17X18oJ1BhZGRpbmcgUmlnaHQgKHB4KScsICd2b2RpLWV4dGVuc2lvbnMnKX1cbiAgICAgICAgICAgICAgICAgICAgdmFsdWU9eyBwYWRkaW5nX3JpZ2h0IH1cbiAgICAgICAgICAgICAgICAgICAgb25DaGFuZ2U9eyB0aGlzLm9uQ2hhbmdlUGFkZGluZ1JpZ2h0IH1cbiAgICAgICAgICAgICAgICAgICAgbWluPXsgMCB9XG4gICAgICAgICAgICAgICAgICAgIG1heD17IDEwMCB9XG4gICAgICAgICAgICAgICAgLz5cbiAgICAgICAgICAgICAgICA8UmFuZ2VDb250cm9sXG4gICAgICAgICAgICAgICAgICAgIGxhYmVsPXtfXygnTWFyZ2luIFRvcCAocHgpJywgJ3ZvZGktZXh0ZW5zaW9ucycpfVxuICAgICAgICAgICAgICAgICAgICB2YWx1ZT17IG1hcmdpbl90b3AgfVxuICAgICAgICAgICAgICAgICAgICBvbkNoYW5nZT17IHRoaXMub25DaGFuZ2VNYXJnaW5Ub3AgfVxuICAgICAgICAgICAgICAgICAgICBtaW49eyAtMTAwIH1cbiAgICAgICAgICAgICAgICAgICAgbWF4PXsgMTAwIH1cbiAgICAgICAgICAgICAgICAvPlxuICAgICAgICAgICAgICAgIDxSYW5nZUNvbnRyb2xcbiAgICAgICAgICAgICAgICAgICAgbGFiZWw9e19fKCdNYXJnaW4gQm90dG9tIChweCknLCAndm9kaS1leHRlbnNpb25zJyl9XG4gICAgICAgICAgICAgICAgICAgIHZhbHVlPXsgbWFyZ2luX2JvdHRvbSB9XG4gICAgICAgICAgICAgICAgICAgIG9uQ2hhbmdlPXsgdGhpcy5vbkNoYW5nZU1hcmdpbkJvdHRvbSB9XG4gICAgICAgICAgICAgICAgICAgIG1pbj17IC0xMDAgfVxuICAgICAgICAgICAgICAgICAgICBtYXg9eyAxMDAgfVxuICAgICAgICAgICAgICAgIC8+XG4gICAgICAgICAgICA8L2Rpdj5cbiAgICAgICAgKTtcbiAgICB9XG59IiwiY29uc3QgeyBfXyB9ID0gd3AuaTE4bjtcbmNvbnN0IHsgTWVkaWFVcGxvYWQgfSA9IHdwLmVkaXRvcjtcbmNvbnN0IHsgRnJhZ21lbnQsIENvbXBvbmVudCB9ID0gd3AuZWxlbWVudDtcbmNvbnN0IHsgQnV0dG9uIH0gPSB3cC5jb21wb25lbnRzO1xuXG4vKipcbiAqIEltYWdlVXBsb2FkIENvbXBvbmVudFxuICovXG5leHBvcnQgY2xhc3MgSW1hZ2VVcGxvYWQgZXh0ZW5kcyBDb21wb25lbnQge1xuICAgIC8qKlxuICAgICAqIENvbnN0cnVjdG9yIGZvciBJbWFnZVVwbG9hZCBDb21wb25lbnQuXG4gICAgICogU2V0cyB1cCBzdGF0ZSwgYW5kIGNyZWF0ZXMgYmluZGluZ3MgZm9yIGZ1bmN0aW9ucy5cbiAgICAgKiBAcGFyYW0gb2JqZWN0IHByb3BzIC0gY3VycmVudCBjb21wb25lbnQgcHJvcGVydGllcy5cbiAgICAgKi9cbiAgICBjb25zdHJ1Y3Rvcihwcm9wcykge1xuICAgICAgICBzdXBlciguLi5hcmd1bWVudHMpO1xuICAgICAgICB0aGlzLnByb3BzID0gcHJvcHM7XG5cbiAgICAgICAgdGhpcy5vbkNoYW5nZUltYWdlID0gdGhpcy5vbkNoYW5nZUltYWdlLmJpbmQodGhpcyk7XG4gICAgICAgIHRoaXMub25SZW1vdmVJbWFnZSA9IHRoaXMub25SZW1vdmVJbWFnZS5iaW5kKHRoaXMpO1xuICAgIH1cblxuICAgIG9uQ2hhbmdlSW1hZ2UoIG1lZGlhICkge1xuICAgICAgICB0aGlzLnByb3BzLm9uU2VsZWN0KCBtZWRpYSApO1xuICAgIH1cblxuICAgIG9uUmVtb3ZlSW1hZ2UoKSB7XG4gICAgICAgIHRoaXMucHJvcHMub25TZWxlY3QoIDAgKTtcbiAgICB9XG5cbiAgICAvKipcbiAgICAgKiBSZW5kZXJzIHRoZSBJbWFnZVVwbG9hZCBjb21wb25lbnQuXG4gICAgICovXG4gICAgcmVuZGVyKCkge1xuICAgICAgICBjb25zdCB7IGF0dHJpYnV0ZXMsIGFkZEltYWdlTGFiZWwsIHJlcGxhY2VJbWFnZUxhYmVsLCByZW1vdmVJbWFnZUxhYmVsLCB2YWx1ZSB9ID0gdGhpcy5wcm9wcztcblxuICAgICAgICByZXR1cm4gKFxuICAgICAgICAgICAgPGRpdiBjbGFzc05hbWU9XCJjb21wb25lbnRzLWJhc2UtY29udHJvbCBjb21wb25lbnRzLWltYWdlLXVwbG9hZFwiPlxuICAgICAgICAgICAgICAgIDxkaXYgY2xhc3NOYW1lPVwiY29tcG9uZW50cy1iYXNlLWNvbnRyb2xfX2ZpZWxkXCI+XG4gICAgICAgICAgICAgICAgICAgIDxNZWRpYVVwbG9hZFxuICAgICAgICAgICAgICAgICAgICAgICAgb25TZWxlY3Q9eyB0aGlzLm9uQ2hhbmdlSW1hZ2UgfVxuICAgICAgICAgICAgICAgICAgICAgICAgdHlwZT1cImltYWdlXCJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlPXsgdmFsdWUgfVxuICAgICAgICAgICAgICAgICAgICAgICAgcmVuZGVyPXsgKCB7IG9wZW4gfSApID0+IChcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzTmFtZT1cImJ1dHRvbi1jb250YWluZXJcIj5cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPEJ1dHRvbiBpc0xhcmdlIG9uQ2xpY2s9eyBvcGVuIH0+XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB7ICggdmFsdWUgKSA/IHJlcGxhY2VJbWFnZUxhYmVsIDogYWRkSW1hZ2VMYWJlbCB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDwvQnV0dG9uPlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDwvZGl2PlxuICAgICAgICAgICAgICAgICAgICAgICAgKSB9XG4gICAgICAgICAgICAgICAgICAgIC8+XG4gICAgICAgICAgICAgICAgPC9kaXY+XG4gICAgICAgICAgICAgICAgeyAoIHZhbHVlICkgPyAoXG4gICAgICAgICAgICAgICAgICAgIDxkaXYgY2xhc3NOYW1lPVwiY29tcG9uZW50cy1iYXNlLWNvbnRyb2xfX2ZpZWxkXCI+XG4gICAgICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzTmFtZT1cImJ1dHRvbi1jb250YWluZXJcIj5cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8QnV0dG9uIGlzTGFyZ2Ugb25DbGljaz17IHRoaXMub25SZW1vdmVJbWFnZSB9PlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB7IHJlbW92ZUltYWdlTGFiZWwgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDwvQnV0dG9uPlxuICAgICAgICAgICAgICAgICAgICAgICAgPC9kaXY+XG4gICAgICAgICAgICAgICAgICAgIDwvZGl2PlxuICAgICAgICAgICAgICAgICkgOiAnJyB9XG4gICAgICAgICAgICA8L2Rpdj5cbiAgICAgICAgKTtcbiAgICB9XG59Il19
