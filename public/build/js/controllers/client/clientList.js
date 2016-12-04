angular.module('app.controllers')
.controller('ClientListController', ['$scope', '$cookies','Client',function($scope, $cookies,Client){
	$scope.clients = Client.query();
	console.log($cookies.getObject('user').email);

	
}]);