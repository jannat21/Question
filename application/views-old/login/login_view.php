<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> </title>

        <!--<link href='<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css' rel="stylesheet">-->
        <!--[if lt IE 9]>
            <script src='<?php echo base_url(); ?>assets/js/html5.js'></script>
        <![endif]-->

        <link href='<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-flatly.min.css' rel="stylesheet">        
        <!--<link ng-href='<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-theme.min.css' rel="stylesheet">-->
        <link href='<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-rtl.min.css' rel="stylesheet">
        <link href='<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-modal-bs3patch.css' rel="stylesheet">
        <link href='<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-modal.css' rel="stylesheet">
        <link href='<?php echo base_url(); ?>assets/bootstrap/css/font-awesome.min.css' rel="stylesheet">
        <!--[if lt IE 9]>
            <script src='<?php echo base_url(); ?>assets/js/html5.js'></script>
        <![endif]-->

        <!-- script references -->
        <script src='<?php echo base_url(); ?>assets/js/jquery-1.10.2.min.js'></script>

        <!--bootstrap integrated libriries-->
        <script src='<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js'></script>
        <script src='<?php echo base_url(); ?>assets/bootstrap/js/bootstrap-modal.js'></script>
        <script src='<?php echo base_url(); ?>assets/bootstrap/js/bootstrap-modalmanager.js'></script>

        <link href='<?php echo base_url(); ?>assets/custom.css' rel="stylesheet">

        <!-- toastr -->
        <link href='<?php echo base_url(); ?>assets/toastr/toastr.min.css' rel="stylesheet">
        <script src='<?php echo base_url(); ?>assets/toastr/toastr.min.js'></script>

    </head>

    <body >
        <script language="javascript" type="text/javascript">
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

            function register() {
                $('#newUserCode').val('');
                $('#newUserFamily').val('');
                $('#newUserName').val('');
                $('#newUserPassword').val('');
                $('#newUserPassword2').val('');
                $('#newUserSaving').hide();
                $('#registerNewUserModal').modal('show');
            }

            function saveNewUser() {
                var newUserName = $('#newUserName').val();
                var newUserFamily = $('#newUserFamily').val();
                var newUserCode = $('#newUserCode').val();
                var newUserPassword = $('#newUserPassword').val();
                var newUserPassword2 = $('#newUserPassword2').val();

                newUserName = newUserName.trim();
                newUserFamily = newUserFamily.trim();
                newUserCode = newUserCode.trim();
                newUserPassword = newUserPassword.trim();
                newUserPassword2 = newUserPassword2.trim();

                var error = 0;
                if (newUserName == "" || newUserName == null) {
                    toastr.error("نام را وارد کنید.", "خطا!");
                    error = 1;
                    $('#newUserName').focus();
                }
                if (newUserFamily == "" || newUserFamily == null) {
                    toastr.error("نام خانوادگی را وارد کنید.", "خطا!");
                    error = 1;
                    $('#newUserFamily').focus();
                }
                if (newUserCode == "" || newUserCode == null) {
                    toastr.error(" کد دانش آموزی را وارد کنید.", "خطا!");
                    error = 1;
                    $('#newUserCode').focus();
                }
                if (newUserPassword == "" || newUserPassword == null) {
                    toastr.error(" کلمه عبور را وارد کنید.", "خطا!");
                    error = 1;
                    $('#newUserPassword').focus();
                }
                if (newUserPassword2 == "" || newUserPassword2 == null) {
                    toastr.error(" تکرار کلمه عبور را وارد کنید.", "خطا!");
                    error = 1;
                    $('#newUserPassword').focus();
                }
                if (newUserPassword2 !== newUserPassword) {
                    toastr.error("عدم یکسان بودن کلمه عبور و تکرار آن!.", "خطا!");
                    error = 1;
                    $('#newUserPassword').focus();
                }
                if (error == 1) {
                    return false;
                }
                $('#registerNewUserForm').submit();
            }

            function login() {
                $('.req').parent().parent().removeClass('has-error');
                $('.req').parent().parent().children('span').removeClass('glyphicon-remove');
                var error = 0;
                var codep = $('#codep').val();
                codep = codep.trim();
                if (codep == "" || codep == null) {
                    $('#codep').parent().parent().addClass('has-error');
                    $('#codep').parent().parent().children('span').addClass('glyphicon-remove');
                    error = 1;
                }
                var password = $('#password').val();
                password = password.trim();
                if (password == "" || password == null) {
                    $('#password').parent().parent().addClass('has-error');
                    $('#password').parent().parent().children('span').addClass('glyphicon-remove');
                    error = 1;
                }
                if (error == 1) {
                    return false;
                }
                $('#login_form').submit();
            }

            //key press
            $(document).ready(function (e) {
                //$('#codep').focus();
                $('#codep').on('keypress', function (e) {
                    if (e.which == 13) {
                        $('#password').focus();
                    }
                });
                $('#password').on('keypress', function (e) {
                    if (e.which == 13) {
                        login();
                    }
                });
                $('.login_button').on('keypress', function (e) {
                    if (e.which == 13) {
                        login();
                    }
                });
            });
        </script>

        <style>
            .login-form{max-width:300px;margin:0 auto;}
            #codep {margin-bottom: -1px;border-bottom-right-radius: 0;border-bottom-left-radius: 0;}
            #password {border-top-left-radius: 0;border-top-right-radius: 0;}
            .form-group{margin:0px;font-family:'Droid Arabic Naskh';}
        </style>

        <div id="main" class="container">
            <div id="content" class="raise text-center">
                <form action='<?php echo base_url(); ?>index.php/login/verify_login' method='post' 
                      name='login_form' id="login_form" class="login-form">            
                    <div class="logo text-center" >
                        <div style="margin:0 auto;" class="text-center">
                            <img class="img-responsive img-rounded" src='<?php echo base_url(); ?>assets/img/1.jpg' 
                                 style="margin:0 auto;" />
                            <br>
                        </div>
                        <!--<div style="margin-left:auto; margin-right:auto;">
                                <img class="img-responsive" src='<?php echo base_url(); ?>assets/img/logo-blue.png' style="margin-bottom:15px;"/>
                        </div>-->
                    </div>
                    <div id="error" class="error">
                        <?php //echo validation_errors(); ?>
                        <?php // echo form_open('group_t/group_t_verify_login'); ?>
                    </div>	

                    <div class="form-group has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user text-info"></i></span>
                            <input type="text" size="30" id="codep" name="codep" placeholder="نام کاربری" value="" tabindex="1" 
                                   class="text-center form-control req" autofocus />
                        </div>
                        <span class="glyphicon form-control-feedback" ></span>
                    </div>

                    <div class="form-group has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock text-info"></i></span>
                            <input type="password" size="30" id="password" name="password" placeholder="کلمه عبور" 
                                   value="" tabindex="2" class="text-center form-control req"/>
                        </div>
                        <span class="glyphicon form-control-feedback" ></span>
                    </div>
                    <br>
                    <a class="btn btn-block btn-primary" onclick="login()" tabindex="3">ورود</a>					
                </form>

                <div style="max-width:300px;margin:10px auto;" class="row">
                    <button onclick="register()" class="btn btn-block btn-success" type="button">
                        <i class="fa fa-plus-square-o"></i>&nbsp; ثبت نام
                    </button>
                </div>
            </div><!--raise-->

            <!-- MODAL FORMS -->
            <!-- register new user modal form -->      
            <div id="registerNewUserModal" class="modal fade in ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h2 class="text-primary"><i class="fa fa-plus-square-o"></i>&nbsp; ثبت نام</h2>                
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form name="registerNewUserForm" id="registerNewUserForm"
                              action='<?php echo base_url(); ?>index.php/login/registerNewUser' method='post'>
                            <div class="col-sm-12">
                                <i class="fa fa-user-plus"></i>&nbsp;<label class="control-label">نام</label>
                                <span style="color: red;">*</span>
                                <input required type="text" placeholder="نام" name="newUserName" id="newUserName" class="form-control" />
                            </div>                    
                            <div class="col-sm-12">
                                <i class="fa fa-user-plus"></i>&nbsp;<label class="control-label">نام خانوادگی</label>
                                <span style="color: red;">*</span>
                                <input required type="text" placeholder="نام خانوادگی" name="newUserFamily" id="newUserFamily" class="form-control" />      
                            </div>
                            <div class="col-sm-12">
                                <i class="fa fa-user-plus"></i>&nbsp;<label class="control-label">کد دانش آموزی</label>
                                <span style="color: red;">*</span>
                                <input required type="text" placeholder="کد دانش آموزی" name="newUserCode" id="newUserCode" class="form-control" />      
                            </div>
                            <div class="col-sm-12">
                                <i class="fa fa-key"></i>&nbsp;<label class="control-label">کلمه عبور</label>
                                <span style="color: red;">*</span>
                                <input required type="password" placeholder="کلمه عبور" name="newUserPassword" id="newUserPassword" class="form-control" />      
                            </div>
                            <div class="col-sm-12">
                                <i class="fa fa-key"></i>&nbsp;<label class="control-label">تکرار کلمه عبور</label>
                                <span style="color: red;">*</span>
                                <input required type="password" placeholder="تکرار کلمه عبور" name="newUserPassword2" id="newUserPassword2" class="form-control" />
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" onclick="saveNewUser()">
                        <i class="fa fa-save"></i>&nbsp; ذخیره
                        <i class="fa fa-spin fa-spinner" id="newUserSaving" style="display: none;"></i>
                    </button>
                    <button class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-times-circle-o"></i>&nbsp; انصراف</button>

                </div>

            </div><!-- register new user modal form -->


        </div><!-- .container -->

    </body>
</html>