(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

var _PostSelector = require("../components/PostSelector");

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
    TextControl = _wp$components.TextControl,
    SelectControl = _wp$components.SelectControl;
registerBlockType('vodi/section-featured-movie', {
  title: __('Featured Movie', 'vodi-extensions'),
  icon: 'editor-video',
  category: 'vodi-blocks',
  edit: function edit(props) {
    var attributes = props.attributes,
        setAttributes = props.setAttributes;
    var feature_movie_action_icon = attributes.feature_movie_action_icon,
        movie_id = attributes.movie_id,
        image = attributes.image,
        bg_image = attributes.bg_image,
        design_options = attributes.design_options;

    var onChangeFeatureVideoActionIcon = function onChangeFeatureVideoActionIcon(newFeatureVideoActionIcon) {
      setAttributes({
        feature_movie_action_icon: newFeatureVideoActionIcon
      });
    };

    var onChangeIds = function onChangeIds(newIds) {
      setAttributes({
        movie_id: newIds.join(',')
      });
    };

    var onChangeImage = function onChangeImage(media) {
      setAttributes({
        image: media.id
      });
    };

    var onChangeBgImage = function onChangeBgImage(media) {
      setAttributes({
        bg_image: media.id
      });
    };

    var onChangeDesignOptions = function onChangeDesignOptions(newDesignOptions) {
      setAttributes({
        design_options: _objectSpread({}, design_options, {}, newDesignOptions)
      });
    };

    return wp.element.createElement(Fragment, null, wp.element.createElement(InspectorControls, null, wp.element.createElement(_PostSelector.PostSelector, {
      postType: "movie",
      selectSingle: true,
      selectedPostIds: movie_id ? movie_id.split(',').map(Number) : [],
      updateSelectedPostIds: onChangeIds
    }), wp.element.createElement(TextControl, {
      label: __('Feature Movie Action Icon', 'vodi-extensions'),
      value: feature_movie_action_icon,
      onChange: onChangeFeatureVideoActionIcon
    }), wp.element.createElement(_ImageUpload.ImageUpload, {
      addImageLabel: __('Pick an Image', 'vodi-extensions'),
      replaceImageLabel: __('Replace Image', 'vodi-extensions'),
      removeImageLabel: __('Remove Image', 'vodi-extensions'),
      value: image,
      onSelect: onChangeImage
    }), wp.element.createElement(_ImageUpload.ImageUpload, {
      addImageLabel: __('Pick an Background Image', 'vodi-extensions'),
      replaceImageLabel: __('Replace Background Image', 'vodi-extensions'),
      removeImageLabel: __('Remove Background Image', 'vodi-extensions'),
      value: bg_image,
      onSelect: onChangeBgImage
    }), wp.element.createElement(PanelBody, {
      title: __('Design Options', 'vodi-extensions'),
      initialOpen: false
    }, wp.element.createElement(_DesignOptions.DesignOptions, {
      attributes: _objectSpread({}, design_options),
      updateDesignOptions: onChangeDesignOptions
    }))), wp.element.createElement(Disabled, null, movie_id ? wp.element.createElement(ServerSideRender, {
      block: "vodi/section-featured-movie",
      attributes: attributes
    }) : __('Choose a movie', 'vodi-extensions')));
  },
  save: function save() {
    // Rendering in PHP
    return null;
  }
});

},{"../components/DesignOptions":2,"../components/ImageUpload":3,"../components/PostSelector":6}],2:[function(require,module,exports){
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

},{}],4:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.Item = void 0;

/**
 * Item Component.
 *
 * @param {string} itemTitle - Current item title.
 * @param {function} clickHandler - this is the handling function for the add/remove function
 * @param {Integer} itemId - Current item ID
 * @param icon
 * @returns {*} Item HTML.
 */
var Item = function Item(_ref) {
  var _ref$title = _ref.title;
  _ref$title = _ref$title === void 0 ? {} : _ref$title;
  var itemTitle = _ref$title.rendered,
      name = _ref.name,
      clickHandler = _ref.clickHandler,
      itemId = _ref.id,
      icon = _ref.icon;
  return wp.element.createElement("article", {
    className: "item"
  }, wp.element.createElement("div", {
    className: "item-body"
  }, wp.element.createElement("h3", {
    className: "item-title"
  }, itemTitle, name)), wp.element.createElement("button", {
    onClick: function onClick() {
      return clickHandler(itemId);
    }
  }, icon));
};

exports.Item = Item;

},{}],5:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.ItemList = void 0;

var _Item = require("./Item");

function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }

var __ = wp.i18n.__;
/**
 * ItemList Component
 * @param object props - Component props.
 * @returns {*}
 * @constructor
 */

var ItemList = function ItemList(props) {
  var _props$filtered = props.filtered,
      filtered = _props$filtered === void 0 ? false : _props$filtered,
      _props$loading = props.loading,
      loading = _props$loading === void 0 ? false : _props$loading,
      _props$items = props.items,
      items = _props$items === void 0 ? [] : _props$items,
      _props$action = props.action,
      action = _props$action === void 0 ? function () {} : _props$action,
      _props$icon = props.icon,
      icon = _props$icon === void 0 ? null : _props$icon;

  if (loading) {
    return wp.element.createElement("p", {
      className: "loading-items"
    }, __('Loading ...', 'vodi-extensions'));
  }

  if (filtered && items.length < 1) {
    return wp.element.createElement("div", {
      className: "item-list"
    }, wp.element.createElement("p", null, __('Your query yielded no results, please try again.', 'vodi-extensions')));
  }

  if (!items || items.length < 1) {
    return wp.element.createElement("p", {
      className: "no-items"
    }, __('Not found.', 'vodi-extensions'));
  }

  return wp.element.createElement("div", {
    className: "item-list"
  }, items.map(function (item) {
    return wp.element.createElement(_Item.Item, _extends({
      key: item.id
    }, item, {
      clickHandler: action,
      icon: icon
    }));
  }));
};

exports.ItemList = ItemList;

},{"./Item":4}],6:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.PostSelector = void 0;

var _ItemList = require("./ItemList");

var api = _interopRequireWildcard(require("../utils/api"));

var _usefulFuncs = require("../utils/useful-funcs");

function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) { var desc = Object.defineProperty && Object.getOwnPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : {}; if (desc.get || desc.set) { Object.defineProperty(newObj, key, desc); } else { newObj[key] = obj[key]; } } } } newObj["default"] = obj; return newObj; } }

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

var __ = wp.i18n.__;
var Icon = wp.components.Icon;
var Component = wp.element.Component;
/**
 * PostSelector Component
 */

var PostSelector =
/*#__PURE__*/
function (_Component) {
  _inherits(PostSelector, _Component);

  /**
   * Constructor for PostSelector Component.
   * Sets up state, and creates bindings for functions.
   * @param object props - current component properties.
   */
  function PostSelector(props) {
    var _this;

    _classCallCheck(this, PostSelector);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(PostSelector).apply(this, arguments));
    _this.props = props;
    _this.state = {
      posts: [],
      loading: false,
      type: props.postType || 'post',
      types: [],
      filter: '',
      filterLoading: false,
      filterPosts: [],
      initialLoading: false,
      selectedPosts: []
    };
    _this.addPost = _this.addPost.bind(_assertThisInitialized(_this));
    _this.removePost = _this.removePost.bind(_assertThisInitialized(_this));
    _this.handleInputFilterChange = _this.handleInputFilterChange.bind(_assertThisInitialized(_this));
    _this.doPostFilter = (0, _usefulFuncs.debounce)(_this.doPostFilter.bind(_assertThisInitialized(_this)), 300);
    _this.getSelectedPostIds = _this.getSelectedPostIds.bind(_assertThisInitialized(_this));
    _this.getSelectedPosts = _this.getSelectedPosts.bind(_assertThisInitialized(_this));
    return _this;
  }
  /**
   * When the component mounts it calls this function.
   * Fetches posts types, selected posts then makes first call for posts
   */


  _createClass(PostSelector, [{
    key: "componentDidMount",
    value: function componentDidMount() {
      var _this2 = this;

      this.setState({
        initialLoading: true
      });
      api.getPostTypes().then(function (response) {
        _this2.setState({
          types: response
        }, function () {
          _this2.retrieveSelectedPosts().then(function (selectedPosts) {
            if (selectedPosts) {
              _this2.setState({
                initialLoading: false,
                selectedPosts: selectedPosts
              });
            } else {
              _this2.setState({
                initialLoading: false
              });
            }
          });
        });
      });
    }
    /**
     * GetPosts wrapper, builds the request argument based state and parameters passed/
     * @param {object} args - desired arguments (can be empty).
     * @returns {Promise<T>}
     */

  }, {
    key: "getPosts",
    value: function getPosts() {
      var _this3 = this;

      var args = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      var postIds = this.getSelectedPostIds();
      var defaultArgs = {
        per_page: 10,
        type: this.state.type,
        search: this.state.filter
      };

      var requestArguments = _objectSpread({}, defaultArgs, {}, args);

      requestArguments.restBase = this.state.types[this.state.type].rest_base;
      return api.getPosts(requestArguments).then(function (response) {
        if (requestArguments.search) {
          _this3.setState({
            filterPosts: response.filter(function (_ref) {
              var id = _ref.id;
              return postIds.indexOf(id) === -1;
            })
          });

          return response;
        }

        _this3.setState({
          posts: (0, _usefulFuncs.uniqueById)([].concat(_toConsumableArray(_this3.state.posts), _toConsumableArray(response)))
        }); // return response to continue the chain


        return response;
      });
    }
    /**
     * Gets the selected posts by id from the `posts` state object and sorts them by their position in the selected array.
     * @returns Array of objects.
     */

  }, {
    key: "getSelectedPostIds",
    value: function getSelectedPostIds() {
      var selectedPostIds = this.props.selectedPostIds;

      if (selectedPostIds) {
        var postIds = Array.isArray(selectedPostIds) ? selectedPostIds : selectedPostIds.split(',');
        return postIds;
      }

      return [];
    }
    /**
     * Gets the selected posts by id from the `posts` state object and sorts them by their position in the selected array.
     * @returns Array of objects.
     */

  }, {
    key: "getSelectedPosts",
    value: function getSelectedPosts(postIds) {
      // const filterPostsList = this.state.filtering && !this.state.filterLoading ? this.state.filterPosts : [];
      var postList = (0, _usefulFuncs.uniqueById)([].concat(_toConsumableArray(this.state.filterPosts), _toConsumableArray(this.state.posts)));
      var selectedPosts = postList.filter(function (_ref2) {
        var id = _ref2.id;
        return postIds.indexOf(id) !== -1;
      }).sort(function (a, b) {
        var aIndex = postIds.indexOf(a.id);
        var bIndex = postIds.indexOf(b.id);

        if (aIndex > bIndex) {
          return 1;
        }

        if (aIndex < bIndex) {
          return -1;
        }

        return 0;
      });
      this.setState({
        selectedPosts: selectedPosts
      });
    }
    /**
     * Makes the necessary api calls to fetch the selected posts and returns a promise.
     * @returns {*}
     */

  }, {
    key: "retrieveSelectedPosts",
    value: function retrieveSelectedPosts() {
      var _this$props = this.props,
          postType = _this$props.postType,
          selectedPostIds = _this$props.selectedPostIds;
      var types = this.state.types;
      var postIds = this.getSelectedPostIds().join(',');

      if (!postIds) {
        // return a fake promise that auto resolves.
        return new Promise(function (resolve) {
          return resolve();
        });
      }

      var post_args = {
        include: postIds,
        per_page: 100,
        postType: postType
      };

      if (this.props.postStatus) {
        post_args.status = this.props.postStatus;
      }

      return this.getPosts(_objectSpread({}, post_args));
    }
    /**
     * Adds desired post id to the selectedPostIds List
     * @param {Integer} post_id
     */

  }, {
    key: "addPost",
    value: function addPost(post_id) {
      if (this.state.filter) {
        var post = this.state.filterPosts.filter(function (p) {
          return p.id === post_id;
        });
        var posts = (0, _usefulFuncs.uniqueById)([].concat(_toConsumableArray(this.state.posts), _toConsumableArray(post)));
        this.setState({
          posts: posts
        });
      }

      if (this.props.selectSingle) {
        var selectedPostIds = [post_id];
        this.props.updateSelectedPostIds(selectedPostIds);
        this.getSelectedPosts(selectedPostIds);
      } else {
        var postIds = this.getSelectedPostIds();

        var _selectedPostIds = [].concat(_toConsumableArray(postIds), [post_id]);

        this.props.updateSelectedPostIds(_selectedPostIds);
        this.getSelectedPosts(_selectedPostIds);
      }
    }
    /**
     * Removes desired post id to the selectedPostIds List
     * @param {Integer} post_id
     */

  }, {
    key: "removePost",
    value: function removePost(post_id) {
      var postIds = this.getSelectedPostIds();

      var selectedPostIds = _toConsumableArray(postIds).filter(function (id) {
        return id !== post_id;
      });

      this.props.updateSelectedPostIds(selectedPostIds);
      this.getSelectedPosts(selectedPostIds);
    }
    /**
     * Handles the search box input value
     * @param string type - comes from the event object target.
     */

  }, {
    key: "handleInputFilterChange",
    value: function handleInputFilterChange() {
      var _this4 = this;

      var _ref3 = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {},
          _ref3$target = _ref3.target;

      _ref3$target = _ref3$target === void 0 ? {} : _ref3$target;
      var _ref3$target$value = _ref3$target.value,
          filter = _ref3$target$value === void 0 ? '' : _ref3$target$value;
      this.setState({
        filter: filter
      }, function () {
        if (!filter) {
          // remove filtered posts
          return _this4.setState({
            filteredPosts: [],
            filtering: false
          });
        }

        _this4.doPostFilter();
      });
    }
    /**
     * Actual api call for searching for query, this function is debounced in constructor.
     */

  }, {
    key: "doPostFilter",
    value: function doPostFilter() {
      var _this5 = this;

      var _this$state$filter = this.state.filter,
          filter = _this$state$filter === void 0 ? '' : _this$state$filter;

      if (!filter) {
        return;
      }

      this.setState({
        filtering: true,
        filterLoading: true
      });
      var post_args = {};

      if (this.props.postStatus) {
        post_args.status = this.props.postStatus;
      }

      this.getPosts(_objectSpread({}, post_args)).then(function () {
        _this5.setState({
          filterLoading: false
        });
      });
    }
    /**
     * Renders the PostSelector component.
     */

  }, {
    key: "render",
    value: function render() {
      var postList = this.state.filtering && !this.state.filterLoading ? this.state.filterPosts : [];
      var addIcon = wp.element.createElement(Icon, {
        icon: "plus"
      });
      var removeIcon = wp.element.createElement(Icon, {
        icon: "minus"
      });
      var searchinputuniqueId = 'searchinput-' + Math.random().toString(36).substr(2, 16);
      return wp.element.createElement("div", {
        className: "components-base-control components-post-selector"
      }, wp.element.createElement("div", {
        className: "components-base-control__field--selected"
      }, wp.element.createElement("h2", null, __('Search Post', 'vodi-extensions')), wp.element.createElement(_ItemList.ItemList, {
        items: _toConsumableArray(this.state.selectedPosts),
        loading: this.state.initialLoading,
        action: this.removePost,
        icon: removeIcon
      })), wp.element.createElement("div", {
        className: "components-base-control__field"
      }, wp.element.createElement("label", {
        htmlFor: searchinputuniqueId,
        className: "components-base-control__label"
      }, wp.element.createElement(Icon, {
        icon: "search"
      })), wp.element.createElement("input", {
        className: "components-text-control__input",
        id: searchinputuniqueId,
        type: "search",
        placeholder: __('Please enter your search query...', 'vodi-extensions'),
        value: this.state.filter,
        onChange: this.handleInputFilterChange
      }), wp.element.createElement(_ItemList.ItemList, {
        items: postList,
        loading: this.state.initialLoading || this.state.loading || this.state.filterLoading,
        filtered: this.state.filtering,
        action: this.addPost,
        icon: addIcon
      })));
    }
  }]);

  return PostSelector;
}(Component);

