
<div class="row" ng-repeat="cource in shc.courceList">
    <div class="col-sm-12 thumbnail">
        <div >
            <h1 class="text-muted">{{cource.title}} {{cource.payeName}}</h1>
            <div class="col-sm-4">
                <table class="table table-striped">
                    <tr><th>تعداد آزمون</th><th>میانگین نمرات</th><th>پائین ترین نمره</th><th>بالاترین نمره</th></tr>
                    <tr><th>{{cource.examList.length}}</th><th>{{cource.avgScore|number:2}}</th><th>{{cource.minScore}}</th><th>{{cource.maxScore}}</th></tr>
                </table>
            </div>
            <div class="col-sm-8">
                <canvas id="cource_{{cource.courceID}}" ng-click="shc.chartCourceClick(cource.courceID)"></canvas>            
            </div>
            <div class="col-sm-6" style="direction: ltr;">
                <canvas id="muzuChart_{{cource.courceID}}"></canvas>
            </div>
            <div class="col-sm-6">
                <canvas id="muzuPercentChart"></canvas>
            </div>
        </div>
    </div>
</div>


<!-- MODAL FORMS ------------------------------------------------------>
<!--------------------------------------------------------------------->
<div id="examResultModal" class="modal fade in container">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="text-primary"><i class="fa fa-question-circle-o"></i>&nbsp; </h2>                
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <img ng-src="{{shc.examResultImage}}" />
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-times-circle-o"></i>&nbsp; انصراف</button>ّ
    </div>

</div><!-- view exam image -->

