<?PHP
    require_once("./include/membersite_config.php");

    if(isset($_POST['submitted']))
    {
        $result = $fgmembersite->RegisterUser();
        if($result)
        {
            $fgmembersite->RedirectToURL("create_account_email_sent.html");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Versoek - maak account</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
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
                <h2 style="color: #7448b1; font-size: 40px; text-align: center; margin-top: 0px; margin-bottom: 0px;">Nieuw account aanmaken</h2><hr>

                <div class="contact_form">
                    <!-- Form Code Start -->
                    <form id='register' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
                        <fieldset >
                            <input type='hidden' name='submitted' id='submitted' value='1'/>
                            <input type='text'  class='spmhidip' name='<?php echo $fgmembersite->GetSpamTrapInputName(); ?>' />

                            <div style="text-align: center; color: #7448b1;"><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
                            <div class='container_field'>
                                <label for='name' >Jouw volledige naam*: </label><br/>
                                <input type='text' name='name' id='name' value='<?php echo $fgmembersite->SafeDisplay('name') ?>' maxlength="50" /><br/>
                                <span id='register_name_errorloc' class='error'></span>
                            </div>
                            <div class='container_field'>
                                <label for='email' >Email Adres*:</label><br/>
                                <input type='text' name='email' id='email' value='<?php echo $fgmembersite->SafeDisplay('email') ?>' maxlength="50" /><br/>
                                <span id='register_email_errorloc' class='error'></span>
                            </div>
                            <div class='container_field'>
                                <label for='username' >Gebruikersnaam*:</label><br/>
                                <input type='text' name='username' id='username' value='<?php echo $fgmembersite->SafeDisplay('username') ?>' maxlength="50" /><br/>
                                <span id='register_username_errorloc' class='error'></span>
                            </div>
                            <div class='container_field' style='height:80px;'>
                                <label for='password' >Paswoord*:</label><br/>
                                <div class='pwdwidgetdiv' id='thepwddiv' ></div>
                                <input type='password' name='password' id='password' maxlength="50" />
                                <i class="bi bi-eye-slash" id="togglePasswordEye"></i>
                                <div id='register_password_errorloc' class='error' style='clear:both'></div>
                            </div>

                            <div class='short_explanation'>* required fields</div>

                            <div class='checkbox_ok_to_contact' style="margin-top: 32px; text-align: left;">
                                <label for='checkbox_ok'>Ik wil meewerken aan het onderzoek</label>
                                <input type='checkbox' name='checkbox_ok' id='checkbox_ok' style="float:left"/>
                            </div>
                            <div class='checkbox_ok_to_contact' style="margin-top: 4px; text-align: left;">
                                <label for='checkbox_ok2'>Ik ga akkoord met de <a href="platform/terms.html" style="color: #7448b1">voorwaarden</a></label>
                                <input type='checkbox' name='checkbox_ok2' id='checkbox_ok2' style="float:left"/>
                            </div>

                            <div class='container_field' style="margin-top: 12px; margin-bottom: 12px; text-align: left;">
                                <input type='submit' name='Submit' value='Aanmaken' />
                            </div>

                        </fieldset>
                    </form>
                </div>
            </div>

            <div class="launch_info_end"></div>

            <div id="footer"></div>
        </div>

        <script type='text/javascript'>
            var frmvalidator  = new Validator("register");
            frmvalidator.EnableOnPageErrorDisplay();
            frmvalidator.EnableMsgsTogether();

            frmvalidator.addValidation("name","req","Please provide your full name");
            frmvalidator.addValidation("email","req","Please provide your email address");
            frmvalidator.addValidation("username","req","Please provide your username");
            frmvalidator.addValidation("password","req","Please provide the password");
        </script>
    </body>
</html>