;(function () {
    'use strict';

    angular.module('xiaohu',['ui.router'])
    .config(['$interpolateProvider','$stateProvider','$urlRouterProvider',
        function ($interpolateProvider,$stateProvider,$urlRouterProvider) {
        $interpolateProvider.startSymbol('[:')
        $interpolateProvider.endSymbol(':]')

        $urlRouterProvider.otherwise('/home'); //如果没有url（其他的view） 跳转到/home
        $stateProvider
            .state('home',{
                url:'/home',
                // template:'<h1>首页</h1>'
                templateUrl: 'home.tpl' //if not find home.tpl on index  then to localhost:8000/home.tpl
            })
            .state('login',{
                url:'/login',
                templateUrl: 'login.tpl'
            })
            .state('signup',{
                url:'/signup',
                templateUrl:'signup.tpl'
            })
    }])
        .service('UserService',[
            function () {
                var me =this;
                me.signup_data = {}
                me.signup = function () {


                }
        }])

        .controller('SignupController',[
            '$scope','UserService',
            function ($scope,UserService) {
                $scope.User = UserService
            }
        ])
})();