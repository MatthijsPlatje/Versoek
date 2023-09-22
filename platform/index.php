<?PHP
    require_once("./include/membersite_config.php");

    if(!$fgmembersite->CheckLogin())
    {
        $fgmembersite->RedirectToURL("login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Versoek</title>
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
                
            <h2 style="color: #7448b1; font-size: 40px; text-align: center; margin-top: 0px; margin-bottom: 0px;">Start pagina</h2><hr>
                
                <table style="padding-bottom: 25px;">
                    <tr>
                        <td><button onclick="window.location.href='platform/my_requests.php';" class="button_start_page">Mijn verzoeken</button></td>
                    </tr>
                    
                    <tr>
                        <td><button onclick="window.location.href='platform/others_requests.php';" class="button_start_page">Vriend verzoeken</button></td>
                    </tr>
                    <tr>
                        <td><button onclick="window.location.href='platform/todo.php';" class="button_start_page">ToDo lijst</button></td>
                    </tr>
                    <tr>
                        <td><button onclick="window.location.href='platform/my_settings.php';" class="button_start_page">Instellingen</button></td>
                    </tr>    
                </table>
            </div>

            <div class="launch_info_end"></div>

            <div id="footer"></div>
        </div>
    </body>
</html>