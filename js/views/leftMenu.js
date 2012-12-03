define([
	'text!templates/leftmenu.tpl'
	,'jqtree'
	],function(
		leftMenuTemplate
		, jqTree
		){
	

		var leftMenuView = Backbone.View.extend({

			el: null
			, initialize: function(el){
				this.$el = el.find('#leftcolumn')
			}
			, render: function(){
		
				this.$el.html(leftMenuTemplate);
				

				//load left menu data and build tree (via jqtree http://mbraak.github.com/)

				this.$el.find('#left-menu').tree({
					dataUrl:'services/left-menu.json'
					, autoOpen: true
				});

			}
		});

	return leftMenuView;
});