(function()
{
    "use strict";
    angular.module("courseQuestion").factory("examinationFactory",["$http",examinationFactory]);
    
    function examinationFactory($http){
        var ef=this;
        
        ef.getExaminationInitial=function(){
            return $http({url: siteUrl + '/Examination/getExaminationInitial'});
        };
        
        ef.createExam=function(selectedCource,questionNum,sections,tags,levels){
            var datas={
                cource:selectedCource,
                questionNum:questionNum,
                sections:sections,
                tags:tags,
                levels:levels
            };
            return $http({url: siteUrl + '/Examination/createExam',data:datas,method:'POST'});
        };
        
        ef.export2Word=function(examTest){
            return $http({url: siteUrl + '/Examination/export2Word',data:examTest,method:'POST'});
        };
        
        
        return ef;
    }
    

}());