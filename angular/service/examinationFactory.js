(function ()
{
    "use strict";
    angular.module("courseQuestion").factory("examinationFactory", ["$http", examinationFactory]);

    function examinationFactory($http) {
        var ef = this;

        ef.getExaminationInitial = function () {
            return $http({url: siteUrl + '/Examination/getExaminationInitial'});
        };

        ef.createExam = function (selectedCource, questionNum, sections, tags, levels) {
            var datas = {
                cource: selectedCource,
                questionNum: questionNum,
                sections: sections,
                tags: tags,
                levels: levels
            };
            return $http({url: siteUrl + '/Examination/createExam', data: datas, method: 'POST'});
        };

        ef.saveExam = function (sendedExamTest, title, filter, serial) {
            return $http({url: siteUrl + '/Examination/saveExam', data: {exam: sendedExamTest, title: title, filter: filter, serial: serial}, method: 'POST'});
        };

        ef.getExamList = function () {
            return $http({url: siteUrl + '/Examination/getExamList', method: 'POST'});
        };

        ef.getExamAnswerSheet = function (md5ID) {
            return $http({url: siteUrl + '/Examination/getExamAnswerSheet', method: 'POST', data: md5ID});
        };

        ef.getSchoolList = function () {
            return $http({url: siteUrl + '/Examination/getSchoolList', method: 'POST'});
        };

        ef.getStudentList = function (classID) {
            return $http({url: siteUrl + '/Examination/getStudentList', method: 'POST', data: classID});
        };

        ef.saveExamResult = function (student, answerSheet,answerSheetImage,markAz20) {
            return $http({url: siteUrl + '/Examination/saveExamResult', method: 'POST', data: {student:student,answerSheet:answerSheet,answerSheetImage:answerSheetImage,markAz20:markAz20}});
        };


        return ef;
    }
}());