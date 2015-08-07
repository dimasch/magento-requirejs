# Magento Require.js

This module adds basic structure for integrating [RequireJS](http://requirejs.org/) with [Magento CE](https://www.magentocommerce.com/download), meeting the following requirements:
- Each page uses a mix of common and page-specific modules.
- All pages share the same config.
- When the [r.js optimizer](https://github.com/jrburke/r.js) is installed and configured, the common items are served in a shared common layer and the page-specific modules are served in a page-specific layer.
- A [shim config](http://requirejs.org/docs/api.html#config-shim) is used to load scripts that do not use define() to declare the dependencies, like [Backbone.js](http://backbonejs.org/) and [Underscore.js](http://underscorejs.org/).
- [jQuery](https://jquery.com/) can be used as an AMD module that does not conflict with Magento's use of [Prototype](http://prototypejs.org/).

See the [requirejs/example-multipage-shim](https://github.com/requirejs/example-multipage-shim) repository for more information on the intended use.

## Installation

Using [modman](https://github.com/colinmollenhour/modman) is the recommended way to get started and will keep the module files separate from the Magento core file:

```
$ modman init
$ modman clone git@github.com:mtaube/magento-requirejs.git
```

The module can also be installed manually by downloading the files and moving them to the correct location alongside the Magento core files, although it is not recommended to mix community module files with Magento core files. If you install manually be sure to re-install the module after each Magento upgrade.

### r.js

To make the best use of this module, and RequireJS in general, you will also need to install the [r.js optimizer](https://github.com/jrburke/r.js). This tool will combine related scripts together into build layers, allowing them to be served in a single compiled file. Without it, the scripts will be served individually.

Using [Node](https://nodejs.org/) and [npm](https://www.npmjs.com/) is the recommended way to install r.js:

```
$ npm install -g requirejs
```

## How to Use

The [common.js](skin/frontend/base/default/js/common.js) file includes both the config and the common layer scripts. Basic libraries like jQuery, Backbone.js, and Underscore.js are included by default. Override the [common.js](skin/frontend/base/default/js/common.js) file in your custom theme's skin directory to change which libraries are loaded and get started with custom development.

A [product module](skin/frontend/base/default/js/product.js) is also included as a page-specific module example. To add modules to specific pages use the ```addModule``` action in your layout XML files. For example:

```
<catalog_product_view>
    <reference name="requirejs">
        <action method="addModule">
            <name>product</name>
        </action>
    </reference>
</catalog_product_view>
```

To remove modules from specific pages use the ```removeModule``` action in your layout XML files. For example:

```
<catalog_product_view>
    <reference name="requirejs">
        <action method="removeModule">
            <name>product</name>
        </action>
    </reference>
</catalog_product_view>
```

## Settings

- Enabled

    If "No" all output will be disabled.

- Common Module Base Dir

    Base dir for all scripts, relative to the js skin directory. The default is ```requirejs```, so the base directory is ```skin/frontend/base/default/js/requirejs```. If a custom theme is used, the base directory is ```skin/frontend/PACKAGE_NAME/THEME_NAME/js/requirejs``` but will fallback according to the usual theme fallback pattern. The common module file should be at the root of this directory.

- Common Module Name

    The name of the common module file. The default is ```common```, so the file name is ```common.js```. Do not include the ```.js``` file extension.

- Build Module Sets

    If "Yes" and the [r.js optimizer](https://github.com/jrburke/r.js) is installed, the build layers will be compiled and cached automatically. To bust the cache use Magento's "Flush Magento Cache" or "Flush JavaScript/CSS Cache" button in the Cache Management admin dashboard.

- Uglify Built Module Sets

    If "Yes" the scripts will be minified using UglifyJS during the build.
