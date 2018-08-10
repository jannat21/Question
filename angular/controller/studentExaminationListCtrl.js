(function ()
{
    "use strict";
    angular.module("courseQuestion").controller("studentExaminationListCtrl", ["studentEexaminationFactory", "$stateParams", "$scope", studentExaminationListCtrl]);

    function studentExaminationListCtrl(studentEexaminationFactory, $stateParams, $scope) {

        var selc = this;

        studentEexaminationFactory.getExaminationListInitial().success(function (data) {}).error(function () {
            toastr.error("ارتباط قطع است. مجدداً تلاش کنید.", "خطا!");
        });






    }// end of controller function courceCtrl


}());