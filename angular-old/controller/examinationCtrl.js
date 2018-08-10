(function()
{
    "use strict";
    angular.module("courseQuestion").controller("examinationCtrl",["examinationFactory","$stateParams","$scope",examinationCtrl]);
    
    function examinationCtrl(examinationFactory,$stateParams,$scope){
        
        var ec=this;
        ec.questionLevels=['ساده','عادی','سخت'];
        ec.courceTags=[];
        ec.courceSections=[];
        
        ec.selectedTags=[];
        ec.selectedSections=[];
        ec.selectedLevels=[];
        
        $scope.selectedCource=[];
        
        $scope.$watch('selectedCource', function (newValue, oldValue) {
            console.log('tags',ec.questionTags);
            ec.courceTags=[];
            console.log('new',newValue);
            for(var i in ec.questionTags){
                if(ec.questionTags[i].courceID==newValue.courceID){
                    ec.courceTags.push(ec.questionTags[i]);
                }
            }
            
            ec.courceSections=[];
            for(var i in ec.sections){
                if(ec.sections[i].courceID==newValue.courceID){
                    ec.courceSections.push(ec.sections[i]);
                }
            }
            
            ec.selectedTags=[];
            ec.selectedSections=[];
            ec.selectedLevels=[];
            
        });
        
        examinationFactory.getExaminationInitial()
            .success(function(data){
                console.log(data);
                ec.payeCource=data.cource;
                ec.questionTags=data.questionTags;
                ec.sections=data.sections;
            })
            .error(function(data){
                toastr.error("ارتباط قطع است. مجدداً تلاش کنید.","خطا!");
            });
            
        $scope.selectedCource=[];
        ec.questionNum=10;
        ec.creatingExam=0;
        ec.originalExam=[];
        
        ec.createExam=function(){
            if($scope.selectedCource.length<=0){
                toastr.error("لطفاً عنوان درس را انتخاب کنید.","خطا!");
                return false;
            }
            if(ec.questionNum==undefined){
                toastr.error("خطا!","لطفاً تعداد سوال را وارد کنید.");
                return false;
            }
            if(ec.questionNum==null){
                toastr.error("خطا!","لطفاً تعداد سوال را وارد کنید.");
                return false;
            }
            
            ec.creatingExam=1;
            
            examinationFactory.createExam($scope.selectedCource,ec.questionNum,ec.selectedSections,ec.selectedTags,ec.selectedLevels)
                .success(function(data){
                    ec.originalExam=data;
                    ec.generateExamTest();
                    ec.creatingExam=0;
                })
                .error(function(data){
                    toastr.error("ارتباط قطع است. مجدداً تلاش کنید.","خطا!");
                    ec.creatingExam=0;
                });
            
            // generate Exam
            ec.generateExamTest=function(){
                ec.examTest=ec.originalExam.slice();
                ec.examTestAnswers=[];
                ec.levelCount={'sade':0,'adi':0,'sakht':0,'namalum':0};
                for(var i in ec.originalExam){
                    if(ec.originalExam[i].questionLevel=='عادی'){
                        ec.levelCount.adi+=1;
                    }else if(ec.originalExam[i].questionLevel=='ساده'){
                        ec.levelCount.sade+=1;
                    }else if(ec.originalExam[i].questionLevel=='سخت'){
                        ec.levelCount.sakht+=1;
                    }else{
                        ec.levelCount.namalum+=1;
                    }
                    var randNum=Math.floor(Math.random()*4)+1;
                    
                    ec.examTestAnswers[i]={questionID:ec.originalExam[i].questionID,answer:randNum};
                    ec.examTest[i].items.splice(randNum-1,0,{
                        courceID:ec.examTest[i].courceID,
                        itemID:"0",
                        itemTitle:ec.examTest[i].questionAnswer,
                        questionID:ec.examTest[i].questionID,
                        sectionID:ec.examTest[i].sectionID,
                        userID:ec.examTest[i].userID});
                        
                        //??????ERROR
                        //count of levels
                        
                }
               
            };
            
            //get answer class
            ec.getAnswerClass=function(index,test){
                for(var i in ec.examTestAnswers){
                    if(ec.examTestAnswers[i].questionID==test.questionID){
                        if(index==ec.examTestAnswers[i].answer){
                            return "text-success";
                        }
                    }
                }
            };
            
            //get answer icon class
            ec.getAnswerIconClass=function(index,test){
                for(var i in ec.examTestAnswers){
                    if(ec.examTestAnswers[i].questionID==test.questionID){
                        if(index==ec.examTestAnswers[i].answer){
                            return "fa fa-check text-success";
                        }else{
                            return "fa fa-times text-danger";
                        }
                    }
                }
            };
            
            // export to word
            ec.export2Word=function() {
                
                console.log(ec.examTest);
                examinationFactory.export2Word(ec.examTest)
                .success(function(data){
                   
                })
                .error(function(data){
                    toastr.error("ارتباط قطع است. مجدداً تلاش کنید.","خطا!");
                });

            };
            
        };
        
        
        
        
    }// end of controller function courceCtrl
    

}());