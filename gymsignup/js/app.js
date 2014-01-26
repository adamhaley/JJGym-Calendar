var app = angular.module("jjgym", ['ui.bootstrap.modal','ui.bootstrap.timepicker','jjgym.controllers']);

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
	      $scope.checkGymAvailability = function(timeStart,timeEnd){

	        // var url = "/api/check-availability";
	        var url = "/jjgym-calendar/gymsignup/index.php/api/get_events_by_date";
	        url += "?date=" + timeStart;
	        console.log(url);

	        var app = this;
	        $http.get(url)
	          .success(function(res){
	            console.log(res);
	            $scope.availability = res.available;
	            $scope.overlappingEvents = res.overlappingEvents;
	          })
	          .error(function(res){
	            console.log(res);
	          });  
	      }
	     
	      $scope.checkGymAvailability($scope.timeStart,$scope.timeEnd);

	      $scope.TimepickerCtrl = function ($scope) {
	        $scope.date = date;
	        $scope.changeTime = function(){
	          if(!moment($scope.timeEnd).isAfter($scope.timeStart)){
	            $scope.timeEnd = moment($scope.timeStart).add('minutes',30).format();
	          }  
	          $scope.checkGymAvailability($scope.timeStart,$scope.timeEnd); 
	        }

	        $scope.clear = function() {
	          $scope.hour = null;
	        };
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
