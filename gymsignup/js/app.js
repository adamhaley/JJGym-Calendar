$(document).ready(function(){
	$('.delete').click(function(evt){
		var id = $(evt.target).attr('data-id');
		var url = '/jjgym-calendar/gymsignup/index.php/calendar/delete_event?id=' + id;
		$.ajax({	
			url: url,
			successs: function(req){
				console.log('success!');
				console.log(req);
			},
			error: function(req){
				console.log('error!');
				console.log(req);
			}
		});

	});

});
