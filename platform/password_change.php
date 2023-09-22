<?PHP
    require_once("./include/membersite_config.php");

    if(!$fgmembersite->CheckLogin())
    {
        $fgmembersite->RedirectToURL("login.php");
        exit;
    }

    if(isset($_POST['submitted']))
    {
        if($fgmembersite->ChangePassword())
        {
            $fgmembersite->RedirectToURL("password_changed.html");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SM!LES Crowd Delivery</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <style type="text/css"> .fa_custom { color: white } </style>
        <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous">
        </script>
        <script>  
            $(function(){ 
                $("#menu").load("menu.php");  
            }); 
        </script> 
        <script>  
            $(function(){ 
                $("#footer").load("footer.html");  
            }); 
        </script> 
        <script type='text/javascript' src='javascript/gen_validatorv31.js'></script>
        <script src="javascript/pwdwidget.js" type="text/javascript"></script>  
    </head>

    <body>
        <div id="menu"></div>

        <div class="container">
            <div class="launch_info">
                <h2 style="color: #7448b1; font-size: 40px; text-align: center; margin-top: 0px; margin-bottom: 0px;">Wachtwoord wijzigen</h2><hr>

                <div class="contact_form">
                    <form id='changepwd' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
                        <fieldset >
                            <input type='hidden' name='submitted' id='submitted' value='1'/>

                            <div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
                            <div class='container_field'>
                                <label for='oldpwd' >Old Password*:</label><br/>
                                <div class='pwdwidgetdiv' id='oldpwddiv' ></div><br/>
                                <noscript>
                                <input type='password' name='oldpwd' id='oldpwd' maxlength="50" />
                                </noscript>    
                                <span id='changepwd_oldpwd_errorloc' class='error'></span>
                            </div>

                            <div class='container_field'>
                                <label for='newpwd' >New Password*:</label><br/>
                                <div class='pwdwidgetdiv' id='newpwddiv' ></div>
                                <noscript>
                                <input type='password' name='newpwd' id='newpwd' maxlength="50" /><br/>
                                </noscript>
                                <span id='changepwd_newpwd_errorloc' class='error'></span>
                            </div>

                            <div class='short_explanation'>* required fields</div>

                            <br>
                            <div class='container_field'>
                                <input type='submit' name='Submit' value='Submit' />
                            </div>

                        </fieldset>
                    </form>
                </div>
            </div>

            <div class="launch_info_end"></div>

            <div id="footer"></div>
        </div>

        <!-- client-side Form Validations:
        Uses the excellent form validation script from JavaScript-coder.com-->
        <script type='text/javascript'>
            var pwdwidget = new PasswordWidget('oldpwddiv','oldpwd');
            pwdwidget.enableGenerate = false;
            pwdwidget.enableShowStrength=false;
            pwdwidget.enableShowStrengthStr =false;
            pwdwidget.MakePWDWidget();
            
            var pwdwidget = new PasswordWidget('newpwddiv','newpwd');
            pwdwidget.MakePWDWidget();
            
            var frmvalidator  = new Validator("changepwd");
            frmvalidator.EnableOnPageErrorDisplay();
            frmvalidator.EnableMsgsTogether();

            frmvalidator.addValidation("oldpwd","req","Please provide your old password");
            frmvalidator.addValidation("newpwd","req","Please provide your new password");
        </script>
    </body>
</html>