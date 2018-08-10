<!-- 
disable save button
level of question
-->
<style>
    .select-search-list-item {color:black;}
    .select-search-list-item_selection{color:black;}
    .selectedItem{font-weight: bolder;}
</style>

<div class="row">
    <div class="col-sm-4 form-group ">
        <label class="control-label">عنوان درس:</label>
        <oi-select 
            oi-options="cource.title+ ' - '+cource.payeName for cource in sec.payeCource" 
            ng-model="selectedCource"
            placeholder="انتخاب درس"
            >
        </oi-select>
    </div>
    <div class="col-sm-4 form-group ">
        <label class="control-label">تعداد سوال:</label>
        <input ng-model="sec.questionNum" type="number" min="1" max="50" class="form-control" placeholder="تعداد سوال" />
    </div>
    <div class="col-sm-4 form-group">
        <label class="control-label">سطح سوالات</label>
        <oi-select 
            oi-options="level for level in sec.questionLevels" 
            ng-model="sec.selectedLevels" 
            multiple 
            >
        </oi-select>
    </div>
    <div class="col-sm-12 form-group">
        <label class="control-label">بخش ها</label>
        <oi-select 
            oi-options="section.sectionTitle for section in sec.courceSections" 
            ng-model="sec.selectedSections"
            placeholder="انتخاب بخش ها (دلخواه)"
            multiple 
            >
        </oi-select>
    </div>
    <div class="col-sm-12 form-group">
        <label class="control-label">کلمات کلیدی</label>
        <oi-select 
            oi-options="tag.tag for tag in sec.courceTags" 
            ng-model="sec.selectedTags"
            placeholder="انتخاب کلمات کلیدی (دلخواه)"
            multiple 
            >
        </oi-select>
    </div>

    <div class="col-sm-6">
        <button type="button" class="btn btn-success" ng-click="sec.createExam()">
            <i class="fa fa-paper"></i> ایجاد آزمون
            <i class="fa fa-spin fa-spinner" ng-show="sec.creatingExam == 1"></i>
        </button>
    </div>
</div>

<hr/>
<div class="row" ng-show="sec.originalExam.length > 0">
    <div class="col-xs-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>سخت</td>
                    <td>{{sec.levelCount.sakht}}</td>
                    <td>عادی</td>
                    <td>{{sec.levelCount.adi}}</td>
                </tr>
                <tr>
                    <td>ساده</td>
                    <td>{{sec.levelCount.sade}}</td>
                    <td>نامعلوم</td>
                    <td>{{sec.levelCount.namalum}}</td>
                </tr>
            </thead>
        </table>

        <div ng-class="sec.questionPanelClass(test,$index)" ng-repeat="test in sec.examTest">
            <div class="panel-heading"> {{$index + 1}}-{{test.questionTitle}}</div>
            <div class="panel-body">
                <div ng-repeat="item in test.items" class="list-group-item-text" style="margin-right:20px; padding:7px;">
                    <div ng-click="sec.selectItem(test,$index+1)" ng-class="sec.getSelectedItemClass(test,$index+1)" style="cursor: pointer;">
                        <i ng-class="sec.getSelectedItemIcon(test,$index+1)"></i>
                        گزینه {{$index + 1}}-{{item.itemTitle}}
                    </div>
                </div>
            </div>
            <div class="panel-footer"></div>
        </div><!-- END OF TEST PANEL -->
        <div class="col-sm-12">
            <button type="button" class="btn btn-success btn-lg" ng-click="sec.checkSaveTest()" ng-disabled="sec.disableCheckSaveBut">
                <i class="fa fa-save"></i> &nbsp; بررسی و ذخیره آزمون
            </button>
        </div>
    </div>
</div>

