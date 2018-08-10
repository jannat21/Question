(function()
{
    "use strict";
    angular.module("courseQuestion").factory("courceFactory",["$http",courceFactory]);
    
    function courceFactory($http){
        var cf=this;
        
        cf.getCourceSections=function(md5ID){
            return $http({url: siteUrl + '/Cource/getCourceSections',method:'POST',data:md5ID});
        };
        
        cf.saveNewCourceSection=function(newCourceSection,courceInfo){
            var datas={newSection:newCourceSection,cource:courceInfo};
            return $http({url: siteUrl + '/Cource/saveNewCourceSection',method:'POST',data:datas});
        };
        
        
        return cf;
    }
    

}());