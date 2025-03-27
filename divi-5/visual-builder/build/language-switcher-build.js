/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/index.jsx":
/*!***********************!*\
  !*** ./src/index.jsx ***!
  \***********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _modules__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modules */ \"./src/modules/index.jsx\");\n\n\n//# sourceURL=webpack://language-sitcher-module-for-divi/./src/index.jsx?");

/***/ }),

/***/ "./src/modules/LanguageSwitcherModule/conversion-outline.jsx":
/*!*******************************************************************!*\
  !*** ./src/modules/LanguageSwitcherModule/conversion-outline.jsx ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   conversionOutline: () => (/* binding */ conversionOutline)\n/* harmony export */ });\nconst convertInlineFont = value => isString(value) ? value.split(',') : [];\nconst conversionOutline = {\n  advanced: {\n    admin_label: 'module.meta.adminLabel',\n    animation: 'module.decoration.animation',\n    background: 'module.decoration.background',\n    disabled_on: 'module.decoration.disabledOn',\n    module: 'module.advanced.htmlAttributes',\n    overflow: 'module.decoration.overflow',\n    position_fields: 'module.decoration.position',\n    scroll: 'module.decoration.scroll',\n    sticky: 'module.decoration.sticky',\n    text: 'module.advanced.text',\n    transform: 'module.decoration.transform',\n    transition: 'module.decoration.transition',\n    z_index: 'module.decoration.zIndex',\n    margin_padding: 'module.decoration.spacing',\n    max_width: 'module.decoration.sizing',\n    height: 'module.decoration.sizing',\n    link_options: 'module.advanced.link',\n    fonts: {\n      header: 'title.decoration.font',\n      body: 'content.decoration.bodyFont.body',\n      body_link: 'content.decoration.bodyFont.link',\n      body_ul: 'content.decoration.bodyFont.ul',\n      body_ol: 'content.decoration.bodyFont.ol',\n      body_quote: 'content.decoration.bodyFont.quote'\n    },\n    text_shadow: {\n      default: 'module.advanced.text.textShadow'\n    },\n    box_shadow: {\n      default: 'module.decoration.boxShadow'\n    },\n    borders: {\n      default: 'module.decoration.border'\n    },\n    filters: {\n      default: 'module.decoration.filters'\n    }\n  },\n  css: {\n    after: 'css.*.after',\n    before: 'css.*.before',\n    main_element: 'css.*.mainElement',\n    title: 'css.*.title',\n    content: 'css.*.content'\n  },\n  module: {\n    title: 'title.innerContent.*',\n    content: 'content.innerContent.*',\n    header_level: 'title.decoration.font.font.*.headingLevel',\n    inline_fonts: 'content.decoration.inlineFont.*.families'\n  },\n  valueExpansionFunctionMap: {\n    inline_fonts: convertInlineFont\n  }\n};\n\n//# sourceURL=webpack://language-sitcher-module-for-divi/./src/modules/LanguageSwitcherModule/conversion-outline.jsx?");

/***/ }),

/***/ "./src/modules/LanguageSwitcherModule/custom-css.jsx":
/*!***********************************************************!*\
  !*** ./src/modules/LanguageSwitcherModule/custom-css.jsx ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   cssFields: () => (/* binding */ cssFields)\n/* harmony export */ });\n/* harmony import */ var _module_json__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./module.json */ \"./src/modules/LanguageSwitcherModule/module.json\");\n/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ \"@wordpress/i18n\");\n/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);\n\n\nconst customCssFields = _module_json__WEBPACK_IMPORTED_MODULE_0__.customCssFields;\n\n// Add labels to custom CSS fields for Visual Builder\ncustomCssFields.title.label = (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Title', 'd5-tutorial-module-conversion');\ncustomCssFields.content.label = (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Content', 'd5-tutorial-module-conversion');\nconst cssFields = {\n  ...customCssFields\n};\n\n//# sourceURL=webpack://language-sitcher-module-for-divi/./src/modules/LanguageSwitcherModule/custom-css.jsx?");

/***/ }),

