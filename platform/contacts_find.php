<?PHP
    require_once("./include/membersite_config.php");

    if(!$fgmembersite->CheckLogin())
    {
        $fgmembersite->RedirectToURL("login.php");
        exit;
    }

    if(isset($_POST['submitted']))
    {
        $contact_found = $fgmembersite->FindContactInMembersDatabase();

        if($contact_found[0])
        {
            if($contact_found[1])
            {
                $fgmembersite->RedirectToURL("contacts_already_exists.html?contact_name=".$contact_found[3]);
            }
            else
            {
                $fgmembersite->RedirectToURL("contacts_found.php?contact_id=".$contact_found[2]."&contact_name=".$contact_found[3]);
            }
        }
        else 
        {
            //echo ($fgmembersite->GetErrorMessage());
            $fgmembersite->RedirectToURL("contacts_invite.php?contact_name=".$contact_found[3]);
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
    </head>

    <body>
        <div id="menu"></div>

        <div class="container">
            <div class="launch_info">
                <h2 style="color: #7448b1; font-size: 40px; text-align: center; margin-top: 0px; margin-bottom: 0px;">Gebruiker zoeken</h2><hr>

                <button style="margin-left: 20px" onclick="window.location.href='platform/contacts_manage.php';" class="button_back">Terug</button>
                <div class="contact_form">
                    <h2 style="text-align: center;">Zoek op gebruikersnaam:</h2>

                    <form action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
                        <input type='hidden' name='submitted' id='submitted' value='1'/>

                        <label for="contact_name">Gebruikersnaam</label>
                        <input type="text" id="contact_name" name="contact_name" placeholder="Gebruikersnaam">

                        <div style="text-align: right;"><input style="margin-right: 20px;" type="submit" class="button_add" value="Zoek gebruiker"></div>
                    
                    </form>

                    <div id="contact_find_result"></div>
                </div>
            </div>

            <div class="launch_info_end"></div>
            
            <div id="footer"></div>
        </div>
    </body>
</html>