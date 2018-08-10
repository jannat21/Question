
(function () {
    "use strict";
    angular.module("courseQuestion").directive("rightMenu", [rightMenu]);

    function rightMenu() {
        return{
            restrict:"E",
            replace:false,
            transclude:true,
            templateUrl:siteUrl+'/views/loadView/rightmenu/directive'            
        }
    }

}());

