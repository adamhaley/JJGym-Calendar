define([
'views/main'
    
], function (mainView) {
	describe('Main View', function(){
		it('Calling mainView.render() should create the three main areas of the layout, a header, and a footer',function(){

			mainView.$el = $('<body />');

			mainView.render();
			
			expect(mainView.$el.find('#maincontainer').length).not.toBe(0);
			expect(mainView.$el.find('#contentwrapper').length).not.toBe(0);
			expect(mainView.$el.find('#leftcolumn').length).not.toBe(0);
			expect(mainView.$el.find('#rightcolumn').length).not.toBe(0);

			expect(mainView.$el.find('header').length).not.toBe(0);
			expect(mainView.$el.find('footer').length).not.toBe(0);

		});

	});

});