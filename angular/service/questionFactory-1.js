(function()
{
    "use strict";
    angular.module("courseQuestion").factory("questionFactory",["$http",questionFactory]);
    
    function questionFactory($http){
        var qf=this;
        
        qf.getCourceSections=function(md5ID){
            return $http({url: siteUrl + '/Cource/getCourceSections',method:'POST',data:md5ID});
        };
        
        qf.saveNewCourceSection=function(newCourceSection,courceInfo){
            var datas={newSection:newCourceSection,cource:courceInfo};
            return $http({url: siteUrl + '/Cource/saveNewCourceSection',method:'POST',data:datas});
        };
        
        //get question view initial data
        qf.getQuestionViewInitial=function(md5CourceID,md5SectionID){
            var datas={md5CourceID:md5CourceID,md5SectionID:md5SectionID};
            return $http({url: siteUrl + '/Question/getQuestionViewInitial',method:'POST',data:datas});
        };
        
        //save new question
        qf.saveQuestion=function(question,sectionInfo){
            console.log('qf',question);
            var datas={question:question,sectionInfo:sectionInfo};
            return $http({url: siteUrl + '/Question/saveQuestion',method:'POST',data:datas});
        };
        
        
        
        return qf;
    }
    

}());