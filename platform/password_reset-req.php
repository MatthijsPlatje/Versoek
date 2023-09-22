<?PHP
require_once("./include/membersite_config.php");

if(isset($_POST['submitted']))
{
   $fgmembersite->RedirectToURL("login.php");
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
                <h2 style="color: #7448b1; font-size: 40px; text-align: center; margin-top: 0px; margin-bottom: 0px;">Reset paswoord</h2><hr>

                <div class="contact_form">
                    <form id='resetreq' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
                        <fieldset >
                        <input type='hidden' name='submitted' id='submitted' value='1'/>

                        <div style="text-align: center; color: #7448b1;"><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
                        <div class='container_field'>
                            <label for='email' >Your Email*:</label><br/>
                            <input type='text' name='email' id='email' value='<?php echo $fgmembersite->SafeDisplay('email') ?>' maxlength="50" /><br/>
                            <span id='resetreq_email_errorloc' class='error'></span>
                        </div>
                        
                        <div class='short_explanation'>* required fields</div>
                        <div class='container_field'>
                            <input type='submit' name='Submit' value='Submit' />
                        </div>

                        </fieldset>
                    </form>

                    <p style="text-align: center; margin-top: 60px;">Een link om je wachtwoord te resetten is naar jouw email adres gestuurd</p>
                </div>

                <div id="footer"></div>
            </div>

            <div class="launch_info_end"></div>
        </div>
        <script type='text/javascript'>
            var frmvalidator  = new Validator("resetreq");
            frmvalidator.EnableOnPageErrorDisplay();
            frmvalidator.EnableMsgsTogether();

            frmvalidator.addValidation("email","req","Please provide the email address used to sign-up");
            frmvalidator.addValidation("email","email","Please provide the email address used to sign-up");
        </script>
    </body>
</html>