exports.PostSelector = PostSelector;

},{"../utils/api":7,"../utils/useful-funcs":8,"./ItemList":5}],7:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.getTerms = exports.getTaxonomies = exports.getPosts = exports.getPostTypes = void 0;

function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }

function _objectWithoutProperties(source, excluded) { if (source == null) return {}; var target = _objectWithoutPropertiesLoose(source, excluded); var key, i; if (Object.getOwnPropertySymbols) { var sourceSymbolKeys = Object.getOwnPropertySymbols(source); for (i = 0; i < sourceSymbolKeys.length; i++) { key = sourceSymbolKeys[i]; if (excluded.indexOf(key) >= 0) continue; if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue; target[key] = source[key]; } } return target; }

function _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }

var _wp = wp,
    apiFetch = _wp.apiFetch;
/**
 * Makes a get request to the PostTypes endpoint.
 *
 * @returns {Promise<any>}
 */

var getPostTypes = function getPostTypes() {
  return apiFetch({
    path: '/wp/v2/types'
  });
};
/**
 * Makes a get request to the desired post type and builds the query string based on an object.
 *
 * @param {string|boolean} restBase - rest base for the query.
 * @param {object} args
 * @returns {Promise<any>}
 */


exports.getPostTypes = getPostTypes;

var getPosts = function getPosts(_ref) {
  var _ref$restBase = _ref.restBase,
      restBase = _ref$restBase === void 0 ? false : _ref$restBase,
      args = _objectWithoutProperties(_ref, ["restBase"]);

  var queryString = Object.keys(args).map(function (arg) {
    return "".concat(arg, "=").concat(args[arg]);
  }).join('&');
  var path = "/wp/v2/".concat(restBase, "?").concat(queryString, "&_embed");
  return apiFetch({
    path: path
  });
};
/**
 * Makes a get request to the PostType Taxonomies endpoint.
 *
 * @returns {Promise<any>}
 */


exports.getPosts = getPosts;

var getTaxonomies = function getTaxonomies(_ref2) {
  var args = _extends({}, _ref2);

  var queryString = Object.keys(args).map(function (arg) {
    return "".concat(arg, "=").concat(args[arg]);
  }).join('&');
  var path = "/wp/v2/taxonomies?".concat(queryString, "&_embed");
  return apiFetch({
    path: path
  });
};
/**
 * Makes a get request to the desired post type and builds the query string based on an object.
 *
 * @param {string|boolean} restBase - rest base for the query.
 * @param {object} args
 * @returns {Promise<any>}
 */


exports.getTaxonomies = getTaxonomies;

var getTerms = function getTerms(_ref3) {
  var _ref3$restBase = _ref3.restBase,
      restBase = _ref3$restBase === void 0 ? false : _ref3$restBase,
      args = _objectWithoutProperties(_ref3, ["restBase"]);

  var queryString = Object.keys(args).map(function (arg) {
    return "".concat(arg, "=").concat(args[arg]);
  }).join('&');
  var path = "/wp/v2/".concat(restBase, "?").concat(queryString, "&_embed");
  return apiFetch({
    path: path
  });
};

exports.getTerms = getTerms;

},{}],8:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.debounce = exports.uniqueById = exports.uniqueBy = void 0;

/**
 * Returns a unique array of objects based on a desired key.
 * @param {array} arr - array of objects.
 * @param {string|int} key - key to filter objects by
 */
var uniqueBy = function uniqueBy(arr, key) {
  var keys = [];
  return arr.filter(function (item) {
    if (keys.indexOf(item[key]) !== -1) {
      return false;
    }

    return keys.push(item[key]);
  });
};
/**
 * Returns a unique array of objects based on the id property.
 * @param {array} arr - array of objects to filter.
 * @returns {*}
 */


exports.uniqueBy = uniqueBy;

var uniqueById = function uniqueById(arr) {
  return uniqueBy(arr, 'id');
};
/**
 * Debounce a function by limiting how often it can run.
 * @param {function} func - callback function
 * @param {Integer} wait - Time in milliseconds how long it should wait.
 * @returns {Function}
 */


exports.uniqueById = uniqueById;

