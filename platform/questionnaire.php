<?PHP
    require_once("./include/membersite_config.php");

    if(!$fgmembersite->CheckLogin())
    {
        $fgmembersite->RedirectToURL("login.php");
        exit;
    }

    if(isset($_POST['submitted']))
    {
        $result = $fgmembersite->AddQuestionnaire1ToDatabase();
        if($result)
        {
            $fgmembersite->RedirectToURL("questionnaire_completed.php");
        }
        else 
        {
            echo ($fgmembersite->GetErrorMessage());
            $fgmembersite->RedirectToURL("questionnaire_failed.html");
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
                
                <h2 style="color: #7448b1; font-size: 40px; text-align: center; margin-top: 0px; margin-bottom: 0px;">Vragenlijst 1</h2><hr>

                <button style="margin-left: 20px" onclick="window.location.href='platform/start.php';" class="button_back">Terug</button>

                <br><p style="color: #7448b1; font-size: 12px; margin-left: 20%; margin-right: 20%; text-align: center;">*De gegevens die je hieronder invult, worden alleen verzamelt voor wetenschappenlijke doeleinden en zijn pseudo-anononiem. Wees echter altijd voorzichtig met het verstrekken van prive data die je liever niet deelt (zoals adressen, telefoonnummers, etc).</p><br>

                <div class="contact_form">
                    <form action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
                        <input type='hidden' name='submitted' id='submitted' value='1'/>
                        
                        <hr><br>

                        <label for="q1a">Vraag 1a - Het concept van Versoek is duidelijk (1 - Ja, 5 - nee)</label><br>
                        <input type="radio" id="q1a_a1" name="question1a" value="Ja">
                        <label for="q1a_a1">1 - Ja</label><br>
                        <input type="radio" id="q1a_a2" name="question1a" value="Redelijk">
                        <label for="q1a_a2">2 - Redelijk</label><br>
                        <input type="radio" id="q1a_a3" name="question1a" value="Matig">
                        <label for="q1a_a3">3 - Matig</label><br>
                        <input type="radio" id="q1a_a4" name="question1a" value="Nauwelijks">
                        <label for="q1a_a4">4 - Nauwelijks</label><br>
                        <input type="radio" id="q1a_a5" name="question1a" value="Nee">
                        <label for="q1a_a5">5 - Nee</label><br><br>
                        
                        <label for="q1b">Vraag 1b - Beschrijf het concept van het Versoek platform in uw eigen woorden</label>
                        <input type="text" id="q1b_a1" name="question1b" placeholder="Uw antwoord...">

                        <hr><br>
                        
                        <label for="q2a">Vraag 2a - Ik ga dit platform gebruiken! (1 - Ja, 5 - nee)</label><br>
                        <input type="radio" id="q2a_a1" name="question2a" value="Ja">
                        <label for="q2a_a1">1 - Ja</label><br>
                        <input type="radio" id="q2a_a2" name="question2a" value="Ik denk het wel">
                        <label for="q2a_a2">2 - Ik denk het wel</label><br>
                        <input type="radio" id="q2a_a3" name="question2a" value="Misschien">
                        <label for="q2a_a3">3 - Misschien</label><br>
                        <input type="radio" id="q2a_a4" name="question2a" value="Ik denk het niet">
                        <label for="q2a_a4">4 - Ik denk het niet</label><br>
                        <input type="radio" id="q2a_a5" name="question2a" value="Nee">
                        <label for="q2a_a5">5 - Nee</label><br><br>

                        <label for="q2b">Vraag 2b - Waarom zou u dit platform wel of niet gebruiken?</label>
                        <input type="text" id="q2b" name="question2b" placeholder="Uw antwoord...">

                        <hr><br>

                        <label for="q3a">Vraag 3a - Hoevaak reist u gemiddeld per week? bijvoorbeeld naar werk of school?</label>
                        <input type="text" id="q3a" name="question3a" placeholder="Uw antwoord...">
                        
                        <label for="q3b">Vraag 3b - Zo ja, hoeveel kilometer reist u ongeveer en op welke manier legt u deze rit af?</label>
                        <input type="text" id="q3b" name="question3b" placeholder="Uw antwoord...">

                        <hr><br>

                        <label for="q4">Vraag 4 - Hoeveel inwoners heeft de plek waar u woont? (schatting) </label>
                        <input type="text" id="q4" name="question4" placeholder="Uw antwoord...">

                        <hr><br>

                        <label for="q5a">Vraag 5a - Hoe vaak krijgt u wel eens een verzoek om iets mee te nemen voor een ander?</label>
                        <input type="text" id="q5a" name="question5a" placeholder="Uw antwoord...">

                        <label for="q5b">Vraag 5b - Wanneer iemand dat verzoekt, doet u dat dan ook? wanneer wel/niet?</label>
                        <input type="text" id="q5b" name="question5b" placeholder="Uw antwoord...">

                        <hr><br>

                        <label for="q6">Vraag 6 - Wat zou voor u voldoende zijn om een verzoek uit te voeren?</label><br>
                        <input type="radio" id="q6_a1" name="question6" value="Ja">
                        <label for="q6_a1">Ik doe dit graag voor iemand die ik ken</label><br>
                        <input type="radio" id="q6_a2" name="question6" value="Ik denk het wel">
                        <label for="q6_a2">Ik doe dit graag voor een beter milieu</label><br>
                        <input type="radio" id="q6_a3" name="question6" value="Misschien">
                        <label for="q6_a3">Ik zou dit doen wanneer ik daar geld voor krijg</label><br>
                        <input type="radio" id="q6_a4" name="question6" value="Ik denk het niet">
                        <label for="q6_a4">In alle bovenstaande gevallen</label><br>
                        <input type="radio" id="q6_a5" name="question6" value="Nee">
                        <label for="q6_a5">In geen van deze gevallen</label><br><br>

                        <hr><br>

                        <label for="q7a">Vraag 7a - Vraagt u wel eens iemand om iets voor u mee te nemen?</label>
                        <input type="text" id="q7a" name="question7a" placeholder="Uw antwoord...">
                        
                        <label for="q7b">Vraag 7b - Zo ja, aan wie vraagt u dat wel eens?</label>
                        <input type="text" id="q7b" name="question7b" placeholder="Familie, vrienden, buren, collegas, anders">
                        
                        <hr><br>

                        <label for="q8a">Vraag 8a - Op de website staat een voorbeeld van iemand die een vergeten boodschap meeneemt voor zijn/haar buurman, zou u dat ook doen?</label>
                        <input type="text" id="q8a" name="question8a" placeholder="Uw antwoord...">

                        <label for="q8b">Vraag 8b - Zou u dit voor iedereen doen?</label>
                        <input type="text" id="q8b" name="question8b" placeholder="'Nee, voor niemand', 'Ja voor iedereen', 'alleen kennissen', 'alleen vrienden/familie/goede buren'">

                        <hr><br>

                        <label for="q9">Vraag 9 - Wat moet er aan het platform veranderen zodat u er wel/meer/beter gebruik van kan maken?</label>
                        <input type="text" id="q9" name="question9" placeholder="Uw antwoord...">
                        
                        <hr><br>

                        <label for="q10">Vraag 10 - Wat voor op/aan merkingen heeft u op de website? (hoe meer hoe beter)</label>
                        <input type="text" id="q10" name="question10" placeholder="Uw antwoord...">

                        <hr><br>

                        <label for="q11">Vraag 11 - Wat voor op/aan merkingen heeft u op het versoek concept? (hoe meer hoe beter)</label>
                        <input type="text" id="q11" name="question11" placeholder="Uw antwoord...">
                        
                        <hr><br>

                        <label for="q12">Vraag 12 - Zou u dit platform en/of concept in de huidige staat aanraden aan anderen?</label><br>
                        <input type="radio" id="q12_a1" name="question12" value="Ja">
                        <label for="q12_a1">1 - Ja</label><br>
                        <input type="radio" id="q12a_a2" name="question12" value="Ik denk het wel">
                        <label for="q12a_a2">2 - Ik denk het wel</label><br>
                        <input type="radio" id="q12a_a3" name="question12" value="Misschien">
                        <label for="q12a_a3">3 - Misschien</label><br>
                        <input type="radio" id="q12a_a4" name="question12" value="Ik denk het niet">
                        <label for="q12a_a4">4 - Ik denk het niet</label><br>
                        <input type="radio" id="q12a_a5" name="question12" value="Nee">
                        <label for="q12a_a5">5 - Nee</label><br><br>

                        <hr><br>

                        <label for="q13">Vraag 13 - Zou u dit platform en/of concept aanraden aan anderen wanneer uw op/aan merkingen zijn doorgevoerd?</label><br>
                        <input type="radio" id="q13_a1" name="question13" value="Ja">
                        <label for="q13_a1">1 - Ja</label><br>
                        <input type="radio" id="q13a_a2" name="question13" value="Ik denk het wel">
                        <label for="q13a_a2">2 - Ik denk het wel</label><br>
                        <input type="radio" id="q13a_a3" name="question13" value="Misschien">
                        <label for="q13a_a3">3 - Misschien</label><br>
                        <input type="radio" id="q13a_a4" name="question13" value="Ik denk het niet">
                        <label for="q13a_a4">4 - Ik denk het niet</label><br>
                        <input type="radio" id="q13a_a5" name="question13" value="Nee">
                        <label for="q13a_a5">5 - Nee</label><br><br>

                        <br><br>

                        <label for="q14">Vraag 14 - Heeft u nog andere op- of aanmerkingen? </label>
                        <input type="text" id="q14" name="question14" placeholder="Uw antwoord...">

                </div>
                
                <div style="text-align: left;"><input style="margin-left: 20%;" type="submit" class="button_add" value="Klaar!"></div>
            </div>

            <div class="launch_info_end"></div>

            <div id="footer"></div>
        </div>
    </body>
</html>