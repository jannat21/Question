(function ()
{
    "use strict";
    angular.module("courseQuestion").factory("studentEexaminationFactory", ["$http", studentEexaminationFactory]);

    function studentEexaminationFactory($http) {
        var sef = this;

        sef.getExaminationInitial = function () {
            return $http({url: siteUrl + '/StudentExamination/getExaminationInitial'});
        };

        sef.createExam = function (selectedCource, questionNum, sections, tags, levels) {
            var datas = {
                cource: selectedCource,
                questionNum: questionNum,
                sections: sections,
                tags: tags,
                levels: levels
            };
            return $http({url: siteUrl + '/StudentExamination/createExam', data: datas, method: 'POST'});
        };
        
        sef.checkSaveTest=function(sendedExamTest){
            return $http({url: siteUrl + '/StudentExamination/checkSaveTest', data: {exam:sendedExamTest}, method: 'POST'});
        };
        
        sef.getExaminationListInitial=function(){
            return $http({url: siteUrl + '/StudentExamination/getExaminationListInitial'});
        };

        return sef;
    }

}());