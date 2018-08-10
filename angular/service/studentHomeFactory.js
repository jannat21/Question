(function ()
{
    "use strict";
    angular.module("courseQuestion").factory("studentHomeFactory", ["$http", studentHomeFactory]);

    function studentHomeFactory($http) {
        var shf = this;

        shf.getHomeInitial = function () {
            return $http({url: siteUrl + '/StudentHome/getHomeInitial'});
        };

        
        return shf;
    }

}());