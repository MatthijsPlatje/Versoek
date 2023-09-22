<?PHP
require_once("./include/membersite_config.php");

if(isset($_GET['code']))
{
   if($fgmembersite->ConfirmUser())
   {
        $fgmembersite->RedirectToURL("create_account_ready.html");
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
        <script src="javascript/gen_validatorv31.js" type="text/javascript"></script>  
    </head>

    <body>
        <div id="menu"></div>

        <div class="container">
            <div class="launch_info">
                <h2 style="color: #7448b1; font-size: 40px; text-align: center; margin-top: 0px; margin-bottom: 0px;">Account bevestigen</h2><hr>

                <div class="contact_form">
                    <!-- Form Code Start -->
                    <form id='confirm' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='get' accept-charset='UTF-8'>
                    <div style="text-align: center; color: #7448b1;"><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
                        <div class='container_field'>
                            <label for='code' >Confirmation Code:* </label><br/>
                            <input type='text' name='code' id='code' maxlength="50" /><br/>
                            <span id='register_code_errorloc' class='error'></span>
                        </div>

                        <div class='short_explanation'>* required fields</div>

                        <div class='container_field'>
                            <input type='submit' name='Submit' value='Submit' />
                        </div>
                    </form>
                </div>
            </div>

            <div class="launch_info_end"></div>

            <div id="footer"></div>
        </div>

        <!-- client-side Form Validations:
        Uses the excellent form validation script from JavaScript-coder.com-->
        <script type='text/javascript'>
            var frmvalidator  = new Validator("confirm");
            frmvalidator.EnableOnPageErrorDisplay();
            frmvalidator.EnableMsgsTogether();
            frmvalidator.addValidation("code","req","Please enter the confirmation code");
        </script>
    </body>
</html>