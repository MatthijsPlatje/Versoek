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
                
                <h2 style="color: #7448b1; font-size: 40px; text-align: center; margin-top: 0px; margin-bottom: 0px;">Mijn verzoeken</h2><hr>

                <button style="margin-left: 20px" onclick="window.location.href='platform/start.php';" class="button_back">Terug</button>
                <table>
                    <?php
                        $query = $fgmembersite->GetMyRequests();
                        while ($row = sqlsrv_fetch_array($query))
                        {
                    ?>

                        <tr>
                            <td>
                                <button onclick="window.location.href='platform/my_request_details.php?item_name=<?php echo $row['item_name'];?>&item_description=<?php echo $row['item_description'];?>&item_location=<?php echo $row['item_location'];?>&item_destination=<?php echo $row['item_destination'];?>&item_status=<?php echo $row['accepted'];?>';" class="button_request"><?php echo $row['item_name'];?></button>
                            </td>
                            <td style="width: 10%">
                                <?php echo ($row['accepted'] == 0 ? "" : "<img src='../images/check.png' alt='check'>");?>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                </table>

                <div style="text-align: right;"><button style="margin-right: 20px;" onclick="window.location.href='platform/my_request_add.php';" class="button_add">Nieuw</button></div>
            </div>

            <div class="launch_info_end"></div>

            <div id="footer"></div>
        </div>
    </body>
</html>