/***/ "./src/modules/LanguageSwitcherModule/edit.jsx":
/*!*****************************************************!*\
  !*** ./src/modules/LanguageSwitcherModule/edit.jsx ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   LanguageSwitcherModuleEdit: () => (/* binding */ LanguageSwitcherModuleEdit)\n/* harmony export */ });\n/* harmony import */ var _module_styles__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./module-styles */ \"./src/modules/LanguageSwitcherModule/module-styles.jsx\");\n/* harmony import */ var _module_script_data__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./module-script-data */ \"./src/modules/LanguageSwitcherModule/module-script-data.jsx\");\n/* harmony import */ var _module_classnames__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./module-classnames */ \"./src/modules/LanguageSwitcherModule/module-classnames.jsx\");\n\n\n\nconst {\n  ModuleContainer\n} = window?.divi?.module;\nconst LanguageSwitcherModuleEdit = ({\n  attrs,\n  elements,\n  id,\n  name\n}) => {\n  return /*#__PURE__*/React.createElement(ModuleContainer, {\n    attrs: attrs,\n    elements: elements,\n    id: id,\n    name: name,\n    scriptDataComponent: _module_script_data__WEBPACK_IMPORTED_MODULE_1__.ModuleScriptData,\n    stylesComponent: _module_styles__WEBPACK_IMPORTED_MODULE_0__.ModuleStyles,\n    classnamesFunction: _module_classnames__WEBPACK_IMPORTED_MODULE_2__.moduleClassnames\n  }, elements.styleComponents({\n    attrName: 'module'\n  }), /*#__PURE__*/React.createElement(\"div\", {\n    className: \"et_pb_module_inner\"\n  }, elements.render({\n    attrName: 'title'\n  }), elements.render({\n    attrName: 'content'\n  })));\n};\n\n//# sourceURL=webpack://language-sitcher-module-for-divi/./src/modules/LanguageSwitcherModule/edit.jsx?");

/***/ }),

/***/ "./src/modules/LanguageSwitcherModule/index.jsx":
/*!******************************************************!*\
  !*** ./src/modules/LanguageSwitcherModule/index.jsx ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   LanguageSwitcherModule: () => (/* binding */ LanguageSwitcherModule),\n/* harmony export */   LanguageSwitcherModuleMetadata: () => (/* binding */ LanguageSwitcherModuleMetadata)\n/* harmony export */ });\n/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./edit */ \"./src/modules/LanguageSwitcherModule/edit.jsx\");\n/* harmony import */ var _module_json__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./module.json */ \"./src/modules/LanguageSwitcherModule/module.json\");\n/* harmony import */ var _conversion_outline__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./conversion-outline */ \"./src/modules/LanguageSwitcherModule/conversion-outline.jsx\");\n/* harmony import */ var _settings_advanced__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./settings-advanced */ \"./src/modules/LanguageSwitcherModule/settings-advanced.jsx\");\n/* harmony import */ var _settings_content__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./settings-content */ \"./src/modules/LanguageSwitcherModule/settings-content.jsx\");\n/* harmony import */ var _settings_design__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./settings-design */ \"./src/modules/LanguageSwitcherModule/settings-design.jsx\");\n\n\n\n\n\n\nconst LanguageSwitcherModuleMetadata = _module_json__WEBPACK_IMPORTED_MODULE_1__;\nconst LanguageSwitcherModule = {\n  renderers: {\n    edit: _edit__WEBPACK_IMPORTED_MODULE_0__.LanguageSwitcherModuleEdit\n  },\n  settings: {\n    content: _settings_content__WEBPACK_IMPORTED_MODULE_4__.SettingsContent,\n    design: _settings_design__WEBPACK_IMPORTED_MODULE_5__.SettingsDesign,\n    advanced: _settings_advanced__WEBPACK_IMPORTED_MODULE_3__.SettingsAdvanced\n  },\n  conversionOutline: _conversion_outline__WEBPACK_IMPORTED_MODULE_2__.conversionOutline\n};\n\n//# sourceURL=webpack://language-sitcher-module-for-divi/./src/modules/LanguageSwitcherModule/index.jsx?");

/***/ }),

/***/ "./src/modules/LanguageSwitcherModule/module-classnames.jsx":
/*!******************************************************************!*\
  !*** ./src/modules/LanguageSwitcherModule/module-classnames.jsx ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   moduleClassnames: () => (/* binding */ moduleClassnames)\n/* harmony export */ });\nconst {\n  elementClassnames,\n  textOptionsClassnames\n} = window?.divi?.module;\nconst moduleClassnames = ({\n  classnamesInstance,\n  attrs\n}) => {\n  // Text Options.\n  classnamesInstance.add(textOptionsClassnames(attrs?.module?.advanced?.text, {\n    orientation: false\n  }));\n\n  // Add element classnames.\n  classnamesInstance.add(elementClassnames({\n    attrs: attrs?.module?.decoration ?? {}\n  }));\n};\n\n//# sourceURL=webpack://language-sitcher-module-for-divi/./src/modules/LanguageSwitcherModule/module-classnames.jsx?");

/***/ }),

