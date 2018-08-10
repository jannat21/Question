
<div class="list-group">
    <div ng-repeat="exam in elc.examList" class="list-group-item">
        {{$index + 1}}-{{exam.title}}
        <div class="pull-left">
            <div class="btn-group btn-group-xs">
                <a ui-sref="checkExamination({md5ID:exam.md5ID})" class="btn btn-info" data-tooltip="تصحیح پاسخنامه"><i class="fa fa-camera"></i> </a>
                <!--<button type="button" class="btn btn-primary">x</button>
                                <button type="button" class="btn btn-primary">y</button>-->
            </div>

            <small>
                <span class="text-muted"><i class="fa fa-calendar-o "></i>&nbsp; {{exam.pdate}}</span>
                <span class="text-muted"><i class="fa fa-clock-o"></i>&nbsp; {{exam.clock}}</span>
            </small>
        </div>
    </div>
</div>

