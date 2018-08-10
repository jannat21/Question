(function()
{
    "use strict";
    angular.module("courseQuestion").controller("questionCtrl",["questionFactory","$stateParams","$scope",questionCtrl]);
    
    function questionCtrl(questionFactory,$stateParams,$scope){
        
        var qc=this;
        
        qc.questionLevel=['ساده','عادی','سخت'];
        
        qc.params=$stateParams;
        console.log($stateParams);
        
        questionFactory.getQuestionViewInitial($stateParams.md5courceID,$stateParams.md5sectionID)
        .success(function(data){
            qc.sectionInfo=data.sectionInfo;
            qc.sectionQuestions=data.sectionQuestions;
            qc.questionItems=data.questionItems;
            qc.tags=[];
            for(var i in data.tags){
                qc.tags.push(data.tags[i].tag);  
            }
        })
        .error(function(data){
            toastr.error("ارتباط قطع است. مجدداً تلاش کنید.","خطا!");
        });
        
        qc.openQuestionModal=function(questionID){
            qc.newQuestion={id:0,questionTitle:'',questionAnswer:'',questionLevel:'',gozineha:[],tags:[]};
            qc.newGozineh='';
            $('#questionModal').modal('show');
        };
        
        qc.addNewGozineh=function(newGozinehForm){
            if(newGozinehForm.$valid){
                qc.newQuestion.gozineha.push(qc.newGozineh);
                qc.newGozineh='';
            }
        };
        
        qc.removeGozine=function(gozine){
            qc.newQuestion.gozineha.splice(qc.newQuestion.gozineha.indexOf(gozine), 1);
        };
        
        
        // save new question
        qc.saveNewQuestion=function(QuestionForm){
            console.log(qc.newQuestion);
            if(QuestionForm.$valid){
                if(qc.newQuestion.gozineha.length<3){
                    toastr.error("حداقل سه گزینه نادرست تعیین شود.", "خطا!");
                    return false;
                }
                qc.newCourceSectionQuestionForm=1;
                questionFactory.saveQuestion(qc.newQuestion,qc.sectionInfo)
                .success(function(data){
                    qc.sectionQuestions=data.sectionQuestions;
                    qc.questionItems=data.questionItems;
                    qc.tags=data.tags;
                    console.log(qc.tags);
                    qc.newCourceSectionQuestionForm=0;
                    $('#questionModal').modal('hide');
                })
                .error(function(data){
                    toastr.error("ارتباط قطع است. مجدداً تلاش کنید.","خطا!");
                    qc.newCourceSectionQuestionForm=0;
                });
                
            }
        };
        
        
//        qc.md5ID=$stateParams.md5ID;
//        courceFactory.getCourceSections(qc.md5ID)
//            .success(function(data){
//                qc.courceInfo=data.CourceInfo[0];
//                qc.courceSections=data.CourceSections;
//            })
//            .error(function(data){
//                alert('ERROR!');
//            });
//            
//        //save new cource
//        qc.saveNewCourceSection=function(newSectionForm){
//            if(newSectionForm.$valid==true){
//                courceFactory.saveNewCourceSection(qc.newCourceSection,qc.courceInfo )
//                .success(function(data){
//                    qc.courceSections=data.CourceSections;
//                    qc.newCourceSection='';
//                })
//                .error(function(data){
//                    alert('ERROR!');
//                });
//            }
//        }
        
    }// end of controller function courceCtrl
    

}());