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
                
                <h2 style="color: #7448b1; font-size: 40px; text-align: center; margin-top: 0px; margin-bottom: 0px;">Mijn gegevens</h2><hr>

                <button style="margin-left: 20px" onclick="window.location.href='platform/my_settings.php';" class="button_back">Terug</button>
                
                <?php
                    $query = $fgmembersite->GetMyDetails(); 
                    if(!$query || !isset($query))
                        $row = array("user_name" => "unknown", "full_name" => "", "email" => "", "phone" => "");
                    else
                        $row = $query[0];
                ?>
                        
                <table>
                    <tr>
                        <td style="background-color: rgb(61, 204, 209); border: 1px solid black; border-radius: 10px;"><h2 style="background-color: rgb(61, 204, 209); margin: 8px;">Login naam:</h2></td>
                        <td style="border: 1px solid black; border-radius: 10px;"><h2 style="text-align: right; margin: 8px;"><?php echo $row['user_name']; ?></h2></td>
                    </tr>
                    <tr>
                        <td style="background-color: rgb(61, 204, 209); border: 1px solid black; border-radius: 10px;"><h2 style="background-color: rgb(61, 204, 209); margin: 8px;">Volledige Naam:</h2></td>
                        <td style="border: 1px solid black; border-radius: 10px;"><h2 style="text-align: right; margin: 8px;"><?php echo $row["full_name"]; ?></h2></td>
                    </tr>
                    <tr>
                        <td style="background-color: rgb(61, 204, 209); border: 1px solid black; border-radius: 10px;"><h2 style="margin: 8px;">E-mail:</h2></td>
                        <td style="border: 1px solid black; border-radius: 10px;"><h2 style="text-align: right; margin: 8px;"><?php echo $row["email"]; ?></h2></td>
                    </tr>
                    <tr>
                        <td style="background-color: rgb(61, 204, 209); border: 1px solid black; border-radius: 10px;"><h2 style="margin: 8px;">Telefoon:</h2></td>
                        <td style="border: 1px solid black; border-radius: 10px;"><h2 style="text-align: right; margin: 8px;"><?php echo $row["phone"]; ?></h2></td>
                    </tr>
                </table>
            </div>

            <div class="launch_info_end"></div>

            <div id="footer"></div>
        </div>
    </body>
</html>