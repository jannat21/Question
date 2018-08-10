(function ()
{
    "use strict";
    angular.module("courseQuestion").controller("studentExaminationCtrl", ["studentEexaminationFactory", "$stateParams", "$scope", studentExaminationCtrl]);

    function studentExaminationCtrl(studentEexaminationFactory, $stateParams, $scope) {

        var sec = this;
        sec.questionLevels = ['ساده', 'عادی', 'سخت'];
        sec.courceTags = [];
        sec.courceSections = [];

        sec.selectedTags = [];
        sec.selectedSections = [];
        sec.selectedLevels = [];

        $scope.selectedCource = [];

        $scope.$watch('selectedCource', function (newValue, oldValue) {
            sec.courceTags = [];
            for (var i in sec.questionTags) {
                if (sec.questionTags[i].courceID == newValue.courceID) {
                    sec.courceTags.push(sec.questionTags[i]);
                }
            }

            sec.courceSections = [];
            for (var i in sec.sections) {
                if (sec.sections[i].courceID == newValue.courceID) {
                    sec.courceSections.push(sec.sections[i]);
                }
            }

            sec.selectedTags = [];
            sec.selectedSections = [];
            sec.selectedLevels = [];

        });

        studentEexaminationFactory.getExaminationInitial()
                .success(function (data) {
                    sec.payeCource = data.cource;
                    sec.questionTags = data.questionTags;
                    sec.sections = data.sections;
                })
                .error(function (data) {
                    toastr.error("ارتباط قطع است. مجدداً تلاش کنید.", "خطا!");
                });

        $scope.selectedCource = [];
        sec.questionNum = 10;
        sec.creatingExam = 0;
        sec.originalExam = [];
        sec.selectedItemList = [];

        sec.createExam = function () {
            if ($scope.selectedCource.length <= 0) {
                toastr.error("لطفاً عنوان درس را انتخاب کنید.", "خطا!");
                return false;
            }
            if (sec.questionNum == undefined) {
                toastr.error("خطا!", "لطفاً تعداد سوال را وارد کنید.");
                return false;
            }
            if (sec.questionNum == null) {
                toastr.error("خطا!", "لطفاً تعداد سوال را وارد کنید.");
                return false;
            }

            sec.creatingExam = 1;

            studentEexaminationFactory.createExam($scope.selectedCource, sec.questionNum, sec.selectedSections, sec.selectedTags, sec.selectedLevels)
                    .success(function (data) {
                        sec.originalExam = data;
                        sec.generateExamTest();
                        sec.creatingExam = 0;
                        sec.disableCheckSaveBut=0;
                        sec.showTestReslt=0;
                    })
                    .error(function (data) {
                        toastr.error("ارتباط قطع است. مجدداً تلاش کنید.", "خطا!");
                        sec.creatingExam = 0;
                    });

            // generate Exam
            sec.generateExamTest = function () {
                sec.examTest = sec.originalExam.slice();
                sec.examTestAnswers = [];
                sec.levelCount = {'sade': 0, 'adi': 0, 'sakht': 0, 'namalum': 0};
                for (var i in sec.originalExam) {
                    if (sec.originalExam[i].questionLevel == 'عادی') {
                        sec.levelCount.adi += 1;
                    } else if (sec.originalExam[i].questionLevel == 'ساده') {
                        sec.levelCount.sade += 1;
                    } else if (sec.originalExam[i].questionLevel == 'سخت') {
                        sec.levelCount.sakht += 1;
                    } else {
                        sec.levelCount.namalum += 1;
                    }
                    var randNum = Math.floor(Math.random() * 4) + 1;

                    sec.examTestAnswers[i] = {questionID: sec.originalExam[i].questionID, answer: randNum};
                    sec.examTest[i].items.splice(randNum - 1, 0, {
                        courceID: sec.examTest[i].courceID,
                        itemID: "0",
                        itemTitle: sec.examTest[i].questionAnswer,
                        questionID: sec.examTest[i].questionID,
                        sectionID: sec.examTest[i].sectionID,
                        userID: sec.examTest[i].userID
                    });

                    //selected item list
                    sec.selectedItemList[i] = {questionID: sec.originalExam[i].questionID, selectedItem: -1};


                    //??????ERROR
                    //count of levels

                }

            };

            sec.selectItem = function (test, index) {
                for (var i in sec.selectedItemList) {
                    if (sec.selectedItemList[i].questionID == test.questionID) {
                        sec.selectedItemList[i].selectedItem = index;
                    }
                }
            };

            sec.getSelectedItemClass = function (test, index) {
                for (var i in sec.selectedItemList) {
                    if (sec.selectedItemList[i].questionID == test.questionID) {
                        if (index == sec.selectedItemList[i].selectedItem) {
                            return "selectedItem";
                        }
                    }
                }
            };

            // save and check answers
            sec.disableCheckSaveBut=0;
            sec.checkSaveTest = function () {
                sec.disableCheckSaveBut=1;
                sec.sendedExamTest=[];
                for(var i in sec.examTest){
                    sec.sendedExamTest[i]={questionID:sec.examTest[i].questionID,item1:0,item2:0,item3:0,item4:0,answerItem:0,checkedItem:0};
                    var item1=sec.examTest[i].items[0].itemID;
                    var item2=sec.examTest[i].items[1].itemID;
                    var item3=sec.examTest[i].items[2].itemID;
                    var item4=sec.examTest[i].items[3].itemID;
                    sec.sendedExamTest[i].item1=item1;
                    sec.sendedExamTest[i].item2=item2;
                    sec.sendedExamTest[i].item3=item3;
                    sec.sendedExamTest[i].item4=item4;
                    if (sec.selectedItemList[i].questionID == sec.examTest[i].questionID) {
                        sec.sendedExamTest[i].checkedItem=sec.selectedItemList[i].selectedItem;
                    }
                    if (sec.examTestAnswers[i].questionID == sec.examTest[i].questionID) {
                        sec.sendedExamTest[i].answerItem= sec.examTestAnswers[i].answer;
                    }
                }
                studentEexaminationFactory.checkSaveTest(sec.sendedExamTest)
                    .success(function (data) {
                        if(data=='success'){
                            sec.showTestReslt=1;
                        }else{
                            toastr.error("ارتباط قطع است. مجدداً تلاش کنید.", "خطا!");
                            sec.disableCheckSaveBut=0;
                        }
                    })
                    .error(function (data) {
                        toastr.error("ارتباط قطع است. مجدداً تلاش کنید.", "خطا!");
                        sec.disableCheckSaveBut=0;
                    });
                //studentEexaminationFactory.
                
            };

            // get selected item icon
            sec.getSelectedItemIcon = function (test, index) {
                for (var i in sec.selectedItemList) {
                    if (sec.selectedItemList[i].questionID == test.questionID) {
                        if (index == sec.selectedItemList[i].selectedItem) {
                            return "fa fa-check text-success";
                        } else {
                            return "fa fa-square-o";
                        }
                    }
                }
            };


            //get answer class
            sec.getAnswerClass = function (index, test) {
                for (var i in sec.examTestAnswers) {
                    if (sec.examTestAnswers[i].questionID == test.questionID) {
                        if (index == sec.examTestAnswers[i].answer) {
                            return "text-success";
                        }
                    }
                }
            };

            //get answer icon class
            sec.getAnswerIconClass = function (index, test) {
                for (var i in sec.examTestAnswers) {
                    if (sec.examTestAnswers[i].questionID == test.questionID) {
                        if (index == sec.examTestAnswers[i].answer) {
                            return "fa fa-check text-success";
                        } else {
                            return "fa fa-times text-danger";
                        }
                    }
                }
            };
            
            // ddefine question panel class
            sec.questionPanelClass=function(test,index){
                if(sec.showTestReslt==1){
                    if(sec.selectedItemList[index].selectedItem==-1){
                        return "panel panel-warning";
                    }
                    if(sec.selectedItemList[index].selectedItem==sec.examTestAnswers[index].answer){
                        return "panel panel-success";
                    }
                    if(sec.selectedItemList[index].selectedItem!=sec.examTestAnswers[index].answer){
                        return "panel panel-danger";
                    }
                }else{
                    return "panel panel-default";
                }
            };
            

        };




    }// end of controller function courceCtrl


}());