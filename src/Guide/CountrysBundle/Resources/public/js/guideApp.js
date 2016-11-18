// controllers and interpolateProvider

var guideApp = angular.module('guideApp', []);
  guideApp.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
  });
  
guideApp.controller('countryCtrl', function ($scope, $http) {
    $scope.countries = [];

    var tabClasses;
    function initTabs() {
        tabClasses = [];
        for (var i = $scope.countries.length - 1; i >= 0; i--) {
            $scope.countries[i]
            tabClasses.push("");
        }
    }

    $scope.currentCountry;

    $scope.getTabClass = function (countryId) {
        return tabClasses[countryId];
    };

    $scope.getTabPaneClass = function (countryId) {
        return 'tab-pane ' + tabClasses[countryId];
    };

    $scope.setActiveTab = function (country) {
        initTabs();
        tabClasses[country.id] = 'active';
        $scope.currentCountry  = country;
    };

    function initData() {
        initTabs();
        var firstCountry;
        for (var i = 0; i < $scope.countries.length; i++) {
            firstCountry = $scope.countries[i];
            break;
        }
        if(firstCountry) {
            $scope.setActiveTab(firstCountry);
        }
    }

    $http({method: 'GET', url: '/country'}).then(
        function successCallback(response) {
            $scope.countries = response.data;
            initData();
        },
        function errorCallback(response) {
        }
    );

    $scope.saveCity = function (city) {
        city.country_id = $scope.currentCountry.id;
        $http({method: 'POST', url: '/city/new', data: city}).then(
            function successCallback(response) {
                $scope.currentCountry.citys.push(response.data);
                $scope.showForm = false;
            },
            function errorCallback(response) {
                $scope.showForm = false;
            }
        );
    }

    $scope.warningCity = function (city, scope) {
        city.warning = true;
    }

    $scope.deleteCity = function (city, scope) {
        $http.delete('city/' + city.id)
        .success(function (response) {
            var cities = $scope.currentCountry.citys;
            for (var i = cities.length - 1; i >= 0; i--) {
                if (cities[i].id == city.id) {
                    cities.splice(i, 1);
                    break;
                }
            }
        })
        .error(function (response) {
            alert(response);
        });
    };

    $scope.editCity = function (city) {
        city.country_id = $scope.currentCountry.id;

        $http({method: 'PUT', url: 'city/edit/'+city.id, data: city}).then(
            function successCallback(response) {
                city.showFormEdit = false;
            },
            function errorCallback(response) {
                $scope.hideFormEdit = false;
            }
        );
    }

    $scope.cancelCity = function (city) {
        if (city.warning == true) {
            city.showFormEdit = false;
            city.warning = false;
        } else {
            var oldCity = city.oldCity;
            for(var k in oldCity) {
                city[k] = oldCity[k];
            }
            city.showFormEdit = false;
            city.warning = false;
        }
    }

    $scope.openCity = function (city) {
        if (city.showFormEdit) {
            city.oldCity      = undefined;
            city.showFormEdit = false;
        } else {
            city.oldCity      = angular.copy(city);
            city.showFormEdit = true;
        }
    }
});