/***/ "./src/modules/LanguageSwitcherModule/module-script-data.jsx":
/*!*******************************************************************!*\
  !*** ./src/modules/LanguageSwitcherModule/module-script-data.jsx ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   ModuleScriptData: () => (/* binding */ ModuleScriptData)\n/* harmony export */ });\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ \"react\");\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);\n\nconst ModuleScriptData = ({\n  elements\n}) => /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement((react__WEBPACK_IMPORTED_MODULE_0___default().Fragment), null, elements.scriptData({\n  attrName: 'module'\n}));\n\n//# sourceURL=webpack://language-sitcher-module-for-divi/./src/modules/LanguageSwitcherModule/module-script-data.jsx?");

/***/ }),

/***/ "./src/modules/LanguageSwitcherModule/module-styles.jsx":
/*!**************************************************************!*\
  !*** ./src/modules/LanguageSwitcherModule/module-styles.jsx ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   ModuleStyles: () => (/* binding */ ModuleStyles)\n/* harmony export */ });\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ \"react\");\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _custom_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./custom-css */ \"./src/modules/LanguageSwitcherModule/custom-css.jsx\");\n\n\nconst {\n  CssStyle,\n  StyleContainer,\n  TextStyle\n} = window?.divi?.module;\n\n/**\r\n * Module style component for static module\r\n */\nconst ModuleStyles = ({\n  attrs,\n  elements,\n  settings,\n  orderClass,\n  mode,\n  state,\n  noStyleTag\n}) => /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(StyleContainer, {\n  mode: mode,\n  state: state,\n  noStyleTag: noStyleTag\n}, elements.style({\n  attrName: 'module',\n  styleProps: {\n    disabledOn: {\n      disabledModuleVisibility: settings?.disabledModuleVisibility\n    }\n  }\n}), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(CssStyle, {\n  selector: orderClass,\n  attr: attrs.css,\n  cssFields: _custom_css__WEBPACK_IMPORTED_MODULE_1__.cssFields\n}), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(TextStyle, {\n  selector: `${orderClass} .dtmc_static_module_content`,\n  attr: attrs?.module?.advanced?.text,\n  propertySelectors: {\n    textShadow: {\n      desktop: {\n        value: {\n          'text-shadow': `${orderClass} .dtmc_static_module_content`\n        }\n      }\n    }\n  }\n}), elements.style({\n  attrName: 'title'\n}), elements.style({\n  attrName: 'content'\n}));\n\n//# sourceURL=webpack://language-sitcher-module-for-divi/./src/modules/LanguageSwitcherModule/module-styles.jsx?");

/***/ }),

/***/ "./src/modules/LanguageSwitcherModule/module.json":
/*!********************************************************!*\
  !*** ./src/modules/LanguageSwitcherModule/module.json ***!
  \********************************************************/
