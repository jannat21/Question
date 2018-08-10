<h1>{{cc.courceInfo.title}}-{{cc.courceInfo.payeName}}</h1>


<form name="insertNewCourceSectionForm" class="form-inline well well-sm">
    <input type="text" placeholder="عنوان بخش جدید"   required  ng-model="cc.newCourceSection" class="form-control"  />      
    <button 
        class="btn btn-success" 
        ng-click="cc.saveNewCourceSection(insertNewCourceSectionForm)" 
        ng-disabled="insertNewCourceSectionForm.$invalid == true">
        <i class="fa fa-plus"></i> افزودن بخش جدید
        <i class="fa fa-spin fa-spinner" ng-show="cc.newCourceSectionSaving == 1"></i>
    </button>
</form>
<hr>

<div class="alert alert-warning" ng-show="cc.courceSections.length == 0">
    هیچ بخشی تعریف نشده است.
</div>

<div class="col-sm-12" ng-show="cc.courceSections.length > 0">
    <div>
        <label> بخش های تعریف شده: </label>
        <span class="badge">{{cc.courceSections.length}}</span></div>
    <div 
        ui-sref="question({md5courceID:section.md5courceID,md5sectionID:section.md5sectionID})" 
        ng-repeat="section in cc.courceSections" 
        class="list-group-item col-sm-6" style="cursor: pointer;">
        {{$index + 1}}-&nbsp;{{section.sectionTitle}}
        <span class="badge">{{section.count_question}}</span>
    </div>
</div>
