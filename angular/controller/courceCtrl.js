(function()
{
    "use strict";
    angular.module("courseQuestion").controller("courceCtrl",["courceFactory","$stateParams",courceCtrl]);
    
    function courceCtrl(courceFactory,$stateParams){
        
        var cc=this;
        
        cc.md5ID=$stateParams.md5ID;
        courceFactory.getCourceSections(cc.md5ID)
            .success(function(data){
                cc.courceInfo=data.CourceInfo[0];
                cc.courceSections=data.CourceSections;
            })
            .error(function(data){
                alert('ERROR!');
            });
            
        //save new cource
        cc.saveNewCourceSection=function(newSectionForm){
            if(newSectionForm.$valid==true){
                courceFactory.saveNewCourceSection(cc.newCourceSection,cc.courceInfo )
                .success(function(data){
                    cc.courceSections=data.CourceSections;
                    cc.newCourceSection='';
                })
                .error(function(data){
                    alert('ERROR!');
                });
            }
        }
        
    }// end of controller function courceCtrl
    

}());