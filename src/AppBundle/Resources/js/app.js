'use strict';

// todo: compare code with video tutorial
var app = angular.module('app', []);

app.controller('FeedController', function ($scope, $http) {
    $scope.products = [];
    $scope.retrieveItems = function(source) {
        $http.get('/feed')
            .success(function (products) {
                $scope.products = products;
            });
    };
});
