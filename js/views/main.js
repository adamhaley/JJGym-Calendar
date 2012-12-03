define([
	'text!templates/main.tpl'
	, 'views/leftMenu'
	, 'views/meterList'
	],function(
		mainTemplate
		, leftMenuView
		, meterListView
		){
	

		var mainView = Backbone.View.extend({

			el: $('body')
			, initialize: function(){

			}
			, render: function(){

				this.$el.prepend(mainTemplate);

				leftMenu = new leftMenuView(this.$el);
				meterList = new meterListView(this.$el);

				leftMenu.render();
				meterList.render();
			}
		});

	return mainView;
});