
// controllers



var guideApp = angular.module('guideApp', []);
  guideApp.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
  });
  
guideApp.controller('countryCtrl', function ($scope, $http) {
    $scope.countries = [];
    $scope.cities    = [];

    $http({method: 'GET', url: '/country'}).then(
        function successCallback(response) {
            $scope.countries = response.data;
        },
        function errorCallback(response) {

        }
    );

    $http({method: 'GET', url: '/city'}).then(
        function successCallback(response) {
            $scope.cities = response.data;
        },
        function errorCallback(response) {

        }
    );
});
