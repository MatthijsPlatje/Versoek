<?PHP
    require_once("./include/membersite_config.php");
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

        <div class="container4">
            <div class="launch_info_end"></div>

                <h2 style="color: #7448b1; font-size: 40px; text-align: center; margin-top: 25px; margin-bottom: 0px;">Nieuwsberichten</h2><hr>

                <?php
                    $query = $fgmembersite->GetNewsItems();
                    $div_end = false;
                    $index = 0;
                    while ($row = sqlsrv_fetch_array($query))
                    {
                        $div_end = false;
                        
                        $index++;
                        if($index > 3)
                            $index = 1;

                        if($index == 1)
                            echo '<div class="flex-container-4" style="padding-top: 50px; padding-bottom: 100px;">';
                ?>

                <div class="flex-child-4 <?php echo ($index == 1 ? 'left' : ($index == 2 ? 'middle' : 'right'));?>">
                    <img src="news/images/<?php echo $row['image'];?>" width="100%" alt="Bezorger">
                    <h2><?php echo $row['title'];?></h2>
                    <p><?php echo $row['text'];?></p>
                    <a href="news/<?php echo $row['url'];?>">Lees meer</a>
                    <hr>
                    <p class="date_of_article">&#x1F4C5 <?php echo $row['published']->format('d/m/Y');?></p>
                </div>
            
                <?php
                    if($index == 3)
                    {
                        echo '</div>';
                        $div_end = true;
                    }
                }
                ?>

            <?php
                if($div_end == false)
                    echo '</div>';
            ?>

            <button onclick="window.location.href='index.php';" class="button_meld_aan" style="margin-top: 0px; padding-bottom: 50px; position: absolute; left: 50%; -ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%);">Home pagina</button>

            <div class="main_end2"></div>
            <div class="page_end"></div>
            <div id="footer"></div>
        </div>
    </body>
</html>