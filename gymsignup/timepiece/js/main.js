$(document).ready(function(){

	$('#form-opener').click(function(e){
		console.log($('#form'));
		
		$('#form').slideDown();
	});

	$('#form-closer').click(function(){
		$('#form').slideUp();
	});

	$('#form-submit').click(function(){

		$('form#contact').submit();

	});

	$('#contact').submit(function(e){
		e.preventDefault();
		// console.log('hi');
		var str = $(this).serialize();
	
		$.ajax({
			url: 'receiver.php?' + str
			, success: function(data){
				$('#form-content').html('<div id="thankyou">Thank You! We will be in touch with you soon..</div>');
				$('#thankyou').fadeIn();
				setTimeout("$('#form').slideUp()",1000);
			}
			, error: function(data){
				
			}
		});
		

	})
		
});