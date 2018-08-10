
<div class="row">
    <div class="col-sm-12">
        <div class="well well-sm">
            <form name="schoolForm" class="form-inline">
                <input ng-model="sc.newSchoolName" type="text" required="" class="form-control" placeholder="نام مدرسه جدید" />
                <button ng-click="sc.addNewSchool(schoolForm)" type="button" class="btn btn-success" ng-disabled="schoolForm.$invalid == true">
                    <i class="fa fa-plus-square-o"></i>&nbsp; افزودن مدرسه جدید
                    <i class="fa fa-spin fa-spinner" ng-show="sc.waitingSchoolSave == 1"></i>
                </button>
            </form>
        </div>
    </div>
    <div class="clearfix"></div>
    <hr>

    <div class="col-sm-6"ng-repeat="school in sc.school">
        <div class="panel panel-default" >
            <div class="panel-heading">
                {{$index + 1}}-{{school.title}}
                <span class="badge badge-primary">{{classList.length}}</span>
            </div>
            <div class="panel-body">
                <h4 class="text-primary">لیست کلاس ها</h4>
                <div ng-show="classList.length <= 0" class="alert alert-info">
                    هیچ کلاسی ثبت نشده است.
                </div>
                <div 
                    ng-repeat="sc_class in (classList = sc.getClassList(school.id))" 
                    class="list-group-item" >
                    {{sc_class.title}}
                    <button ng-click="sc.getStudentList(sc_class)" class="btn btn-primary btn-xs pull-left" data-tooltip="لیست دانش آموزان کلاس">
                        <i class="fa fa-users"></i>
                    </button>
                    <a ng-href="{{sc.getClassExportExcelLink(sc_class)}}" target="_blank" class="btn btn-info btn-xs pull-left" data-tooltip="لیست کلاس به اکسل" style="margin-left: 3px;">
                        <i class="fa fa-file-excel-o"></i>
                    </a>
                </div>
            </div>
            <div class="panel-footer">
                <form name="newClassForm" class="form-inline">
                    <input ng-model="sc.newClassName[school.id]" type="text" required="" class="form-control input-sm" placeholder="نام کلاس جدید" />
                    <button ng-click="sc.addNewClass(school, newClassForm)" type="button" class="btn btn-success btn-sm" ng-disabled="newClassForm.$invalid == true">
                        <i class="fa fa-plus-square-o"></i>&nbsp; افزودن کلاس جدید
                        <i class="fa fa-spin fa-spinner" ng-show="sc.waitingClassSave[school.id] == 1"></i>
                    </button>
                </form>
            </div>
        </div>

    </div>


</div>

<!-- MODAL FORMS ------------------------------------------------------>
<!--------------------------------------------------------------------->
<div id="studentModal" class="modal fade in container">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="text-primary"><i class="fa "></i>&nbsp; لیست دانش آموزان <small></small></h2>
        <button ng-click="sc.newStudentModal()" class="btn btn-success pull-left">
            <i class="fa fa-plus-square-o"></i>&nbsp; دانش آموز جدید
        </button>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-sm-12">

                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    <input type="text" ng-model="sc.searchClass.$" class="form-control" placeholder="جستجو"/>
                </div>
                <hr>

                <i ng-show="sc.waitingShowClassStudent == 1" class="fa fa-spin fa-spinner text-warning"></i>
                <div class="text-danger" ng-show="sc.classStudentList.length == 0">دانش آموزی ثبت نشده است.</div>

                <div ng-repeat="student in sc.classStudentList | filter:sc.searchClass" class="col-md-4 col-sm-6 col-xs-12">
                    <div class="list-group-item list-group-item-text">
                        <div class="pull-left fa fa-edit fa-2x" style="cursor: pointer;" ></div>
                        <p><label>کد دانش آموزی:</label>&nbsp; {{student.studentCode}}</p>
                        <p><label>نام:</label>&nbsp; {{student.studentName}}</p>
                        <p><label>نام خانوادگی:</label>&nbsp; {{student.studentFamily}}</p>                        
                    </div>

                </div>

            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-times-circle-o"></i>&nbsp; انصراف</button>
    </div>

</div><!-- student modal form -->ّ

<!-- new student -->
<div id="newStudentModal" class="modal fade in">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="text-primary"><i class="fa "></i>&nbsp; دانش آموز جدید <small></small></h2>        
    </div>
    <div class="modal-body">
        <div class="row">

            <form name="insertNewStudentForm" class="form- well well-sm">

                <input type="text" placeholder="کد دانش آموز"   required  ng-model="sc.newStudent.code" class="form-control"  />
                <input type="text" placeholder="نام دانش آموز" required ng-model="sc.newStudent.name" class="form-control" />
                <input type="text" placeholder="نام خانوادگی دانش آموز" required ng-model="sc.newStudent.family" class="form-control" />

                <br>
                <button ng-click="sc.saveNewStudent(insertNewStudentForm)" class="btn btn-success"
                        ng-disabled="insertNewStudentForm.$invalid == true">
                    <i class="fa fa-plus"></i> افزودن دانش آموز جدید
                    <i class="fa fa-spin fa-spinner" ng-show="sc.newStudentForm == 1"></i>
                </button>
            </form>

        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-times-circle-o"></i>&nbsp; انصراف</button>
    </div>

</div><!-- student modal form -->