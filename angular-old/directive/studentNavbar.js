
(function () {
    "use strict";
    angular.module("courseQuestion").directive("studentNavbar", [studentNavbar]);

    function studentNavbar() {
        return{
            restrict:"E",
            replace:false,
            transclude:true,
            templateUrl:siteUrl+'/views/loadView/studentNavbar/directive'            
        }
    }

}());

