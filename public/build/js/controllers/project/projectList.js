angular.module('app.controllers')
.controller('ProjectListController', ['$scope', '$cookies','Project',function($scope, $cookies, Project){
	$scope.projects = Project.query();

	
}]);