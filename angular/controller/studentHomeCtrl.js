(function ()
{
    "use strict";
    angular.module("courseQuestion").controller("studentHomeCtrl", ["studentHomeFactory", "$stateParams", "$scope", "$timeout", studentHomeCtrl]);

    function studentHomeCtrl(studentHomeFactory, $stateParams, $scope, $timeout) {

        var shc = this;

        studentHomeFactory.getHomeInitial()
                .success(function (data) {
                    console.log(data);
                    shc.examList = data.examResuls;
                    shc.getCourceList();
                    shc.countQuestionLevel = data.countQuestionLevel;
                    shc.countQuestionMuzu = data.countQuestionMuzu;
                    shc.getExamMuzuChart();
                })
                .error(function (e) {
                    toastr.error("ارتباط قطع است. مجدداً تلاش کنید.", "خطا!");
                });

        shc.getCourceList = function () {
            shc.courceList = [];
            var exist;
            for (var i = 0; i < shc.examList.length; i++) {
                exist = 0;
                for (var j = 0; j < shc.courceList.length; j++) {
                    if (shc.examList[i].courceID == shc.courceList[j].courceID)
                        exist = 1;
                }
                if (exist == 0)
                    shc.courceList.push(
                            {
                                courceID: shc.examList[i].courceID,
                                title: shc.examList[i].title,
                                payeName: shc.examList[i].payeName,
                                examList: [],
                                minScore: '-',
                                maxScore: '-',
                                avgScore: '-',
                                chartData: {},
                                chart: [],
                                muzuData: [],
                                muzuList: [],
                                muzuChart: []
                            });
            }
            shc.getCourceExams();
        };

        shc.getCourceExams = function () {
            for (var i = 0; i < shc.examList.length; i++)
                for (var j = 0; j < shc.courceList.length; j++)
                    if (shc.examList[i].courceID == shc.courceList[j].courceID)
                        shc.courceList[j].examList.push(shc.examList[i]);
            shc.getMinMaxAvg();
            shc.getCourceChartData();
        };

        shc.getMinMaxAvg = function () {
            var min, max, sum;
            for (var j = 0; j < shc.courceList.length; j++) {
                min = 100, max = 0, sum = 0;
                for (var i = 0; i < shc.courceList[j].examList.length; i++) {
                    var nomre = shc.courceList[j].examList[i].nomreAz20;
                    sum += parseFloat(nomre);
                    if (min > nomre)
                        min = nomre;
                    if (max < nomre)
                        max = nomre;
                }
                shc.courceList[j].minScore = min;
                shc.courceList[j].maxScore = max;
                shc.courceList[j].avgScore = parseFloat(sum / shc.courceList[j].examList.length);
            }
        };

        shc.getCourceChartData = function () {
            shc.charts = [];
            for (var j = 0; j < shc.courceList.length; j++) {
                var labels = [], data = [], dataID = [], options = [];
                for (var i = 0; i < shc.courceList[j].examList.length; i++) {
                    labels.push(shc.courceList[j].examList[i].fadate);
                    data.push(shc.courceList[j].examList[i].nomreAz20);
                    dataID.push(shc.courceList[j].examList[i].examResultID);
                }
                var chartData = {
                    labels: labels,
                    datasets: [{
                            label: "نمره",
                            backgroundColor: 'rgba(255, 99, 132, 0.8)',
                            borderColor: 'rgba(255, 99, 132, 0.2)',

                            data: data,
                            dataID: dataID,
                            fill: false,
                            pointRadius: 8,
                            pointHoverRadius: 10,
                        }]
                };
                shc.courceList[j].chartData = chartData;


            }
        };

        $timeout(function () {
            for (var j = 0; j < shc.courceList.length; j++) {
                var canvasID = 'cource_' + shc.courceList[j].courceID;
                var ctx = document.getElementById(canvasID).getContext('2d');
                shc.courceList[j].chart.push(new Chart(ctx, {type: 'line', data: shc.courceList[j].chartData, options: {}}));
            }
        }, 3000);

//        shc.createChart = function (canvasID, chartType, data) {
//            var ctx = document.getElementById(canvasID).getContext('2d');
//            window.chart = new Chart(ctx, {
//                type: chartType,
//                data: data,
//                options: {events: ['click']}
//            });
//            console.log(chart);
//            shc.charts.push({ID: canvasID, chart: chart});
//        };

        shc.chartCourceClick = function (courceID) {
            for (var i = 0; i < shc.courceList.length; i++) {
                if (shc.courceList[i].courceID == courceID) {
                    var chart = shc.courceList[i].chart[0];
                    var activePoint = chart.active;
                    if (activePoint.length > 0) {
                        var index = activePoint[0]._index;
                        var chartData = shc.courceList[i].chartData;
                        var dataID = chartData.datasets[0].dataID;
                        var examResultID = dataID[index];

                        for (var j = 0; j < shc.courceList[i].examList.length; j++) {
                            if (shc.courceList[i].examList[j].examResultID == examResultID) {
                                shc.examResultImage = shc.courceList[i].examList[j].examImage;
                                $('#examResultModal').modal('show');
                            }
                        }
                        console.log(shc.courceList[i].examList);
                    }
                }
            }
        };

        shc.getExamMuzuChart = function () {
            // get muzu data based on cource
            for (var j = 0; j < shc.courceList.length; j++)
                for (var i = 0; i < shc.countQuestionMuzu.length; i++)
                    if (shc.courceList[j].courceID == shc.countQuestionMuzu[i].courceID)
                        shc.courceList[j].muzuData.push(shc.countQuestionMuzu[i]);

            // get muzu list based on cource
            for (var j = 0; j < shc.courceList.length; j++) {
                var muzuList = [], exist = 0;
                for (var i = 0; i < shc.courceList[j].muzuData.length; i++) {
                    exist = 0;
                    for (var k = 0; k < muzuList.length; k++)
                        if (shc.courceList[j].muzuData[i].muzu == muzuList[k])
                            exist = 1;

                    if (exist == 0)
                        muzuList.push(shc.courceList[j].muzuData[i].muzu);
                }
                shc.courceList[j].muzuList = muzuList;
            }

            //get muzu chart data based on cource
            for (var j = 0; j < shc.courceList.length; j++) {
                var chartDataCorrect = [], chartDataNotCorrect = [], chartDataNone = [];
                for (var i = 0; i < shc.courceList[j].muzuList.length; i++) {
                    chartDataCorrect[i] = 0;
                    chartDataNotCorrect[i] = 0;
                    chartDataNone[i] = 0;
                }

                for (var i = 0; i < shc.courceList[j].muzuData.length; i++) {
                    for (var k = 0; k < shc.courceList[j].muzuList.length; k++) {
                        if (shc.courceList[j].muzuData[i].muzu == shc.courceList[j].muzuList[k]) {
                            if (shc.courceList[j].muzuData[i].isCorrect == 0)
                                chartDataCorrect[k] = shc.courceList[j].muzuData[i].count;
                            if (shc.courceList[j].muzuData[i].isCorrect == 1)
                                chartDataNotCorrect[k] = shc.courceList[j].muzuData[i].count;
                            if (shc.courceList[j].muzuData[i].isCorrect == -1)
                                chartDataNone[k] = shc.courceList[j].muzuData[i].count;
                        }
                    }
                }

                var data = {
                    labels: shc.courceList[j].muzuList,
                    datasets: [
                        {label: "جواب صحیح", backgroundColor: "#00a379", data: chartDataCorrect},
                        {label: "جواب غلط", backgroundColor: "#BD362F", data: chartDataNotCorrect},
                        {label: "بدون جواب", backgroundColor: "#DDDDDD", data: chartDataNone}
                    ]
                }
                shc.courceList[j].muzuChart = data;
            }
        };

        $timeout(function () {
            for (var j = 0; j < shc.courceList.length; j++) {
                var ctx = document.getElementById('muzuChart_' + shc.courceList[j].courceID).getContext('2d');
                var muzuChart = new Chart(ctx, {type: 'bar', data: shc.courceList[j].muzuChart, options: {}});
            }
        }, 4000);


    }// end of controller function courceCtrl


}());