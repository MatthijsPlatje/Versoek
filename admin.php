<?PHP
    require_once("./include/membersite_config.php");

    if(!($fgmembersite->CheckLogin() && $fgmembersite->IsAdmin()))
    {
        $fgmembersite->RedirectToURL("../platform/login.php");
        exit;
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
                
                <h2 style="color: #7448b1; font-size: 40px; text-align: center; margin-top: 25px; margin-bottom: 0px;">Database data</h2><hr>

                <div class="contact_form" style="text-align: justify;">
                    <div style="text-align: center;">
                        <p>Number of users</p><br>
                        <img src="images/fake_graph.png" style="margin-bottom: 10px;" height="320px" alt="graph"></a>
                        <hr style="margin-top: 10px; margin-bottom: 10px;">
                        <p>Total number of requests</p><br>
                        <img src="images/fake_graph.png" style="margin-bottom: 10px;" height="320px" alt="graph"></a>
                        <hr style="margin-top: 10px; margin-bottom: 10px;">
                        <p>Number of open requests</p><br>
                        <img src="images/fake_graph.png" style="margin-bottom: 10px;" height="320px" alt="graph"></a>
                        <hr style="margin-top: 10px; margin-bottom: 10px;">
                        <p>Number of finalized requests</p><br>
                        <img src="images/fake_graph.png" style="margin-bottom: 10px;" height="320px" alt="graph"></a>
                        <hr style="margin-top: 10px; margin-bottom: 10px;">
                        <p>Number of newsletter subscribers</p><br>
                        <img src="images/fake_graph.png" style="margin-bottom: 10px;" height="320px" alt="graph"></a>
                    </div>
                </div>
            </div>

            <div class="page_end"></div>
            <div id="footer"></div>
        </div>
    </body>
</html>