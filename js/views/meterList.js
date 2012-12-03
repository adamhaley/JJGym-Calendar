define([
	'collections/metersCollection'
	,'slickgrid'
	,'text!templates/grid.tpl'

	],function(
		meterModel
		, Slickgrid
		, gridTemplate
		, meterData
	){
		var meterListView = Backbone.View.extend({

			el: null
			, initialize: function(el){
				this.$el = el.find('#contentcolumn >div.inner');
			}
			, render: function(){

			
				this.$el.html(gridTemplate);


				var url = 'services/meterList.json';

				$.getJSON(url,function(meterData){

					console.log(meterData.meters);

					var columns = [
						{id:"id",name:"Meter ID",field:"id"}
						, {id:"address",name:"Service Address",field:"address"}
						, {id:"city-state",name:"City/State",field:"city-state"}
						, {id:"name",name:"Customer Name",field:"name"}
						, {id:"acct-number",name:"Account Number", field:"acct-number"}
					];
			
					var options = {
						enableCellNavigation: true
						, enableColumnReorder: false

					}

					var grid = new Slick.Grid('#grid', meterData.meters, columns, options);


				});

				
			}
		});

	return meterListView;
});