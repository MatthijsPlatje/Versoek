<?PHP
    require_once("./include/membersite_config.php");

    if(!$fgmembersite->CheckLogin())
    {
        $fgmembersite->RedirectToURL("login.php");
        exit;
    }

    if(isset($_POST['submitted']))
    {
        $result = $fgmembersite->AddRequestToDatabase();
        if($result)
        {
            $fgmembersite->RedirectToURL("my_request_add_successful.html");
        }
        else 
        {
            echo ($fgmembersite->GetErrorMessage());
            $fgmembersite->RedirectToURL("my_request_add_not_successful.html");
        }
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
                <h2 style="color: #7448b1; font-size: 40px; text-align: center; margin-top: 0px; margin-bottom: 0px;">Nieuw verzoek aanmaken</h2><hr>

                <button style="margin-left: 20px" onclick="window.location.href='platform/my_requests.php';" class="button_back">Terug</button>
                <div class="contact_form">
                    <form action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
                        <input type='hidden' name='submitted' id='submitted' value='1'/>

                        <label for="request_name">Naam van het verzoek</label>
                        <input type="text" id="request_name" name="request_name" placeholder="Een korte naam">
                    
                        <label for="request_description">Beschrijving</label>
                        <input type="text" id="request_description" name="request_description" placeholder="Beschrijving van jouw verzoek...">
                    
                        <div id="location_fields">
                            <label for="location">Start locatie</label>
                            <input type="text" id="location" name="location" placeholder="Vanaf waar...">

                            <label for="destination">Eindbestemming</label>
                            <input type="text" id="destination" name="destination" placeholder="Eindbestemming...">
                        </div>

                        <div class="checkbox_ok_to_contact" style="margin-top: 32px; margin-bottom: 24px; text-align: left;">
                            <label for="checkbox_date">Ik wil een tijdstip opgeven</label>
                            <input type="checkbox" name="checkbox_date" id="checkbox_date" style="float:left"/>
                        </div>

                        <div id="date_and_time_field">
                            <label for="date">Datum en tijd</label>
                            <input type="text" id="date" name="date" placeholder="Op welke datum/tijdstip geldt dit verzoek...">
                        </div>
                    
                        <div style="text-align: right;"><input style="margin-right: 20px;" type="submit" class="button_add" value="Voeg nieuw verzoek toe"></div>

                        <br><p style="color: #7448b1; font-size: 12px; margin-left: 10%; margin-right: 10%; text-align: center;">*De gegevens die je hier invult, kan door jouw contactpersonen worden gezien. Wees daarom voorzichtig met het verstrekken van prive data die je liever niet deelt.</p><br>
                    </form>
                </div>
            </div>

            <div class="launch_info_end"></div>
            
            <div id="footer"></div>
        </div>

        <script>
            const dateCheckbox = document.querySelector('#checkbox_date');
            const dateField = document.getElementById('date_and_time_field');
            dateField.style.display = 'none';

            dateCheckbox.addEventListener('change', () => {
                if (dateCheckbox.checked) {
                    dateField.style.display = '';
                    dateField.value = '';
                } else {
                    dateField.style.display = 'none';
                }
            });
        </script>
    </body>
</html>