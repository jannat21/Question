
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
            oi-options="level.title for level in ec.questionLevels" 
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
            <i class="fa fa-spin fa-spinner" ng-show="ec.creatingExam == 1"></i>
        </button>
    </div>
</div>

<hr/>
<div class="row alert alert-warning" ng-show="ec.originalExam.length + ec.clickCreateBut == 1">
    آزمونی منطبق با شرایط گفته شده یافت نشد.</div>
<div class="row" ng-show="ec.originalExam.length > 0">

    <div class="row">
        <div class="col-sm-12 well well-sm">
            <form name="saveExamForm">
                <div class="col-sm-6">
                    <input required type="text" ng-model="ec.examTitle" class="form-control" placeholder="عنوان آزمون" />
                </div>
                <div class="col-sm-6">
                    <label ng-show="ec.examSerial > 0" class="control-label">شماره سری: {{ec.examSerial}}</label>
                    <button ng-click="ec.saveExam(saveExamForm)" class="btn btn-success" ng-disabled="ec.savingExam + ec.savedExam > 0">
                        <i class="fa fa-save"></i>
                        ذخیره آزمون
                        <i class="fa fa-spin fa-spinner" ng-show="ec.savingExam == 1"></i>
                    </button>
                    <button ng-click="ec.reGenerateExamTest()" data-tooltip="بازچینش گزینه ها" type="button" class="btn btn-primary">
                        <i class="fa fa-refresh"></i>
                    </button>
                    <a data-tooltip="ارسال به Word" ng-href="{{ec.getLink('word')}}" target="_blank" class="btn btn-primary" ng-show="ec.savedExam > 0">
                        <i class="fa fa-file-word-o"></i>
                    </a>
                    <a data-tooltip="دریافت پاسخنامه" ng-href="{{ec.getLink('excel')}}" target="_blank" class="btn btn-info" ng-show="ec.savedExam > 0">
                        <i class="fa fa-file-excel-o"></i>
                    </a>
                </div>

            </form>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">

        </div>
    </div>

    <div class="col-xs-12">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <td class="danger">سخت</td>
                    <td class="danger text-center">{{ec.levelCount.sakht}}</td>
                    <td class="warning">عادی</td>
                    <td class="warning text-center">{{ec.levelCount.adi}}</td>
                </tr>
                <tr>
                    <td class="success">ساده</td>
                    <td class="success text-center">{{ec.levelCount.sade}}</td>
                    <td class="info">نامعلوم</td>
                    <td class="info text-center">{{ec.levelCount.namalum}}</td>
                </tr>
            </thead>
        </table>

        <div class="panel panel-default" ng-repeat="test in ec.examTest">
            <div class="panel-heading"> {{$index + 1}}-{{test.questionTitle}}</div>
            <div class="panel-body">
                <div 
                    ng-repeat="item in test.items" 
                    ng-class="ec.getAnswerClass($index + 1, test)" 
                    class="list-group-item-text" 
                    style="margin-right:20px; padding:7px;">
                    <i ng-class="ec.getAnswerIconClass($index + 1, test)"></i>
                    گزینه {{$index + 1}}-{{item.itemTitle}}
                </div>
            </div>
        </div>
    </div>
</div>

