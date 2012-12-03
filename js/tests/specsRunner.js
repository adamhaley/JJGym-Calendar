define([], function () {

    var execute = function () {

        require([

              'sinon'
            , 'jasmine'

            //TODO: References all BDD/TDD Specs in here
            , 'tests/mainViewSpec'
          
        ], function () {

            // Registers all the test cases
            var specs = Array.prototype.slice.call(arguments, 4);
            for (var i = 0; i < specs.length; i++) {
                specs[i].run();
            }

            jasmine.getEnv().addReporter(new jasmine.HtmlReporter());
            jasmine.getEnv().execute();

            var $HtmlReporter = $('#HTMLReporter');
            if ($HtmlReporter.length) {
                $HtmlReporter
                    .find('.banner')
                    .prepend($('<a id="JasmineReporterCloseBtn" href="javascript:void(0)" title="Close tests results">x</a>')
                    .click(function() {
                        $('#HTMLReporter').remove();
                    })
                );
            }
        });
    };

    return { execute: execute };
    
});