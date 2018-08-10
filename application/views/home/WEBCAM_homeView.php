
<!doctype html>
<html ng-app="courseQuestion" ng-controller="mainController as mCtrl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title></title>

        <link ng-href='<?php echo base_url(); ?>assets/bootstrap/css/{{mCtrl.themeName}}.min.css' rel="stylesheet">        
        <!--<link ng-href='<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-theme.min.css' rel="stylesheet">-->
        <link ng-href='<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-rtl.min.css' rel="stylesheet">
        <link ng-href='<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-modal-bs3patch.css' rel="stylesheet">
        <link ng-href='<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-modal.css' rel="stylesheet">
        <link ng-href='<?php echo base_url(); ?>assets/bootstrap/css/font-awesome.min.css' rel="stylesheet">
        <!--[if lt IE 9]>
            <script src='<?php echo base_url(); ?>assets/js/html5.js'></script>
        <![endif]-->

        <!-- script references -->
        <script src='<?php echo base_url(); ?>assets/js/jquery-1.10.2.min.js'></script>

        <!--bootstrap integrated libriries-->
        <script src='<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js'></script>
        <script src='<?php echo base_url(); ?>assets/bootstrap/js/bootstrap-modal.js'></script>
        <script src='<?php echo base_url(); ?>assets/bootstrap/js/bootstrap-modalmanager.js'></script>

        <script src='<?php echo base_url(); ?>assets/angularjs/angular.js'></script>
        <script src='<?php echo base_url(); ?>assets/angularjs/angular-animate.js'></script>
        <script src='<?php echo base_url(); ?>assets/angularjs/angular-ui-router.min.js'></script>


        <script src='<?php echo base_url(); ?>angular/app.js'></script>
        
        <!-- CONTROLLERS -->
        <script src='<?php echo base_url(); ?>angular/controller/courceCtrl.js'></script>
        <script src='<?php echo base_url(); ?>angular/controller/questionCtrl.js'></script>
        <script src='<?php echo base_url(); ?>angular/controller/examinationCtrl.js'></script>


        <!-- SERVICES -->
        <script src='<?php echo base_url(); ?>angular/service/serviceModule.js'></script>
        <script src='<?php echo base_url(); ?>angular/service/courceFactory.js'></script>
        <script src='<?php echo base_url(); ?>angular/service/questionFactory.js'></script>
        <script src='<?php echo base_url(); ?>angular/service/examinationFactory.js'></script>


        <!-- DIRECTIVE -->
        <script src='<?php echo base_url(); ?>angular/directive/navbar.js'></script>
        <script src='<?php echo base_url(); ?>angular/directive/rightmenu.js'></script>
        
        <!-- toastr -->
        <link href='<?php echo base_url(); ?>assets/toastr/toastr.min.css' rel="stylesheet">
        <script src='<?php echo base_url(); ?>assets/toastr/toastr.min.js'></script>
        
        <!-- oi select -->
        <link href='<?php echo base_url(); ?>assets/oiselect/select.min.css' rel="stylesheet">
        <script src='<?php echo base_url(); ?>assets/oiselect/select.js'></script>
                
        <link ng-href='<?php echo base_url(); ?>assets/custom.css' rel="stylesheet">

<!-- Global site tag (gtag.js) - Google Analytics -->
<!--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-111999648-1"></script>
<script>
 // window.dataLayer = window.dataLayer || [];
 // function gtag(){dataLayer.push(arguments);}
 // gtag('js', new Date());

