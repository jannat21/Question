(function ()
{
    "use strict";
    angular.module("courseQuestion").factory("schoolFactory", ["$http", schoolFactory]);

    function schoolFactory($http) {
        var sf = this;

        sf.getInitialData = function () {
            return $http({url: siteUrl + '/School/getInitialData'});
        };

        sf.addNewSchool = function (newSchoolName) {
            return $http({url: siteUrl + '/School/addNewSchool', data: {schoolName: newSchoolName}, method: 'POST'});
        };

        sf.addNewClass = function (newClassName, schoolID) {
            return $http({url: siteUrl + '/School/addNewClass', data: {className: newClassName, schoolID: schoolID}, method: 'POST'});
        };

        sf.saveNewStudent = function (newStudent, selectedClass) {
            return $http({url: siteUrl + '/School/saveNewStudent', data: {selectedClass: selectedClass, newStudent: newStudent}, method: 'POST'});
        };

        sf.getClassStudents = function (selectedClass) {
            return $http({url: siteUrl + '/School/getClassStudents', data: {selectedClass: selectedClass}, method: 'POST'});
        };


        return sf;
    }


}());