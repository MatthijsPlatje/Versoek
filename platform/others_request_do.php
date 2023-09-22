<?PHP
    require_once("./include/membersite_config.php");

    if(!$fgmembersite->CheckLogin())
    {
        $fgmembersite->RedirectToURL("login.php");
        exit;
    }

    if(isset($_POST['submitted']))
    {
        if($fgmembersite->AddToTODO())
        {
            $fgmembersite->RedirectToURL("todo.php");
        }
        else 
        {
            echo ($fgmembersite->GetErrorMessage());
            $fgmembersite->RedirectToURL("others_request_do_not_successful.html");
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
                <h2 style="color: #7448b1; font-size: 40px; text-align: center; margin-top: 0px; margin-bottom: 0px;">Verzoek accepteren</h2><hr>

                <button style="margin-left: 20px" onclick="window.location.href='platform/others_requests.php';" class="button_back">Terug</button>
                <div class="contact_form">
                <form action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
                        <input type='hidden' name='submitted' id='submitted' value='1'/>
                        <input type="hidden" id="request_id" name="request_id"/>

                        <h2 style="text-align: center;">Weet je zeker dat je het verzoek</h2>
                        <h2 style="text-align: center; color: #7448b1;" id="request_name"></h2>
                        <h2 style="text-align: center;">van</h2><h2 style="text-align: center; color: #7448b1;" id="contact_name"></h2>
                        <h2 style="text-align: center;">accepteerd?</h2>

                        <script>
                            var url_string = window.location.href;
                            var url = new URL(url_string);

                            var contact_name = url.searchParams.get("contact_name");
                            if(contact_name) document.getElementById("contact_name").innerHTML = contact_name;
                            
                            var request_name = url.searchParams.get("request_name");
                            if(request_name) document.getElementById("request_name").innerHTML = request_name;
                            
                            var request_id = url.searchParams.get("request_id");
                            if(request_id) document.getElementById("request_id").value = request_id;
                        </script>
                    
                        <div style="text-align: right;"><input style="margin-right: 20px;" type="submit" class="button_add" value="Doe ik!"></div>
                    </form>
                </div>
            </div>

            <div class="launch_info_end"></div>
            
            <div id="footer"></div>
        </div>
    </body>
</html>