define([
	'models/meter'

	],function(
		meterModel

	){
		metersCollection = Backbone.Collection.extend({
			model: meterModel
			, url: 'services/meters.json'

		});

		return metersCollection;
});