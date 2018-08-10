(function ()
{
    "use strict";
    angular.module("courseQuestion").controller("schoolCtrl", ["schoolFactory", schoolCtrl]);

    function schoolCtrl(schoolFactory) {

        var sc = this;

        schoolFactory.getInitialData().success(function (data) {
            sc.school = data.school;
            sc.school_class = data.school_class;
        }).error(function (data) {
            toastr.error("خطا در دریافت اطلاعات!", "خطا!");
            return false;
        });

        sc.addNewSchool = function (schoolForm) {
            if (schoolForm.$invalid) {
                toastr.error("لطفاً عنوان مدرسه را وارد کنید", "خطا!");
                return false;
            }
            sc.waitingSchoolSave = 1;
            schoolFactory.addNewSchool(sc.newSchoolName).success(function (data) {
                sc.school = data.school;
                sc.school_class = data.school_class;
                sc.waitingSchoolSave = 0;
            }).error(function (data) {
                sc.waitingSchoolSave = 0;
            });
        };

        sc.newClassName = [];
        sc.waitingClassSave = [];
        sc.addNewClass = function (school, newClassForm) {
            if (newClassForm.$invalid) {
                toastr.error("لطفاً عنوان کلاس را وارد کنید", "خطا!");
                return false;
            }
            sc.waitingClassSave[school.id] = 1;
            schoolFactory.addNewClass(sc.newClassName[school.id], school.id).success(function (data) {
                sc.school = data.school;
                sc.school_class = data.school_class;
                sc.waitingClassSave[school.id] = 0;
            }).error(function (data) {
                sc.waitingClassSave[school.id] = 0;
            });
        };

        sc.getClassList = function (schoolID) {
            var classList = [];
            for (var i in sc.school_class) {
                if (sc.school_class[i].schoolID == schoolID) {
                    classList.push(sc.school_class[i]);
                }
            }
            return classList;
        };

        sc.waitingShowClassStudent = 0;
        sc.getStudentList = function (sc_class) {
            sc.selectedClass = sc_class;
            sc.classStudentList = [];
            sc.waitingShowClassStudent = 1;
            schoolFactory.getClassStudents(sc_class).success(function (data) {
                sc.classStudentList = data;
                sc.waitingShowClassStudent = 0;
            }).error(function (data) {
                sc.waitingShowClassStudent = 0;
            });
            $('#studentModal').modal('show');
        };

        sc.newStudentModal = function () {
            sc.newStudent = {code: '', name: '', family: ''};
            $('#newStudentModal').modal('show');
        };

        sc.saveNewStudent = function (insertNewStudentForm) {
            if (insertNewStudentForm.$valid) {
                schoolFactory.saveNewStudent(sc.newStudent, sc.selectedClass).success(function (data) {
                    console.log(data);
                    if (data.result == 'repeated') {
                        toastr.error("کد دانش آموزی وارد شده تکراری است.", "خطا!");
                    }
                    if (data.result == 'success') {
                        toastr.success("اطلاعات با موفقیت ثبت شد.", "ثبت اطلاعات!");
                        sc.newStudent = {code: '', name: '', family: ''};
                        sc.classStudentList = data.data;

                    }
                }).error(function (data) {});
            }
        };

        sc.getClassExportExcelLink = function (sc_class) {
            return siteUrl + '/School/exportClassStudent2Excel/' + sc_class.md5ClassID;
        };

    }// end of controller function courceCtrl


}());