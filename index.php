<?PHP
    require_once("./include/membersite_config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--<meta name="viewport" content="width=1080px, initial-scale=1" />-->

    <title>Versoek Crowd Delivery</title>
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
    <script src="https://cdn.logwork.com/widget/countdown.js"></script>
</head>

<body>
    <div id="menu"></div>

    <div class="container">
        <div class="launch_info">
            <div class="flex-container">
                <div class="flex-child left">
                    <p class="eind2024">Het platform is in volle ontwikkeling</p>
                    <p>Ben jij benieuwd wat het inhoud en wil jij op de hoogte gehouden worden van de ontwikkelingen? Lees meer en meld je aan voor de nieuwsbrief!</p>
                    <div class="flex-container-2">
                        <div class="flex-child-2 left">
                            <button onclick="window.location.href='about_us.html';" class="button_lees_meer">Lees meer over SMiLES!</button>
                        </div>
                        <div class="flex-child-2 right">
                            <button onclick="window.location.href='apply_newsletter.html';" class="button_meld_aan">Meld je aan!</button>
                        </div>
                    </div>
                </div>

                <div class="flex-child right" style="font-size: 40px">
                    <a href="https://logwork.com/countdown-wqwg" class="countdown-timer" data-timezone="Europe/Amsterdam" data-textcolor="#000000" data-date="2024-01-01 12:00" data-background="#ffffff" data-digitscolor="#000000" data-unitscolor="#ffffff">Tijd tot launch</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container2">
        <div class="launch_info_end"></div>

        <div class="flex-container-3">
            <div class="flex-child-3 left">
                <img src="../images/bezorger3.jpg" width="100%" alt="Bezorger" style="opacity: 0.5">
                <h2>Bezorger</h2>
                <p>Wil jij pakketjes gaan ophalen en bezorgen op jouw route? Lees dan meer over de voordelen hiervan</p>
                <button onclick="window.location.href='by_you.html';" class="button_lees_meer">Klik hier</button>
            </div>

            <div class="flex-child-3 right">
                <img src="../images/consument4.jpg" width="100%" alt="Consument" style="opacity: 0.5">
                <h2>Consument</h2>
                <p>Wil jij pakketjes bestellen op een verantwoordelijke wijze? Lees dan meer over de positieve gevolgen hiervan</p>
                <button onclick="window.location.href='for_you.html';" class="button_lees_meer">Klik hier</button>
            </div>
        </div>
    </div>

    <div class="container3">
        <div class="container3_begin"></div>
            <div class="join_community">
                <p class="join_title">Join the community!</p>
                <p class="join_text">Wil jij deel uitmaken van ons platform?</p>
                <p class="join_text">Meld je dan aan om op de hoogte gehouden te worden!</p>
                <button onclick="window.location.href='apply_newsletter.html';" class="button_meld_aan" style="margin-top: 20px;">Meld je aan!</button>
            </div>
        <div class="container3_end"></div>
    </div>

    <div class="container4">
        <div class="container4-div">
            <h2>Onze actuele berichten</h2>
        </div>

        <div class="flex-container-4">
            <?php
                $query = $fgmembersite->GetNewsItems();
                
                $index = 0;
                while ($row = sqlsrv_fetch_array($query))
                {
                    $index++;
                    if($index > 3)
                        break;
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
                }
            ?>
        </div>

        <div class="container4-div-end">
            <button onclick="window.location.href='news.php';" class="button_lees_meer">Lees meer nieuws berichten</button>
        </div>

        <div class="main_end2"></div>
        <div class="page_end"></div>
        <div id="footer"></div>
    </div>
</body>
</html>