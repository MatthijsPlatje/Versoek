<?PHP
    require_once("./include/membersite_config.php");

    if(!$fgmembersite->CheckLogin())
    {
        $fgmembersite->RedirectToURL("login.php");
        exit;
    }

    if(isset($_POST['submitted']))
    {
        if($_POST['submitted'] == 1)
        {
            $result = $fgmembersite->RemoveFromContacts();

            if($result)
            {
                $fgmembersite->RedirectToURL("contacts_remove_successful.html");
            }
            else 
            {
                $fgmembersite->RedirectToURL("contacts_remove_not_successful.html");
            }
        }
        else if($_POST['submitted'] == 2)
        {
            $fgmembersite->RedirectToURL("contacts_manage.php");
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
                <h2 style="color: #7448b1; font-size: 40px; text-align: center; margin-top: 0px; margin-bottom: 0px;">Contact verwijderen</h2><hr>

                <div class="contact_form">
                    <form action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
                        <input type='hidden' name='submitted' id='submitted' value='1'/>
                        <input type="hidden" id="contact_id" name="contact_id"/>
                        <input type="hidden" id="contact_name" name="contact_name"/>

                        <h2 style="text-align: center;">Gebruiker</h2>
                        <h2 style="text-align: center; margin: 8px; color: #7448b1;" id="visible_contact_name"></h2>
                        <h2 style="text-align: center;">verwijderen uit jouw contacten?</p>

                        <script>
                            var url_string = window.location.href;
                            var url = new URL(url_string);

                            var contact_id = url.searchParams.get("contact_id");
                            if(contact_id) document.getElementById("contact_id").value = contact_id;
                            
                            var contact_name = url.searchParams.get("contact_name");
                            if(contact_name) document.getElementById("visible_contact_name").innerHTML = contact_name;
                            if(contact_name) document.getElementById("contact_name").value = contact_name;
                        </script>

                        <div style="display: flex;">
                            <div style="flex: 1; text-align: left;"><button style="margin-left: 40px;" onclick="returnWithoutSubmit()" class="button_add">Nee</button></div>
                            <div style="text-align: right;"><input style="margin-right: 20px;" type="submit" class="button_add" value="Ja!"></div>
                        </div>

                        <script>
                            function returnWithoutSubmit()
                            {
                                document.getElementById("submitted").value = '2';
                            }
                        </script>
                    </form>
                </div>
            </div>

            <div class="launch_info_end"></div>

            <div id="footer"></div>
        </div>
    </body>
</html>