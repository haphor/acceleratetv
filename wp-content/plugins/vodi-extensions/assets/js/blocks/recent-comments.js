(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

var _DesignOptions = require("../components/DesignOptions");

var _Repeater = require("../components/Repeater");

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

var __ = wp.i18n.__;
var registerBlockType = wp.blocks.registerBlockType;
var InspectorControls = wp.editor.InspectorControls;
var Fragment = wp.element.Fragment;
var _wp$components = wp.components,
    ServerSideRender = _wp$components.ServerSideRender,
    Disabled = _wp$components.Disabled,
    PanelBody = _wp$components.PanelBody,
    TextControl = _wp$components.TextControl,
    SelectControl = _wp$components.SelectControl,
    RangeControl = _wp$components.RangeControl;
registerBlockType('vodi/recent-comments', {
  title: __('Vodi Recent Comment', 'vodi-extensions'),
  icon: 'list-view',
  category: 'vodi-blocks',
  edit: function edit(props) {
    var attributes = props.attributes,
        setAttributes = props.setAttributes;
    var section_title = attributes.section_title,
        section_nav_links = attributes.section_nav_links,
        limit = attributes.limit,
        design_options = attributes.design_options;

    var onChangeSectionTitle = function onChangeSectionTitle(newSectionTitle) {
      setAttributes({
        section_title: newSectionTitle
      });
    };

    var onChangeSectionNavLinks = function onChangeSectionNavLinks(newSectionNavLinks) {
      setAttributes({
        section_nav_links: JSON.stringify(_toConsumableArray(newSectionNavLinks))
      });
    };

    var onChangeSectionNavLinksText = function onChangeSectionNavLinksText(newSectionNavLinksText, index) {
      var section_nav_links_updated = JSON.parse(section_nav_links);
      section_nav_links_updated[index].title = newSectionNavLinksText;
      setAttributes({
        section_nav_links: JSON.stringify(_toConsumableArray(section_nav_links_updated))
      });
    };

    var onChangeSectionNavLinksLink = function onChangeSectionNavLinksLink(newSectionNavLinksLink, index) {
      var section_nav_links_updated = JSON.parse(section_nav_links);
      section_nav_links_updated[index].link = newSectionNavLinksLink;
      setAttributes({
        section_nav_links: JSON.stringify(_toConsumableArray(section_nav_links_updated))
      });
    };

    var onChangeLimit = function onChangeLimit(newLimit) {
      setAttributes({
        limit: newLimit
      });
    };

    var onChangeDesignOptions = function onChangeDesignOptions(newDesignOptions) {
      setAttributes({
        design_options: _objectSpread({}, design_options, {}, newDesignOptions)
      });
    };

    return wp.element.createElement(Fragment, null, wp.element.createElement(InspectorControls, null, wp.element.createElement(TextControl, {
      label: __('Section Title', 'vodi-extensions'),
      value: section_title,
      onChange: onChangeSectionTitle
    }), wp.element.createElement(_Repeater.Repeater, {
      title: __('Nav Links', 'vodi-extensions'),
      values: section_nav_links ? JSON.parse(section_nav_links) : [],
      defaultValues: {
        title: '',
        link: ''
      },
      updateValues: onChangeSectionNavLinks
    }, wp.element.createElement(TextControl, {
      label: __('Action Text', 'vodi-extensions'),
      name: "title",
      valuekey: "value",
      value: "",
      trigger_method_name: "onChange",
      onChange: onChangeSectionNavLinksText
    }), wp.element.createElement(TextControl, {
      label: __('Action Link', 'vodi-extensions'),
      name: "link",
      valuekey: "value",
      value: "",
      trigger_method_name: "onChange",
      onChange: onChangeSectionNavLinksLink
    })), wp.element.createElement(PanelBody, {
      title: __('Number of comments to show', 'vodi-extensions'),
      initialOpen: true
    }, wp.element.createElement(RangeControl, {
      label: __('Limit', 'vodi-extensions'),
      value: limit,
      onChange: onChangeLimit,
      min: 1,
      max: 10
    })), wp.element.createElement(PanelBody, {
      title: __('Design Options', 'vodi-extensions'),
      initialOpen: false
    }, wp.element.createElement(_DesignOptions.DesignOptions, {
      attributes: _objectSpread({}, design_options),
      updateDesignOptions: onChangeDesignOptions
    }))), wp.element.createElement(Disabled, null, wp.element.createElement(ServerSideRender, {
      block: "vodi/recent-comments",
      attributes: attributes
    })));
  },
  save: function save() {
    // Rendering in PHP
    return null;
  }
});

},{"../components/DesignOptions":2,"../components/Repeater":3}],2:[function(require,module,exports){
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
exports.Repeater = void 0;

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

var __ = wp.i18n.__;
var _wp$element = wp.element,
    Component = _wp$element.Component,
    Children = _wp$element.Children;
var _wp$components = wp.components,
    Panel = _wp$components.Panel,
    Button = _wp$components.Button,
    Icon = _wp$components.Icon;
/**
 * Repeater Component
 */

var Repeater =
/*#__PURE__*/
function (_Component) {
  _inherits(Repeater, _Component);

  /**
   * Constructor for Repeater Component.
   * Sets up state, and creates bindings for functions.
   * @param object props - current component properties.
   */
  function Repeater(props) {
    var _this;

    _classCallCheck(this, Repeater);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(Repeater).apply(this, arguments));
    _this.props = props;
    _this.renderAddButton = _this.renderAddButton.bind(_assertThisInitialized(_this));
    _this.renderRemoveButton = _this.renderRemoveButton.bind(_assertThisInitialized(_this));
    _this.handleAdd = _this.handleAdd.bind(_assertThisInitialized(_this));
    _this.handleRemove = _this.handleRemove.bind(_assertThisInitialized(_this));
    _this.renderChildrenElements = _this.renderChildrenElements.bind(_assertThisInitialized(_this));
    return _this;
  }

  _createClass(Repeater, [{
    key: "renderAddButton",
    value: function renderAddButton() {
      return wp.element.createElement(Button, {
        isDefault: true,
        className: "button-fullwidth",
        onClick: this.handleAdd
      }, wp.element.createElement(Icon, {
        icon: "plus"
      }));
    }
  }, {
    key: "renderRemoveButton",
    value: function renderRemoveButton() {
      return wp.element.createElement(Button, {
        isDestructive: true,
        className: "button-remove",
        onClick: this.handleRemove
      }, wp.element.createElement(Icon, {
        icon: "dismiss"
      }));
    }
  }, {
    key: "handleAdd",
    value: function handleAdd() {
      var _this$props = this.props,
          defaultValues = _this$props.defaultValues,
          updateValues = _this$props.updateValues;
      var values = this.props.values;
      var current_values = values ? [].concat(_toConsumableArray(values), [_objectSpread({}, defaultValues)]) : [_objectSpread({}, defaultValues)];
      updateValues(current_values);
    }
  }, {
    key: "handleRemove",
    value: function handleRemove(index) {
      var updateValues = this.props.updateValues;
      var values = this.props.values;
      var current_values = values.filter(function (value, i) {
        return i != index;
      });
      updateValues(current_values);
    }
  }, {
    key: "renderChildrenElements",
    value: function renderChildrenElements() {
      var children = this.props.children;
      var values = this.props.values;

      if (!values) {
        return [];
      }

      var remove_button = this.renderRemoveButton();
      return values.map(function (value, index) {
        var updated_children = Children.map(children, function (child) {
          var child_props = _objectSpread({}, child.props);

          if (values[index][child.props.name]) {
            child_props[child.props.valuekey] = values[index][child.props.name];
          }

          child_props[child.props.trigger_method_name] = function (value) {
            return child.props[child.props.trigger_method_name](value, index);
          };

          return React.cloneElement(child, _objectSpread({}, child_props));
        });
        var updated_remove_button = React.cloneElement(remove_button, {
          key: 'repeater-remove-' + index,
          onClick: function onClick() {
            return remove_button.props['onClick'](index);
          }
        });
        return React.createElement(Panel, {
          key: 'repeater-child-' + index
        }, [updated_children, updated_remove_button]);
      });
    }
    /**
     * Renders the Repeater component.
     */

  }, {
    key: "render",
    value: function render() {
      return wp.element.createElement("div", {
        className: "components-base-control repeater-component"
      }, wp.element.createElement("div", {
        className: "components-base-control__field"
      }, wp.element.createElement("label", {
        className: "components-base-control__label"
      }, this.props.title), this.renderChildrenElements(), this.renderAddButton()));
    }
  }]);

  return Repeater;
}(Component);

exports.Repeater = Repeater;

},{}]},{},[1])
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9icm93c2VyLXBhY2svX3ByZWx1ZGUuanMiLCJzcmMvcGx1Z2lucy92b2RpLWV4dGVuc2lvbnMvYXNzZXRzL2VzbmV4dC9ibG9ja3MvcmVjZW50LWNvbW1lbnRzLmpzIiwic3JjL3BsdWdpbnMvdm9kaS1leHRlbnNpb25zL2Fzc2V0cy9lc25leHQvY29tcG9uZW50cy9EZXNpZ25PcHRpb25zLmpzIiwic3JjL3BsdWdpbnMvdm9kaS1leHRlbnNpb25zL2Fzc2V0cy9lc25leHQvY29tcG9uZW50cy9SZXBlYXRlci5qcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQTs7O0FDQUE7O0FBQ0E7Ozs7Ozs7Ozs7Ozs7Ozs7SUFFUSxFLEdBQU8sRUFBRSxDQUFDLEksQ0FBVixFO0lBQ0EsaUIsR0FBc0IsRUFBRSxDQUFDLE0sQ0FBekIsaUI7SUFDQSxpQixHQUFzQixFQUFFLENBQUMsTSxDQUF6QixpQjtJQUNBLFEsR0FBYSxFQUFFLENBQUMsTyxDQUFoQixRO3FCQUNvRixFQUFFLENBQUMsVTtJQUF2RixnQixrQkFBQSxnQjtJQUFrQixRLGtCQUFBLFE7SUFBVSxTLGtCQUFBLFM7SUFBVyxXLGtCQUFBLFc7SUFBYSxhLGtCQUFBLGE7SUFBZSxZLGtCQUFBLFk7QUFFM0UsaUJBQWlCLENBQUUsc0JBQUYsRUFBMEI7QUFDdkMsRUFBQSxLQUFLLEVBQUUsRUFBRSxDQUFDLHFCQUFELEVBQXdCLGlCQUF4QixDQUQ4QjtBQUd2QyxFQUFBLElBQUksRUFBRSxXQUhpQztBQUt2QyxFQUFBLFFBQVEsRUFBRSxhQUw2QjtBQU92QyxFQUFBLElBQUksRUFBSSxjQUFFLEtBQUYsRUFBYTtBQUFBLFFBQ1QsVUFEUyxHQUNxQixLQURyQixDQUNULFVBRFM7QUFBQSxRQUNHLGFBREgsR0FDcUIsS0FEckIsQ0FDRyxhQURIO0FBQUEsUUFFVCxhQUZTLEdBRW1ELFVBRm5ELENBRVQsYUFGUztBQUFBLFFBRU0saUJBRk4sR0FFbUQsVUFGbkQsQ0FFTSxpQkFG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QSxpQkFBTyxLQUFLLENBQUMsWUFBTixDQUFvQixLQUFwQixvQkFBZ0MsV0FBaEMsRUFBUDtBQUNILFNBUHdCLENBQXpCO0FBU0EsWUFBTSxxQkFBcUIsR0FBRyxLQUFLLENBQUMsWUFBTixDQUFvQixhQUFwQixFQUFtQztBQUFFLFVBQUEsR0FBRyxFQUFFLHFCQUFtQixLQUExQjtBQUFpQyxVQUFBLE9BQU8sRUFBRTtBQUFBLG1CQUFNLGFBQWEsQ0FBQyxLQUFkLENBQW9CLFNBQXBCLEVBQStCLEtBQS9CLENBQU47QUFBQTtBQUExQyxTQUFuQyxDQUE5QjtBQUVBLGVBQU8sS0FBSyxDQUFDLGFBQU4sQ0FBcUIsS0FBckIsRUFBNEI7QUFBRSxVQUFBLEdBQUcsRUFBRSxvQkFBa0I7QUFBekIsU0FBNUIsRUFBOEQsQ0FBQyxnQkFBRCxFQUFtQixxQkFBbkIsQ0FBOUQsQ0FBUDtBQUNILE9BYk0sQ0FBUDtBQWNIO0FBRUQ7Ozs7Ozs2QkFHUztBQUNMLGFBQ0k7QUFBSyxRQUFBLFNBQVMsRUFBQztBQUFmLFNBQ0k7QUFBSyxRQUFBLFNBQVMsRUFBQztBQUFmLFNBQ0k7QUFBTyxRQUFBLFNBQVMsRUFBQztBQUFqQixTQUFtRCxLQUFLLEtBQUwsQ0FBVyxLQUE5RCxDQURKLEVBRUssS0FBSyxzQkFBTCxFQUZMLEVBR0ssS0FBSyxlQUFMLEVBSEwsQ0FESixDQURKO0FBU0g7Ozs7RUF0RnlCLFMiLCJmaWxlIjoiZ2VuZXJhdGVkLmpzIiwic291cmNlUm9vdCI6IiIsInNvdXJjZXNDb250ZW50IjpbIihmdW5jdGlvbigpe2Z1bmN0aW9uIHIoZSxuLHQpe2Z1bmN0aW9uIG8oaSxmKXtpZighbltpXSl7aWYoIWVbaV0pe3ZhciBjPVwiZnVuY3Rpb25cIj09dHlwZW9mIHJlcXVpcmUmJnJlcXVpcmU7aWYoIWYmJmMpcmV0dXJuIGMoaSwhMCk7aWYodSlyZXR1cm4gdShpLCEwKTt2YXIgYT1uZXcgRXJyb3IoXCJDYW5ub3QgZmluZCBtb2R1bGUgJ1wiK2krXCInXCIpO3Rocm93IGEuY29kZT1cIk1PRFVMRV9OT1RfRk9VTkRcIixhfXZhciBwPW5baV09e2V4cG9ydHM6e319O2VbaV1bMF0uY2FsbChwLmV4cG9ydHMsZnVuY3Rpb24ocil7dmFyIG49ZVtpXVsxXVtyXTtyZXR1cm4gbyhufHxyKX0scCxwLmV4cG9ydHMscixlLG4sdCl9cmV0dXJuIG5baV0uZXhwb3J0c31mb3IodmFyIHU9XCJmdW5jdGlvblwiPT10eXBlb2YgcmVxdWlyZSYmcmVxdWlyZSxpPTA7aTx0Lmxlbmd0aDtpKyspbyh0W2ldKTtyZXR1cm4gb31yZXR1cm4gcn0pKCkiLCJpbXBvcnQgeyBEZXNpZ25PcHRpb25zIH0gZnJvbSAnLi4vY29tcG9uZW50cy9EZXNpZ25PcHRpb25zJztcbmltcG9ydCB7IFJlcGVhdGVyIH0gZnJvbSAnLi4vY29tcG9uZW50cy9SZXBlYXRlcic7XG5cbmNvbnN0IHsgX18gfSA9IHdwLmkxOG47XG5jb25zdCB7IHJlZ2lzdGVyQmxvY2tUeXBlIH0gPSB3cC5ibG9ja3M7XG5jb25zdCB7IEluc3BlY3RvckNvbnRyb2xzIH0gPSB3cC5lZGl0b3I7XG5jb25zdCB7IEZyYWdtZW50IH0gPSB3cC5lbGVtZW50O1xuY29uc3QgeyBTZXJ2ZXJTaWRlUmVuZGVyLCBEaXNhYmxlZCwgUGFuZWxCb2R5LCBUZXh0Q29udHJvbCwgU2VsZWN0Q29udHJvbCwgUmFuZ2VDb250cm9sIH0gPSB3cC5jb21wb25lbnRzO1xuXG5yZWdpc3RlckJsb2NrVHlwZSggJ3ZvZGkvcmVjZW50LWNvbW1lbnRzJywge1xuICAgIHRpdGxlOiBfXygnVm9kaSBSZWNlbnQgQ29tbWVudCcsICd2b2RpLWV4dGVuc2lvbnMnKSxcblxuICAgIGljb246ICdsaXN0LXZpZXcnLFxuXG4gICAgY2F0ZWdvcnk6ICd2b2RpLWJsb2NrcycsXG5cbiAgICBlZGl0OiAoICggcHJvcHMgKSA9PiB7XG4gICAgICAgIGNvbnN0IHsgYXR0cmlidXRlcywgc2V0QXR0cmlidXRlcyB9ID0gcHJvcHM7XG4gICAgICAgIGNvbnN0IHsgc2VjdGlvbl90aXRsZSwgc2VjdGlvbl9uYXZfbGlua3MsIGxpbWl0LCBkZXNpZ25fb3B0aW9ucyB9ID0gYXR0cmlidXRlcztcblxuICAgICAgICBjb25zdCBvbkNoYW5nZVNlY3Rpb25UaXRsZSA9IG5ld1NlY3Rpb25UaXRsZSA9PiB7XG4gICAgICAgICAgICBzZXRBdHRyaWJ1dGVzKCB7IHNlY3Rpb25fdGl0bGU6IG5ld1NlY3Rpb25UaXRsZSB9ICk7XG4gICAgICAgIH07XG5cbiAgICAgICAgY29uc3Qgb25DaGFuZ2VTZWN0aW9uTmF2TGlua3MgPSBuZXdTZWN0aW9uTmF2TGlua3MgPT4ge1xuICAgICAgICAgICAgc2V0QXR0cmlidXRlcyggeyBzZWN0aW9uX25hdl9saW5rczogSlNPTi5zdHJpbmdpZnkoWy4uLm5ld1NlY3Rpb25OYXZMaW5rc10pIH0gKTtcbiAgICAgICAgfTtcblxuICAgICAgICBjb25zdCBvbkNoYW5nZVNlY3Rpb25OYXZMaW5rc1RleHQgPSAobmV3U2VjdGlvbk5hdkxpbmtzVGV4dCwgaW5kZXgpID0+IHtcbiAgICAgICAgICAgIHZhciBzZWN0aW9uX25hdl9saW5rc191cGRhdGVkID0gSlNPTi5wYXJzZShzZWN0aW9uX25hdl9saW5rcyk7XG4gICAgICAgICAgICBzZWN0aW9uX25hdl9saW5rc191cGRhdGVkW2luZGV4XS50aXRsZSA9IG5ld1NlY3Rpb25OYXZMaW5rc1RleHQ7XG4gICAgICAgICAgICBzZXRBdHRyaWJ1dGVzKCB7IHNlY3Rpb25fbmF2X2xpbmtzOiBKU09OLnN0cmluZ2lmeShbLi4uc2VjdGlvbl9uYXZfbGlua3NfdXBkYXRlZF0pIH0gKTtcbiAgICAgICAgfTtcblxuICAgICAgICBjb25zdCBvbkNoYW5nZVNlY3Rpb25OYXZMaW5rc0xpbmsgPSAobmV3U2VjdGlvbk5hdkxpbmtzTGluaywgaW5kZXgpID0+IHtcbiAgICAgICAgICAgIHZhciBzZWN0aW9uX25hdl9saW5rc191cGRhdGVkID0gSlNPTi5wYXJzZShzZWN0aW9uX25hdl9saW5rcyk7XG4gICAgICAgICAgICBzZWN0aW9uX25hdl9saW5rc191cGRhdGVkW2luZGV4XS5saW5rID0gbmV3U2VjdGlvbk5hdkxpbmtzTGluaztcbiAgICAgICAgICAgIHNldEF0dHJpYnV0ZXMoIHsgc2VjdGlvbl9uYXZfbGlua3M6IEpTT04uc3RyaW5naWZ5KFsuLi5zZWN0aW9uX25hdl9saW5rc191cGRhdGVkXSkgfSApO1xuICAgICAgICB9O1xuXG4gICAgICAgIGNvbnN0IG9uQ2hhbmdlTGltaXQgPSBuZXdMaW1pdCA9PiB7XG4gICAgICAgICAgICBzZXRBdHRyaWJ1dGVzKCB7IGxpbWl0OiBuZXdMaW1pdCB9ICk7XG4gICAgICAgIH07XG5cbiAgICAgICAgY29uc3Qgb25DaGFuZ2VEZXNpZ25PcHRpb25zID0gbmV3RGVzaWduT3B0aW9ucyA9PiB7XG4gICAgICAgICAgICBzZXRBdHRyaWJ1dGVzKCB7IGRlc2lnbl9vcHRpb25zOiB7IC4uLmRlc2lnbl9vcHRpb25zLCAuLi5uZXdEZXNpZ25PcHRpb25zIH0gfSApO1xuICAgICAgICB9O1xuXG4gICAgICAgIHJldHVybiAoXG4gICAgICAgICAgICA8RnJhZ21lbnQ+XG4gICAgICAgICAgICAgICAgPEluc3BlY3RvckNvbnRyb2xzPlxuICAgICAgICAgICAgICAgICAgICA8VGV4dENvbnRyb2xcbiAgICAgICAgICAgICAgICAgICAgICAgIGxhYmVsPXtfXygnU2VjdGlvbiBUaXRsZScsICd2b2RpLWV4dGVuc2lvbnMnKX1cbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlPXsgc2VjdGlvbl90aXRsZSB9XG4gICAgICAgICAgICAgICAgICAgICAgICBvbkNoYW5nZT17IG9uQ2hhbmdlU2VjdGlvblRpdGxlIH1cbiAgICAgICAgICAgICAgICAgICAgLz5cbiAgICAgICAgICAgICAgICAgICAgPFJlcGVhdGVyXG4gICAgICAgICAgICAgICAgICAgICAgICB0aXRsZT17X18oJ05hdiBMaW5rcycsICd2b2RpLWV4dGVuc2lvbnMnKX1cbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlcz17IHNlY3Rpb25fbmF2X2xpbmtzID8gSlNPTi5wYXJzZShzZWN0aW9uX25hdl9saW5rcykgOiBbXSB9XG4gICAgICAgICAgICAgICAgICAgICAgICBkZWZhdWx0VmFsdWVzPXsgeyB0aXRsZTogJycsIGxpbms6ICcnIH0gfVxuICAgICAgICAgICAgICAgICAgICAgICAgdXBkYXRlVmFsdWVzPXsgb25DaGFuZ2VTZWN0aW9uTmF2TGlua3MgfVxuICAgICAgICAgICAgICAgICAgICA+XG4gICAgICAgICAgICAgICAgICAgICAgICA8VGV4dENvbnRyb2xcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBsYWJlbD17X18oJ0FjdGlvbiBUZXh0JywgJ3ZvZGktZXh0ZW5zaW9ucycpfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG5hbWU9J3RpdGxlJ1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVla2V5PSd2YWx1ZSdcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZT0nJ1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHRyaWdnZXJfbWV0aG9kX25hbWU9J29uQ2hhbmdlJ1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG9uQ2hhbmdlPXsgb25DaGFuZ2VTZWN0aW9uTmF2TGlua3NUZXh0IH1cbiAgICAgICAgICAgICAgICAgICAgICAgIC8+XG4gICAgICAgICAgICAgICAgICAgICAgICA8VGV4dENvbnRyb2xcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBsYWJlbD17X18oJ0FjdGlvbiBMaW5rJywgJ3ZvZGktZXh0ZW5zaW9ucycpfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG5hbWU9J2xpbmsnXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWVrZXk9J3ZhbHVlJ1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlPScnXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdHJpZ2dlcl9tZXRob2RfbmFtZT0nb25DaGFuZ2UnXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgb25DaGFuZ2U9eyBvbkNoYW5nZVNlY3Rpb25OYXZMaW5rc0xpbmsgfVxuICAgICAgICAgICAgICAgICAgICAgICAgLz5cbiAgICAgICAgICAgICAgICAgICAgPC9SZXBlYXRlcj5cbiAgICAgICAgICAgICAgICAgICAgPFBhbmVsQm9keVxuICAgICAgICAgICAgICAgICAgICAgICAgdGl0bGU9e19fKCdOdW1iZXIgb2YgY29tbWVudHMgdG8gc2hvdycsICd2b2RpLWV4dGVuc2lvbnMnKX1cbiAgICAgICAgICAgICAgICAgICAgICAgIGluaXRpYWxPcGVuPXsgdHJ1ZSB9XG4gICAgICAgICAgICAgICAgICAgID5cbiAgICAgICAgICAgICAgICAgICAgPFJhbmdlQ29udHJvbFxuICAgICAgICAgICAgICAgICAgICAgICAgbGFiZWw9e19fKCdMaW1pdCcsICd2b2RpLWV4dGVuc2lvbnMnKX1cbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlPXsgbGltaXQgfVxuICAgICAgICAgICAgICAgICAgICAgICAgb25DaGFuZ2U9eyBvbkNoYW5nZUxpbWl0IH1cbiAgICAgICAgICAgICAgICAgICAgICAgIG1pbj17IDEgfVxuICAgICAgICAgICAgICAgICAgICAgICAgbWF4PXsgMTAgfVxuICAgICAgICAgICAgICAgICAgICAvPlxuICAgICAgICAgICAgICAgICAgICA8L1BhbmVsQm9keT5cbiAgICAgICAgICAgICAgICAgICAgPFBhbmVsQm9keVxuICAgICAgICAgICAgICAgICAgICAgICAgdGl0bGU9e19fKCdEZXNpZ24gT3B0aW9ucycsICd2b2RpLWV4dGVuc2lvbnMnKX1cbiAgICAgICAgICAgICAgICAgICAgICAgIGluaXRpYWxPcGVuPXsgZmFsc2UgfVxuICAgICAgICAgICAgICAgICAgICA+XG4gICAgICAgICAgICAgICAgICAgICAgICA8RGVzaWduT3B0aW9uc1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGF0dHJpYnV0ZXMgPSB7IHsgLi4uZGVzaWduX29wdGlvbnMgfSB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdXBkYXRlRGVzaWduT3B0aW9ucyA9IHsgb25DaGFuZ2VEZXNpZ25PcHRpb25zIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIC8+XG4gICAgICAgICAgICAgICAgICAgIDwvUGFuZWxCb2R5PlxuICAgICAgICAgICAgICAgIDwvSW5zcGVjdG9yQ29udHJvbHM+XG4gICAgICAgICAgICAgICAgPERpc2FibGVkPlxuICAgICAgICAgICAgICAgICAgICA8U2VydmVyU2lkZVJlbmRlclxuICAgICAgICAgICAgICAgICAgICAgICAgYmxvY2s9XCJ2b2RpL3JlY2VudC1jb21tZW50c1wiXG4gICAgICAgICAgICAgICAgICAgICAgICBhdHRyaWJ1dGVzPXsgYXR0cmlidXRlcyB9XG4gICAgICAgICAgICAgICAgICAgIC8+XG4gICAgICAgICAgICAgICAgPC9EaXNhYmxlZD5cbiAgICAgICAgICAgIDwvRnJhZ21lbnQ+XG4gICAgICAgICk7XG4gICAgfSApLFxuXG4gICAgc2F2ZSgpIHtcbiAgICAgICAgLy8gUmVuZGVyaW5nIGluIFBIUFxuICAgICAgICByZXR1cm4gbnVsbDtcbiAgICB9LFxufSApOyIsImNvbnN0IHsgX18gfSA9IHdwLmkxOG47XG5jb25zdCB7IENvbXBvbmVudCB9ID0gd3AuZWxlbWVudDtcbmNvbnN0IHsgUmFuZ2VDb250cm9sIH0gPSB3cC5jb21wb25lbnRzO1xuXG4vKipcbiAqIERlc2lnbk9wdGlvbnMgQ29tcG9uZW50XG4gKi9cbmV4cG9ydCBjbGFzcyBEZXNpZ25PcHRpb25zIGV4dGVuZHMgQ29tcG9uZW50IHtcbiAgICAvKipcbiAgICAgKiBDb25zdHJ1Y3RvciBmb3IgRGVzaWduT3B0aW9ucyBDb21wb25lbnQuXG4gICAgICogU2V0cyB1cCBzdGF0ZSwgYW5kIGNyZWF0ZXMgYmluZGluZ3MgZm9yIGZ1bmN0aW9ucy5cbiAgICAgKiBAcGFyYW0gb2JqZWN0IHByb3BzIC0gY3VycmVudCBjb21wb25lbnQgcHJvcGVydGllcy5cbiAgICAgKi9cbiAgICBjb25zdHJ1Y3Rvcihwcm9wcykge1xuICAgICAgICBzdXBlciguLi5hcmd1bWVudHMpO1xuICAgICAgICB0aGlzLnByb3BzID0gcHJvcHM7XG5cbiAgICAgICAgdGhpcy5vbkNoYW5nZVBhZGRpbmdUb3AgPSB0aGlzLm9uQ2hhbmdlUGFkZGluZ1RvcC5iaW5kKHRoaXMpO1xuICAgICAgICB0aGlzLm9uQ2hhbmdlUGFkZGluZ0JvdHRvbSA9IHRoaXMub25DaGFuZ2VQYWRkaW5nQm90dG9tLmJpbmQodGhpcyk7XG4gICAgICAgIHRoaXMub25DaGFuZ2VQYWRkaW5nTGVmdCA9IHRoaXMub25DaGFuZ2VQYWRkaW5nTGVmdC5iaW5kKHRoaXMpO1xuICAgICAgICB0aGlzLm9uQ2hhbmdlUGFkZGluZ1JpZ2h0ID0gdGhpcy5vbkNoYW5nZVBhZGRpbmdSaWdodC5iaW5kKHRoaXMpO1xuICAgICAgICB0aGlzLm9uQ2hhbmdlTWFyZ2luVG9wID0gdGhpcy5vbkNoYW5nZU1hcmdpblRvcC5iaW5kKHRoaXMpO1xuICAgICAgICB0aGlzLm9uQ2hhbmdlTWFyZ2luQm90dG9tID0gdGhpcy5vbkNoYW5nZU1hcmdpbkJvdHRvbS5iaW5kKHRoaXMpO1xuICAgIH1cblxuICAgIG9uQ2hhbmdlUGFkZGluZ1RvcCggbmV3b25DaGFuZ2VQYWRkaW5nVG9wICkge1xuICAgICAgICB0aGlzLnByb3BzLnVwZGF0ZURlc2lnbk9wdGlvbnMoe1xuICAgICAgICAgICAgcGFkZGluZ190b3A6IG5ld29uQ2hhbmdlUGFkZGluZ1RvcFxuICAgICAgICB9KTtcbiAgICB9XG5cbiAgICBvbkNoYW5nZVBhZGRpbmdCb3R0b20oIG5ld29uQ2hhbmdlUGFkZGluZ0JvdHRvbSApIHtcbiAgICAgICAgdGhpcy5wcm9wcy51cGRhdGVEZXNpZ25PcHRpb25zKHtcbiAgICAgICAgICAgIHBhZGRpbmdfYm90dG9tOiBuZXdvbkNoYW5nZVBhZGRpbmdCb3R0b21cbiAgICAgICAgfSk7XG4gICAgfVxuXG4gICAgb25DaGFuZ2VQYWRkaW5nTGVmdCggbmV3b25DaGFuZ2VQYWRkaW5nTGVmdCApIHtcbiAgICAgICAgdGhpcy5wcm9wcy51cGRhdGVEZXNpZ25PcHRpb25zKHtcbiAgICAgICAgICAgIHBhZGRpbmdfbGVmdDogbmV3b25DaGFuZ2VQYWRkaW5nTGVmdFxuICAgICAgICB9KTtcbiAgICB9XG5cbiAgICBvbkNoYW5nZVBhZGRpbmdSaWdodCggbmV3b25DaGFuZ2VQYWRkaW5nUmlnaHQgKSB7XG4gICAgICAgIHRoaXMucHJvcHMudXBkYXRlRGVzaWduT3B0aW9ucyh7XG4gICAgICAgICAgICBwYWRkaW5nX3JpZ2h0OiBuZXdvbkNoYW5nZVBhZGRpbmdSaWdodFxuICAgICAgICB9KTtcbiAgICB9XG5cbiAgICBvbkNoYW5nZU1hcmdpblRvcCggbmV3b25DaGFuZ2VNYXJnaW5Ub3AgKSB7XG4gICAgICAgIHRoaXMucHJvcHMudXBkYXRlRGVzaWduT3B0aW9ucyh7XG4gICAgICAgICAgICBtYXJnaW5fdG9wOiBuZXdvbkNoYW5nZU1hcmdpblRvcFxuICAgICAgICB9KTtcbiAgICB9XG5cbiAgICBvbkNoYW5nZU1hcmdpbkJvdHRvbSggbmV3b25DaGFuZ2VNYXJnaW5Cb3R0b20gKSB7XG4gICAgICAgIHRoaXMucHJvcHMudXBkYXRlRGVzaWduT3B0aW9ucyh7XG4gICAgICAgICAgICBtYXJnaW5fYm90dG9tOiBuZXdvbkNoYW5nZU1hcmdpbkJvdHRvbVxuICAgICAgICB9KTtcbiAgICB9XG5cbiAgICAvKipcbiAgICAgKiBSZW5kZXJzIHRoZSBEZXNpZ25PcHRpb25zIGNvbXBvbmVudC5cbiAgICAgKi9cbiAgICByZW5kZXIoKSB7XG4gICAgICAgIGNvbnN0IHsgYXR0cmlidXRlcyB9ID0gdGhpcy5wcm9wcztcbiAgICAgICAgY29uc3QgeyBwYWRkaW5nX3RvcCwgcGFkZGluZ19ib3R0b20sIHBhZGRpbmdfbGVmdCwgcGFkZGluZ19yaWdodCwgbWFyZ2luX3RvcCwgbWFyZ2luX2JvdHRvbSB9ID0gYXR0cmlidXRlcztcblxuICAgICAgICByZXR1cm4gKFxuICAgICAgICAgICAgPGRpdj5cbiAgICAgICAgICAgICAgICA8UmFuZ2VDb250cm9sXG4gICAgICAgICAgICAgICAgICAgIGxhYmVsPXtfXygnUGFkZGluZyBUb3AgKHB4KScsICd2b2RpLWV4dGVuc2lvbnMnKX1cbiAgICAgICAgICAgICAgICAgICAgdmFsdWU9eyBwYWRkaW5nX3RvcCB9XG4gICAgICAgICAgICAgICAgICAgIG9uQ2hhbmdlPXsgdGhpcy5vbkNoYW5nZVBhZGRpbmdUb3AgfVxuICAgICAgICAgICAgICAgICAgICBtaW49eyAwIH1cbiAgICAgICAgICAgICAgICAgICAgbWF4PXsgMTAwIH1cbiAgICAgICAgICAgICAgICAvPlxuICAgICAgICAgICAgICAgIDxSYW5nZUNvbnRyb2xcbiAgICAgICAgICAgICAgICAgICAgbGFiZWw9e19fKCdQYWRkaW5nIEJvdHRvbSAocHgpJywgJ3ZvZGktZXh0ZW5zaW9ucycpfVxuICAgICAgICAgICAgICAgICAgICB2YWx1ZT17IHBhZGRpbmdfYm90dG9tIH1cbiAgICAgICAgICAgICAgICAgICAgb25DaGFuZ2U9eyB0aGlzLm9uQ2hhbmdlUGFkZGluZ0JvdHRvbSB9XG4gICAgICAgICAgICAgICAgICAgIG1pbj17IDAgfVxuICAgICAgICAgICAgICAgICAgICBtYXg9eyAxMDAgfVxuICAgICAgICAgICAgICAgIC8+XG4gICAgICAgICAgICAgICAgPFJhbmdlQ29udHJvbFxuICAgICAgICAgICAgICAgICAgICBsYWJlbD17X18oJ1BhZGRpbmcgTGVmdCAocHgpJywgJ3ZvZGktZXh0ZW5zaW9ucycpfVxuICAgICAgICAgICAgICAgICAgICB2YWx1ZT17IHBhZGRpbmdfbGVmdCB9XG4gICAgICAgICAgICAgICAgICAgIG9uQ2hhbmdlPXsgdGhpcy5vbkNoYW5nZVBhZGRpbmdMZWZ0IH1cbiAgICAgICAgICAgICAgICAgICAgbWluPXsgMCB9XG4gICAgICAgICAgICAgICAgICAgIG1heD17IDEwMCB9XG4gICAgICAgICAgICAgICAgLz5cbiAgICAgICAgICAgICAgICA8UmFuZ2VDb250cm9sXG4gICAgICAgICAgICAgICAgICAgIGxhYmVsPXtfXygnUGFkZGluZyBSaWdodCAocHgpJywgJ3ZvZGktZXh0ZW5zaW9ucycpfVxuICAgICAgICAgICAgICAgICAgICB2YWx1ZT17IHBhZGRpbmdfcmlnaHQgfVxuICAgICAgICAgICAgICAgICAgICBvbkNoYW5nZT17IHRoaXMub25DaGFuZ2VQYWRkaW5nUmlnaHQgfVxuICAgICAgICAgICAgICAgICAgICBtaW49eyAwIH1cbiAgICAgICAgICAgICAgICAgICAgbWF4PXsgMTAwIH1cbiAgICAgICAgICAgICAgICAvPlxuICAgICAgICAgICAgICAgIDxSYW5nZUNvbnRyb2xcbiAgICAgICAgICAgICAgICAgICAgbGFiZWw9e19fKCdNYXJnaW4gVG9wIChweCknLCAndm9kaS1leHRlbnNpb25zJyl9XG4gICAgICAgICAgICAgICAgICAgIHZhbHVlPXsgbWFyZ2luX3RvcCB9XG4gICAgICAgICAgICAgICAgICAgIG9uQ2hhbmdlPXsgdGhpcy5vbkNoYW5nZU1hcmdpblRvcCB9XG4gICAgICAgICAgICAgICAgICAgIG1pbj17IC0xMDAgfVxuICAgICAgICAgICAgICAgICAgICBtYXg9eyAxMDAgfVxuICAgICAgICAgICAgICAgIC8+XG4gICAgICAgICAgICAgICAgPFJhbmdlQ29udHJvbFxuICAgICAgICAgICAgICAgICAgICBsYWJlbD17X18oJ01hcmdpbiBCb3R0b20gKHB4KScsICd2b2RpLWV4dGVuc2lvbnMnKX1cbiAgICAgICAgICAgICAgICAgICAgdmFsdWU9eyBtYXJnaW5fYm90dG9tIH1cbiAgICAgICAgICAgICAgICAgICAgb25DaGFuZ2U9eyB0aGlzLm9uQ2hhbmdlTWFyZ2luQm90dG9tIH1cbiAgICAgICAgICAgICAgICAgICAgbWluPXsgLTEwMCB9XG4gICAgICAgICAgICAgICAgICAgIG1heD17IDEwMCB9XG4gICAgICAgICAgICAgICAgLz5cbiAgICAgICAgICAgIDwvZGl2PlxuICAgICAgICApO1xuICAgIH1cbn0iLCJjb25zdCB7IF9fIH0gPSB3cC5pMThuO1xuY29uc3QgeyBDb21wb25lbnQsIENoaWxkcmVuIH0gPSB3cC5lbGVtZW50O1xuY29uc3QgeyBQYW5lbCwgQnV0dG9uLCBJY29uIH0gPSB3cC5jb21wb25lbnRzO1xuXG4vKipcbiAqIFJlcGVhdGVyIENvbXBvbmVudFxuICovXG5leHBvcnQgY2xhc3MgUmVwZWF0ZXIgZXh0ZW5kcyBDb21wb25lbnQge1xuICAgIC8qKlxuICAgICAqIENvbnN0cnVjdG9yIGZvciBSZXBlYXRlciBDb21wb25lbnQuXG4gICAgICogU2V0cyB1cCBzdGF0ZSwgYW5kIGNyZWF0ZXMgYmluZGluZ3MgZm9yIGZ1bmN0aW9ucy5cbiAgICAgKiBAcGFyYW0gb2JqZWN0IHByb3BzIC0gY3VycmVudCBjb21wb25lbnQgcHJvcGVydGllcy5cbiAgICAgKi9cbiAgICBjb25zdHJ1Y3Rvcihwcm9wcykge1xuICAgICAgICBzdXBlciguLi5hcmd1bWVudHMpO1xuICAgICAgICB0aGlzLnByb3BzID0gcHJvcHM7XG5cbiAgICAgICAgdGhpcy5yZW5kZXJBZGRCdXR0b24gPSB0aGlzLnJlbmRlckFkZEJ1dHRvbi5iaW5kKHRoaXMpO1xuICAgICAgICB0aGlzLnJlbmRlclJlbW92ZUJ1dHRvbiA9IHRoaXMucmVuZGVyUmVtb3ZlQnV0dG9uLmJpbmQodGhpcyk7XG4gICAgICAgIHRoaXMuaGFuZGxlQWRkID0gdGhpcy5oYW5kbGVBZGQuYmluZCh0aGlzKTtcbiAgICAgICAgdGhpcy5oYW5kbGVSZW1vdmUgPSB0aGlzLmhhbmRsZVJlbW92ZS5iaW5kKHRoaXMpO1xuICAgICAgICB0aGlzLnJlbmRlckNoaWxkcmVuRWxlbWVudHMgPSB0aGlzLnJlbmRlckNoaWxkcmVuRWxlbWVudHMuYmluZCh0aGlzKTtcbiAgICB9XG5cbiAgICByZW5kZXJBZGRCdXR0b24oKSB7XG4gICAgICAgIHJldHVybihcbiAgICAgICAgICAgIDxCdXR0b24gaXNEZWZhdWx0IGNsYXNzTmFtZT1cImJ1dHRvbi1mdWxsd2lkdGhcIiBvbkNsaWNrPXt0aGlzLmhhbmRsZUFkZH0+XG4gICAgICAgICAgICAgICAgPEljb24gaWNvbj1cInBsdXNcIiAvPlxuICAgICAgICAgICAgPC9CdXR0b24+XG4gICAgICAgICk7XG4gICAgfVxuXG4gICAgcmVuZGVyUmVtb3ZlQnV0dG9uKCkge1xuICAgICAgICByZXR1cm4oXG4gICAgICAgICAgICA8QnV0dG9uIGlzRGVzdHJ1Y3RpdmUgY2xhc3NOYW1lPVwiYnV0dG9uLXJlbW92ZVwiIG9uQ2xpY2s9e3RoaXMuaGFuZGxlUmVtb3ZlfT5cbiAgICAgICAgICAgICAgICA8SWNvbiBpY29uPVwiZGlzbWlzc1wiIC8+XG4gICAgICAgICAgICA8L0J1dHRvbj5cbiAgICAgICAgKTtcbiAgICB9XG5cbiAgICBoYW5kbGVBZGQoKSB7XG4gICAgICAgIGNvbnN0IHsgZGVmYXVsdFZhbHVlcywgdXBkYXRlVmFsdWVzIH0gPSB0aGlzLnByb3BzO1xuICAgICAgICBjb25zdCB7IHZhbHVlcyB9ID0gdGhpcy5wcm9wcztcbiAgICAgICAgY29uc3QgY3VycmVudF92YWx1ZXMgPSB2YWx1ZXMgPyBbIC4uLnZhbHVlcywgeyAuLi5kZWZhdWx0VmFsdWVzIH0gXSA6IFsgeyAuLi5kZWZhdWx0VmFsdWVzIH0gXTtcbiAgICAgICAgdXBkYXRlVmFsdWVzKCBjdXJyZW50X3ZhbHVlcyApO1xuICAgIH1cblxuICAgIGhhbmRsZVJlbW92ZSggaW5kZXggKSB7XG4gICAgICAgIGNvbnN0IHsgdXBkYXRlVmFsdWVzIH0gPSB0aGlzLnByb3BzO1xuICAgICAgICBjb25zdCB7IHZhbHVlcyB9ID0gdGhpcy5wcm9wcztcbiAgICAgICAgY29uc3QgY3VycmVudF92YWx1ZXMgPSB2YWx1ZXMuZmlsdGVyKCAoIHZhbHVlLCBpICkgPT4gaSAhPSBpbmRleCApO1xuICAgICAgICB1cGRhdGVWYWx1ZXMoIGN1cnJlbnRfdmFsdWVzICk7XG4gICAgfVxuXG4gICAgcmVuZGVyQ2hpbGRyZW5FbGVtZW50cygpIHtcbiAgICAgICAgY29uc3QgeyBjaGlsZHJlbiB9ID0gdGhpcy5wcm9wcztcbiAgICAgICAgY29uc3QgeyB2YWx1ZXMgfSA9IHRoaXMucHJvcHM7XG5cbiAgICAgICAgaWYoICEgdmFsdWVzICkge1xuICAgICAgICAgICAgcmV0dXJuIFtdO1xuICAgICAgICB9XG5cbiAgICAgICAgY29uc3QgcmVtb3ZlX2J1dHRvbiA9IHRoaXMucmVuZGVyUmVtb3ZlQnV0dG9uKCk7XG5cbiAgICAgICAgcmV0dXJuIHZhbHVlcy5tYXAoICggdmFsdWUsIGluZGV4ICkgPT4ge1xuICAgICAgICAgICAgY29uc3QgdXBkYXRlZF9jaGlsZHJlbiA9IENoaWxkcmVuLm1hcChjaGlsZHJlbiwgKCBjaGlsZCApID0+IHtcbiAgICAgICAgICAgICAgICBsZXQgY2hpbGRfcHJvcHMgPSB7IC4uLmNoaWxkLnByb3BzIH07XG4gICAgICAgICAgICAgICAgaWYoIHZhbHVlc1tpbmRleF1bY2hpbGQucHJvcHMubmFtZV0gKSB7XG4gICAgICAgICAgICAgICAgICAgIGNoaWxkX3Byb3BzW2NoaWxkLnByb3BzLnZhbHVla2V5XSA9IHZhbHVlc1tpbmRleF1bY2hpbGQucHJvcHMubmFtZV07XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIGNoaWxkX3Byb3BzW2NoaWxkLnByb3BzLnRyaWdnZXJfbWV0aG9kX25hbWVdID0gKHZhbHVlKSA9PiBjaGlsZC5wcm9wc1tjaGlsZC5wcm9wcy50cmlnZ2VyX21ldGhvZF9uYW1lXSh2YWx1ZSwgaW5kZXgpO1xuICAgICAgICAgICAgICAgIHJldHVybiBSZWFjdC5jbG9uZUVsZW1lbnQoIGNoaWxkLCB7IC4uLmNoaWxkX3Byb3BzIH0gKTtcbiAgICAgICAgICAgIH0gKTtcblxuICAgICAgICAgICAgY29uc3QgdXBkYXRlZF9yZW1vdmVfYnV0dG9uID0gUmVhY3QuY2xvbmVFbGVtZW50KCByZW1vdmVfYnV0dG9uLCB7IGtleTogJ3JlcGVhdGVyLXJlbW92ZS0nK2luZGV4LCBvbkNsaWNrOiAoKSA9PiByZW1vdmVfYnV0dG9uLnByb3BzWydvbkNsaWNrJ10oaW5kZXgpIH0gKTtcblxuICAgICAgICAgICAgcmV0dXJuIFJlYWN0LmNyZWF0ZUVsZW1lbnQoIFBhbmVsLCB7IGtleTogJ3JlcGVhdGVyLWNoaWxkLScraW5kZXggfSwgW3VwZGF0ZWRfY2hpbGRyZW4sIHVwZGF0ZWRfcmVtb3ZlX2J1dHRvbl0pO1xuICAgICAgICB9ICk7XG4gICAgfVxuXG4gICAgLyoqXG4gICAgICogUmVuZGVycyB0aGUgUmVwZWF0ZXIgY29tcG9uZW50LlxuICAgICAqL1xuICAgIHJlbmRlcigpIHtcbiAgICAgICAgcmV0dXJuIChcbiAgICAgICAgICAgIDxkaXYgY2xhc3NOYW1lPVwiY29tcG9uZW50cy1iYXNlLWNvbnRyb2wgcmVwZWF0ZXItY29tcG9uZW50XCI+XG4gICAgICAgICAgICAgICAgPGRpdiBjbGFzc05hbWU9XCJjb21wb25lbnRzLWJhc2UtY29udHJvbF9fZmllbGRcIj5cbiAgICAgICAgICAgICAgICAgICAgPGxhYmVsIGNsYXNzTmFtZT1cImNvbXBvbmVudHMtYmFzZS1jb250cm9sX19sYWJlbFwiPnt0aGlzLnByb3BzLnRpdGxlfTwvbGFiZWw+XG4gICAgICAgICAgICAgICAgICAgIHt0aGlzLnJlbmRlckNoaWxkcmVuRWxlbWVudHMoKX1cbiAgICAgICAgICAgICAgICAgICAge3RoaXMucmVuZGVyQWRkQnV0dG9uKCl9XG4gICAgICAgICAgICAgICAgPC9kaXY+XG4gICAgICAgICAgICA8L2Rpdj5cbiAgICAgICAgKTtcbiAgICB9XG59Il19
