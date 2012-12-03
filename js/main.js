requirejs.config({

    // Defines the base URL for Javascript files
    // The URL is relative to the main index.html page
    baseUrl: 'js/'

    // Defines aliases for common Javascript files/modules
    , paths: {
    	'text': 'libs/require/require-text.min'
		, 'jquery': 'libs/jquery/jquery.min'
		, 'underscore': 'libs/underscore/underscore'
		, 'backbone': 'libs/backbone/backbone'
		, 'mustache': 'libs/mustache/mustache'
		, 'fullcalendar': 'libs/fullcalendar/fullcalendar'
		, 'templates': '../templates'	
        , 'jasmine': 'libs/jasmine/jasmine'
        , 'jasmineHtml': 'libs/jasmine/jasmine-html'
        , 'specsRunner': 'tests/specsRunner'
	}
	
	, shim: {
		'views/main': ['backbone','jquery']
		, 'backbone': {
            deps: ['underscore', 'jquery'],
            exports: 'Backbone'
        }
        , 'fullcalendar': 'jquery'
        , 'jasmineHtml': ['jasmine']
		, 'router': ['backbone', 'underscore', 'mustache','jasmineHtml']

	}

});

// Activates router module
require(['router'], function() { });