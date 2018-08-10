
(function () {
    "use strict";
    var app = angular.module("courseQuestion", ['ui.router', 'serviceModule','ngAnimate','oi.select']);
    app.config(config);
    app.run(Run);
    
    
    
    // main controller
    app.controller('mainController', function ($http) {
        var mCtrl = this;
        mCtrl.themeName = 'bootstrap-flatly';
        mCtrl.saveWaiting=0;
        
        $http({url: siteUrl + '/Home/home/getPayeandCources'}).success(function (data) {
            mCtrl.payeList=data.payeList;
            mCtrl.courceList=data.courceList;
        });
        
        mCtrl.saveNewCourse=function(newCourceForm){
            if(newCourceForm.$valid===true){
                mCtrl.saveWaiting=1;
                $http({url: siteUrl + '/Home/Home/saveNewPayeandCources',method:'POST',data:mCtrl.newCource}).success(function (data) {
                    mCtrl.courceList=data.courceList;
                    $('#insertNewCourse').modal('hide');
                    mCtrl.saveWaiting=0;
                }).error(function(){
                    alert('ERROR');
                });
            }
            
        };// save new cource
        
        mCtrl.inserNewCource=function(courseID){
            
            mCtrl.newCource={selectedPaye:{},newDars:''};
            $('#insertNewCourse').modal('show');
        };
        
     
    });
    
    // config
    function config($stateProvider, $urlRouterProvider) {
        $urlRouterProvider.otherwise('/');
        
        $stateProvider
                .state("payeCource", {url: "/", templateUrl: siteUrl + "/views/loadView/payeCourceView"})
                .state("cource", {url: "/cource/:md5ID", templateUrl: siteUrl + "/views/loadView/courceView/cource",controller:"courceCtrl as cc"})
                .state("question", {url: "/question/:md5courceID/:md5sectionID", templateUrl: siteUrl + "/views/loadView/questionView/question",controller:"questionCtrl as qc"})
                .state("examination", {url: "/examination", templateUrl: siteUrl + "/views/loadView/examinationView/examination",controller:"examinationCtrl as ec"})
                .state("test2", {url: "/test2", template: "TEST2"});
    }
    
    // RUN
    function Run($rootScope) {
        $rootScope.$on('$stateChangeSuccess', function (event, toState, toParams, fromState, fromParams) {
            $rootScope.currentState = toState.name;
        });
    }
    
    
    
}());




