<?PHP
    require_once("./include/membersite_config.php");

    if(isset($_POST['submitted']))
    {
        if($fgmembersite->Login())
        {
            $fgmembersite->RedirectToURL("start.php");
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
    </head>

    <body>
        <div id="menu"></div>

        <div class="container">
            <div class="launch_info">
                <h2 style="color: #7448b1; font-size: 40px; text-align: center; margin-top: 0px; margin-bottom: 0px;">Inloggen</h2><hr>

                <div class="contact_form" style="padding-bottom: 32px;">
                    <form id='login' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
                        <fieldset >
                            <input type='hidden' name='submitted' id='submitted' value='1'/>

                            <div style="text-align: center; color: #7448b1;"><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
                            <div class='container_field'>
                                <label for='username' >UserName*:</label><br/>
                                <input type='text' name='username' id='username' value='<?php echo $fgmembersite->SafeDisplay('username') ?>' maxlength="50" /><br/>
                                <span id='login_username_errorloc' class='error'></span>
                            </div>
                            <div class='container_field'>
                                <label for='password' >Password*:</label><br/>
                                <input type='password' name='password' id='password' maxlength="50" /><br/>
                                <span id='login_password_errorloc' class='error'></span>
                            </div>

                            <div class='short_explanation'>* required fields</div>

                            <div class='container_field'>
                                <input type='submit' name='Submit' value='Login' />
                            </div>
                        </fieldset>
                    </form>

                    <p style="text-align: center; margin-top: 60px;"><a href='platform/password_reset-req.php'>Paswoord vergeten?</a></p>
                    <p style="text-align: center; margin-top: 0px; padding-bottom: 20px;">Nog geen account? <a href="platform/create_account.php">Maak hier een aan!</a></p>
                </div>
            </div>

            <div class="launch_info_end" style="margin-top: 0px;"></div>
            <div id="footer"></div>
        </div>

        <script type='text/javascript'>
            var frmvalidator  = new Validator("login");
            frmvalidator.EnableOnPageErrorDisplay();
            frmvalidator.EnableMsgsTogether();

            frmvalidator.addValidation("username","req","Please provide your username");
            frmvalidator.addValidation("password","req","Please provide the password");
        </script>
    </body>
</html>