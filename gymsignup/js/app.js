var app = angular.module("jjgym", ['ui.bootstrap.modal','ui.bootstrap.datepicker', 'ui.bootstrap.timepicker','jjgym.controllers']);

var ctrls = angular.module('jjgym.controllers',[]);

ctrls.controller('CalendarController', function($scope,$location,$modal,$http,$log,$timeout){


	/**
	*delete event
	*/
	$scope.deleteEvent = function(evt){
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
	}
	/**
  *book Time 
  */
	$scope.bookTime = function(){
	    
	    // $scope.hour = date;

	    var ModalInstanceCtrl = function ($scope, $modalInstance, date) {
	    	var date = moment().format('YYYY-MM-DD');

	    	$scope.liveDate = date;
	    	$scope.date = moment(date).format('dddd MMMM Do, YYYY');
	    	// $scope.hour = moment(date).format('h:mma');
	    	$scope.hour = moment(date).format("hh:mm");
	      // $scope.date = date;
	      $scope.availability = 0;
	     
	    	$scope.timeStart = moment(date + ' ' + $scope.hour).format();
	     	$scope.timeEnd = moment(date + ' ' + $scope.hour).add(1,'hours').format();
	      
	      //percentages
	      $scope.percentages = [25,50,75,100];
	      /*calculate timeStart based on x position of click if month view
	      */
	      
	    	var addSelectpicker = function(){
	    		$('.selectpicker').selectpicker();
	    	}
	    	setTimeout(addSelectpicker,250);

	      $scope.checkGymAvailability = function(timeStart,timeEnd,date){
	      	var date = moment(date).format('YYYY-MM-DD');
	      	var timeStart = moment(timeStart).format('HH:mm');//remove date from time
	      	var timeEnd = moment(timeEnd).format('HH:mm');

	      	console.log('in checkGymAvailability date is ' + date);
	        var url = "/jjgym-calendar/gymsignup/index.php/api/get_events_by_date";
	        url += "?date=" + date;
	      	var checkAvailability = function(res){
	          console.log(res);
	        	rows = res.response;
	         	overlappingEvents = _.filter(rows,function(row){
		          //if the row overlaps our time boundaries
		          // timeStart = moment(date + " " + timeStart);
		          var range1 = moment(date + ' ' + timeStart).twix(date + ' ' + timeEnd);
		          var range2 = moment(date + " " + row.time_start).twix(date + " " + row.time_end);

		          if(range2.overlaps(range1)){
		            return row;
		          } 
		      	});
	      
			      //total up percentage
			      //loop through every half hour time slot between timeStart and timeEnd
			      var maxUsage = 0;
			      for(i = 0; moment(date + ' ' + timeStart).add('minutes', i * 30).isBefore(moment(date + ' ' + timeEnd)); i++){
			        var usage = 0;
			        var rangeStart = moment(date + ' ' + timeStart).add('minutes', i * 30);
			        var rangeEnd = moment(date + ' ' + timeStart).add('minutes', (i+1) * 30);

			        //filter overlappingEvents by events that occur in this range
			        thisSlotOverlapping = _.filter(rows,function(row){
			          //if the row overlaps our time boundaries
			          var range1 = rangeStart.twix(rangeEnd);
			          var range2 = moment(date + " " + row.time_start).twix(date + " " + row.time_end);
			          if(range2.overlaps(range1)){
			            return row;
			          }
			        });
			        //add up usage percentage
			        _.each(thisSlotOverlapping,function(row){
			          usage += parseInt(row.usage);
			        });
			        maxUsage = usage > maxUsage? usage : maxUsage;
			      }

			      var out = {
			        overlappingEvents: overlappingEvents,
			        usage: maxUsage,
			        available: 100 - maxUsage
			      }
						$scope.availability = out.available;
	          $scope.overlappingEvents = res.overlappingEvents;
	        } 

	        var app = this;
	        $http.get(url)
	          .success(checkAvailability)
	          .error(function(res){
	            console.log(res);
	          });  
	      }
	     
	      $scope.checkGymAvailability($scope.timeStart,$scope.timeEnd);



	      $scope.TimepickerCtrl = function ($scope) {

	        $scope.changeTime = function(){
	          if(!moment($scope.timeEnd).isAfter($scope.timeStart)){
	            $scope.timeEnd = moment($scope.timeStart).add('minutes',30).format();
	          }  
	          $scope.checkGymAvailability($scope.timeStart,$scope.timeEnd,$scope.liveDate); 
	        }

	        $scope.clear = function() {
	          $scope.hour = null;
	        };
	      };

	      $scope.DatepickerCtrl = function ($scope) {
					  $scope.today = function() {
					    $scope.dt = new Date();
					  };
					  $scope.today();

					  $scope.showWeeks = true;
					  $scope.toggleWeeks = function () {
					    $scope.showWeeks = ! $scope.showWeeks;
					  };

					  $scope.clear = function () {
					    $scope.dt = null;
					  };

					  $scope.changed = function(){
					  	console.log('in changed..');
					  	$scope.$parent.liveDate = moment($scope.dt).format('YYYY-MM-DD');
					  	$scope.checkGymAvailability($scope.timeStart,$scope.timeEnd,$scope.liveDate); 
					  }
					  // Disable weekend selection
					  /*
					  $scope.disabled = function(date, mode) {
					    return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
					  };
						*/
					  $scope.toggleMin = function() {
					    $scope.minDate = ( $scope.minDate ) ? null : new Date();
					  };
					  $scope.toggleMin();

					  $scope.open = function($event) {
					    $event.preventDefault();
					    $event.stopPropagation();

					    $scope.opened = true;
					  };

					  $scope.prev = function(){
					  	$scope.dt = moment($scope.dt).subtract('days',1).toDate();	
					  	$scope.$parent.liveDate = moment($scope.dt).format('YYYY-MM-DD');
					  	$scope.checkGymAvailability($scope.timeStart,$scope.timeEnd,$scope.$parent.liveDate); 
					  }

					  $scope.next = function(){
					  	$scope.dt = moment($scope.dt).add('days',1).toDate();
					  	$scope.$parent.liveDate = moment($scope.dt).format('YYYY-MM-DD');
					  	$scope.checkGymAvailability($scope.timeStart,$scope.timeEnd,$scope.$parent.liveDate); 
					  }

					  $scope.dateOptions = {
					    'year-format': "'yy'",
					    'starting-day': 1
					  };

					  $scope.format = 'longDate';
				};
     

	      $scope.ok = function () {
	        $modalInstance.close();
	      };
	      $scope.cancel = function () {
	        $modalInstance.dismiss('cancel');
	      };
	    };

	    var modalInstance = $modal.open({
	      templateUrl: 'js/templates/booktime.html',
	      controller: ModalInstanceCtrl,
	      resolve: {
	        date: function() {
	          return $scope.date;
	        },
	        hour: function() {
	          return $scope.hour;
	        },
	        timeStart: function(){
	          return $scope.timeStart;
	        },
	        timeEnd: function(){
	          return $scope.timeEnd;
	        }
	      }
	    });
	   
	    

	    modalInstance.result.then(function () {
	    	
	      // $scope.selected = selectedItem;
	    }, function () {
	      $log.info('Modal dismissed');
	    }); 

	}
});
