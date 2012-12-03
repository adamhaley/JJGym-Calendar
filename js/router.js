(function(old) {
    Backbone.History.prototype.getFragment = function() {
        return old.apply(this, arguments).replace(/\?.*/, '');
    };
})(Backbone.History.prototype.getFragment);

define([

    'views/main'
    , 'specsRunner'
    
    ], function(
    
        mainView
        , specsRunner
    
        ) {

    var AppRouter = Backbone.Router.extend({
	       
    	routes: {

                'home': 'defaultAction'
                ,'tests': 'runTests'
                , '*actions':'defaultAction'
        
        }
        , initialize: function () {
	    	Backbone.history.start();
	    }
        , defaultAction: function(){
           
            // console.log(mainView.$el);
           main = new mainView;
           main.render(); 
        }
        ,runTests: function(){
            console.log('running tests..');
            specsRunner.execute();
        }
    })
    , router = new AppRouter;

  return router;
});