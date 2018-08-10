
<!-- 
tags
button toggle show answers
save exam
-->
<style>
    .select-search-list-item {color:black;}
    .select-search-list-item_selection{color:black;}
</style>

<div class="row">
    <div class="col-sm-4 form-group ">
        <label class="control-label">عنوان درس:</label>
        <oi-select 
            oi-options="cource.title+ ' - '+cource.payeName for cource in ec.payeCource" 
            ng-model="selectedCource"
            placeholder="انتخاب درس"
            >
        </oi-select>
    </div>
    <div class="col-sm-4 form-group ">
        <label class="control-label">تعداد سوال:</label>
        <input ng-model="ec.questionNum" type="number" min="1" max="50" class="form-control" placeholder="تعداد سوال" />
    </div>
    <div class="col-sm-4 form-group">
        <label class="control-label">سطح سوالات</label>
        <oi-select 
            oi-options="level for level in ec.questionLevels" 
            ng-model="ec.selectedLevels" 
            multiple 
            >
        </oi-select>
    </div>
    <div class="col-sm-12 form-group">
        <label class="control-label">بخش ها</label>
        <oi-select 
            oi-options="section.sectionTitle for section in ec.courceSections" 
            ng-model="ec.selectedSections"
            placeholder="انتخاب بخش ها (دلخواه)"
            multiple 
            >
        </oi-select>
    </div>
    <div class="col-sm-12 form-group">
        <label class="control-label">کلمات کلیدی</label>
        <oi-select 
            oi-options="tag.tag for tag in ec.courceTags" 
            ng-model="ec.selectedTags"
            placeholder="انتخاب کلمات کلیدی (دلخواه)"
            multiple 
            >
        </oi-select>
    </div>
    
    <div class="col-sm-6">
        <button type="button" class="btn btn-success" ng-click="ec.createExam()">
            <i class="fa fa-paper"></i> ایجاد آزمون
            <i class="fa fa-spin fa-spinner" ng-show="ec.creatingExam==1"></i>
        </button>
    </div>
</div>

<hr/>
<div class="row" ng-show="ec.originalExam.length>0">
    
    <button ng-click="ec.export2Word()" class="btn btn-primary">
        <i class="fa fa-file-word-o"></i>
        ارسال به Word
    </button>
    
    
    <div class="col-xs-12">
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>سخت</td>
                    <td>{{ec.levelCount.sakht}}</td>
                    <td>عادی</td>
                    <td>{{ec.levelCount.adi}}</td>
                </tr>
                <tr>
                    <td>ساده</td>
                    <td>{{ec.levelCount.sade}}</td>
                    <td>نامعلوم</td>
                    <td>{{ec.levelCount.namalum}}</td>
                </tr>
            </thead>
        </table>
        
        <div class="panel panel-default" ng-repeat="test in ec.examTest">
            <div class="panel-heading"> {{$index+1}}-{{test.questionTitle}}</div>
            <div class="panel-body">
                <div 
                    ng-repeat="item in test.items" 
                    ng-class="ec.getAnswerClass($index+1,test)" 
                    class="list-group-item-text" 
                    style="margin-right:20px; padding:7px;">
                    <i ng-class="ec.getAnswerIconClass($index+1,test)"></i>
                    گزینه {{$index+1}}-{{item.itemTitle}}
                </div>
            </div>
        </div>
    </div>
</div>

<button ng-click="ec.export2Word('docx')">Export</button>
<div id="docx">
  <div class="WordSection1">
    dsad
     <!-- The html you want to export goes here -->

  </div>
</div>
