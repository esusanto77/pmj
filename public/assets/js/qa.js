var rootUrl = window.location.hostname;
var qaApp = angular.module('qaApp', []);

rootUrl = root.base_url.substring(0, root.base_url.length - 1);

qaApp.controller('qaCtrl', function ($scope, $http) {     
  	// get question json
    $scope.currentQuiz = 1;
    $scope.ajaxNo = 3;

    for (var i = 1; i < 3; i++) {
      $http({method: 'GET', url: rootUrl + '/api/get_question/' + i}).
      success(function(data, status, headers, config) {     
        if(i == 1){
          $scope.quiz = data.questions;                  
        } else {

          if(data != "empty "){
            console.log(data);            
            $scope.quiz.push(data.questions[0]);                  
          }
        }

      });
    };
	 


   $scope.getQuiz = function(){         
      jQuery(".question-number-"+$scope.currentQuiz).hide();
      $scope.currentQuiz++;
     	$http({method: 'GET', url: rootUrl + '/api/get_question/' + $scope.ajaxNo}).
    	 success(function(data, status, headers, config) {    		    	        
        if(data == 0){
          if($scope.ajaxNo == $scope.currentQuiz){
            window.location.href = rootUrl;
          } else {
            return false;
          }          
        } else {
          $scope.quiz.push(data.questions[0]);                  
        }    	   
  	   });       
    }   

    $scope.postAnswer = function(quiz,answer,type){                  
       $http.post(rootUrl + '/api/post_answer/', {question:quiz,answer:answer,type:type}).success(function(response) {
          $scope.response = response;
          $scope.loading = false;
        });        
    }


});