var debounce = function debounce(func, wait) {
  var timeout = null;
  return function () {
    var context = this;
    var args = arguments;

    var later = function later() {
      func.apply(context, args);
    };

    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
};

exports.debounce = debounce;

},{}]},{},[1])
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9icm93c2VyLXBhY2svX3ByZWx1ZGUuanMiLCJzcmMvcGx1Z2lucy92b2RpLWV4dGVuc2lvbnMvYXNzZXRzL2VzbmV4dC9ibG9ja3Mvc2VjdGlvbi1mZWF0dXJlZC1tb3ZpZS5qcyIsInNyYy9wbHVnaW5zL3ZvZGktZXh0ZW5zaW9ucy9hc3NldHMvZXNuZXh0L2NvbXBvbmVudHMvRGVzaWduT3B0aW9ucy5qcyIsInNyYy9wbHVnaW5zL3ZvZGktZXh0ZW5zaW9ucy9hc3NldHMvZXNuZXh0L2NvbXBvbmVudHMvSW1hZ2VVcGxvYWQuanMiLCJzcmMvcGx1Z2lucy92b2RpLWV4dGVuc2lvbnMvYXNzZXRzL2VzbmV4dC9jb21wb25lbnRzL0l0ZW0uanMiLCJzcmMvcGx1Z2lucy92b2RpLWV4dGVuc2lvbnMvYXNzZXRzL2VzbmV4dC9jb21wb25lbnRzL0l0ZW1MaXN0LmpzIiwic3JjL3BsdWdpbnMvdm9kaS1leHRlbnNpb25zL2Fzc2V0cy9lc25leHQvY29tcG9uZW50cy9Qb3N0U2VsZWN0b3IuanMiLCJzcmMvcGx1Z2lucy92b2RpLWV4dGVuc2lvbnMvYXNzZXRzL2VzbmV4dC91dGlscy9hcGkuanMiLCJzcmMvcGx1Z2lucy92b2RpLWV4dGVuc2lvbnMvYXNzZXRzL2VzbmV4dC91dGlscy91c2VmdWwtZnVuY3MuanMiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBQUE7OztBQ0FBOztBQUNBOztBQUNBOzs7Ozs7OztJQUVRLEUsR0FBTyxFQUFFLENBQUMsSSxDQUFWLEU7SUFDQSxpQixHQUFzQixFQUFFLENBQUMsTSxDQUF6QixpQjtJQUNBLGlCLEdBQXNCLEVBQUUsQ0FBQyxNLENBQXpCLGlCO0lBQ0EsUSxHQUFhLEVBQUUsQ0FBQyxPLENBQWhCLFE7cUJBQ3NFLEVBQUUsQ0FBQyxVO0lBQXpFLGdCLGtCQUFBLGdCO0lBQWtCLFEsa0JBQUEsUTtJQUFVLFMsa0JBQUEsUztJQUFXLFcsa0JBQUEsVztJQUFhLGEsa0JBQUEsYTtBQUU1RCxp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Ozs7Ozs7QUM1Q1A7Ozs7O0FBS08sSUFBTSxRQUFRLEdBQUcsU0FBWCxRQUFXLENBQUMsR0FBRCxFQUFNLEdBQU4sRUFBYztBQUNsQyxNQUFJLElBQUksR0FBRyxFQUFYO0FBQ0EsU0FBTyxHQUFHLENBQUMsTUFBSixDQUFXLFVBQUEsSUFBSSxFQUFJO0FBQ3RCLFFBQUksSUFBSSxDQUFDLE9BQUwsQ0FBYSxJQUFJLENBQUMsR0FBRCxDQUFqQixNQUE0QixDQUFDLENBQWpDLEVBQW9DO0FBQ2hDLGFBQU8sS0FBUDtBQUNIOztBQUVELFdBQU8sSUFBSSxDQUFDLElBQUwsQ0FBVSxJQUFJLENBQUMsR0FBRCxDQUFkLENBQVA7QUFDSCxHQU5NLENBQVA7QUFPSCxDQVRNO0FBV1A7Ozs7Ozs7OztBQUtPLElBQU0sVUFBVSxHQUFHLFNBQWIsVUFBYSxDQUFBLEdBQUc7QUFBQSxTQUFJLFFBQVEsQ0FBQyxHQUFELEVBQU0sSUFBTixDQUFaO0FBQUEsQ0FBdEI7QUFFUDs7Ozs7Ozs7OztBQU1PLElBQU0sUUFBUSxHQUFHLFNBQVgsUUFBVyxDQUFDLElBQUQsRUFBTyxJQUFQLEVBQWdCO0FBQ3BDLE1BQUksT0FBTyxHQUFHLElBQWQ7QUFFQSxTQUFPLFlBQVk7QUFDZixRQUFNLE9BQU8sR0FBRyxJQUFoQjtBQUNBLFFBQU0sSUFBSSxHQUFHLFNBQWI7O0FBRUEsUUFBTSxLQUFLLEdBQUcsU0FBUixLQUFRLEdBQU07QUFDaEIsTUFBQSxJQUFJLENBQUMsS0FBTCxDQUFXLE9BQVgsRUFBb0IsSUFBcEI7QUFDSCxLQUZEOztBQUlBLElBQUEsWUFBWSxDQUFDLE9BQUQsQ0FBWjtBQUNBLElBQUEsT0FBTyxHQUFHLFVBQVUsQ0FBQyxLQUFELEVBQVEsSUFBUixDQUFwQjtBQUNILEdBVkQ7QUFXSCxDQWRNIiwiZmlsZSI6ImdlbmVyYXRlZC5qcyIsInNvdXJjZVJvb3QiOiIiLCJzb3VyY2VzQ29udGVudCI6WyIoZnVuY3Rpb24oKXtmdW5jdGlvbiByKGUsbix0KXtmdW5jdGlvbiBvKGksZil7aWYoIW5baV0pe2lmKCFlW2ldKXt2YXIgYz1cImZ1bmN0aW9uXCI9PXR5cGVvZiByZXF1aXJlJiZyZXF1aXJlO2lmKCFmJiZjKXJldHVybiBjKGksITApO2lmKHUpcmV0dXJuIHUoaSwhMCk7dmFyIGE9bmV3IEVycm9yKFwiQ2Fubm90IGZpbmQgbW9kdWxlICdcIitpK1wiJ1wiKTt0aHJvdyBhLmNvZGU9XCJNT0RVTEVfTk9UX0ZPVU5EXCIsYX12YXIgcD1uW2ldPXtleHBvcnRzOnt9fTtlW2ldWzBdLmNhbGwocC5leHBvcnRzLGZ1bmN0aW9uKHIpe3ZhciBuPWVbaV1bMV1bcl07cmV0dXJuIG8obnx8cil9LHAscC5leHBvcnRzLHIsZSxuLHQpfXJldHVybiBuW2ldLmV4cG9ydHN9Zm9yKHZhciB1PVwiZnVuY3Rpb25cIj09dHlwZW9mIHJlcXVpcmUmJnJlcXVpcmUsaT0wO2k8dC5sZW5ndGg7aSsrKW8odFtpXSk7cmV0dXJuIG99cmV0dXJuIHJ9KSgpIiwiaW1wb3J0IHsgUG9zdFNlbGVjdG9yIH0gZnJvbSAnLi4vY29tcG9uZW50cy9Qb3N0U2VsZWN0b3InO1xuaW1wb3J0IHsgRGVzaWduT3B0aW9ucyB9IGZyb20gJy4uL2NvbXBvbmVudHMvRGVzaWduT3B0aW9ucyc7XG5pbXBvcnQgeyBJbWFnZVVwbG9hZCB9IGZyb20gJy4uL2NvbXBvbmVudHMvSW1hZ2VVcGxvYWQnO1xuXG5jb25zdCB7IF9fIH0gPSB3cC5pMThuO1xuY29uc3QgeyByZWdpc3RlckJsb2NrVHlwZSB9ID0gd3AuYmxvY2tzO1xuY29uc3QgeyBJbnNwZWN0b3JDb250cm9scyB9ID0gd3AuZWRpdG9yO1xuY29uc3QgeyBGcmFnbWVudCB9ID0gd3AuZWxlbWVudDtcbmNvbnN0IHsgU2VydmVyU2lkZVJlbmRlciwgRGlzYWJsZWQsIFBhbmVsQm9keSwgVGV4dENvbnRyb2wsIFNlbGVjdENvbnRyb2wgfSA9IHdwLmNvbXBvbmVudHM7XG5cbnJlZ2lzdGVyQmxvY2tUeXBlKCAndm9kaS9zZWN0aW9uLWZlYXR1cmVkLW1vdmllJywge1xuICAgIHRpdGxlOiBfXygnRmVhdHVyZWQgTW92aWUnLCAndm9kaS1leHRlbnNpb25zJyksXG5cbiAgICBpY29uOiAnZWRpdG9yLXZpZGVvJyxcblxuICAgIGNhdGVnb3J5OiAndm9kaS1ibG9ja3MnLFxuXG4gICAgZWRpdDogKCAoIHByb3BzICkgPT4ge1xuICAgICAgICBjb25zdCB7IGF0dHJpYnV0ZXMsIHNldEF0dHJpYnV0ZXMgfSA9IHByb3BzO1xuICAgICAgICBjb25zdCB7IGZlYXR1cmVfbW92aWVfYWN0aW9uX2ljb24sIG1vdmllX2lkLCBpbWFnZSwgYmdfaW1hZ2UsIGRlc2lnbl9vcHRpb25zIH0gPSBhdHRyaWJ1dGVzO1xuXG4gICAgICAgIGNvbnN0IG9uQ2hhbmdlRmVhdHVyZVZpZGVvQWN0aW9uSWNvbiA9IG5ld0ZlYXR1cmVWaWRlb0FjdGlvbkljb24gPT4ge1xuICAgICAgICAgICAgc2V0QXR0cmlidXRlcyggeyBmZWF0dXJlX21vdmllX2FjdGlvbl9pY29uOiBuZXdGZWF0dXJlVmlkZW9BY3Rpb25JY29uIH0gKTtcbiAgICAgICAgfTtcblxuICAgICAgICBjb25zdCBvbkNoYW5nZUlkcyA9IG5ld0lkcz0+IHtcbiAgICAgICAgICAgIHNldEF0dHJpYnV0ZXMoIHsgbW92aWVfaWQ6IG5ld0lkcy5qb2luKCcsJykgfSApO1xuICAgICAgICB9O1xuXG4gICAgICAgIGNvbnN0IG9uQ2hhbmdlSW1hZ2UgPSBtZWRpYSA9PiB7XG4gICAgICAgICAgICBzZXRBdHRyaWJ1dGVzKCB7IGltYWdlOiBtZWRpYS5pZCB9ICk7XG4gICAgICAgIH07XG5cbiAgICAgICAgY29uc3Qgb25DaGFuZ2VCZ0ltYWdlID0gbWVkaWEgPT4ge1xuICAgICAgICAgICAgc2V0QXR0cmlidXRlcyggeyBiZ19pbWFnZTogbWVkaWEuaWQgfSApO1xuICAgICAgICB9O1xuXG4gICAgICAgIGNvbnN0IG9uQ2hhbmdlRGVzaWduT3B0aW9ucyA9IG5ld0Rlc2lnbk9wdGlvbnMgPT4ge1xuICAgICAgICAgICAgc2V0QXR0cmlidXRlcyggeyBkZXNpZ25fb3B0aW9uczogeyAuLi5kZXNpZ25fb3B0aW9ucywgLi4ubmV3RGVzaWduT3B0aW9ucyB9IH0gKTtcbiAgICAgICAgfTtcblxuICAgICAgICByZXR1cm4gKFxuICAgICAgICAgICAgPEZyYWdtZW50PlxuICAgICAgICAgICAgICAgIDxJbnNwZWN0b3JDb250cm9scz5cbiAgICAgICAgICAgICAgICAgICAgPFBvc3RTZWxlY3RvclxuICAgICAgICAgICAgICAgICAgICAgICAgcG9zdFR5cGUgPSAnbW92aWUnXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxlY3RTaW5nbGUgPSB7IHRydWUgfVxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZWN0ZWRQb3N0SWRzPXsgbW92aWVfaWQgPyBtb3ZpZV9pZC5zcGxpdCgnLCcpLm1hcChOdW1iZXIpIDogW10gfVxuICAgICAgICAgICAgICAgICAgICAgICAgdXBkYXRlU2VsZWN0ZWRQb3N0SWRzPXsgb25DaGFuZ2VJZHMgfVxuICAgICAgICAgICAgICAgICAgICAvPlxuICAgICAgICAgICAgICAgICAgICA8VGV4dENvbnRyb2xcbiAgICAgICAgICAgICAgICAgICAgICAgIGxhYmVsPXtfXygnRmVhdHVyZSBNb3ZpZSBBY3Rpb24gSWNvbicsICd2b2RpLWV4dGVuc2lvbnMnKX1cbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlPXsgZmVhdHVyZV9tb3ZpZV9hY3Rpb25faWNvbiB9XG4gICAgICAgICAgICAgICAgICAgICAgICBvbkNoYW5nZT17IG9uQ2hhbmdlRmVhdHVyZVZpZGVvQWN0aW9uSWNvbiB9XG4gICAgICAgICAgICAgICAgICAgIC8+XG4gICAgICAgICAgICAgICAgICAgIDxJbWFnZVVwbG9hZFxuICAgICAgICAgICAgICAgICAgICAgICAgYWRkSW1hZ2VMYWJlbD17IF9fKCdQaWNrIGFuIEltYWdlJywgJ3ZvZGktZXh0ZW5zaW9ucycpIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIHJlcGxhY2VJbWFnZUxhYmVsPXsgX18oJ1JlcGxhY2UgSW1hZ2UnLCAndm9kaS1leHRlbnNpb25zJykgfVxuICAgICAgICAgICAgICAgICAgICAgICAgcmVtb3ZlSW1hZ2VMYWJlbD17IF9fKCdSZW1vdmUgSW1hZ2UnLCAndm9kaS1leHRlbnNpb25zJykgfVxuICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWU9eyBpbWFnZSB9XG4gICAgICAgICAgICAgICAgICAgICAgICBvblNlbGVjdD17IG9uQ2hhbmdlSW1hZ2UgfVxuICAgICAgICAgICAgICAgICAgICAvPlxuICAgICAgICAgICAgICAgICAgICA8SW1hZ2VVcGxvYWRcbiAgICAgICAgICAgICAgICAgICAgICAgIGFkZEltYWdlTGFiZWw9eyBfXygnUGljayBhbiBCYWNrZ3JvdW5kIEltYWdlJywgJ3ZvZGktZXh0ZW5zaW9ucycpIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIHJlcGxhY2VJbWFnZUxhYmVsPXsgX18oJ1JlcGxhY2UgQmFja2dyb3VuZCBJbWFnZScsICd2b2RpLWV4dGVuc2lvbnMnKSB9XG4gICAgICAgICAgICAgICAgICAgICAgICByZW1vdmVJbWFnZUxhYmVsPXsgX18oJ1JlbW92ZSBCYWNrZ3JvdW5kIEltYWdlJywgJ3ZvZGktZXh0ZW5zaW9ucycpIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlPXsgYmdfaW1hZ2UgfVxuICAgICAgICAgICAgICAgICAgICAgICAgb25TZWxlY3Q9eyBvbkNoYW5nZUJnSW1hZ2UgfVxuICAgICAgICAgICAgICAgICAgICAvPlxuICAgICAgICAgICAgICAgICAgICA8UGFuZWxCb2R5XG4gICAgICAgICAgICAgICAgICAgICAgICB0aXRsZT17X18oJ0Rlc2lnbiBPcHRpb25zJywgJ3ZvZGktZXh0ZW5zaW9ucycpfVxuICAgICAgICAgICAgICAgICAgICAgICAgaW5pdGlhbE9wZW49eyBmYWxzZSB9XG4gICAgICAgICAgICAgICAgICAgID5cbiAgICAgICAgICAgICAgICAgICAgICAgIDxEZXNpZ25PcHRpb25zXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgYXR0cmlidXRlcyA9IHsgeyAuLi5kZXNpZ25fb3B0aW9ucyB9IH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB1cGRhdGVEZXNpZ25PcHRpb25zID0geyBvbkNoYW5nZURlc2lnbk9wdGlvbnMgfVxuICAgICAgICAgICAgICAgICAgICAgICAgLz5cbiAgICAgICAgICAgICAgICAgICAgPC9QYW5lbEJvZHk+XG4gICAgICAgICAgICAgICAgPC9JbnNwZWN0b3JDb250cm9scz5cbiAgICAgICAgICAgICAgICA8RGlzYWJsZWQ+XG4gICAgICAgICAgICAgICAgICAgIHsgbW92aWVfaWQgPyAoXG4gICAgICAgICAgICAgICAgICAgIDxTZXJ2ZXJTaWRlUmVuZGVyXG4gICAgICAgICAgICAgICAgICAgICAgICBibG9jaz1cInZvZGkvc2VjdGlvbi1mZWF0dXJlZC1tb3ZpZVwiXG4gICAgICAgICAgICAgICAgICAgICAgICBhdHRyaWJ1dGVzPXsgYXR0cmlidXRlcyB9XG4gICAgICAgICAgICAgICAgICAgIC8+XG4gICAgICAgICAgICAgICAgICAgICkgOiBfXygnQ2hvb3NlIGEgbW92aWUnLCAndm9kaS1leHRlbnNpb25zJykgfVxuICAgICAgICAgICAgICAgIDwvRGlzYWJsZWQ+XG4gICAgICAgICAgICA8L0ZyYWdtZW50PlxuICAgICAgICApO1xuICAgIH0gKSxcblxuICAgIHNhdmUoKSB7XG4gICAgICAgIC8vIFJlbmRlcmluZyBpbiBQSFBcbiAgICAgICAgcmV0dXJuIG51bGw7XG4gICAgfSxcbn0gKTsiLCJjb25zdCB7IF9fIH0gPSB3cC5pMThuO1xuY29uc3QgeyBDb21wb25lbnQgfSA9IHdwLmVsZW1lbnQ7XG5jb25zdCB7IFJhbmdlQ29udHJvbCB9ID0gd3AuY29tcG9uZW50cztcblxuLyoqXG4gKiBEZXNpZ25PcHRpb25zIENvbXBvbmVudFxuICovXG5leHBvcnQgY2xhc3MgRGVzaWduT3B0aW9ucyBleHRlbmRzIENvbXBvbmVudCB7XG4gICAgLyoqXG4gICAgICogQ29uc3RydWN0b3IgZm9yIERlc2lnbk9wdGlvbnMgQ29tcG9uZW50LlxuICAgICAqIFNldHMgdXAgc3RhdGUsIGFuZCBjcmVhdGVzIGJpbmRpbmdzIGZvciBmdW5jdGlvbnMuXG4gICAgICogQHBhcmFtIG9iamVjdCBwcm9wcyAtIGN1cnJlbnQgY29tcG9uZW50IHByb3BlcnRpZXMuXG4gICAgICovXG4gICAgY29uc3RydWN0b3IocHJvcHMpIHtcbiAgICAgICAgc3VwZXIoLi4uYXJndW1lbnRzKTtcbiAgICAgICAgdGhpcy5wcm9wcyA9IHByb3BzO1xuXG4gICAgICAgIHRoaXMub25DaGFuZ2VQYWRkaW5nVG9wID0gdGhpcy5vbkNoYW5nZVBhZGRpbmdUb3AuYmluZCh0aGlzKTtcbiAgICAgICAgdGhpcy5vbkNoYW5nZVBhZGRpbmdCb3R0b20gPSB0aGlzLm9uQ2hhbmdlUGFkZGluZ0JvdHRvbS5iaW5kKHRoaXMpO1xuICAgICAgICB0aGlzLm9uQ2hhbmdlUGFkZGluZ0xlZnQgPSB0aGlzLm9uQ2hhbmdlUGFkZGluZ0xlZnQuYmluZCh0aGlzKTtcbiAgICAgICAgdGhpcy5vbkNoYW5nZVBhZGRpbmdSaWdodCA9IHRoaXMub25DaGFuZ2VQYWRkaW5nUmlnaHQuYmluZCh0aGlzKTtcbiAgICAgICAgdGhpcy5vbkNoYW5nZU1hcmdpblRvcCA9IHRoaXMub25DaGFuZ2VNYXJnaW5Ub3AuYmluZCh0aGlzKTtcbiAgICAgICAgdGhpcy5vbkNoYW5nZU1hcmdpbkJvdHRvbSA9IHRoaXMub25DaGFuZ2VNYXJnaW5Cb3R0b20uYmluZCh0aGlzKTtcbiAgICB9XG5cbiAgICBvbkNoYW5nZVBhZGRpbmdUb3AoIG5ld29uQ2hhbmdlUGFkZGluZ1RvcCApIHtcbiAgICAgICAgdGhpcy5wcm9wcy51cGRhdGVEZXNpZ25PcHRpb25zKHtcbiAgICAgICAgICAgIHBhZGRpbmdfdG9wOiBuZXdvbkNoYW5nZVBhZGRpbmdUb3BcbiAgICAgICAgfSk7XG4gICAgfVxuXG4gICAgb25DaGFuZ2VQYWRkaW5nQm90dG9tKCBuZXdvbkNoYW5nZVBhZGRpbmdCb3R0b20gKSB7XG4gICAgICAgIHRoaXMucHJvcHMudXBkYXRlRGVzaWduT3B0aW9ucyh7XG4gICAgICAgICAgICBwYWRkaW5nX2JvdHRvbTogbmV3b25DaGFuZ2VQYWRkaW5nQm90dG9tXG4gICAgICAgIH0pO1xuICAgIH1cblxuICAgIG9uQ2hhbmdlUGFkZGluZ0xlZnQoIG5ld29uQ2hhbmdlUGFkZGluZ0xlZnQgKSB7XG4gICAgICAgIHRoaXMucHJvcHMudXBkYXRlRGVzaWduT3B0aW9ucyh7XG4gICAgICAgICAgICBwYWRkaW5nX2xlZnQ6IG5ld29uQ2hhbmdlUGFkZGluZ0xlZnRcbiAgICAgICAgfSk7XG4gICAgfVxuXG4gICAgb25DaGFuZ2VQYWRkaW5nUmlnaHQoIG5ld29uQ2hhbmdlUGFkZGluZ1JpZ2h0ICkge1xuICAgICAgICB0aGlzLnByb3BzLnVwZGF0ZURlc2lnbk9wdGlvbnMoe1xuICAgICAgICAgICAgcGFkZGluZ19yaWdodDogbmV3b25DaGFuZ2VQYWRkaW5nUmlnaHRcbiAgICAgICAgfSk7XG4gICAgfVxuXG4gICAgb25DaGFuZ2VNYXJnaW5Ub3AoIG5ld29uQ2hhbmdlTWFyZ2luVG9wICkge1xuICAgICAgICB0aGlzLnByb3BzLnVwZGF0ZURlc2lnbk9wdGlvbnMoe1xuICAgICAgICAgICAgbWFyZ2luX3RvcDogbmV3b25DaGFuZ2VNYXJnaW5Ub3BcbiAgICAgICAgfSk7XG4gICAgfVxuXG4gICAgb25DaGFuZ2VNYXJnaW5Cb3R0b20oIG5ld29uQ2hhbmdlTWFyZ2luQm90dG9tICkge1xuICAgICAgICB0aGlzLnByb3BzLnVwZGF0ZURlc2lnbk9wdGlvbnMoe1xuICAgICAgICAgICAgbWFyZ2luX2JvdHRvbTogbmV3b25DaGFuZ2VNYXJnaW5Cb3R0b21cbiAgICAgICAgfSk7XG4gICAgfVxuXG4gICAgLyoqXG4gICAgICogUmVuZGVycyB0aGUgRGVzaWduT3B0aW9ucyBjb21wb25lbnQuXG4gICAgICovXG4gICAgcmVuZGVyKCkge1xuICAgICAgICBjb25zdCB7IGF0dHJpYnV0ZXMgfSA9IHRoaXMucHJvcHM7XG4gICAgICAgIGNvbnN0IHsgcGFkZGluZ190b3AsIHBhZGRpbmdfYm90dG9tLCBwYWRkaW5nX2xlZnQsIHBhZGRpbmdfcmlnaHQsIG1hcmdpbl90b3AsIG1hcmdpbl9ib3R0b20gfSA9IGF0dHJpYnV0ZXM7XG5cbiAgICAgICAgcmV0dXJuIChcbiAgICAgICAgICAgIDxkaXY+XG4gICAgICAgICAgICAgICAgPFJhbmdlQ29udHJvbFxuICAgICAgICAgICAgICAgICAgICBsYWJlbD17X18oJ1BhZGRpbmcgVG9wIChweCknLCAndm9kaS1leHRlbnNpb25zJyl9XG4gICAgICAgICAgICAgICAgICAgIHZhbHVlPXsgcGFkZGluZ190b3AgfVxuICAgICAgICAgICAgICAgICAgICBvbkNoYW5nZT17IHRoaXMub25DaGFuZ2VQYWRkaW5nVG9wIH1cbiAgICAgICAgICAgICAgICAgICAgbWluPXsgMCB9XG4gICAgICAgICAgICAgICAgICAgIG1heD17IDEwMCB9XG4gICAgICAgICAgICAgICAgLz5cbiAgICAgICAgICAgICAgICA8UmFuZ2VDb250cm9sXG4gICAgICAgICAgICAgICAgICAgIGxhYmVsPXtfXygnUGFkZGluZyBCb3R0b20gKHB4KScsICd2b2RpLWV4dGVuc2lvbnMnKX1cbiAgICAgICAgICAgICAgICAgICAgdmFsdWU9eyBwYWRkaW5nX2JvdHRvbSB9XG4gICAgICAgICAgICAgICAgICAgIG9uQ2hhbmdlPXsgdGhpcy5vbkNoYW5nZVBhZGRpbmdCb3R0b20gfVxuICAgICAgICAgICAgICAgICAgICBtaW49eyAwIH1cbiAgICAgICAgICAgICAgICAgICAgbWF4PXsgMTAwIH1cbiAgICAgICAgICAgICAgICAvPlxuICAgICAgICAgICAgICAgIDxSYW5nZUNvbnRyb2xcbiAgICAgICAgICAgICAgICAgICAgbGFiZWw9e19fKCdQYWRkaW5nIExlZnQgKHB4KScsICd2b2RpLWV4dGVuc2lvbnMnKX1cbiAgICAgICAgICAgICAgICAgICAgdmFsdWU9eyBwYWRkaW5nX2xlZnQgfVxuICAgICAgICAgICAgICAgICAgICBvbkNoYW5nZT17IHRoaXMub25DaGFuZ2VQYWRkaW5nTGVmdCB9XG4gICAgICAgICAgICAgICAgICAgIG1pbj17IDAgfVxuICAgICAgICAgICAgICAgICAgICBtYXg9eyAxMDAgfVxuICAgICAgICAgICAgICAgIC8+XG4gICAgICAgICAgICAgICAgPFJhbmdlQ29udHJvbFxuICAgICAgICAgICAgICAgICAgICBsYWJlbD17X18oJ1BhZGRpbmcgUmlnaHQgKHB4KScsICd2b2RpLWV4dGVuc2lvbnMnKX1cbiAgICAgICAgICAgICAgICAgICAgdmFsdWU9eyBwYWRkaW5nX3JpZ2h0IH1cbiAgICAgICAgICAgICAgICAgICAgb25DaGFuZ2U9eyB0aGlzLm9uQ2hhbmdlUGFkZGluZ1JpZ2h0IH1cbiAgICAgICAgICAgICAgICAgICAgbWluPXsgMCB9XG4gICAgICAgICAgICAgICAgICAgIG1heD17IDEwMCB9XG4gICAgICAgICAgICAgICAgLz5cbiAgICAgICAgICAgICAgICA8UmFuZ2VDb250cm9sXG4gICAgICAgICAgICAgICAgICAgIGxhYmVsPXtfXygnTWFyZ2luIFRvcCAocHgpJywgJ3ZvZGktZXh0ZW5zaW9ucycpfVxuICAgICAgICAgICAgICAgICAgICB2YWx1ZT17IG1hcmdpbl90b3AgfVxuICAgICAgICAgICAgICAgICAgICBvbkNoYW5nZT17IHRoaXMub25DaGFuZ2VNYXJnaW5Ub3AgfVxuICAgICAgICAgICAgICAgICAgICBtaW49eyAtMTAwIH1cbiAgICAgICAgICAgICAgICAgICAgbWF4PXsgMTAwIH1cbiAgICAgICAgICAgICAgICAvPlxuICAgICAgICAgICAgICAgIDxSYW5nZUNvbnRyb2xcbiAgICAgICAgICAgICAgICAgICAgbGFiZWw9e19fKCdNYXJnaW4gQm90dG9tIChweCknLCAndm9kaS1leHRlbnNpb25zJyl9XG4gICAgICAgICAgICAgICAgICAgIHZhbHVlPXsgbWFyZ2luX2JvdHRvbSB9XG4gICAgICAgICAgICAgICAgICAgIG9uQ2hhbmdlPXsgdGhpcy5vbkNoYW5nZU1hcmdpbkJvdHRvbSB9XG4gICAgICAgICAgICAgICAgICAgIG1pbj17IC0xMDAgfVxuICAgICAgICAgICAgICAgICAgICBtYXg9eyAxMDAgfVxuICAgICAgICAgICAgICAgIC8+XG4gICAgICAgICAgICA8L2Rpdj5cbiAgICAgICAgKTtcbiAgICB9XG59IiwiY29uc3QgeyBfXyB9ID0gd3AuaTE4bjtcbmNvbnN0IHsgTWVkaWFVcGxvYWQgfSA9IHdwLmVkaXRvcjtcbmNvbnN0IHsgRnJhZ21lbnQsIENvbXBvbmVudCB9ID0gd3AuZWxlbWVudDtcbmNvbnN0IHsgQnV0dG9uIH0gPSB3cC5jb21wb25lbnRzO1xuXG4vKipcbiAqIEltYWdlVXBsb2FkIENvbXBvbmVudFxuICovXG5leHBvcnQgY2xhc3MgSW1hZ2VVcGxvYWQgZXh0ZW5kcyBDb21wb25lbnQge1xuICAgIC8qKlxuICAgICAqIENvbnN0cnVjdG9yIGZvciBJbWFnZVVwbG9hZCBDb21wb25lbnQuXG4gICAgICogU2V0cyB1cCBzdGF0ZSwgYW5kIGNyZWF0ZXMgYmluZGluZ3MgZm9yIGZ1bmN0aW9ucy5cbiAgICAgKiBAcGFyYW0gb2JqZWN0IHByb3BzIC0gY3VycmVudCBjb21wb25lbnQgcHJvcGVydGllcy5cbiAgICAgKi9cbiAgICBjb25zdHJ1Y3Rvcihwcm9wcykge1xuICAgICAgICBzdXBlciguLi5hcmd1bWVudHMpO1xuICAgICAgICB0aGlzLnByb3BzID0gcHJvcHM7XG5cbiAgICAgICAgdGhpcy5vbkNoYW5nZUltYWdlID0gdGhpcy5vbkNoYW5nZUltYWdlLmJpbmQodGhpcyk7XG4gICAgICAgIHRoaXMub25SZW1vdmVJbWFnZSA9IHRoaXMub25SZW1vdmVJbWFnZS5iaW5kKHRoaXMpO1xuICAgIH1cblxuICAgIG9uQ2hhbmdlSW1hZ2UoIG1lZGlhICkge1xuICAgICAgICB0aGlzLnByb3BzLm9uU2VsZWN0KCBtZWRpYSApO1xuICAgIH1cblxuICAgIG9uUmVtb3ZlSW1hZ2UoKSB7XG4gICAgICAgIHRoaXMucHJvcHMub25TZWxlY3QoIDAgKTtcbiAgICB9XG5cbiAgICAvKipcbiAgICAgKiBSZW5kZXJzIHRoZSBJbWFnZVVwbG9hZCBjb21wb25lbnQuXG4gICAgICovXG4gICAgcmVuZGVyKCkge1xuICAgICAgICBjb25zdCB7IGF0dHJpYnV0ZXMsIGFkZEltYWdlTGFiZWwsIHJlcGxhY2VJbWFnZUxhYmVsLCByZW1vdmVJbWFnZUxhYmVsLCB2YWx1ZSB9ID0gdGhpcy5wcm9wcztcblxuICAgICAgICByZXR1cm4gKFxuICAgICAgICAgICAgPGRpdiBjbGFzc05hbWU9XCJjb21wb25lbnRzLWJhc2UtY29udHJvbCBjb21wb25lbnRzLWltYWdlLXVwbG9hZFwiPlxuICAgICAgICAgICAgICAgIDxkaXYgY2xhc3NOYW1lPVwiY29tcG9uZW50cy1iYXNlLWNvbnRyb2xfX2ZpZWxkXCI+XG4gICAgICAgICAgICAgICAgICAgIDxNZWRpYVVwbG9hZFxuICAgICAgICAgICAgICAgICAgICAgICAgb25TZWxlY3Q9eyB0aGlzLm9uQ2hhbmdlSW1hZ2UgfVxuICAgICAgICAgICAgICAgICAgICAgICAgdHlwZT1cImltYWdlXCJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlPXsgdmFsdWUgfVxuICAgICAgICAgICAgICAgICAgICAgICAgcmVuZGVyPXsgKCB7IG9wZW4gfSApID0+IChcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzTmFtZT1cImJ1dHRvbi1jb250YWluZXJcIj5cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPEJ1dHRvbiBpc0xhcmdlIG9uQ2xpY2s9eyBvcGVuIH0+XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB7ICggdmFsdWUgKSA/IHJlcGxhY2VJbWFnZUxhYmVsIDogYWRkSW1hZ2VMYWJlbCB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDwvQnV0dG9uPlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDwvZGl2PlxuICAgICAgICAgICAgICAgICAgICAgICAgKSB9XG4gICAgICAgICAgICAgICAgICAgIC8+XG4gICAgICAgICAgICAgICAgPC9kaXY+XG4gICAgICAgICAgICAgICAgeyAoIHZhbHVlICkgPyAoXG4gICAgICAgICAgICAgICAgICAgIDxkaXYgY2xhc3NOYW1lPVwiY29tcG9uZW50cy1iYXNlLWNvbnRyb2xfX2ZpZWxkXCI+XG4gICAgICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzTmFtZT1cImJ1dHRvbi1jb250YWluZXJcIj5cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8QnV0dG9uIGlzTGFyZ2Ugb25DbGljaz17IHRoaXMub25SZW1vdmVJbWFnZSB9PlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB7IHJlbW92ZUltYWdlTGFiZWwgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDwvQnV0dG9uPlxuICAgICAgICAgICAgICAgICAgICAgICAgPC9kaXY+XG4gICAgICAgICAgICAgICAgICAgIDwvZGl2PlxuICAgICAgICAgICAgICAgICkgOiAnJyB9XG4gICAgICAgICAgICA8L2Rpdj5cbiAgICAgICAgKTtcbiAgICB9XG59IiwiXG4vKipcbiAqIEl0ZW0gQ29tcG9uZW50LlxuICpcbiAqIEBwYXJhbSB7c3RyaW5nfSBpdGVtVGl0bGUgLSBDdXJyZW50IGl0ZW0gdGl0bGUuXG4gKiBAcGFyYW0ge2Z1bmN0aW9ufSBjbGlja0hhbmRsZXIgLSB0aGlzIGlzIHRoZSBoYW5kbGluZyBmdW5jdGlvbiBmb3IgdGhlIGFkZC9yZW1vdmUgZnVuY3Rpb25cbiAqIEBwYXJhbSB7SW50ZWdlcn0gaXRlbUlkIC0gQ3VycmVudCBpdGVtIElEXG4gKiBAcGFyYW0gaWNvblxuICogQHJldHVybnMgeyp9IEl0ZW0gSFRNTC5cbiAqL1xuZXhwb3J0IGNvbnN0IEl0ZW0gPSAoeyB0aXRsZTogeyByZW5kZXJlZDogaXRlbVRpdGxlIH0gPSB7fSwgbmFtZSwgY2xpY2tIYW5kbGVyLCBpZDogaXRlbUlkLCBpY29uIH0pID0+IChcbiAgICA8YXJ0aWNsZSBjbGFzc05hbWU9XCJpdGVtXCI+XG4gICAgICAgIDxkaXYgY2xhc3NOYW1lPVwiaXRlbS1ib2R5XCI+XG4gICAgICAgICAgICA8aDMgY2xhc3NOYW1lPVwiaXRlbS10aXRsZVwiPntpdGVtVGl0bGV9e25hbWV9PC9oMz5cbiAgICAgICAgPC9kaXY+XG4gICAgICAgIDxidXR0b24gb25DbGljaz17KCkgPT4gY2xpY2tIYW5kbGVyKGl0ZW1JZCl9PntpY29ufTwvYnV0dG9uPlxuICAgIDwvYXJ0aWNsZT5cbik7IiwiaW1wb3J0IHsgSXRlbSB9IGZyb20gJy4vSXRlbSc7XG5cbmNvbnN0IHsgX18gfSA9IHdwLmkxOG47XG5cbi8qKlxuICogSXRlbUxpc3QgQ29tcG9uZW50XG4gKiBAcGFyYW0gb2JqZWN0IHByb3BzIC0gQ29tcG9uZW50IHByb3BzLlxuICogQHJldHVybnMgeyp9XG4gKiBAY29uc3RydWN0b3JcbiAqL1xuZXhwb3J0IGNvbnN0IEl0ZW1MaXN0ID0gcHJvcHMgPT4ge1xuICAgIGNvbnN0IHsgZmlsdGVyZWQgPSBmYWxzZSwgbG9hZGluZyA9IGZhbHNlLCBpdGVtcyA9IFtdLCBhY3Rpb24gPSAoKSA9PiB7fSwgaWNvbiA9IG51bGwgfSA9IHByb3BzO1xuXG4gICAgaWYgKGxvYWRpbmcpIHtcbiAgICAgICAgcmV0dXJuIDxwIGNsYXNzTmFtZT1cImxvYWRpbmctaXRlbXNcIj57X18oJ0xvYWRpbmcgLi4uJywgJ3ZvZGktZXh0ZW5zaW9ucycpfTwvcD47XG4gICAgfVxuXG4gICAgaWYgKGZpbHRlcmVkICYmIGl0ZW1zLmxlbmd0aCA8IDEpIHtcbiAgICAgICAgcmV0dXJuIChcbiAgICAgICAgICAgIDxkaXYgY2xhc3NOYW1lPVwiaXRlbS1saXN0XCI+XG4gICAgICAgICAgICAgICAgPHA+e19fKCdZb3VyIHF1ZXJ5IHlpZWxkZWQgbm8gcmVzdWx0cywgcGxlYXNlIHRyeSBhZ2Fpbi4nLCAndm9kaS1leHRlbnNpb25zJyl9PC9wPlxuICAgICAgICAgICAgPC9kaXY+XG4gICAgICAgICk7XG4gICAgfVxuXG4gICAgaWYgKCAhIGl0ZW1zIHx8IGl0ZW1zLmxlbmd0aCA8IDEgKSB7XG4gICAgICAgIHJldHVybiA8cCBjbGFzc05hbWU9XCJuby1pdGVtc1wiPntfXygnTm90IGZvdW5kLicsICd2b2RpLWV4dGVuc2lvbnMnKX08L3A+XG4gICAgfVxuXG4gICAgcmV0dXJuIChcbiAgICAgICAgPGRpdiBjbGFzc05hbWU9XCJpdGVtLWxpc3RcIj5cbiAgICAgICAgICAgIHtpdGVtcy5tYXAoKGl0ZW0pID0+IDxJdGVtIGtleT17aXRlbS5pZH0gey4uLml0ZW19IGNsaWNrSGFuZGxlcj17YWN0aW9ufSBpY29uPXtpY29ufSAvPil9XG4gICAgICAgIDwvZGl2PlxuICAgICk7XG59OyIsImltcG9ydCB7IEl0ZW1MaXN0IH0gZnJvbSAnLi9JdGVtTGlzdCc7XG5pbXBvcnQgKiBhcyBhcGkgZnJvbSAnLi4vdXRpbHMvYXBpJztcbmltcG9ydCB7IHVuaXF1ZUJ5SWQsIGRlYm91bmNlIH0gZnJvbSAnLi4vdXRpbHMvdXNlZnVsLWZ1bmNzJztcblxuY29uc3QgeyBfXyB9ID0gd3AuaTE4bjtcbmNvbnN0IHsgSWNvbiB9ID0gd3AuY29tcG9uZW50cztcbmNvbnN0IHsgQ29tcG9uZW50IH0gPSB3cC5lbGVtZW50O1xuXG4vKipcbiAqIFBvc3RTZWxlY3RvciBDb21wb25lbnRcbiAqL1xuZXhwb3J0IGNsYXNzIFBvc3RTZWxlY3RvciBleHRlbmRzIENvbXBvbmVudCB7XG4gICAgLyoqXG4gICAgICogQ29uc3RydWN0b3IgZm9yIFBvc3RTZWxlY3RvciBDb21wb25lbnQuXG4gICAgICogU2V0cyB1cCBzdGF0ZSwgYW5kIGNyZWF0ZXMgYmluZGluZ3MgZm9yIGZ1bmN0aW9ucy5cbiAgICAgKiBAcGFyYW0gb2JqZWN0IHByb3BzIC0gY3VycmVudCBjb21wb25lbnQgcHJvcGVydGllcy5cbiAgICAgKi9cbiAgICBjb25zdHJ1Y3Rvcihwcm9wcykge1xuICAgICAgICBzdXBlciguLi5hcmd1bWVudHMpO1xuICAgICAgICB0aGlzLnByb3BzID0gcHJvcHM7XG5cbiAgICAgICAgdGhpcy5zdGF0ZSA9IHtcbiAgICAgICAgICAgIHBvc3RzOiBbXSxcbiAgICAgICAgICAgIGxvYWRpbmc6IGZhbHNlLFxuICAgICAgICAgICAgdHlwZTogcHJvcHMucG9zdFR5cGUgfHwgJ3Bvc3QnLFxuICAgICAgICAgICAgdHlwZXM6IFtdLFxuICAgICAgICAgICAgZmlsdGVyOiAnJyxcbiAgICAgICAgICAgIGZpbHRlckxvYWRpbmc6IGZhbHNlLFxuICAgICAgICAgICAgZmlsdGVyUG9zdHM6IFtdLFxuICAgICAgICAgICAgaW5pdGlhbExvYWRpbmc6IGZhbHNlLFxuICAgICAgICAgICAgc2VsZWN0ZWRQb3N0czogW10sXG4gICAgICAgIH07XG5cbiAgICAgICAgdGhpcy5hZGRQb3N0ID0gdGhpcy5hZGRQb3N0LmJpbmQodGhpcyk7XG4gICAgICAgIHRoaXMucmVtb3ZlUG9zdCA9IHRoaXMucmVtb3ZlUG9zdC5iaW5kKHRoaXMpO1xuICAgICAgICB0aGlzLmhhbmRsZUlucHV0RmlsdGVyQ2hhbmdlID0gdGhpcy5oYW5kbGVJbnB1dEZpbHRlckNoYW5nZS5iaW5kKHRoaXMpO1xuICAgICAgICB0aGlzLmRvUG9zdEZpbHRlciA9IGRlYm91bmNlKHRoaXMuZG9Qb3N0RmlsdGVyLmJpbmQodGhpcyksIDMwMCk7XG4gICAgICAgIHRoaXMuZ2V0U2VsZWN0ZWRQb3N0SWRzID0gdGhpcy5nZXRTZWxlY3RlZFBvc3RJZHMuYmluZCh0aGlzKTtcbiAgICAgICAgdGhpcy5nZXRTZWxlY3RlZFBvc3RzID0gdGhpcy5nZXRTZWxlY3RlZFBvc3RzLmJpbmQodGhpcyk7XG4gICAgfVxuXG4gICAgLyoqXG4gICAgICogV2hlbiB0aGUgY29tcG9uZW50IG1vdW50cyBpdCBjYWxscyB0aGlzIGZ1bmN0aW9uLlxuICAgICAqIEZldGNoZXMgcG9zdHMgdHlwZXMsIHNlbGVjdGVkIHBvc3RzIHRoZW4gbWFrZXMgZmlyc3QgY2FsbCBmb3IgcG9zdHNcbiAgICAgKi9cbiAgICBjb21wb25lbnREaWRNb3VudCgpIHtcbiAgICAgICAgdGhpcy5zZXRTdGF0ZSh7XG4gICAgICAgICAgICBpbml0aWFsTG9hZGluZzogdHJ1ZSxcbiAgICAgICAgfSk7XG5cbiAgICAgICAgYXBpLmdldFBvc3RUeXBlcygpXG4gICAgICAgICAgICAudGhlbigoIHJlc3BvbnNlICkgPT4ge1xuICAgICAgICAgICAgICAgIHRoaXMuc2V0U3RhdGUoe1xuICAgICAgICAgICAgICAgICAgICB0eXBlczogcmVzcG9uc2VcbiAgICAgICAgICAgICAgICB9LCAoKSA9PiB7XG4gICAgICAgICAgICAgICAgICAgIHRoaXMucmV0cmlldmVTZWxlY3RlZFBvc3RzKClcbiAgICAgICAgICAgICAgICAgICAgICAgIC50aGVuKCggc2VsZWN0ZWRQb3N0cyApID0+IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiggc2VsZWN0ZWRQb3N0cyApIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdGhpcy5zZXRTdGF0ZSh7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpbml0aWFsTG9hZGluZzogZmFsc2UsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBzZWxlY3RlZFBvc3RzOiBzZWxlY3RlZFBvc3RzLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB0aGlzLnNldFN0YXRlKHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGluaXRpYWxMb2FkaW5nOiBmYWxzZSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIH0pO1xuICAgIH1cblxuICAgIC8qKlxuICAgICAqIEdldFBvc3RzIHdyYXBwZXIsIGJ1aWxkcyB0aGUgcmVxdWVzdCBhcmd1bWVudCBiYXNlZCBzdGF0ZSBhbmQgcGFyYW1ldGVycyBwYXNzZWQvXG4gICAgICogQHBhcmFtIHtvYmplY3R9IGFyZ3MgLSBkZXNpcmVkIGFyZ3VtZW50cyAoY2FuIGJlIGVtcHR5KS5cbiAgICAgKiBAcmV0dXJucyB7UHJvbWlzZTxUPn1cbiAgICAgKi9cbiAgICBnZXRQb3N0cyhhcmdzID0ge30pIHtcbiAgICAgICAgY29uc3QgcG9zdElkcyA9IHRoaXMuZ2V0U2VsZWN0ZWRQb3N0SWRzKCk7XG5cbiAgICAgICAgY29uc3QgZGVmYXVsdEFyZ3MgPSB7XG4gICAgICAgICAgICBwZXJfcGFnZTogMTAsXG4gICAgICAgICAgICB0eXBlOiB0aGlzLnN0YXRlLnR5cGUsXG4gICAgICAgICAgICBzZWFyY2g6IHRoaXMuc3RhdGUuZmlsdGVyLFxuICAgICAgICB9O1xuXG4gICAgICAgIGNvbnN0IHJlcXVlc3RBcmd1bWVudHMgPSB7XG4gICAgICAgICAgICAuLi5kZWZhdWx0QXJncyxcbiAgICAgICAgICAgIC4uLmFyZ3NcbiAgICAgICAgfTtcblxuICAgICAgICByZXF1ZXN0QXJndW1lbnRzLnJlc3RCYXNlID0gdGhpcy5zdGF0ZS50eXBlc1t0aGlzLnN0YXRlLnR5cGVdLnJlc3RfYmFzZTtcblxuICAgICAgICByZXR1cm4gYXBpLmdldFBvc3RzKHJlcXVlc3RBcmd1bWVudHMpXG4gICAgICAgICAgICAudGhlbihyZXNwb25zZSA9PiB7XG4gICAgICAgICAgICAgICAgaWYgKHJlcXVlc3RBcmd1bWVudHMuc2VhcmNoKSB7XG4gICAgICAgICAgICAgICAgICAgIHRoaXMuc2V0U3RhdGUoe1xuICAgICAgICAgICAgICAgICAgICAgICAgZmlsdGVyUG9zdHM6IHJlc3BvbnNlLmZpbHRlcigoeyBpZCB9KSA9PiBwb3N0SWRzLmluZGV4T2YoaWQpID09PSAtMSksXG4gICAgICAgICAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICAgICAgICAgIHJldHVybiByZXNwb25zZTtcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICB0aGlzLnNldFN0YXRlKHtcbiAgICAgICAgICAgICAgICAgICAgcG9zdHM6IHVuaXF1ZUJ5SWQoWy4uLnRoaXMuc3RhdGUucG9zdHMsIC4uLnJlc3BvbnNlXSksXG4gICAgICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgICAgICAvLyByZXR1cm4gcmVzcG9uc2UgdG8gY29udGludWUgdGhlIGNoYWluXG4gICAgICAgICAgICAgICAgcmV0dXJuIHJlc3BvbnNlO1xuICAgICAgICAgICAgfSk7XG4gICAgfVxuXG4gICAgLyoqXG4gICAgICogR2V0cyB0aGUgc2VsZWN0ZWQgcG9zdHMgYnkgaWQgZnJvbSB0aGUgYHBvc3RzYCBzdGF0ZSBvYmplY3QgYW5kIHNvcnRzIHRoZW0gYnkgdGhlaXIgcG9zaXRpb24gaW4gdGhlIHNlbGVjdGVkIGFycmF5LlxuICAgICAqIEByZXR1cm5zIEFycmF5IG9mIG9iamVjdHMuXG4gICAgICovXG4gICAgZ2V0U2VsZWN0ZWRQb3N0SWRzKCkge1xuICAgICAgICBjb25zdCB7IHNlbGVjdGVkUG9zdElkcyB9ID0gdGhpcy5wcm9wcztcblxuICAgICAgICBpZiggc2VsZWN0ZWRQb3N0SWRzICkge1xuICAgICAgICAgICAgY29uc3QgcG9zdElkcyA9IEFycmF5LmlzQXJyYXkoIHNlbGVjdGVkUG9zdElkcyApID8gc2VsZWN0ZWRQb3N0SWRzIDogc2VsZWN0ZWRQb3N0SWRzLnNwbGl0KCcsJyk7XG4gICAgICAgICAgICByZXR1cm4gcG9zdElkcztcbiAgICAgICAgfVxuXG4gICAgICAgIHJldHVybiBbXTtcbiAgICB9XG5cbiAgICAvKipcbiAgICAgKiBHZXRzIHRoZSBzZWxlY3RlZCBwb3N0cyBieSBpZCBmcm9tIHRoZSBgcG9zdHNgIHN0YXRlIG9iamVjdCBhbmQgc29ydHMgdGhlbSBieSB0aGVpciBwb3NpdGlvbiBpbiB0aGUgc2VsZWN0ZWQgYXJyYXkuXG4gICAgICogQHJldHVybnMgQXJyYXkgb2Ygb2JqZWN0cy5cbiAgICAgKi9cbiAgICBnZXRTZWxlY3RlZFBvc3RzKCBwb3N0SWRzICkge1xuICAgICAgICAvLyBjb25zdCBmaWx0ZXJQb3N0c0xpc3QgPSB0aGlzLnN0YXRlLmZpbHRlcmluZyAmJiAhdGhpcy5zdGF0ZS5maWx0ZXJMb2FkaW5nID8gdGhpcy5zdGF0ZS5maWx0ZXJQb3N0cyA6IFtdO1xuICAgICAgICBjb25zdCBwb3N0TGlzdCA9IHVuaXF1ZUJ5SWQoW1xuICAgICAgICAgICAgLi4udGhpcy5zdGF0ZS5maWx0ZXJQb3N0cyxcbiAgICAgICAgICAgIC4uLnRoaXMuc3RhdGUucG9zdHNcbiAgICAgICAgXSk7XG4gICAgICAgIGNvbnN0IHNlbGVjdGVkUG9zdHMgPSBwb3N0TGlzdFxuICAgICAgICAgICAgLmZpbHRlcigoeyBpZCB9KSA9PiBwb3N0SWRzLmluZGV4T2YoaWQpICE9PSAtMSlcbiAgICAgICAgICAgIC5zb3J0KChhLCBiKSA9PiB7XG4gICAgICAgICAgICAgICAgY29uc3QgYUluZGV4ID0gcG9zdElkcy5pbmRleE9mKGEuaWQpO1xuICAgICAgICAgICAgICAgIGNvbnN0IGJJbmRleCA9IHBvc3RJZHMuaW5kZXhPZihiLmlkKTtcblxuICAgICAgICAgICAgICAgIGlmIChhSW5kZXggPiBiSW5kZXgpIHtcbiAgICAgICAgICAgICAgICAgICAgcmV0dXJuIDE7XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgaWYgKGFJbmRleCA8IGJJbmRleCkge1xuICAgICAgICAgICAgICAgICAgICByZXR1cm4gLTE7XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgcmV0dXJuIDA7XG4gICAgICAgICAgICB9KTtcblxuICAgICAgICB0aGlzLnNldFN0YXRlKHtcbiAgICAgICAgICAgIHNlbGVjdGVkUG9zdHM6IHNlbGVjdGVkUG9zdHMsXG4gICAgICAgIH0pO1xuICAgIH1cblxuICAgIC8qKlxuICAgICAqIE1ha2VzIHRoZSBuZWNlc3NhcnkgYXBpIGNhbGxzIHRvIGZldGNoIHRoZSBzZWxlY3RlZCBwb3N0cyBhbmQgcmV0dXJucyBhIHByb21pc2UuXG4gICAgICogQHJldHVybnMgeyp9XG4gICAgICovXG4gICAgcmV0cmlldmVTZWxlY3RlZFBvc3RzKCkge1xuICAgICAgICBjb25zdCB7IHBvc3RUeXBlLCBzZWxlY3RlZFBvc3RJZHMgfSA9IHRoaXMucHJvcHM7XG4gICAgICAgIGNvbnN0IHsgdHlwZXMgfSA9IHRoaXMuc3RhdGU7XG5cbiAgICAgICAgY29uc3QgcG9zdElkcyA9IHRoaXMuZ2V0U2VsZWN0ZWRQb3N0SWRzKCkuam9pbignLCcpO1xuXG4gICAgICAgIGlmICggISBwb3N0SWRzICkge1xuICAgICAgICAgICAgLy8gcmV0dXJuIGEgZmFrZSBwcm9taXNlIHRoYXQgYXV0byByZXNvbHZlcy5cbiAgICAgICAgICAgIHJldHVybiBuZXcgUHJvbWlzZSgocmVzb2x2ZSkgPT4gcmVzb2x2ZSgpKTtcbiAgICAgICAgfVxuXG4gICAgICAgIGxldCBwb3N0X2FyZ3MgPSB7XG4gICAgICAgICAgICBpbmNsdWRlOiBwb3N0SWRzLFxuICAgICAgICAgICAgcGVyX3BhZ2U6IDEwMCxcbiAgICAgICAgICAgIHBvc3RUeXBlXG4gICAgICAgIH07XG5cbiAgICAgICAgaWYoIHRoaXMucHJvcHMucG9zdFN0YXR1cyApIHtcbiAgICAgICAgICAgIHBvc3RfYXJncy5zdGF0dXMgPSB0aGlzLnByb3BzLnBvc3RTdGF0dXM7XG4gICAgICAgIH1cblxuICAgICAgICByZXR1cm4gdGhpcy5nZXRQb3N0cyh7XG4gICAgICAgICAgICAuLi5wb3N0X2FyZ3NcbiAgICAgICAgfSk7XG4gICAgfVxuXG4gICAgLyoqXG4gICAgICogQWRkcyBkZXNpcmVkIHBvc3QgaWQgdG8gdGhlIHNlbGVjdGVkUG9zdElkcyBMaXN0XG4gICAgICogQHBhcmFtIHtJbnRlZ2VyfSBwb3N0X2lkXG4gICAgICovXG4gICAgYWRkUG9zdChwb3N0X2lkKSB7XG4gICAgICAgIGlmICh0aGlzLnN0YXRlLmZpbHRlcikge1xuICAgICAgICAgICAgY29uc3QgcG9zdCA9IHRoaXMuc3RhdGUuZmlsdGVyUG9zdHMuZmlsdGVyKHAgPT4gcC5pZCA9PT0gcG9zdF9pZCk7XG4gICAgICAgICAgICBjb25zdCBwb3N0cyA9IHVuaXF1ZUJ5SWQoW1xuICAgICAgICAgICAgICAgIC4uLnRoaXMuc3RhdGUucG9zdHMsXG4gICAgICAgICAgICAgICAgLi4ucG9zdFxuICAgICAgICAgICAgXSk7XG5cbiAgICAgICAgICAgIHRoaXMuc2V0U3RhdGUoe1xuICAgICAgICAgICAgICAgIHBvc3RzXG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuXG4gICAgICAgIGlmKCB0aGlzLnByb3BzLnNlbGVjdFNpbmdsZSApIHtcbiAgICAgICAgICAgIGNvbnN0IHNlbGVjdGVkUG9zdElkcyA9IFsgcG9zdF9pZCBdO1xuICAgICAgICAgICAgdGhpcy5wcm9wcy51cGRhdGVTZWxlY3RlZFBvc3RJZHMoIHNlbGVjdGVkUG9zdElkcyApO1xuICAgICAgICAgICAgdGhpcy5nZXRTZWxlY3RlZFBvc3RzKCBzZWxlY3RlZFBvc3RJZHMgKTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIGNvbnN0IHBvc3RJZHMgPSB0aGlzLmdldFNlbGVjdGVkUG9zdElkcygpO1xuICAgICAgICAgICAgY29uc3Qgc2VsZWN0ZWRQb3N0SWRzID0gWyAuLi5wb3N0SWRzLCBwb3N0X2lkIF07XG4gICAgICAgICAgICB0aGlzLnByb3BzLnVwZGF0ZVNlbGVjdGVkUG9zdElkcyggc2VsZWN0ZWRQb3N0SWRzICk7XG4gICAgICAgICAgICB0aGlzLmdldFNlbGVjdGVkUG9zdHMoIHNlbGVjdGVkUG9zdElkcyApO1xuICAgICAgICB9XG4gICAgfVxuXG4gICAgLyoqXG4gICAgICogUmVtb3ZlcyBkZXNpcmVkIHBvc3QgaWQgdG8gdGhlIHNlbGVjdGVkUG9zdElkcyBMaXN0XG4gICAgICogQHBhcmFtIHtJbnRlZ2VyfSBwb3N0X2lkXG4gICAgICovXG4gICAgcmVtb3ZlUG9zdChwb3N0X2lkKSB7XG4gICAgICAgIGNvbnN0IHBvc3RJZHMgPSB0aGlzLmdldFNlbGVjdGVkUG9zdElkcygpO1xuICAgICAgICBjb25zdCBzZWxlY3RlZFBvc3RJZHMgPSBbIC4uLnBvc3RJZHMgXS5maWx0ZXIoaWQgPT4gaWQgIT09IHBvc3RfaWQpO1xuICAgICAgICB0aGlzLnByb3BzLnVwZGF0ZVNlbGVjdGVkUG9zdElkcyggc2VsZWN0ZWRQb3N0SWRzICk7XG4gICAgICAgIHRoaXMuZ2V0U2VsZWN0ZWRQb3N0cyggc2VsZWN0ZWRQb3N0SWRzICk7XG4gICAgfVxuXG4gICAgLyoqXG4gICAgICogSGFuZGxlcyB0aGUgc2VhcmNoIGJveCBpbnB1dCB2YWx1ZVxuICAgICAqIEBwYXJhbSBzdHJpbmcgdHlwZSAtIGNvbWVzIGZyb20gdGhlIGV2ZW50IG9iamVjdCB0YXJnZXQuXG4gICAgICovXG4gICAgaGFuZGxlSW5wdXRGaWx0ZXJDaGFuZ2UoeyB0YXJnZXQ6IHsgdmFsdWU6ZmlsdGVyID0gJycgfSA9IHt9IH0gPSB7fSkge1xuICAgICAgICB0aGlzLnNldFN0YXRlKHtcbiAgICAgICAgICAgIGZpbHRlclxuICAgICAgICB9LCAoKSA9PiB7XG4gICAgICAgICAgICBpZiAoIWZpbHRlcikge1xuICAgICAgICAgICAgICAgIC8vIHJlbW92ZSBmaWx0ZXJlZCBwb3N0c1xuICAgICAgICAgICAgICAgIHJldHVybiB0aGlzLnNldFN0YXRlKHsgZmlsdGVyZWRQb3N0czogW10sIGZpbHRlcmluZzogZmFsc2UgfSk7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIHRoaXMuZG9Qb3N0RmlsdGVyKCk7XG4gICAgICAgIH0pXG4gICAgfVxuXG4gICAgLyoqXG4gICAgICogQWN0dWFsIGFwaSBjYWxsIGZvciBzZWFyY2hpbmcgZm9yIHF1ZXJ5LCB0aGlzIGZ1bmN0aW9uIGlzIGRlYm91bmNlZCBpbiBjb25zdHJ1Y3Rvci5cbiAgICAgKi9cbiAgICBkb1Bvc3RGaWx0ZXIoKSB7XG4gICAgICAgIGNvbnN0IHsgZmlsdGVyID0gJycgfSA9IHRoaXMuc3RhdGU7XG5cbiAgICAgICAgaWYgKCFmaWx0ZXIpIHtcbiAgICAgICAgICAgIHJldHVybjtcbiAgICAgICAgfVxuXG4gICAgICAgIHRoaXMuc2V0U3RhdGUoe1xuICAgICAgICAgICAgZmlsdGVyaW5nOiB0cnVlLFxuICAgICAgICAgICAgZmlsdGVyTG9hZGluZzogdHJ1ZVxuICAgICAgICB9KTtcblxuICAgICAgICBsZXQgcG9zdF9hcmdzID0ge307XG5cbiAgICAgICAgaWYoIHRoaXMucHJvcHMucG9zdFN0YXR1cyApIHtcbiAgICAgICAgICAgIHBvc3RfYXJncy5zdGF0dXMgPSB0aGlzLnByb3BzLnBvc3RTdGF0dXM7XG4gICAgICAgIH1cblxuICAgICAgICB0aGlzLmdldFBvc3RzKHtcbiAgICAgICAgICAgIC4uLnBvc3RfYXJnc1xuICAgICAgICB9KS50aGVuKCgpID0+IHtcbiAgICAgICAgICAgIHRoaXMuc2V0U3RhdGUoe1xuICAgICAgICAgICAgICAgIGZpbHRlckxvYWRpbmc6IGZhbHNlXG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfSk7XG4gICAgfVxuXG4gICAgLyoqXG4gICAgICogUmVuZGVycyB0aGUgUG9zdFNlbGVjdG9yIGNvbXBvbmVudC5cbiAgICAgKi9cbiAgICByZW5kZXIoKSB7XG4gICAgICAgIGNvbnN0IHBvc3RMaXN0ID0gdGhpcy5zdGF0ZS5maWx0ZXJpbmcgJiYgIXRoaXMuc3RhdGUuZmlsdGVyTG9hZGluZyA/IHRoaXMuc3RhdGUuZmlsdGVyUG9zdHMgOiBbXTtcblxuICAgICAgICBjb25zdCBhZGRJY29uID0gPEljb24gaWNvbj1cInBsdXNcIiAvPjtcbiAgICAgICAgY29uc3QgcmVtb3ZlSWNvbiA9IDxJY29uIGljb249XCJtaW51c1wiIC8+O1xuXG4gICAgICAgIGNvbnN0IHNlYXJjaGlucHV0dW5pcXVlSWQgPSAnc2VhcmNoaW5wdXQtJyArIE1hdGgucmFuZG9tKCkudG9TdHJpbmcoMzYpLnN1YnN0cigyLCAxNik7XG5cbiAgICAgICAgcmV0dXJuIChcbiAgICAgICAgICAgIDxkaXYgY2xhc3NOYW1lPVwiY29tcG9uZW50cy1iYXNlLWNvbnRyb2wgY29tcG9uZW50cy1wb3N0LXNlbGVjdG9yXCI+XG4gICAgICAgICAgICAgICAgPGRpdiBjbGFzc05hbWU9XCJjb21wb25lbnRzLWJhc2UtY29udHJvbF9fZmllbGQtLXNlbGVjdGVkXCI+XG4gICAgICAgICAgICAgICAgICAgIDxoMj57X18oJ1NlYXJjaCBQb3N0JywgJ3ZvZGktZXh0ZW5zaW9ucycpfTwvaDI+XG4gICAgICAgICAgICAgICAgICAgIDxJdGVtTGlzdFxuICAgICAgICAgICAgICAgICAgICAgICAgaXRlbXM9eyBbLi4udGhpcy5zdGF0ZS5zZWxlY3RlZFBvc3RzXSB9XG4gICAgICAgICAgICAgICAgICAgICAgICBsb2FkaW5nPXt0aGlzLnN0YXRlLmluaXRpYWxMb2FkaW5nfVxuICAgICAgICAgICAgICAgICAgICAgICAgYWN0aW9uPXt0aGlzLnJlbW92ZVBvc3R9XG4gICAgICAgICAgICAgICAgICAgICAgICBpY29uPXtyZW1vdmVJY29ufVxuICAgICAgICAgICAgICAgICAgICAvPlxuICAgICAgICAgICAgICAgIDwvZGl2PlxuICAgICAgICAgICAgICAgIDxkaXYgY2xhc3NOYW1lPVwiY29tcG9uZW50cy1iYXNlLWNvbnRyb2xfX2ZpZWxkXCI+XG4gICAgICAgICAgICAgICAgICAgIDxsYWJlbCBodG1sRm9yPXtzZWFyY2hpbnB1dHVuaXF1ZUlkfSBjbGFzc05hbWU9XCJjb21wb25lbnRzLWJhc2UtY29udHJvbF9fbGFiZWxcIj5cbiAgICAgICAgICAgICAgICAgICAgICAgIDxJY29uIGljb249XCJzZWFyY2hcIiAvPlxuICAgICAgICAgICAgICAgICAgICA8L2xhYmVsPlxuICAgICAgICAgICAgICAgICAgICA8aW5wdXRcbiAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzTmFtZT1cImNvbXBvbmVudHMtdGV4dC1jb250cm9sX19pbnB1dFwiXG4gICAgICAgICAgICAgICAgICAgICAgICBpZD17c2VhcmNoaW5wdXR1bmlxdWVJZH1cbiAgICAgICAgICAgICAgICAgICAgICAgIHR5cGU9XCJzZWFyY2hcIlxuICAgICAgICAgICAgICAgICAgICAgICAgcGxhY2Vob2xkZXI9e19fKCdQbGVhc2UgZW50ZXIgeW91ciBzZWFyY2ggcXVlcnkuLi4nLCAndm9kaS1leHRlbnNpb25zJyl9XG4gICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZT17dGhpcy5zdGF0ZS5maWx0ZXJ9XG4gICAgICAgICAgICAgICAgICAgICAgICBvbkNoYW5nZT17dGhpcy5oYW5kbGVJbnB1dEZpbHRlckNoYW5nZX1cbiAgICAgICAgICAgICAgICAgICAgLz5cbiAgICAgICAgICAgICAgICAgICAgPEl0ZW1MaXN0XG4gICAgICAgICAgICAgICAgICAgICAgICBpdGVtcz17cG9zdExpc3R9XG4gICAgICAgICAgICAgICAgICAgICAgICBsb2FkaW5nPXt0aGlzLnN0YXRlLmluaXRpYWxMb2FkaW5nfHx0aGlzLnN0YXRlLmxvYWRpbmd8fHRoaXMuc3RhdGUuZmlsdGVyTG9hZGluZ31cbiAgICAgICAgICAgICAgICAgICAgICAgIGZpbHRlcmVkPXt0aGlzLnN0YXRlLmZpbHRlcmluZ31cbiAgICAgICAgICAgICAgICAgICAgICAgIGFjdGlvbj17dGhpcy5hZGRQb3N0fVxuICAgICAgICAgICAgICAgICAgICAgICAgaWNvbj17YWRkSWNvbn1cbiAgICAgICAgICAgICAgICAgICAgLz5cbiAgICAgICAgICAgICAgICA8L2Rpdj5cbiAgICAgICAgICAgIDwvZGl2PlxuICAgICAgICApO1xuICAgIH1cbn0iLCJjb25zdCB7IGFwaUZldGNoIH0gPSB3cDtcblxuLyoqXG4gKiBNYWtlcyBhIGdldCByZXF1ZXN0IHRvIHRoZSBQb3N0VHlwZXMgZW5kcG9pbnQuXG4gKlxuICogQHJldHVybnMge1Byb21pc2U8YW55Pn1cbiAqL1xuZXhwb3J0IGNvbnN0IGdldFBvc3RUeXBlcyA9ICgpID0+IHtcbiAgICByZXR1cm4gYXBpRmV0Y2goIHsgcGF0aDogJy93cC92Mi90eXBlcycgfSApO1xufTtcblxuLyoqXG4gKiBNYWtlcyBhIGdldCByZXF1ZXN0IHRvIHRoZSBkZXNpcmVkIHBvc3QgdHlwZSBhbmQgYnVpbGRzIHRoZSBxdWVyeSBzdHJpbmcgYmFzZWQgb24gYW4gb2JqZWN0LlxuICpcbiAqIEBwYXJhbSB7c3RyaW5nfGJvb2xlYW59IHJlc3RCYXNlIC0gcmVzdCBiYXNlIGZvciB0aGUgcXVlcnkuXG4gKiBAcGFyYW0ge29iamVjdH0gYXJnc1xuICogQHJldHVybnMge1Byb21pc2U8YW55Pn1cbiAqL1xuZXhwb3J0IGNvbnN0IGdldFBvc3RzID0gKHsgcmVzdEJhc2UgPSBmYWxzZSwgLi4uYXJncyB9KSA9PiB7XG4gICAgY29uc3QgcXVlcnlTdHJpbmcgPSBPYmplY3Qua2V5cyhhcmdzKS5tYXAoYXJnID0+IGAke2FyZ309JHthcmdzW2FyZ119YCkuam9pbignJicpO1xuXG4gICAgbGV0IHBhdGggPSBgL3dwL3YyLyR7cmVzdEJhc2V9PyR7cXVlcnlTdHJpbmd9Jl9lbWJlZGA7XG4gICAgcmV0dXJuIGFwaUZldGNoKCB7IHBhdGg6IHBhdGggfSApO1xufTtcblxuLyoqXG4gKiBNYWtlcyBhIGdldCByZXF1ZXN0IHRvIHRoZSBQb3N0VHlwZSBUYXhvbm9taWVzIGVuZHBvaW50LlxuICpcbiAqIEByZXR1cm5zIHtQcm9taXNlPGFueT59XG4gKi9cbmV4cG9ydCBjb25zdCBnZXRUYXhvbm9taWVzID0gKHsgLi4uYXJncyB9KSA9PiB7XG4gICAgY29uc3QgcXVlcnlTdHJpbmcgPSBPYmplY3Qua2V5cyhhcmdzKS5tYXAoYXJnID0+IGAke2FyZ309JHthcmdzW2FyZ119YCkuam9pbignJicpO1xuXG4gICAgbGV0IHBhdGggPSBgL3dwL3YyL3RheG9ub21pZXM/JHtxdWVyeVN0cmluZ30mX2VtYmVkYDtcbiAgICByZXR1cm4gYXBpRmV0Y2goIHsgcGF0aDogcGF0aCB9ICk7XG59O1xuXG4vKipcbiAqIE1ha2VzIGEgZ2V0IHJlcXVlc3QgdG8gdGhlIGRlc2lyZWQgcG9zdCB0eXBlIGFuZCBidWlsZHMgdGhlIHF1ZXJ5IHN0cmluZyBiYXNlZCBvbiBhbiBvYmplY3QuXG4gKlxuICogQHBhcmFtIHtzdHJpbmd8Ym9vbGVhbn0gcmVzdEJhc2UgLSByZXN0IGJhc2UgZm9yIHRoZSBxdWVyeS5cbiAqIEBwYXJhbSB7b2JqZWN0fSBhcmdzXG4gKiBAcmV0dXJucyB7UHJvbWlzZTxhbnk+fVxuICovXG5leHBvcnQgY29uc3QgZ2V0VGVybXMgPSAoeyByZXN0QmFzZSA9IGZhbHNlLCAuLi5hcmdzIH0pID0+IHtcbiAgICBjb25zdCBxdWVyeVN0cmluZyA9IE9iamVjdC5rZXlzKGFyZ3MpLm1hcChhcmcgPT4gYCR7YXJnfT0ke2FyZ3NbYXJnXX1gKS5qb2luKCcmJyk7XG5cbiAgICBsZXQgcGF0aCA9IGAvd3AvdjIvJHtyZXN0QmFzZX0/JHtxdWVyeVN0cmluZ30mX2VtYmVkYDtcbiAgICByZXR1cm4gYXBpRmV0Y2goIHsgcGF0aDogcGF0aCB9ICk7XG59OyIsIi8qKlxuICogUmV0dXJucyBhIHVuaXF1ZSBhcnJheSBvZiBvYmplY3RzIGJhc2VkIG9uIGEgZGVzaXJlZCBrZXkuXG4gKiBAcGFyYW0ge2FycmF5fSBhcnIgLSBhcnJheSBvZiBvYmplY3RzLlxuICogQHBhcmFtIHtzdHJpbmd8aW50fSBrZXkgLSBrZXkgdG8gZmlsdGVyIG9iamVjdHMgYnlcbiAqL1xuZXhwb3J0IGNvbnN0IHVuaXF1ZUJ5ID0gKGFyciwga2V5KSA9PiB7XG4gICAgbGV0IGtleXMgPSBbXTtcbiAgICByZXR1cm4gYXJyLmZpbHRlcihpdGVtID0+IHtcbiAgICAgICAgaWYgKGtleXMuaW5kZXhPZihpdGVtW2tleV0pICE9PSAtMSkge1xuICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xuICAgICAgICB9XG5cbiAgICAgICAgcmV0dXJuIGtleXMucHVzaChpdGVtW2tleV0pO1xuICAgIH0pO1xufTtcblxuLyoqXG4gKiBSZXR1cm5zIGEgdW5pcXVlIGFycmF5IG9mIG9iamVjdHMgYmFzZWQgb24gdGhlIGlkIHByb3BlcnR5LlxuICogQHBhcmFtIHthcnJheX0gYXJyIC0gYXJyYXkgb2Ygb2JqZWN0cyB0byBmaWx0ZXIuXG4gKiBAcmV0dXJucyB7Kn1cbiAqL1xuZXhwb3J0IGNvbnN0IHVuaXF1ZUJ5SWQgPSBhcnIgPT4gdW5pcXVlQnkoYXJyLCAnaWQnKTtcblxuLyoqXG4gKiBEZWJvdW5jZSBhIGZ1bmN0aW9uIGJ5IGxpbWl0aW5nIGhvdyBvZnRlbiBpdCBjYW4gcnVuLlxuICogQHBhcmFtIHtmdW5jdGlvbn0gZnVuYyAtIGNhbGxiYWNrIGZ1bmN0aW9uXG4gKiBAcGFyYW0ge0ludGVnZXJ9IHdhaXQgLSBUaW1lIGluIG1pbGxpc2Vjb25kcyBob3cgbG9uZyBpdCBzaG91bGQgd2FpdC5cbiAqIEByZXR1cm5zIHtGdW5jdGlvbn1cbiAqL1xuZXhwb3J0IGNvbnN0IGRlYm91bmNlID0gKGZ1bmMsIHdhaXQpID0+IHtcbiAgICBsZXQgdGltZW91dCA9IG51bGw7XG5cbiAgICByZXR1cm4gZnVuY3Rpb24gKCkge1xuICAgICAgICBjb25zdCBjb250ZXh0ID0gdGhpcztcbiAgICAgICAgY29uc3QgYXJncyA9IGFyZ3VtZW50cztcblxuICAgICAgICBjb25zdCBsYXRlciA9ICgpID0+IHtcbiAgICAgICAgICAgIGZ1bmMuYXBwbHkoY29udGV4dCwgYXJncyk7XG4gICAgICAgIH07XG5cbiAgICAgICAgY2xlYXJUaW1lb3V0KHRpbWVvdXQpO1xuICAgICAgICB0aW1lb3V0ID0gc2V0VGltZW91dChsYXRlciwgd2FpdCk7XG4gICAgfVxufTsiXX0=
