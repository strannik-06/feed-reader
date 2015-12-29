'use strict';

var app = angular.module('app', []);

app.controller('FeedController', function ($scope, $http) {
    $scope.products = [];
    $('.hide').removeClass('hide');

    $scope.retrieveItems = function(source, start, amount) {
        if (start < 0) start = 0;

        $http.get(Routing.generate('feed', {
                source: source,
                start: start,
                amount: amount
            }, true))
            .success(function (products) {
                $scope.products = products;
                $scope.start = start;
                $scope.amount = amount;
            });
    };
});
