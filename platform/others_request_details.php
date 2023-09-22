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
                <h2 style="color: #7448b1; font-size: 40px; text-align: center; margin-top: 0px; margin-bottom: 0px;">Verzoek details</h2><hr>
                
                <button style="margin-left: 20px;" onclick="window.location.href='platform/others_requests.php';" class="button_back">Terug</button>

                <div class="contact_form">
                    <form action="action_page.php">

                        <table style="margin-left: 0%; width: 100%;">
                            <tr>
                                <td style="background-color: rgb(61, 204, 209); border: 1px solid black; border-radius: 10px;"><h2 style="margin: 8px;">Persoon:</h2></td>
                                <td style="background-color: rgb(255, 255, 255); border: 1px solid black; border-radius: 10px;"><h2 style="text-align: right; margin: 8px;" id="user_name"></h2></td>
                            </tr>
                            <tr>
                                <td style="background-color: rgb(61, 204, 209); border: 1px solid black; border-radius: 10px;"><h2 style="margin: 8px;">Wil:</h2></td>
                                <td style="background-color: rgb(255, 255, 255); border: 1px solid black; border-radius: 10px;"><h2 style="text-align: right; margin: 8px;" id="item_name"></h2></td>
                            </tr>
                            <tr>
                                <td style="background-color: rgb(61, 204, 209); border: 1px solid black; border-radius: 10px;"><h2 style="margin: 8px;">Omschrijving:</h2></td>
                                <td style="background-color: rgb(255, 255, 255); border: 1px solid black; border-radius: 10px;"><h2 style="text-align: right; margin: 8px;" id="item_description"></h2></td>
                            </tr>
                            <tr>
                                <td style="background-color: rgb(61, 204, 209); border: 1px solid black; border-radius: 10px;"><h2 style="margin: 8px;">Locatie:</h2></td>
                                <td style="background-color: rgb(255, 255, 255); border: 1px solid black; border-radius: 10px;"><h2 style="text-align: right; margin: 8px;" id="item_location"></h2></td>
                            </tr>
                            <tr>
                                <td style="background-color: rgb(61, 204, 209); border: 1px solid black; border-radius: 10px;"><h2 style="margin: 8px;">Prijs:</h2></td>
                                <td style="background-color: rgb(255, 255, 255); border: 1px solid black; border-radius: 10px;"><h2 style="text-align: right; margin: 8px;" id="item_price"></h2></td>
                            </tr>
                            <tr>
                                <td style="background-color: rgb(61, 204, 209); border: 1px solid black; border-radius: 10px;"><h2 style="margin: 8px;">Wanneer:</h2></td>
                                <td style="background-color: rgb(255, 255, 255); border: 1px solid black; border-radius: 10px;"><h2 style="text-align: right; margin: 8px;" id="item_date"></h2></td>
                            </tr>
                        </table>

                        <script>
                            var url_string = window.location.href;
                            var url = new URL(url_string);

                            var user_name = url.searchParams.get("user_name");
                            if(user_name) document.getElementById("user_name").innerHTML = user_name;

                            var item_name = url.searchParams.get("item_name");
                            if(item_name) document.getElementById("item_name").innerHTML = item_name;

                            var item_description = url.searchParams.get("item_description");
                            if(item_description) document.getElementById("item_description").innerHTML = item_description;

                            var item_location = url.searchParams.get("item_location");
                            if(item_location) document.getElementById("item_location").innerHTML = item_location;

                            var item_price = url.searchParams.get("item_price");
                            if(item_price) document.getElementById("item_price").innerHTML = item_price;

                            var item_date = url.searchParams.get("item_date");
                            if(item_date) document.getElementById("item_date").innerHTML = item_date;
                        </script>
                    </form>
                </div>

                <script>
                    function gotoConfirmDoRequest()
                    {
                        var url_string = window.location.href;
                        var url = new URL(url_string);

                        var request_id = url.searchParams.get("item_id");
                        var request_name = url.searchParams.get("item_name");
                        var contact_name = url.searchParams.get("user_name");
                        window.location.href='platform/others_request_do.php?request_id=' + request_id + "&request_name=" + request_name + "&contact_name=" + contact_name;
                    }

                </script>

                <div style="text-align: right;"><button style="margin-right: 20px;" onclick="gotoConfirmDoRequest()" class="button_add">Doe ik!</button></div>
            </div>

            <div class="launch_info_end"></div>

            <div id="footer"></div>
        </div>
    </body>
</html>