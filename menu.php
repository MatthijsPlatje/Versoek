<?PHP
    require_once("./include/membersite_config.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Versoek</title>
        <base href="\">
        <link rel="icon" href="../images/smile_icon.png">
        <!--<meta name="viewport" content="width=1080px, initial-scale=1" />-->
        
        <!-- Start Open Web Analytics Tracker -->
        <!-- <script type="text/javascript">
            //<![CDATA[
            var owa_baseUrl = 'http://localhost/owa/';
            var owa_cmds = owa_cmds || [];
            owa_cmds.push(['setSiteId', '37e7083655c389a191cce4679732790e']);
            owa_cmds.push(['trackPageView']);
            owa_cmds.push(['trackClicks']);
            
            (function() {
                var _owa = document.createElement('script'); _owa.type = 'text/javascript'; _owa.async = true;
                owa_baseUrl = ('https:' == document.location.protocol ? window.owa_baseSecUrl || owa_baseUrl.replace(/http:/, 'https:') : owa_baseUrl );
                _owa.src = owa_baseUrl + 'modules/base/dist/owa.tracker.js';
                var _owa_s = document.getElementsByTagName('script')[0]; _owa_s.parentNode.insertBefore(_owa, _owa_s);
            }());
            //]]>
        </script> -->
        <!-- End Open Web Analytics Code -->

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-PB4XM1H6N0"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-PB4XM1H6N0');
        </script>

        <div id="consent-popup" class="hidden disabled">
            <p>
               Wil jij een cookie van ons? Voor meer informatie, lees onze <a href="terms.html" style="color: #fff;">voorwaarden</a>.<br>
               <a id="denied" href="#" style="color: rgb(252, 244, 164);">Nee bedankt, ik haat cookies!</a> <a id="accept" href="#">Ja graag, ik hou van cookies!</a>
            </p>
        </div>
        <script src="javascript/cookies.js"></script>
    </head>

    <body>
        <div class="container_nav">
            <div class="nav_img">
                <?php 
                    $isLoggedIn = $fgmembersite->CheckLogin();
                    $isAdmin = ($fgmembersite->IsAdmin() > 0);
                    $label = ($isLoggedIn ? "Logout" : "Login");
                    $link = ($isLoggedIn ? "platform/logout.php" : "platform/login.php");
                ?>

                <!--<a href="https://www.smiles-living-lab.nl/"><img src="../images/Logo_smiles_RGB_StudioTW.webp" alt="smiles logo"></a>-->
                <a href="index.php"><i class="fa fa-home fa_custom" style="position: absolute; margin-left: 10px; margin-top: 10px; font-size: 48px; color: white;"></i></a>
                <!-- <p class="welcome_name"><?php echo ($isLoggedIn ? "Hallo ".($fgmembersite->UserFullName()) : "") ?></p> -->
                <a class="welcome_name" href="platform/start.php"> <?php echo ($isLoggedIn ? "Hallo ".($fgmembersite->UserFullName()) : "") ?></a>
                        
                <div class="nav_container">
                    <div class="nav">
                        <a href="about_us.html">OVER ONS</a>
                        <a href="launch.html">DE LANCERING</a>
                        <a href="contact.html">CONTACT</a>
                        <?php echo (($isAdmin && $isLoggedIn) ? "<a class='voor_jou' href='admin.php'>ADMIN</a>" : "") ?>
                        <a class="contact" href=<?php echo $link ?>><?php echo $label ?></a>
                    </div>
                </div>
            </div>
            <main>
                <!--
                <p style="margin-top: 12px; margin-bottom: 4px; color: white; background-color: orange; font-weight: bold;">De website wordt op dit moment ontwikkeld</p>
                <p style="margin-top: 4px; margin-bottom: 12px; color: white; background-color: orange; font-weight: bold;">Nog niet alles is functioneel of visueel in orde</p> 
                -->

                <h1>Versoek</h1>
                <p>Het vriendelijke bezorg platform</p>
                <a class="voor_jou" href="for_you.html">Voor jou!</a>
                <a class="door_jou" href="by_you.html">Door jou!</a>
            </main>
            <div class="main_end"></div>
        </div>
    </body>
</html>