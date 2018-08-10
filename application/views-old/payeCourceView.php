
<button class="btn btn-success" ng-click="mCtrl.inserNewCource(0)">
    <i class="fa fa-book"></i>
    درس جدید
</button>

  
<hr>
<div>تعداد درس ثبت شده: <span class="badge badge-primary">{{mCtrl.courceList.length}}</span></div>
<div class="table-responsive">
    <table class="table table-bordered">
        <tr>
            <th>عنوان پایه</th>
            <th>عنوان درس</th>
            <th>مشاهده</th>
        </tr>
        <tr  ng-repeat="dars in mCtrl.courceList">
            <td>{{dars.payeName}}</td>
            <td>{{dars.title}}</td>
            <td>
                <a class="btn btn-primary btn-sm" type="button" ui-sref="cource({md5ID:dars.md5CourceID})"><i class="fa fa-eye"></i> مشاهده</a>
            </td>
        </tr>
    </table>

</div>

<!-- MODAL FORM -->
<div id="insertNewCourse" class="modal fade in container">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="text-primary"><i class="fa fa-home"></i>&nbsp; ثبت درس جدید</h2>                
    </div>
    <div class="modal-body">
        <div class="row">
            <form name="newCourseForm">
                <div class="col-sm-6">
                    <i class="fa fa-hand-pointer-o"></i>&nbsp;<label class="control-label">پایه / کلاس</label>
                    <select required ng-model="mCtrl.newCource.selectedPaye" ng-options="paye.payeName for paye in mCtrl.payeList" class="form-control" style="padding: 1px;"></select>
                </div>                    
                <div class="col-sm-6">
                    <i class=""></i>&nbsp;<label class="control-label">عنوان درس</label>
                    <input required type="text" ng-model="mCtrl.newCource.newDars" class="form-control" />                         
                </div>    
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success" ng-click="mCtrl.saveNewCourse(newCourseForm)" ng-disabled="!newCourseForm.$valid">
            <i class="fa fa-save"></i>&nbsp; ذخیره
            <i class="fa fa-spin fa-spinner" ng-show="mCtrl.saveWaiting==1"></i>
        </button>
        <button class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-times-circle-o"></i>&nbsp; انصراف</button>

    </div>

</div><!-- insert new modal form -->