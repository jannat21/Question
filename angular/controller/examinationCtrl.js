(function ()
{
    "use strict";
    angular.module("courseQuestion").controller("examinationCtrl", ["examinationFactory", "$stateParams", "$scope", examinationCtrl]);

    function examinationCtrl(examinationFactory, $stateParams, $scope) {

        var ec = this;
        ec.questionLevels = [{id: 1, title: 'ساده'}, {id: 2, title: 'عادی'}, {id: 3, title: 'سخت'}];
        ec.courceTags = [];
        ec.courceSections = [];

        ec.selectedTags = [];
        ec.selectedSections = [];
        ec.selectedLevels = [];

        $scope.selectedCource = [];

        $scope.$watch('selectedCource', function (newValue, oldValue) {
            ec.courceTags = [];
            for (var i in ec.questionTags) {
                if (ec.questionTags[i].courceID == newValue.courceID) {
                    ec.courceTags.push(ec.questionTags[i]);
                }
            }

            ec.courceSections = [];
            for (var i in ec.sections) {
                if (ec.sections[i].courceID == newValue.courceID) {
                    ec.courceSections.push(ec.sections[i]);
                }
            }

            ec.selectedTags = [];
            ec.selectedSections = [];
            ec.selectedLevels = [];

        });

        examinationFactory.getExaminationInitial()
                .success(function (data) {
                    ec.payeCource = data.cource;
                    ec.questionTags = data.questionTags;
                    ec.sections = data.sections;
                })
                .error(function (data) {
                    toastr.error("ارتباط قطع است. مجدداً تلاش کنید.", "خطا!");
                });

        $scope.selectedCource = [];
        ec.questionNum = 10;
        ec.creatingExam = 0;
        ec.originalExam = [];
        ec.clickCreateBut = 0;

        ec.createExam = function () {
            if ($scope.selectedCource.length <= 0) {
                toastr.error("لطفاً عنوان درس را انتخاب کنید.", "خطا!");
                return false;
            }
            if (ec.questionNum == undefined) {
                toastr.error("خطا!", "لطفاً تعداد سوال را وارد کنید.");
                return false;
            }
            if (ec.questionNum == null) {
                toastr.error("خطا!", "لطفاً تعداد سوال را وارد کنید.");
                return false;
            }

            ec.creatingExam = 1;
            ec.clickCreateBut = 1;

            examinationFactory.createExam($scope.selectedCource, ec.questionNum, ec.selectedSections, ec.selectedTags, ec.selectedLevels)
                    .success(function (data) {
                        ec.originalExam = data.questions;
                        ec.filterArray = data.filter;
                        ec.generateExamTest();
                        ec.creatingExam = 0;
                        ec.examSerial = 0;
                        ec.examTitle = '';
                    })
                    .error(function (data) {
                        toastr.error("ارتباط قطع است. مجدداً تلاش کنید.", "خطا!");
                        ec.creatingExam = 0;
                    });

            // generate Exam
            ec.generateExamTest = function () {
                ec.examTest = ec.originalExam.slice();
                ec.examTestAnswers = [];
                ec.levelCount = {'sade': 0, 'adi': 0, 'sakht': 0, 'namalum': 0};
                for (var i in ec.originalExam) {
                    if (ec.originalExam[i].questionLevel == 'عادی') {
                        ec.levelCount.adi += 1;
                    } else if (ec.originalExam[i].questionLevel == 'ساده') {
                        ec.levelCount.sade += 1;
                    } else if (ec.originalExam[i].questionLevel == 'سخت') {
                        ec.levelCount.sakht += 1;
                    } else {
                        ec.levelCount.namalum += 1;
                    }
                    var randNum = Math.floor(Math.random() * 4) + 1;

                    ec.examTestAnswers[i] = {questionID: ec.originalExam[i].questionID, answer: randNum};
                    ec.examTest[i].items.splice(randNum - 1, 0, {
                        courceID: ec.examTest[i].courceID,
                        itemID: "0",
                        itemTitle: ec.examTest[i].questionAnswer,
                        questionID: ec.examTest[i].questionID,
                        sectionID: ec.examTest[i].sectionID,
                        userID: ec.examTest[i].userID});
                }
            };

            //regenerate examination
            ec.reGenerateExamTest = function () {
                console.log(ec.examTestAnswers);
                ec.savedExam = 0;
                ec.examTest = ec.sortArrayRandomly(ec.examTest);
                for (var i in ec.examTest) {
                    ec.examTest[i].items = ec.sortArrayRandomly(ec.examTest[i].items);
                    for (var j = 0; j < 4; j++) {
                        if (ec.examTest[i].items[j].itemID == 0) {
                            for (var k = 0; k < ec.examTestAnswers.length; k++) {
                                if (ec.examTestAnswers[k].questionID == ec.examTest[i].questionID) {
                                    ec.examTestAnswers[k].answer = j + 1;
                                }
                            }
                        }
                    }
                }

//                var currentIndex = ec.examTest.length;
//                var examTemp, randomIndex;
//                while (0 !== currentIndex) {
//                    randomIndex = Math.floor(Math.random() * currentIndex);
//                    currentIndex -= 1;
//                    examTemp = ec.examTest[currentIndex];
//                    ec.examTest[currentIndex] = ec.examTest[randomIndex];
//                    ec.examTest[randomIndex] = examTemp;
//                }
            };

            // sort array randomly
            ec.sortArrayRandomly = function (array) {
                var currentIndex = array.length;
                var examTemp, randomIndex;
                while (0 !== currentIndex) {
                    randomIndex = Math.floor(Math.random() * currentIndex);
                    currentIndex -= 1;
                    examTemp = array[currentIndex];
                    array[currentIndex] = array[randomIndex];
                    array[randomIndex] = examTemp;
                }
                return array;
            };

            //get answer class
            ec.getAnswerClass = function (index, test) {
                for (var i in ec.examTestAnswers) {
                    if (ec.examTestAnswers[i].questionID == test.questionID) {
                        if (index == ec.examTestAnswers[i].answer) {
                            return "text-success";
                        }
                    }
                }
            };

            //get answer icon class
            ec.getAnswerIconClass = function (index, test) {
                for (var i in ec.examTestAnswers) {
                    if (ec.examTestAnswers[i].questionID == test.questionID) {
                        if (index == ec.examTestAnswers[i].answer) {
                            return "fa fa-check text-success";
                        } else {
                            return "fa fa-times text-danger";
                        }
                    }
                }
            };

            // save exam
            ec.savingExam = 0;
            ec.savedExam = 0;
            ec.saveExam = function (saveExamForm) {
                if (saveExamForm.$invalid) {
                    toastr.error("لطفاً عنوان آزمون را وارد کنید.", "خطا");
                    return false;
                }
                ec.savingExam = 1;
                var sendedExamTest = [];
                for (var i in ec.examTest) {
                    sendedExamTest.push({
                        questionIndex: parseInt(i) + 1,
                        questionID: ec.examTest[i].questionID,
                        item1ID: ec.examTest[i].items[0].itemID,
                        item2ID: ec.examTest[i].items[1].itemID,
                        item3ID: ec.examTest[i].items[2].itemID,
                        item4ID: ec.examTest[i].items[3].itemID,
                        answer: ec.examTestAnswers[i].answer
                    });
                }

                console.log(sendedExamTest);
                examinationFactory.saveExam(sendedExamTest, ec.examTitle, ec.filterArray, ec.examSerial + 1)
                        .success(function (data) {
                            ec.savingExam = 0;
                            ec.savedExam = 1;
                            ec.examMD5ID = data;
                            ec.examSerial += 1;
                        })
                        .error(function (data) {
                            toastr.error("ارتباط قطع است. مجدداً تلاش کنید.", "خطا!");
                            ec.savingExam = 0;
                        });
            };

            // get expoert link
            ec.getLink = function (type) {
                if (type == 'word') {
                    return siteUrl + '/Examination/export2Word/' + ec.examMD5ID;
                }
                if (type == 'excel') {
                    return siteUrl + '/Examination/export2Excel/' + ec.examMD5ID;
                }
            };

        };




    }// end of controller function courceCtrl


}());