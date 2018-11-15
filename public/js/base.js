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
            '$state',
            '$http',
            function ($state,$http) {
                var me =this;
                me.signup_data = {}
                me.signup = function () {
                    $http.post('/api/signup',me.signup_data)
                        .then(function (r) {
                            if(r.data.status)
                                 me.sginup_data = {};
                                 $state.go('login');
                        },function (e) {
                            console.log('e',e)
                        })
                }
                me.username_exists = function () {
                    $http.post('/api/user/exists',{username:me.signup_data.username})
                        .then(function (r) {
                            if(r.data.status && r.data.data.count)
                                me.signup_username_exists = true;
                            else
                                me.signup_username_exists = false;
                        }, function (e) {
                                console.log('e',e)
                            })
                        
                }
        }])

        .controller('SignupController',[
            '$scope','UserService',
            function ($scope,UserService) {
                $scope.User = UserService;

                $scope.$watch(function ()
                {
                    return UserService.signup_data;
                },function (n,o) {
                    if(n.username != o.username)
                        UserService.username_exists();
                },true)
            }
        ])
})();