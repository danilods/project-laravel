var app = angular.module('app',['ngRoute','angular-oauth2','app.controllers',
	'app.services', 'app.filters']);

angular.module('app.controllers',['ngMessages','angular-oauth2']);
angular.module('app.filters',[]);

angular.module('app.services',['ngResource']);


app.provider('appConfig', function(){
	var config = {
		baseUrl: 'http://localhost:8000',
		project:{
			status:[
			{value: 1, label: 'Não iniciado'},
			{value: 2, label: 'iniciado'},
			{value: 3, label: 'Concluído'}
			]
			
		}
	};
	return {
		config: config,
		$get: function(){
			return config;
		}
	}
});

app.config(['$routeProvider', '$httpProvider','OAuthProvider', 'OAuthTokenProvider','appConfigProvider',
	function($routeProvider, $httpProvider,OAuthProvider, OAuthTokenProvider, appConfigProvider){
		$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

		$httpProvider.defaults.headers.put['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

		$httpProvider.defaults.transformResponse = function(data, headers){
				var headersGetter = headers();
				if(headersGetter['content-type'] == 'application/json' ||
					headersGetter['content-type'] == 'text/json' ){
						var dataJson = JSON.parse(data);
						if(dataJson.hasOwnProperty('data')){
							dataJson = dataJson.data;
						}
						return dataJson;
						
			}
			return data;
				
			};
	$routeProvider
		.when('/login',{
			templateUrl: 'build/views/login.html',
			controller: 'LoginController'
		})
		.when('/home',{
			templateUrl: 'build/views/home.html',
			controller: 'HomeController'
		})
		.when('/clients',{
			templateUrl: 'build/views/client/list.html',
			controller: 'ClientListController'
		})


		.when('/clients/new',{
			templateUrl: 'build/views/client/new.html',
			controller: 'ClientNewController'
		})

		.when('/clients/:id/edit',{
			templateUrl: 'build/views/client/edit.html',
			controller: 'ClientEditController'
		})

		.when('/clients/:id/remove',{
			templateUrl: 'build/views/client/remove.html',
			controller: 'ClientRemoveController'
		})

		.when('/project',{
			templateUrl: 'build/views/project/list.html',
			controller: 'ProjectListController'
		})		
		.when('/project/new',{
			templateUrl: 'build/views/project/new.html',
			controller: 'ProjectNewController'
		})
		.when('/project/:id/edit',{
			templateUrl: 'build/views/project/edit.html',
			controller: 'ProjectEditController'
		})
		.when('/project/:id/remove',{
			templateUrl: 'build/views/project/remove.html',
			controller: 'ProjectRemoveController'
		})
		.when('/project/:id/notes',{
			templateUrl: 'build/views/project-note/list.html',
			controller: 'ProjectNoteListController'
		})
		.when('/project/:id/notes/:idNote/show',{
			templateUrl: 'build/views/project-note/show.html',
			controller: 'ProjectNoteShowController'
		})
		.when('/project/:id/notes/new',{
			templateUrl: 'build/views/project-note/new.html',
			controller: 'ProjectNoteNewController'
		})
		.when('/project/:id/note/:idNote/edit',{
			templateUrl: 'build/views/project-note/edit.html',
			controller: 'ProjectNoteEditController'
		})
		.when('/project/:id/note/:idNote/remove',{
			templateUrl: 'build/views/project-note/remove.html',
			controller: 'ProjectNoteRemoveController'
		});

		/*
		Route::get('{id}/note', 'ProjectNotesController@index');
		Route::post('{id}/note', 'ProjectNotesController@store');
		Route::get('{id}/note/{noteId}', 'ProjectNotesController@show');
		//Route::put('{id}/note/{noteId}', 'ProjectNotesController@update');
		Route::put('note/{idNote}', 'ProjectNotesController@update');

		Route::delete('note/{noteId}', 'ProjectNotesController@destroy');

		Route::post('{id}/file', 'ProjectFileController@store');
		*/



		OAuthProvider.configure({
		      baseUrl: appConfigProvider.config.baseUrl,
		      clientId: 'appid1',
		      clientSecret: 'secret', // optional
		      grantPath: 'oauth/access_token'
		    });

		OAuthTokenProvider.configure({
			  name: 'token',
			  options: {
			  	secure: false
			  }

		})

}]);

app.run(['$rootScope', '$window', 'OAuth', function($rootScope, $window, OAuth) {
    $rootScope.$on('oauth:error', function(event, rejection) {
      // Ignore `invalid_grant` error - should be catched on `LoginController`.
      if ('invalid_grant' === rejection.data.error) {
        return;
      }

      // Refresh token when a `invalid_token` error occurs.
      if ('invalid_token' === rejection.data.error) {
        return OAuth.getRefreshToken();
      }

      // Redirect to `/login` with the `error_reason`.
      return $window.location.href = '/login?error_reason=' + rejection.data.error;
    });
  }]);