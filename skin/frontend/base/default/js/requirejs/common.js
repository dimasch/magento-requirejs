/**
 * Mtaube (https://github.com/mtaube)
 *
 * @category    design
 * @package     base_default
 * @copyright   Copyright (c) 2015 Matt Taube
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 */

require.config({
    paths: {
        'backbone': 'lib/backbone/backbone',
        'jquery': 'lib/jquery/jquery',
        'json2': 'lib/json2/json2',
        'underscore': 'lib/underscore/underscore',
    },
    shim: {
        // NOTE Shim required because Backbone / Underscore are not AMD modules.
        'backbone': {
            deps: ['jquery', 'json2', 'underscore'],
            exports: 'Backbone'
        },
        'underscore': { exports: '_' },
    },
});

define(
[
    'jquery',
    'backbone',
],

function ($, Backbone) {

    // NOTE Insert custom theme js here.

});
