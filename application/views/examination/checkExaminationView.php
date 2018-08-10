<div class="">
    <div class="row">
        <audio id="audio" src="<?php echo base_url(); ?>assets/beep-07.wav" autostart="false" ></audio>

        <div class="row">
            <div class="col-sm-12" ng-show="cec.answerSheet !== false">
                <div class="col-sm-6">
                    <i class="fa fa-spin fa-spinner text-warning" ng-show="cec.schoolList === false"></i>
                    <oi-select 
                        oi-options="schoolClass.school +' - '+schoolClass.title for schoolClass in cec.schoolList" 
                        ng-model="selectedSchool"
                        placeholder="انتخاب دبیرستان - کلاس"
                        >
                    </oi-select>
                </div>

                <div class="col-sm-6">
                    <i class="fa fa-spin fa-spinner text-warning" ng-show="cec.schoolList === false"></i>
                    <oi-select 
                        oi-options="student.studentCode +' - '+student.studentName+' - '+student.studentFamily for student in cec.studentList" 
                        ng-model="selectedStudent"
                        placeholder="مشخصات دانش آموز"
                        >
                    </oi-select>
                </div>    
            </div>    
        </div>
        <br>
        <div class="row">

            <div class="col-sm-6">
                <button ng-click="capture21()" class="btn btn-primary btn-block"><i class="fa fa-camera"></i>&nbsp; اسکن پاسخنامه</button>
            </div>
            <div class="col-sm-6">
                <div class="well well-lg">
                    <div class="col-sm-4"><strong>تعداد سوالات:</strong>&nbsp;<strong>{{cec.questionCount}}</strong></div>
                    <div class="col-sm-3"><strong> صحیح:</strong>&nbsp;<strong>{{cec.correctQuestionCount}}</strong></div>
                    <div class="col-sm-3"><strong> غلط:</strong>&nbsp;<strong>{{cec.inCorrectQuestionCount}}</strong></div>
                    <div class="col-sm-2"><strong>نمره:</strong>&nbsp;<strong>{{cec.examMark|number:2}}</strong></div>                    
                </div>
            </div>
            <div class="col-sm-6">
                <button ng-click="refreshCamere()" class="btn btn-default btn-block"><i class="fa fa-refresh"></i></button>
            </div>
            <div class="col-sm-6">
                <button ng-click="cec.saveInfo()" class="btn btn-success btn-block">
                    <i class="fa fa-save"></i>&nbsp; ذخیره اطلاعات آزمون
                    <i class="fa fa-spin fa-spinner" ng-show="cec.saveingInfo == true"></i>
                </button>
            </div>

        </div>
        <br>
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-6 canvasFrame21">
                    <webcam channel="channel" on-streaming="onSuccess()" on-error="onError(err)" on-stream="onStream(stream)"></webcam>
                </div>
                <div class="col-sm-6">
                    <div class="col-xs-6 text-center">
                        <table class="" style="border-collapse:separate;  border-spacing: 10px 0px ;">
                            <tr ng-repeat="quest in cec.answerSheetTemp.column1" style="border: 1px solid #EEE;">
                                <td>{{quest.questionIndex}}</td>
                                <td ng-repeat="itemX in quest.items">
                                    <div class="itemMarker" ng-class="cec.getItemTempClass(quest.isCorrect, itemX)" style="border:1px solid #ffb6c1; height: 14px; width: 24px; border-radius: 30%;"></div>
                                </td>
                                <td>
                                    <i class="fa fa-times text-danger" ng-show="quest.isCorrect == -1"></i>
                                    <i class="fa fa-check text-success" ng-show="quest.isCorrect == 1"></i>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-6 text-center">
                        <table class="" style="border-collapse:separate;  border-spacing: 10px 0px;">
                            <tr ng-repeat="quest in cec.answerSheetTemp.column2">
                                <td>{{quest.questionIndex}}</td>
                                <td ng-repeat="itemX in quest.items">
                                    <div class="itemMarker" ng-class="cec.getItemTempClass(quest.isCorrect, itemX)" style="border:1px solid #ffb6c1; height: 14px; width: 24px; border-radius: 30%;"></div>
                                </td>
                                <td>
                                    <i class="fa fa-times text-danger" ng-show="quest.isCorrect == -1"></i>
                                    <i class="fa fa-check text-success" ng-show="quest.isCorrect == 1"></i>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <!--??????-->
        <div class="col-sm-6" ng-show="0">
            <div class="canvasFrame21" ><canvas id="snapshot" ></canvas></div>
        </div>

    </div><!-- row -->
</div><!-- container -->
<br>

<style>
    .rect{
        width: 80px;
        height: 80px;
        position: absolute;
        left: -1000px;
        top:-1000px;        
    }
</style>

<script>


//    function clear() {
//        document.querySelector('.canvasFrame').removeChild();
//    }

</script>


