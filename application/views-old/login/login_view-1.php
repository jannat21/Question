<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> </title>

        <link href='<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css' rel="stylesheet">
        <!--[if lt IE 9]>
            <script src='<?php echo base_url(); ?>assets/js/html5.js'></script>
        <![endif]-->

        <!-- script references -->
        <script src='<?php echo base_url(); ?>assets/js/jquery-1.10.2.min.js'></script>
        
    </head>

    <body >
        <script language="javascript" type="text/javascript">
            function login() {
                $('.req').parent().parent().removeClass('has-error');
                $('.req').parent().parent().children('span').removeClass('glyphicon-remove');
                var error = 0;
                var codep = $('#codep').val();
                codep = codep.trim();
                if (codep == "" || codep == null)
                {
                    $('#codep').parent().parent().addClass('has-error');
                    $('#codep').parent().parent().children('span').addClass('glyphicon-remove');
                    error = 1;
                }
                var password = $('#password').val();
                password = password.trim();
                if (password == "" || password == null)
                {
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
            .login-form{
                max-width:300px;
                margin:0 auto;	
            }
            #codep {
                margin-bottom: -1px;
                border-bottom-right-radius: 0;
                border-bottom-left-radius: 0;
            }
            #password {
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
            .form-group{
                margin:0px;	
                font-family:'Droid Arabic Naskh'
            }

        </style>


        <div id="main" class="container">
            <div id="content" class="raise text-center">
                
                <br><br><br><br><br>

                <form action='<?php echo base_url(); ?>index.php/login/verify_login' method='post' name='login_form' id="login_form" class="login-form">            
                    <div class="logo text-center" >
                        <div style="margin:0 auto;" class="text-center">
                            <img class="img-responsive img-rounded" src='<?php echo base_url(); ?>assets/img/1.jpg' style="margin:0 auto;" />
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
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user text-info"></i></span>
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
            </div><!--raise-->
        </div><!-- .container -->

    </body>
</html>