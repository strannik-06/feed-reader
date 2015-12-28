'use strict';

// todo: compare code with video tutorial
var app = angular.module('app', []);

app.controller('FeedController', function ($scope, $http) {
    $scope.items = [];
    $scope.retrieveItems = function(source) {
        $http.get('/feed')
            .success(function (items) {
                $scope.items = items;
            });
    };
});