//  gtag('config', 'UA-111999648-1');
</script>
-->

    </head>

    <body dir="rtl">

        <div class="container-fluid" style="margin-right: 60px;">
            <navbar></navbar>
            <!--<right-menu></right-menu>-->
            
            
            WEBCAM
            <div class="row">
                <button class="btn btn-primary" id="btnEdge">Edge</button>
                 <form id="form1" enctype="multipart/form-data" method="post" action="Upload.aspx">
                    <div>
                      <label for="fileToUpload">Take or select photo(s)</label><br />
                      <input type="file" name="fileToUpload" id="fileToUpload" onchange="fileSelected();" accept="image/*" capture="camera" />
                    </div>
                    <div id="details"></div>
                    <div>
                        <input type="button"  onchange="readURL(this)" onclick="uploadFile()" value="Upload" />
                    </div>
                    <div class="col-sm-6"><img id="blah" class="img img-responsive" /></div>
                    <div class="col-md-6">
                        <canvas id="canvas2" width="500" height="600"></canvas>
                    </div>
                    <div id="progress"></div>
                  </form>
                  
                  
                  <script type="text/javascript">
                  
                      function fileSelected() {
                            var input=document.getElementById('fileToUpload');
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                $('#blah').attr('src', e.target.result);
                            }
                            reader.readAsDataURL(input.files[0]);
                            
                            var count = document.getElementById('fileToUpload').files.length;
                              document.getElementById('details').innerHTML = "";
                              for (var index = 0; index < count; index ++){
                                     var file = document.getElementById('fileToUpload').files[index];
                                     var fileSize = 0;
                                     if (file.size > 1024 * 1024)
                                        fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
                                    else
                                        fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
                                    
                                    document.getElementById('details').innerHTML += 'Name: ' + file.name + '<br>Size: ' + fileSize + '<br>Type: ' + file.type;
                                    document.getElementById('details').innerHTML += '<p>';
                                }
                      }
                      function uploadFile() {
                        var fd = new FormData();
                              var count = document.getElementById('fileToUpload').files.length;
                              for (var index = 0; index < count; index ++)
                              {
                                     var file = document.getElementById('fileToUpload').files[index];
                                     fd.append('myFile', file);
                              }
                        var xhr = new XMLHttpRequest();
                        xhr.upload.addEventListener("progress", uploadProgress, false);
                        xhr.addEventListener("load", uploadComplete, false);
                        xhr.addEventListener("error", uploadFailed, false);
                        xhr.addEventListener("abort", uploadCanceled, false);
                        xhr.open("POST", siteUrl + '/Cource/savetofile');
                        xhr.send(fd);
                      }
                    function uploadProgress(evt) {
                        if (evt.lengthComputable) {
                          var percentComplete = Math.round(evt.loaded * 100 / evt.total);
                          document.getElementById('progress').innerHTML = percentComplete.toString() + '%';
                        }
                        else {
                          document.getElementById('progress').innerHTML = 'unable to compute';
                        }
                      }
                      function uploadComplete(evt) {
                        /* This event is raised when the server send back a response */
                        alert(evt.target.responseText);
                      }
                      function uploadFailed(evt) {
                        alert("There was an error attempting to upload the file.");
                      }
                      function uploadCanceled(evt) {
                        alert("The upload has been canceled by the user or the browser dropped the connection.");
                      }
                    </script>
            </div>
            
            
            TEST 3
            <div class="row">
                <div class="col-md-12">
                    <div id="webcam_container">
                        <input type="file" id="myVideo" accept="image/*;capture=camera">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <button class="btn btn-primary" id="btnGray">Gray</button>
                        <button class="btn btn-primary" id="btnBinary">Binary</button>
                        <button class="btn btn-primary" id="btnEdge">Edge</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <canvas id="canvas" width="500" height="600"></canvas>
                </div>
                
                
                
                <script>
                
                    var canvas2,context2,btnEdge;
                    
                    btnEdge = document.getElementById("btnEdge");
                    btnEdge.addEventListener("click", edge);
                    
                    canvas2 = document.getElementById("canvas2");
                    context2 = canvas2.getContext("2d");
                    
                    function edge(){
                        
                        canvas2.width=picture.width;
                        canvas2.height=picture.height;
                        context2.drawImage(picture, 0, 0, canvas2.width, canvas2.height);
                        
                        console.log('width:',canvas2.width,'h:',canvas2.height)
                        
                        var image = context2.getImageData(0, 0, canvas2.width, canvas2.height);
                        var w=image.width;
                        var h=image.height;
                        console.log('pixel w:',image.width,'pixel H:',image.height);
                        var thresh_red =20;
                        var thresh_green =20;
                        var thresh_blue = 20;
                        
                        var thresh_edge=50;
                    
                        var channels = image.data.length/4;
                        for(var i=0;i<channels;i++){
                            var r = image.data[i*4 + 0];
                            var g = image.data[i*4 + 1];
                            var b = image.data[i*4 + 2];
                            if( r>= thresh_red && g>= thresh_green && b>=thresh_blue ){
                                image.data[i*4 + 0] = 0;
                                image.data[i*4 + 1] = 0;
                                image.data[i*4 + 2] = 0;
                            }else{
                                image.data[i*4 + 0] =255;
                                image.data[i*4 + 1] = 255;
                                image.data[i*4 + 2] = 255;
                            }
                        }
                        
                        var filterAvg=[];
                        var filterAvg2=[];
                        var filterAvg3=[];
                        var filterAvg4=[];
                        var avgFilterCount=4;
                        for(var i=0;i<channels;i++){
                            for(var i1=0;i1<avgFilterCount;i1++){
                                for(var i2=0;i2<avgFilterCount;i2++){
                                    filterAvg[i1+5*i2]=image.data[(i+i1)*4+(i2*w*4) + 0];
                                    //filterAvg2[i1+5*i2]=image.data[(i-i1)*4-(i2*w*4) + 0];
                                    //filterAvg3[i1+5*i2]=image.data[(i-i1)*4+(i2*w*4) + 0];
                                    filterAvg4[i1+5*i2]=image.data[(i+i1)*4-(i2*w*4) + 0];
                                }   
                            }
                            //console.log('AVG:',filterAvg);
                            sum=0;
                            for(var i3 in filterAvg){
                                sum+=filterAvg[i3];
                            }
                            for(var i3 in filterAvg2){
                                //sum+=filterAvg2[i3];
                            }
                            for(var i3 in filterAvg2){
                                //sum+=filterAvg3[i3];
                            }
                            for(var i3 in filterAvg3){
                                sum+=filterAvg4[i3];
                            }
                            var avg=sum/(2*(filterAvg.length));
                            if(avg<105){
                                image.data[i*4 + 0] =255;
                                image.data[i*4 + 1] = 255;
                                image.data[i*4 + 2] = 0;
                            }else{
                                image.data[i*4 + 0] =0;
                                image.data[i*4 + 1] = 0;
                                image.data[i*4 + 2] = 255;
                            }
                        }
                        
                       
                        
                        
                        //remove noise
                       /* for(var i=0;i<channels;i++){
                            var count=0;
                            if(image.data[i*4 + 2] ==image.data[i*4+4 + 2]){
                                count+=1;
                            }
                            if(image.data[i*4 + 2] ==image.data[i*4-4 + 2]){
                                count+=1;
                            }
                            if(image.data[i*4 + 2] ==image.data[i*4+w*4+4 + 2]){
                                count+=1;
                            }
                            if(image.data[i*4 + 2] ==image.data[i*4-w*4 + 2]){
                                count+=1;
                            }
                            
                            if(count<=1){
                                image.data[i*4 + 0] =0;
                                image.data[i*4 + 1] =0;
                                image.data[i*4 + 2] = 0;
                            }
                        }
                        
                        var SquareSize=Math.floor(Math.min(Math.floor(w/10), Math.floor(h/16))/2);
                        */
                        /*SquareSize=50;
                        alert(SquareSize);
                        for(var i=0;i<channels;i++){
                            
                            if(image.data[i*4 + 0] ==255 && image.data[i*4 + 1] ==255 && image.data[i*4 + 2] ==255){
                                if(image.data[i*4+w*SquareSize*4+SquareSize*4 + 0] ==255 && image.data[i*4+w*SquareSize*4+SquareSize*4 + 1] ==255 && image.data[i*4+w*SquareSize*4+SquareSize*4 + 2] ==255){
                                    image.data[i*4 + 0] =255;
                                    image.data[i*4 + 1] = 255;
                                    image.data[i*4 + 2] = 0;
                                }
                            }
                           
                        }*/
                        
                        context2.putImageData(image, 0,  0);
                    }
                    
                    function getColorIndicesForCoord(x, y, width) {
                      var red = y * (width * 4) + x * 4;
                      return [red, red + 1, red + 2, red + 3];
                    }

                    
                    
                    var picture;
                    var canvas;
                    var btnGray, btnBinary;
                    var imcanvas;
                    
                    picture=document.getElementById("blah");
                    canvas = document.getElementById("canvas");
                    btnGray = document.getElementById("btnGray");
                    btnBinary = document.getElementById("btnBinary");
                    imcanvas = canvas.getContext("2d");
                    //set up event listeners ..
                    btnGray.addEventListener("click", gray);
                    btnBinary.addEventListener("click", binary);
                    
                    function capture(){
                        console.log(picture);
                        canvas.width=picture.width;
                        canvas.height=picture.height;
                        imcanvas.drawImage(picture, 0, 0, canvas.width, canvas.height);
                    }
                    
                    function gray(){
                        capture();
                        // 32 bit image
                        var image = imcanvas.getImageData(0, 0, canvas.width, canvas.height);
                        var channels = image.data.length/4;
                        for(var i=0;i<channels;i++){
                            var r = image.data[i*4 + 0];
                            var g = image.data[i*4 + 1];
                            var b = image.data[i*4 + 2];
                            var gray =  Math.round(0.21*r + 0.72*g + 0.07*b);
                            image.data[i*4 + 0] = gray;
                            image.data[i*4 + 1] = gray;
                            image.data[i*4 + 2] = gray;
                        }
                    
                        console.log(image);
                        imcanvas.putImageData(image, 0, 0);
                        //imcanvas.putImageData(image.toDataURL(), 0, 0, canvas.width, canvas.height);
                        // imcanvas.drawImage();
                    }
                    
                    function binary(){
                        capture();
                        var image = imcanvas.getImageData(0, 0, canvas.width, canvas.height);
                        var thresh_red =100;
                        var thresh_green = 100;
                        var thresh_blue = 100;
                    
                        var channels = image.data.length/4;
                        for(var i=0;i<channels;i++){
                            var r = image.data[i*4 + 0];
                            var g = image.data[i*4 + 1];
                            var b = image.data[i*4 + 2];
                            if( r>= thresh_red && g>= thresh_green && b>=thresh_blue ){
                                image.data[i*4 + 0] = 0;
                                image.data[i*4 + 1] = 0;
                                image.data[i*4 + 2] = 0;
                            }else{
                                image.data[i*4 + 0] = 255;
                                image.data[i*4 + 1] = 255;
                                image.data[i*4 + 2] = 255;
                            }
                        }
                        imcanvas.putImageData(image, 0,  0);
                    
                    }
                    
                    
                </script>
                
            </div>
            
            
            <!--view-->
            <div class="row">
                <div class="col-sm-12">
                    <div ui-view></div>
                </div>
            </div>
        </div><!-- .container-fluid -->


        <!-- MODAL FORMS ------------------------------------------------------>
        <!--------------------------------------------------------------------->
        



        <script>
            var baseUrl = '<?= base_url(); ?>';
            var siteUrl = '<?= site_url(); ?>';
            toastr.options = {
              "closeButton": true,
              "debug": false,
              "newestOnTop": true,
              "progressBar": true,
              "positionClass": "toast-top-center",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
        </script>

    </body>
</html>