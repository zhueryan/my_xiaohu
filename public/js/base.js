;(function () {
    'use strict';

    angular.module('xiaohu',[])
    .config(function ($interpolateProvider) {
        $interpolateProvider.startSymbol('[:')
        $interpolateProvider.endSymbol(':]')
    })
    /*rootscope*/
        .controller('TestController',function ($scope) {
            $scope.name = 'Bob';
        })
})();