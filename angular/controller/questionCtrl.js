(function ()
{
    "use strict";
    angular.module("courseQuestion").controller("questionCtrl", ["questionFactory", "$stateParams", "$scope", questionCtrl]);

    function questionCtrl(questionFactory, $stateParams, $scope) {

        var qc = this;

        qc.questionLevel = [{id: 1, title: 'ساده'}, {id: 2, title: 'عادی'}, {id: 3, title: 'سخت'}];

        qc.params = $stateParams;

        questionFactory.getQuestionViewInitial($stateParams.md5courceID, $stateParams.md5sectionID)
                .success(function (data) {
                    qc.sectionInfo = data.sectionInfo;
                    qc.sectionQuestions = data.sectionQuestions;
                    qc.questionItems = data.questionItems;
                    qc.sections = data.sections;
                    qc.tags = [];
                    for (var i in data.tags) {
                        qc.tags.push(data.tags[i].tag);
                    }
                    qc.muzuList = [];
                    for (var i in data.muzuList) {
                        qc.muzuList.push(data.muzuList[i].muzu);
                    }
                })
                .error(function (data) {
                    toastr.error("ارتباط قطع است. مجدداً تلاش کنید.", "خطا!");
                });

        qc.openQuestionModal = function (questionID) {
            qc.newQuestion =
                    {
                        id: 0,
                        questionTitle: '',
                        questionAnswer: '',
                        questionLevel: {id: 0, title: ''},
                        gozineha: [],
                        tags: [],
                        muzu:[],
                        section: {sectionID: qc.sectionInfo[0].sectionID, sectionTitle: qc.sectionInfo[0].sectionTitle}
                    };
            qc.newGozineh = '';
            $('#questionModal').modal('show');
        };

        qc.editQuestion = function (question) {
            var items = qc.getQuestionItems(question.questionID);
            var itemsString = [];
            for (var i in items) {
                itemsString.push(items[i].itemTitle);
            }
            var tags = question.questionTags.split(",");
            qc.newQuestion = {
                id: question.questionID,
                questionTitle: question.questionTitle,
                questionAnswer: question.questionAnswer,
                muzu:[question.muzu],
                questionLevel: {id: question.questionLevelID, title: question.questionLevel},
                gozineha: itemsString,
                tags: tags,
                section: {sectionID: qc.sectionInfo[0].sectionID, sectionTitle: qc.sectionInfo[0].sectionTitle}
            };
            qc.newGozineh = '';
            $('#questionModal').modal('show');
        };

        qc.addNewGozineh = function (newGozinehForm) {
            if (newGozinehForm.$valid) {
                qc.newQuestion.gozineha.push(qc.newGozineh);
                qc.newGozineh = '';
            }
        };

        qc.removeGozine = function (gozine) {
            qc.newQuestion.gozineha.splice(qc.newQuestion.gozineha.indexOf(gozine), 1);
        };


        // save new question
        qc.saveNewQuestion = function (QuestionForm) {
            console.log(qc.newQuestion);
            if (QuestionForm.$valid) {
                if (qc.newQuestion.gozineha.length < 3) {
                    toastr.error("حداقل سه گزینه نادرست تعیین شود.", "خطا!");
                    return false;
                }
                if (qc.newQuestion.section.sectionID <= 0) {
                    toastr.error("لطفاً عنوان بخش را تعیین کنید.", "خطا!");
                    return false;
                }
                qc.newCourceSectionQuestionForm = 1;
                questionFactory.saveQuestion(qc.newQuestion, qc.sectionInfo)
                        .success(function (data) {
                            qc.sectionQuestions = data.sectionQuestions;
                            qc.questionItems = data.questionItems;
                            qc.tags = data.tags;
                            qc.newCourceSectionQuestionForm = 0;
                            $('#questionModal').modal('hide');
                        })
                        .error(function (data) {
                            toastr.error("ارتباط قطع است. مجدداً تلاش کنید.", "خطا!");
                            qc.newCourceSectionQuestionForm = 0;
                        });
            }
        };

        // change question status
        qc.changeQuestionStatus = function (question, newStatus) {
            questionFactory.changeQuestionStatus(question, newStatus).success(function (data) {
                question.status = newStatus;
            }).error(function (data) {
                toastr.error("ارتباط قطع است. مجدداً تلاش کنید.", "خطا!");
            });

        };

        // get question items
        qc.getQuestionItems = function (questionID) {
            var items = [];
            for (var i in qc.questionItems) {
                if (qc.questionItems[i].questionID == questionID) {
                    items.push(qc.questionItems[i]);
                }
            }
            return items;
        };


    }// end of controller function questionCtrl


}());