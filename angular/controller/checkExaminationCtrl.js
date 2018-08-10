(function () {
    "use strict";
    angular.module("courseQuestion").controller("checkExaminationCtrl", ["examinationFactory", "$stateParams", "$scope", checkExaminationCtrl]);

    function checkExaminationCtrl(examinationFactory, $stateParams, $scope) {

        var cec = this;

        $scope.selectedSchool = false;
        $scope.selectedStudent = false;
        cec.schoolList = false;
        cec.studentList = false;
        cec.answerSheet = false;
        cec.saveingInfo = false;

        // play sound
        var sound = document.getElementById("audio");

        examinationFactory.getExamAnswerSheet($stateParams).success(function (data) {
            cec.answerSheet = data;
            console.log("1:", cec.answerSheet);
        }).error(function () {
            toastr.error("ارتباط قطع است. مجدداً تلاش کنید.", "خطا!");
        });

        examinationFactory.getSchoolList().success(function (data) {
            cec.schoolList = data;
        }).error(function () {
            toastr.error("ارتباط قطع است. مجدداً تلاش کنید.", "خطا!");
        });

        $scope.$watch('selectedSchool', function (newValue, oldValue) {
            if (newValue === false)
                return false;
            examinationFactory.getStudentList(newValue.id).success(function (data) {
                cec.studentList = data;
            }).error(function () {
                toastr.error("ارتباط قطع است. مجدداً تلاش کنید.", "خطا!");
            });
        });

        cec.cleanAnswerSheetTemp = function () {
            cec.answerSheetTemp = {column1: [], column2: []};
            for (var i = 0; i < 20; i++) {
                cec.answerSheetTemp.column1.push({questionIndex: i + 1, isCorrect: 0, items: {item1: 0, item2: 0, item3: 0, item4: 0}});
                cec.answerSheetTemp.column2.push({questionIndex: i + 21, isCorrect: 0, items: {item1: 0, item2: 0, item3: 0, item4: 0}});

            }
        };

        $scope.capture21 = function () {
            $scope.makeSnapshot();
            $scope.binary21();
            $scope.track21();
        };

        var _video = null, patData = null;
        $scope.patOpts = {x: 0, y: 0, w: 25, h: 25};
        $scope.channel = {videoHeight: 500, videoWidth: 500, video: null};

        $scope.webcamError = false;
        $scope.onError = function (err) {
            $scope.$apply(function () {
                $scope.webcamError = err;
            });
        };

        $scope.onSuccess = function () {
            // The video element contains the captured camera data
            _video = $scope.channel.video;
            $scope.$apply(function () {
                $scope.patOpts.w = _video.width;
                $scope.patOpts.h = _video.height;
                //$scope.showDemos = true;
            });
        };

        $scope.onStream = function (stream) {
            // You could do something manually with the stream.
        };

        var patCanvas = document.querySelector('#snapshot');
        var ctxPat = patCanvas.getContext('2d');
        $scope.makeSnapshot = function () {
            if (_video) {

                if (!patCanvas)
                    return;

                patCanvas.width = _video.width;
                patCanvas.height = _video.height;

                var idata = getVideoData($scope.patOpts.x, $scope.patOpts.y, $scope.patOpts.w, $scope.patOpts.h);
                ctxPat.putImageData(idata, 0, 0);
                sendSnapshotToServer(patCanvas.toDataURL());
                patData = idata;
            }
        };

        $scope.binary21 = function () {
            //capture();
            var image = ctxPat.getImageData(0, 0, patCanvas.width, patCanvas.height);
            var thresh_red = 100;
            var thresh_green = 100;
            var thresh_blue = 100;

            var channels = image.data.length / 4;
            for (var i = 0; i < channels; i++) {
                var r = image.data[i * 4 + 0];
                var g = image.data[i * 4 + 1];
                var b = image.data[i * 4 + 2];
                if (r >= thresh_red && g >= thresh_green && b >= thresh_blue) {
                    image.data[i * 4 + 0] = 255;
                    image.data[i * 4 + 1] = 255;
                    image.data[i * 4 + 2] = 255;
                } else {
                    image.data[i * 4 + 0] = 0;
                    image.data[i * 4 + 1] = 0;
                    image.data[i * 4 + 2] = 0;
                }
            }
            ctxPat.putImageData(image, 0, 0);
        };

        $scope.plot21 = function (x, y, w, h, color, text = '') {
            var rect = document.createElement('div21');
            document.querySelector('.canvasFrame21').appendChild(rect);
            rect.classList.add('rect');
            rect.style.border = '3px solid ' + color;
            rect.style.width = w + 'px';
            rect.style.height = h + 'px';
            rect.style.left = (x + 70) + 'px';
            rect.style.top = (y - 0) + 'px';
            rect.innerHTML = text;
            rect.style.color = 'red';
        }

        $scope.Ansewrs = [];

        $scope.track21 = function () {
            var maxW = 0;
            var maxH = 0;
            var maxWarray = [];
            var maxHarray = [];
            var w_thresh = 5;
            var h_thresh = 5;
            var x_thresh = 3;
            var y_thresh = 3;
            var col1_min_y = 0, col1_max_y = 0, col2_min_y = 0, col2_max_y = 0;
            var min_x = 0, max_x = 0;

            tracking.ColorTracker.registerColor('black', function (r, g, b) {
                if (r >= 0 && r < 20 && g >= 0 && g < 20 && b >= 0 && b < 20) {
                    return true;
                }
            });
            tracking.ColorTracker.prototype.setMinDimension(5);
            var tracker = new tracking.ColorTracker(['black']);

            tracker.on('track', function (event) {

                event.data.forEach(function (rect) {
                    if (rect.width > maxW) {
                        maxW = rect.width;
                    }
                    if (rect.height > maxH) {
                        maxH = rect.height;
                    }
                    rect.x_center = rect.x + Math.round(rect.width / 2);
                    rect.y_center = rect.y + Math.round(rect.height / 2);
                });
                //????? reform max H
                for (var i in event.data) {
                    if (event.data[i].width > maxW - w_thresh) {
                        maxWarray.push(event.data[i]);
                        $scope.plot21(event.data[i].x, event.data[i].y, event.data[i].width, event.data[i].height, 'blue');
                    }
                    if (event.data[i].height > maxH - h_thresh) {
                        maxHarray.push(event.data[i]);
                        $scope.plot21(event.data[i].x, event.data[i].y, event.data[i].width, event.data[i].height, 'green');
                    }
                }

                col1_min_y = maxHarray[0].y;
                col1_max_y = maxHarray[1].y + maxHarray[1].height;
                col2_min_y = maxHarray[2].y;
                col2_max_y = maxHarray[3].y + maxHarray[3].height;

                var itemWidth = Math.round((col1_max_y - col1_min_y) / 4);

                min_x = maxWarray[0].x;
                max_x = maxWarray[3].x + maxWarray[3].width;
                var itemHeight = (max_x - min_x) / 20;

                for (var i in event.data) {
                    event.data[i].colNum = 0;
                    event.data[i].questionNum = 0;
                    event.data[i].itemNum = 0;
                    if (event.data[i].y >= col1_min_y - y_thresh && event.data[i].y <= col1_max_y + y_thresh) {
                        event.data[i].colNum = 1;
                        if (event.data[i].y_center >= col1_min_y && event.data[i].y_center <= col1_min_y + itemWidth)
                            event.data[i].itemNum = 4;
                        if (event.data[i].y_center > col1_min_y + itemWidth && event.data[i].y_center <= col1_min_y + 2 * itemWidth)
                            event.data[i].itemNum = 3;
                        if (event.data[i].y_center > col1_min_y + 2 * itemWidth && event.data[i].y_center <= col1_min_y + 3 * itemWidth)
                            event.data[i].itemNum = 2;
                        if (event.data[i].y_center > col1_min_y + 3 * itemWidth && event.data[i].y_center <= col1_min_y + 4 * itemWidth)
                            event.data[i].itemNum = 1;
                    }
                    if (event.data[i].y >= col2_min_y - y_thresh && event.data[i].y <= col2_max_y + y_thresh) {
                        event.data[i].colNum = 2;
                        if (event.data[i].y_center >= col2_min_y && event.data[i].y_center <= col2_min_y + itemWidth)
                            event.data[i].itemNum = 4;
                        if (event.data[i].y_center > col2_min_y + itemWidth && event.data[i].y_center <= col2_min_y + 2 * itemWidth)
                            event.data[i].itemNum = 3;
                        if (event.data[i].y_center > col2_min_y + 2 * itemWidth && event.data[i].y_center <= col2_min_y + 3 * itemWidth)
                            event.data[i].itemNum = 2;
                        if (event.data[i].y_center > col2_min_y + 3 * itemWidth && event.data[i].y_center <= col2_min_y + 4 * itemWidth)
                            event.data[i].itemNum = 1;
                    }

                    if (event.data[i].x >= min_x - x_thresh && event.data[i].x <= max_x + x_thresh) {
                        event.data[i].questionNum = 20 - (Math.floor((event.data[i].x - min_x) / itemHeight));
                        if (event.data[i].colNum == 1)
                            event.data[i].questionNum += 20;
                    }

                    if (event.data[i].itemNum > 0 && event.data[i].questionNum > 0) {

                        $scope.Ansewrs.push({questionIndex: event.data[i].questionNum, answer: event.data[i].itemNum});

                        var colorPoint = 'red';
                        if (event.data[i].itemNum == 1)
                            colorPoint = 'yellow';
                        if (event.data[i].itemNum == 2)
                            colorPoint = 'cyan';
                        if (event.data[i].itemNum == 3)
                            colorPoint = 'brown';
                        if (event.data[i].itemNum == 4)
                            colorPoint = 'blue';
                        $scope.plot21(event.data[i].x, event.data[i].y, event.data[i].width, event.data[i].height, colorPoint, event.data[i].questionNum);
                    }
                }
                $scope.calcMark();

            });
            tracking.track('#snapshot', tracker);
        };

        cec.cleanAnswerSheetTemp();

        $scope.calcMark = function () {
            for (var j = 0; j < cec.answerSheet.length; j++) {
                for (var i = 0; i < $scope.Ansewrs.length; i++) {
                    if ($scope.Ansewrs[i].questionIndex == cec.answerSheet[j].questionIndex) {
                        cec.answerSheet[j].checkedItem = parseInt($scope.Ansewrs[i].answer);
                        cec.answerSheet[j].checkedCount = parseInt(cec.answerSheet[j].checkedCount) + 1;
                        cec.answerSheet[j].checkedList = cec.answerSheet[j].checkedList + cec.answerSheet[j].checkedItem + ',';
                    }
                }
            }
            cec.cleanAnswerSheetTemp();
            for (var i = 0; i < cec.answerSheet.length; i++) {
                cec.answerSheet[i].checkedList = cec.answerSheet[i].checkedList.slice(0, -1);
                //COLUMN 1
                for (j = 0; j < cec.answerSheetTemp.column1.length; j++) {
                    if (cec.answerSheetTemp.column1[j].questionIndex == cec.answerSheet[i].questionIndex) {
                        if (cec.answerSheet[i].checkedCount > 1) {
                            cec.answerSheetTemp.column1[j].isCorrect = -1;
                            cec.answerSheet[i].isCorrect = -1;
                            var checkedItems = cec.answerSheet[i].checkedList.split(",");
                            for (var k = 0; k < checkedItems.length; k++) {
                                cec.answerSheetTemp.column1[j].items["item" + checkedItems[k]] = 1;
                            }
                        }
                        if (cec.answerSheet[i].checkedCount == 1) {
                            cec.answerSheetTemp.column1[j].items["item" + cec.answerSheet[i].checkedItem] = 1;
                            if (cec.answerSheet[i].checkedItem == cec.answerSheet[i].answer) {
                                cec.answerSheetTemp.column1[j].isCorrect = 1;
                                cec.answerSheet[i].isCorrect = 1;
                            } else {
                                cec.answerSheetTemp.column1[j].isCorrect = -1;
                                cec.answerSheet[i].isCorrect = -1;
                            }
                        }
                    }
                }
                //COLUMN 2
                for (j = 0; j < cec.answerSheetTemp.column2.length; j++) {
                    if (cec.answerSheetTemp.column2[j].questionIndex == cec.answerSheet[i].questionIndex) {
                        if (cec.answerSheet[i].checkedCount > 1) {
                            cec.answerSheetTemp.column2[j].isCorrect = -1;
                            cec.answerSheet[i].isCorrect = -1;
                            var checkedItems = cec.answerSheet[i].checkedList.split(",");
                            for (var k = 0; k < checkedItems.length; k++) {
                                cec.answerSheetTemp.column2[j].items["item" + checkedItems[k]] = 1;
                            }
                        }
                        if (cec.answerSheet[i].checkedCount == 1) {
                            cec.answerSheetTemp.column2[j].items["item" + cec.answerSheet[i].checkedItem] = 1;
                            if (cec.answerSheet[i].checkedItem == cec.answerSheet[i].answer) {
                                cec.answerSheetTemp.column2[j].isCorrect = 1;
                                cec.answerSheet[i].isCorrect = 1;
                            } else {
                                cec.answerSheetTemp.column2[j].isCorrect = -1;
                                cec.answerSheet[i].isCorrect = -1;
                            }
                        }
                    }
                }
            }
            sound.play();
            cec.questionCount = cec.answerSheet.length;
            cec.correctQuestionCount = 0;
            cec.inCorrectQuestionCount = 0;
            cec.nonAnswerQuestionCount = 0;
            var correctStatue = 0;
            for (var i = 0; i < cec.answerSheet.length; i++) {
                correctStatue = parseInt(cec.answerSheet[i].isCorrect);
                if (correctStatue == 0)
                    cec.nonAnswerQuestionCount += 1;
                else if (correctStatue == 1)
                    cec.correctQuestionCount += 1;
                else if (correctStatue == -1)
                    cec.inCorrectQuestionCount += 1;
            }
            cec.examMark = (cec.correctQuestionCount * 3 - cec.inCorrectQuestionCount) / (cec.questionCount * 3);
            cec.examMark = cec.examMark * 20;
        };

        cec.getItemTempClass = function (isCorrect, itemX) {
            if (itemX == 1) {
                if (isCorrect == 1)
                    return 'bg-success';
                if (isCorrect == -1)
                    return 'bg-danger';
            }
        };


        cec.saveInfo = function () {
            if ($scope.selectedStudent == false) {
                toastr.error("لطفاً مشخصات دانش آموز را تعیین کنید.", "خطا!");
                return false;
            }
            examinationFactory.saveExamResult($scope.selectedStudent, cec.answerSheet, $scope.snapshotData, cec.examMark).success(function (data) {
                console.log(data);
            }).error(function (data) {});

        };




        /**
         * Redirect the browser to the URL given.
         * Used to download the image by passing a dataURL string
         */
        $scope.downloadSnapshot = function downloadSnapshot(dataURL) {
            window.location.href = dataURL;
        };

        var getVideoData = function getVideoData(x, y, w, h) {
            var hiddenCanvas = document.createElement('canvas');
            hiddenCanvas.width = _video.width;
            hiddenCanvas.height = _video.height;
            var ctx = hiddenCanvas.getContext('2d');
            ctx.drawImage(_video, 0, 0, _video.width, _video.height);
            return ctx.getImageData(x, y, w, h);
        };

        /**
         * This function could be used to send the image data
         * to a backend server that expects base64 encoded images.
         *
         * In this example, we simply store it in the scope for display.
         */
        var sendSnapshotToServer = function sendSnapshotToServer(imgBase64) {
            $scope.snapshotData = imgBase64;
        };


        $scope.refreshCamere = function () {
            var div21 = $('.rect');
            div21.remove();
//            $scope.Ansewrs = [];
//cec.answerSheet = false;
            console.log("2:", cec.answerSheet);
            for (var i = 0; i < cec.answerSheet.length; i++) {
                cec.answerSheet[i].checkedCount = 0;
                cec.answerSheet[i].checkedItem = 0;
                cec.answerSheet[i].checkedList = "";
                cec.answerSheet[i].isCorrect = 0;
            }
            cec.cleanAnswerSheetTemp();

//            document.querySelector('.canvasFrame21').removeChild('.rect')();
        };






//        $scope.myChannel = {
//            // the fields below are all optional
//            videoHeight: 800,
//            videoWidth: 600,
//            video: null // Will reference the video element on success
//        };
//        console.log($stateParams);

//        var videoElement = document.querySelector('video');
//        var videoSelect = document.querySelector('select#videoSource');
//        var selectors = [videoSelect];

//        function gotDevices(deviceInfos) {
//            // Handles being called several times to update labels. Preserve values.
//            var values = selectors.map(function (select) {
//                return select.value;
//            });
//            selectors.forEach(function (select) {
//                while (select.firstChild) {
//                    select.removeChild(select.firstChild);
//                }
//            });
//            for (var i = 0; i !== deviceInfos.length; ++i) {
//                var deviceInfo = deviceInfos[i];
//                var option = document.createElement('option');
//                option.value = deviceInfo.deviceId;
//                if (deviceInfo.kind === 'videoinput') {
//                    option.text = deviceInfo.label || 'camera ' + (videoSelect.length + 1);
//                    videoSelect.appendChild(option);
//                }
//            }
//            selectors.forEach(function (select, selectorIndex) {
//                if (Array.prototype.slice.call(select.childNodes).some(function (n) {
//                    return n.value === values[selectorIndex];
//                })) {
//                    select.value = values[selectorIndex];
//                }
//            });
//        }

//        navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);

//        function gotStream(stream) {
//
//            window.stream = stream; // make stream available to console
//            videoElement.srcObject = stream;
//            // Refresh button list in case labels have become available
//            return navigator.mediaDevices.enumerateDevices();
//        }

//        function start() {
//            if (window.stream) {
//                window.stream.getTracks().forEach(function (track) {
//                    track.stop();
//                });
//            }
//            var videoSource = videoSelect.value;
//            var constraints = {
//                video: {deviceId: videoSource ? {exact: videoSource} : undefined}
//            };
//            navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);
//        }

//        videoSelect.onchange = start;
//        start();

//        function handleError(error) {
//            console.log('navigator.getUserMedia error: ', error);
//        }
//

//        cec.capture = function () {
//            capture();
//        };
//        cec.track = function () {
//            track();
//        };


    }// end of controller function courceCtrl







}());