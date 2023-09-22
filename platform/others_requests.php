<?PHP
    require_once("./include/membersite_config.php");

    if(!$fgmembersite->CheckLogin())
    {
        $fgmembersite->RedirectToURL("login.php");
        exit;
    }
?>

<?php
    function console_log($output, $with_script_tags = true) {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
        ');';
            if ($with_script_tags) {
                $js_code = '<script>' . $js_code . '</script>';
            }
        echo $js_code;
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
                <h2 style="color: #7448b1; font-size: 40px; text-align: center; margin-top: 0px; margin-bottom: 0px;">Verzoeken van contacten</h2><hr>
                
                <button style="margin-left: 20px" onclick="window.location.href='platform/start.php';" class="button_back">Terug</button>
                <table>
                    <?php
                        $query = $fgmembersite->GetRequestsFromContacts();
                        foreach ($query as &$row)
                        {
                    ?>

                        <tr>
                            <td>
                                <button style="margin-top: 10px;" onclick="window.location.href='platform/others_request_details.php?user_name=<?php echo $row['user_name'];?>&item_id=<?php echo $row['item_id'];?>&item_name=<?php echo $row['item_name'];?>&item_description=<?php echo $row['item_description'];?>&item_location=<?php echo $row['item_location'];?>';" class="button_start_page"><?php echo $row['user_name'];?> wil <?php echo $row['item_name'];?></button>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                </table>

                <div style="text-align: right;"><button style="margin-right: 20px; height: 72px;" onclick="window.location.href='platform/contacts_manage.php';" class="button_add"><h2 style="margin-top: 8px; margin-bottom: 8px;">+</h2></button></div>
            </div>

            <div class="launch_info_end"></div>

            <div id="footer"></div>
        </div>
    </body>
</html>