/***/ ((module) => {

eval("module.exports = /*#__PURE__*/JSON.parse('{\"name\":\"lsad/language-sitcher-module-for-divi\",\"d4Shortcode\":\"language_switcher_module\",\"title\":\"Language Switcher Module\",\"titles\":\"Language Switcher Modules\",\"category\":\"module\",\"attributes\":{\"module\":{\"type\":\"object\",\"selector\":\"{{selector}}\",\"default\":{\"advanced\":{\"text\":{\"desktop\":{\"value\":{\"color\":\"light\"}}}}},\"styleProps\":{\"sizing\":{\"propertySelectors\":{\"desktop\":{\"value\":{\"margin-left\":\"{{selector}}.et_pb_module\",\"margin-right\":\"{{selector}}.et_pb_module\"}}},\"important\":{\"desktop\":{\"value\":{\"margin-left\":true,\"margin-right\":true}}}}}},\"title\":{\"type\":\"object\",\"selector\":\"{{selector}} h2.dtmc_static_module_title, {{selector}} h1.dtmc_static_module_title, {{selector}} h3.dtmc_static_module_title, {{selector}} h4.dtmc_static_module_title, {{selector}} h5.dtmc_static_module_title, {{selector}} h6.dtmc_static_module_title\",\"attributes\":{\"class\":\"dtmc_static_module_title\"},\"tagName\":\"h2\",\"elementType\":\"heading\",\"childrenSanitizer\":\"et_core_esc_previously\",\"default\":{\"font\":{\"font\":{\"desktop\":{\"value\":{\"headingLevel\":\"h2\"}}}}},\"styleProps\":{\"font\":{\"headingLevel\":\"h2\",\"important\":true}}},\"content\":{\"type\":\"object\",\"selector\":\"{{selector}} .dtmc_static_module_content\",\"attributes\":{\"class\":\"dtmc_static_module_content\"},\"tagName\":\"div\",\"childrenSanitizer\":\"et_core_esc_previously\",\"allowHtml\":true,\"styleProps\":{\"bodyFont\":{\"important\":{\"body\":{\"font\":{\"desktop\":{\"value\":{\"color\":true}}}}}}}}},\"customCssFields\":{\"title\":{\"subName\":\"title\",\"selectorSuffix\":\" .dtmc_static_module_title\"},\"content\":{\"subName\":\"content\",\"selectorSuffix\":\" .dtmc_static_module_content\"}}}');\n\n//# sourceURL=webpack://language-sitcher-module-for-divi/./src/modules/LanguageSwitcherModule/module.json?");

/***/ }),

/***/ "./src/modules/LanguageSwitcherModule/settings-advanced.jsx":
/*!******************************************************************!*\
  !*** ./src/modules/LanguageSwitcherModule/settings-advanced.jsx ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   SettingsAdvanced: () => (/* binding */ SettingsAdvanced)\n/* harmony export */ });\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ \"react\");\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _custom_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./custom-css */ \"./src/modules/LanguageSwitcherModule/custom-css.jsx\");\n\n\nconst {\n  CssGroup,\n  IdClassesGroup,\n  PositionSettingsGroup,\n  ScrollSettingsGroup,\n  TransitionGroup,\n  VisibilitySettingsGroup\n} = window?.divi?.module;\n\n/**\r\n * Advanced Settings panel for the Static Module.\r\n */\nconst SettingsAdvanced = () => /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement((react__WEBPACK_IMPORTED_MODULE_0___default().Fragment), null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(IdClassesGroup, null), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(CssGroup, {\n  mainSelector: \".static-module\" // This is the main selector for the module.\n  ,\n  cssFields: _custom_css__WEBPACK_IMPORTED_MODULE_1__.cssFields // This is the list of CSS fields.\n}), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(VisibilitySettingsGroup, null), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(TransitionGroup, null), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(PositionSettingsGroup, null), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(ScrollSettingsGroup, null));\n\n//# sourceURL=webpack://language-sitcher-module-for-divi/./src/modules/LanguageSwitcherModule/settings-advanced.jsx?");

/***/ }),

/***/ "./src/modules/LanguageSwitcherModule/settings-content.jsx":
/*!*****************************************************************!*\
  !*** ./src/modules/LanguageSwitcherModule/settings-content.jsx ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   SettingsContent: () => (/* binding */ SettingsContent)\n/* harmony export */ });\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ \"react\");\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ \"@wordpress/i18n\");\n/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);\n\n\nconst {\n  RichTextContainer,\n  TextContainer\n} = window?.divi?.fieldLibrary;\nconst {\n  GroupContainer\n} = window?.divi?.modal;\nconst {\n  AdminLabelGroup,\n  BackgroundGroup,\n  FieldContainer,\n  LinkGroup\n} = window?.divi?.module;\n\n/**\r\n * Content Settings panel for the Static Module.\r\n */\nconst SettingsContent = ({\n  defaultSettingsAttrs\n}) => /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement((react__WEBPACK_IMPORTED_MODULE_0___default().Fragment), null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(GroupContainer, {\n  id: \"mainContent\",\n  title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Text', 'd5-tutorial-module-conversion')\n}, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(FieldContainer, {\n  attrName: \"title.innerContent\",\n  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Title', 'd5-tutorial-module-conversion'),\n  description: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Text entered here will appear as title.', 'd5-tutorial-module-conversion'),\n  features: {\n    sticky: false\n  }\n}, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(TextContainer, null)), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(FieldContainer, {\n  attrName: \"content.innerContent\",\n  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Content', 'd5-tutorial-module-conversion'),\n  description: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Content entered here will appear inside the module.', 'd5-tutorial-module-conversion'),\n  features: {\n    sticky: false\n  }\n}, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(RichTextContainer, null))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(LinkGroup, null), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(BackgroundGroup, null), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(AdminLabelGroup, {\n  defaultGroupAttr: defaultSettingsAttrs?.module?.meta?.adminLabel ?? {}\n}));\n\n//# sourceURL=webpack://language-sitcher-module-for-divi/./src/modules/LanguageSwitcherModule/settings-content.jsx?");

