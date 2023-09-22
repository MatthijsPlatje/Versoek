<?PHP
    require_once("./include/membersite_config.php");

    if(!$fgmembersite->CheckLogin())
    {
        $fgmembersite->RedirectToURL("login.php");
        exit;
    }

    if(isset($_POST['submitted']))
    {
        $contact_name = $_POST['contact_name'];
        $contact_email = $_POST['contact_email'];
        $fgmembersite->RedirectToURL("contacts_manage.php");
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
            <button style="margin-left: 20px" onclick="window.location.href='platform/contacts_manage.php';" class="button_back">Terug</button>
                <div class="contact_form">
                    <form action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
                        <input type='hidden' name='submitted' id='submitted' value='1'/>
                        <input type="hidden" id="send_email_to_contact_name" name="send_email_to_contact_name"/>                        

                        <?php $full_user_name = $fgmembersite->UserFullName(); ?>

                        <p>Hieronder staat het bericht dat verstuurt zal worden:</p>
                        <hr>

                        <h2 style="display: inline;">Beste </h2><h2 style="display: inline; color: #7448b1;" id="contact_name"></h2><h2 style="display: inline;">,</h2>
                        <br><br><br>
                        <h2 style="display: inline; color: #7448b1;" id="user_name"><?php echo $full_user_name;?></h2><h2 style="display: inline;"> nodigt jou uit om deel te nemen aan het Smile Platform!</h2>
                        <br>
                        <p>Klik <a href="index.php">hier</a> voor meer informatie over het platform</p>
                        <p>Of klik <a href="platform/create_account.php">hier</a> om direct een account aan te maken</p>
                        <br>
                        <p>Met vriendelijke groet,</p>
                        <p>Smiles Crowd</p>

                        <hr>

                        <label for="contact_email">Email adres van de persoon die je wil uitnodigen</label>
                        <input type="text" id="contact_email" name="contact_email" placeholder="Email adres">

                        <script>
                            var url_string = window.location.href;
                            var url = new URL(url_string);

                            var contact_name = url.searchParams.get("contact_name");
                            if(contact_name) document.getElementById("contact_name").innerHTML = contact_name;
                        </script>

                        <div style="text-align: right;"><input style="margin-right: 20px;" type="submit" class="button_add" value="Verstuur"></div>
                    
                    </form>
                </div>
            </div>

            <div class="launch_info_end"></div>
            
            <div id="footer"></div>
        </div>
    </body>
</html>