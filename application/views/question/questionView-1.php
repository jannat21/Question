
<!--
Add tags to tag list
add search for questions
add edit for questions
DD IOSELECT FOR GOZINEH

-->

<style>
    .select-search-list-item {color:black;}
    .select-search-list-item_selection{color:black;}
</style>


<button type="button" class="btn btn-success" ng-click="qc.openQuestionModal(0)"><i class="fa fa-plus"></i> سوال جدید</button>

<div class="row">
    <div class="col-xs-12">
        <h2>{{qc.sectionInfo[0].courceTitle}} <small>{{qc.sectionInfo[0].payeTitle}}</small></h2>
    </div>
    <div class="col-xs-12">
        <h3>{{qc.sectionInfo[0].sectionTitle}} <small class="badge">{{qc.sectionQuestions.length}}</small></h2>
    </div>
    <hr><br>
    <div class="clearfix"></div>
    <hr><br>
    
    <div class="col-sm-12">
        <div class="alert alert-warning" ng-show="qc.sectionQuestions.length == 0">سوالی وجود ندارد.</div>    
    </div>
    
    <div class="col-sm-12">
        <div class="" ng-show="qc.sectionQuestions.length > 0">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input class="form-control" ng-model="qc.search.$" />
            </div>            
        </div>
    </div>

    <div class="col-xs-12 thumbnail" ng-repeat="question in qc.sectionQuestions|filter:qc.search">
        <h3><div class="label label-primary">سوال &nbsp; {{$index+1}}</div></h3>
        <table class="table table-striped">
            <tr>
                <td><i class="fa fa-question-circle-o"></i></td>
                <td><label class="control-label">عنوان سوال: </label></td>
                <td>{{question.questionTitle}}</td>
            </tr>
            <tr>
                <td><i class="fa fa-check text-success"></i></td>
                <td><label class="control-label">جواب صحیح : </label></td>
                <td>{{question.questionAnswer}}</td>
            </tr>
            <tr>
                <td><i class="fa fa-key"></i></td>
                <td><label class="control-label"> کلمات کلیدی: </label></td>
                <td>{{question.questionTags}}</td>
            </tr>
            <tr>
                <td><i class="fa fa-sort-amount-asc"></i></td>
                <td><label class="control-label">سطح : </label></td>
                <td>{{question.questionLevel}}</td>
            </tr>
            <tr>
                <td><i class="fa fa-list-ol"></i></td>
                <td><label class="control-label">گزینه ها : </label></td>
                <td>{{question.questionTitle}}</td>
            </tr>
        </table>
    </div>

</div>

<!-- MODAL FORMS ------------------------------------------------------>
<!--------------------------------------------------------------------->
<div id="questionModal" class="modal fade in container">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="text-primary"><i class="fa fa-home"></i>&nbsp; ثبت درس جدید</h2>                
    </div>
    <div class="modal-body">
        <div class="row">

            <form name="insertNewCourceSectionQuestionForm" class="form- well well-sm">
                <input type="text" placeholder="عنوان سوال جدید"   required  ng-model="qc.newQuestion.questionTitle" class="form-control"  />
                <input type="text" placeholder="جواب صحیح سوال جدید" required ng-model="qc.newQuestion.questionAnswer" class="form-control" />
                <label class="control-label">سطح سوال</label>
                <select ng-model="qc.newQuestion.questionLevel" ng-options="title for title in qc.questionLevel" class="form-control" style="padding: 1px;" placeholder=""></select>

                <div class="form-group">
                    <label class="control-label">کلمات کلیدی</label>
                    <oi-select 
                        oi-options="tag for tag in qc.tags" 
                        ng-model="qc.newQuestion.tags" 
                        multiple 
                        oi-select-options="{newItem: true,newItem: true, saveTrigger: 'enter blur space . , ;'}">
                    </oi-select>
                </div>

                <div class="col-xs-12">
                    <label class="control-label">لیست گزینه ها نادرست<span class="badge">{{qc.newQuestion.gozineha.length}}</span></label>
                    <label class="text-warning">حداقل سه گزینه نادرست اضافه شود.</label>
                </div>
                <div class="form-group">
                    <label class="control-label">گزینه ها</label>
                    <oi-select ng-model="qc.newQuestion.gozineha" multiple oi-select-options="{newItem: true}"></oi-select>
                </div>
                <table class="table">
                    <tr ng-repeat="gozine in qc.newQuestion.gozineha">
                        <td>{{$index + 1}}</td>
                        <td>{{gozine}}</td>
                        <td><i class="fa fa-remove text-danger" ng-click="qc.removeGozine(gozine)" style="cursor:pointer;"></i></td>
                    </tr>
                </table>

                <button 
                    class="btn btn-success" 
                    ng-click="qc.saveNewQuestion(insertNewCourceSectionQuestionForm)" 
                    ng-disabled="insertNewCourceSectionQuestionForm.$invalid == true">
                    <i class="fa fa-plus"></i> افزودن سوال جدید
                    <i class="fa fa-spin fa-spinner" ng-show="qc.newCourceSectionQuestionForm == 1"></i>
                </button>
            </form>
            <form name="newGozinehForm">
                <div class="col-xs-12"><label class="control-label">افزودن گزینه ها نادرست<span class="badge"></span></label></div>
                <div class="col-xs-11">
                    <input type="text" required ng-model="qc.newGozineh" required class="form-control"  placeholder="گزینه جدید" />
                </div>
                <div class="col-xs-1">
                    <button type="button" class="btn btn-success" ng-disabled="newGozinehForm.$invalid" ng-click="qc.addNewGozineh(newGozinehForm)" >
                        <i class="fa fa-plus-circle"></i>
                    </button>        
                </div>    
            </form>

        </div>
    </div>
    <div class="modal-footer">
        <!--<button class="btn btn-success" ng-click="mCtrl.saveNewCourse(newCourseForm)" ng-disabled="!newCourseForm.$valid">
            <i class="fa fa-save"></i>&nbsp; ذخیره
            <i class="fa fa-spin fa-spinner" ng-show="mCtrl.saveWaiting==1"></i>
        </button>
        <button class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-times-circle-o"></i>&nbsp; انصراف</button>
        -->
    </div>

</div><!-- insert new question modal form -->