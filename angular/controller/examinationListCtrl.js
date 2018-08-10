(function ()
{
    "use strict";
    angular.module("courseQuestion").controller("examinationListCtrl", ["examinationFactory", "$stateParams", "$scope", examinationListCtrl]);

    function examinationListCtrl(examinationFactory, $stateParams, $scope) {

        var elc = this;

        examinationFactory.getExamList()
                .success(function (data) {
                    elc.examList = data;
                })
                .error(function (data) {
                    toastr.error("ارتباط قطع است. مجدداً تلاش کنید.", "خطا!");
                });

    }

}());