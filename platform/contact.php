<?PHP
    require_once("./include/membersite_config.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Versoek - Contact</title>
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

                <?php 
                    $isLoggedIn = $fgmembersite->CheckLogin();
                ?>
                
                <h2 style="color: #7448b1; font-size: 40px; text-align: center; margin-top: 25px; margin-bottom: 0px;">Stuur ons een bericht</h2><hr>

                <div class="contact_form">
                    <div class="status"></div>
                    <form action="#" id="subsFrm" method="post">
                        <label for="fname">Voornaam</label>
                        <input type="text" id="fname" name="firstname" placeholder="Voornaam..">
                    
                        <label for="lname">Achternaam</label>
                        <input type="text" id="lname" name="lastname" placeholder="Achternaam..">
                    
                        <label for="email">Email adres</label>
                        <input type="text" id="email" name="email" placeholder="name@example.com">
                    
                        <label for="subject">Bericht</label>
                        <textarea id="subject" name="subject" placeholder="Schrijf hier jouw bericht.." style="height:200px"></textarea>
                        
                        <!--TODO-->
                        <input type="hidden" id="user_id" name="user_id" placeholder=<?php echo ($isLoggedIn ? "".($fgmembersite->UserID()) : "?") ?>>
                    
                        <div class="join_community">
                            <input type="button" class="button_meld_aan" id="sendBtn" value="Verstuur" style="margin-top: 16px;">
                        </div>
                    </form>
                </div>
            </div>

            <div class="page_end"></div>
            <div id="footer"></div>
        </div>
        <script>
            $(document).ready(function(){
                $('#sendBtn').on('click', function()
                {
                    // Remove previous status message
                    $('.status').html('');

                    // Email and name regex
                    var regEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
                    var regName = /^[a-zA-Z]+$/;
                    
                    // Get input values
                    var fname = $('#fname').val();
                    var lname = $('#lname').val();
                    var email = $('#email').val();
                    var body = $('#subject').val();
                    
                    // Validate input fields
                    if(fname.trim() == '' )
                    {
                        alert('Please enter your first name.');
                        $('#fname').focus();
                        return false;
                    }
                    else if(lname.trim() == '' )
                    {
                        alert('Please enter your last name.');
                        $('#lname').focus();
                        return false;
                    }
                    else if (!regName.test(fname))
                    {
                        alert('Please enter a valid first name.');
                        $('#fname').focus();
                        return false;
                    }
                    else if (!regName.test(lname))
                    {
                        alert('Please enter a valid last name.');
                        $('#lname').focus();
                        return false;
                    }
                    else if(email.trim() == '' )
                    {
                        alert('Please enter your email.');
                        $('#email').focus();
                        return false;
                    }
                    else if(body.trim() == '' )
                    {
                        alert('Please type your message.');
                        $('#body').focus();
                        return false;
                    }
                    else if(email.trim() != '' && !regEmail.test(email))
                    {
                        alert('Please enter a valid email.');
                        $('#email').focus();
                        return false;
                    }
                    else
                    {
                        var jqxhr = $.post("email_subscription/subscription.php", {send_email:1, fname:fname, lname:lname, email:email, body:body}, function(data) {
                            if(data.endsWith("ok"))
                            {
                                $('#subsFrm')[0].reset();
                                $('.status').html('<p class="success">Bedankt voor je bericht!</p>');
                            }
                            else
                            {
                                $('.status').html('<p class="error">Er is iets mis gegaan!</p>');
                            }
                            $('#sendBtn').removeAttr("disabled");
                            $('.content-frm').css('opacity', '');
                        }).done(function(data) {
                            //nothing
                        }).fail(function(jqxhr, textStatus, errorThrown) {
                            alert("fail. status: " + textStatus);
                        })
                    }
                });
            });
        </script>
    </body>
</html>