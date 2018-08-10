
(function () {
    "use strict";
    angular.module("courseQuestion").directive("navbar", [navBar]);

    function navBar() {
        return{
            restrict:"E",
            replace:false,
            transclude:true,
            templateUrl:siteUrl+'/views/loadView/navbar/directive'            
        }
    }

}());