/***/ }),

/***/ "./src/modules/LanguageSwitcherModule/settings-design.jsx":
/*!****************************************************************!*\
  !*** ./src/modules/LanguageSwitcherModule/settings-design.jsx ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   SettingsDesign: () => (/* binding */ SettingsDesign)\n/* harmony export */ });\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ \"react\");\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ \"@wordpress/i18n\");\n/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);\n\n\nconst {\n  AnimationGroup,\n  BorderGroup,\n  BoxShadowGroup,\n  FiltersGroup,\n  FontGroup,\n  FontBodyGroup,\n  SizingGroup,\n  SpacingGroup,\n  TextGroup,\n  TransformGroup\n} = window?.divi?.module;\n\n/**\r\n * Design Settings panel for the Static Module.\r\n */\nconst SettingsDesign = ({\n  defaultSettingsAttrs\n}) => /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement((react__WEBPACK_IMPORTED_MODULE_0___default().Fragment), null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(TextGroup, {\n  defaultGroupAttr: defaultSettingsAttrs?.module?.advanced?.text\n}), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(FontGroup, {\n  attrName: \"title.decoration.font\",\n  groupLabel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Title Text', 'd5-tutorial-module-conversion'),\n  fieldLabel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Title', 'd5-tutorial-module-conversion'),\n  fields: {\n    headingLevel: {\n      render: true\n    }\n  },\n  defaultGroupAttr: defaultSettingsAttrs?.title?.decoration?.font\n}), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(FontBodyGroup, {\n  attrName: \"content.decoration.bodyFont\"\n}), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(SizingGroup, null), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(SpacingGroup, null), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(BorderGroup, null), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(BoxShadowGroup, null), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(FiltersGroup, null), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(TransformGroup, null), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(AnimationGroup, null));\n\n//# sourceURL=webpack://language-sitcher-module-for-divi/./src/modules/LanguageSwitcherModule/settings-design.jsx?");

/***/ }),

/***/ "./src/modules/index.jsx":
/*!*******************************!*\
  !*** ./src/modules/index.jsx ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _wordpress_hooks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/hooks */ \"@wordpress/hooks\");\n/* harmony import */ var _wordpress_hooks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_hooks__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _LanguageSwitcherModule__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./LanguageSwitcherModule */ \"./src/modules/LanguageSwitcherModule/index.jsx\");\n\n\nconst {\n  registerModule\n} = window?.divi?.moduleLibrary;\n(0,_wordpress_hooks__WEBPACK_IMPORTED_MODULE_0__.addAction)('divi.moduleLibrary.registerModuleLibraryStore.after', 'lsad', () => {\n  registerModule(_LanguageSwitcherModule__WEBPACK_IMPORTED_MODULE_1__.LanguageSwitcherModuleMetadata, _LanguageSwitcherModule__WEBPACK_IMPORTED_MODULE_1__.LanguageSwitcherModule);\n});\n\n//# sourceURL=webpack://language-sitcher-module-for-divi/./src/modules/index.jsx?");

/***/ }),

/***/ "@wordpress/hooks":
/*!****************************************!*\
  !*** external ["vendor","wp","hooks"] ***!
  \****************************************/
/***/ ((module) => {

module.exports = vendor.wp.hooks;

/***/ }),

/***/ "@wordpress/i18n":
/*!***************************************!*\
  !*** external ["vendor","wp","i18n"] ***!
  \***************************************/
/***/ ((module) => {

module.exports = vendor.wp.i18n;

/***/ }),

/***/ "react":
/*!***********************************!*\
  !*** external ["vendor","React"] ***!
  \***********************************/
/***/ ((module) => {

module.exports = vendor.React;

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./src/index.jsx");
/******/ 	
/******/ })()
;