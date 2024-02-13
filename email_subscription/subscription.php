<?php 
// Include config file 
require_once 'config.php'; 
 
// Include Subscriber class 
require_once 'subscriber.class.php'; 

// Include PHPMailer class 
require_once("../include/phpmailer/PHPMailer.php");
require_once("../include/phpmailer/Exception.php");
require_once("../include/phpmailer/SMTP.php");

use PHPMailer\PHPMailer\PhPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$subscriber = new Subscriber(); 
 
if(isset($_POST['subscribe']))
{ 
    // Default response 
    $response = 'Error! Something went horribly wrong, please try after some time.' ;
     
    //Input fields validation 
    if(empty($_POST['name'])){ 
        $pre = !empty($msg)?'<br/>':''; 
        $errorMsg .= $pre.'vul je volledige naam in (voor- en achternaam).'; 
    } 

    if(empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){ 
        $pre = !empty($msg)?'<br/>':'';
        $errorMsg .= $pre.'Geef een geldig email adres op.'; 
    }
     
    // If validation successful 
    if(empty($errorMsg))
    {    
        $name = $_POST['name']; 
        $email = $_POST['email']; 
        $participate = $_POST['participate'];
        $verify_code = md5(uniqid(mt_rand()));

        // Check whether the given email already exists 
        $con = array( 
            'where' => array( 
                'email' => $email 
            ), 
            'return_type' => 'count' 
        ); 
        $prevRow = $subscriber->getRows($con); 

        if($prevRow > 0)
        { 
            $response = 'Your email already exists in our subscribers list.'; 
        }
        else
        { 
            // Insert subscriber info //name, email, verify_code, is_verified, status, participate
            $data = array( 
                'name' => $name, 
                'email' => $email, 
                'verify_code' => $verify_code,
                'is_verified' => '0',
                'status' => '0',
                'participate' => $participate
            ); 

            echo implode(" ", $data)."<br />";

            $insert = $subscriber->insert($data); 

            if( ($errors = sqlsrv_errors() ) != null) {
                foreach( $errors as $error ) {
                    echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
                    echo "code: ".$error[ 'code']."<br />";
                    echo "message: ".$error[ 'message']."<br />";
                }
            }

            if($insert)
            {
                $mailer = new PHPMailer(true);
                $mailer->SMTPDebug = SMTP::DEBUG_SERVER;
                $mailer->IsSMTP();
                $mailer->Host = "smtp.gmail.com";
                $mailer->Port = 465;
                $mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mailer->SMTPAuth = true;
                $mailer->Username = "mplatje@gmail.com";
                $mailer->Password = "piqpxlbopjpolnds";
                
                $mailer->AddAddress($email, $name);
                $mailer->Subject = "Bevestigen aanmelden nieuwsbrief Carpool.Versoek.nl";
                // $mailer->From = "info@versoek.nl";
                $mailer->Sender='info@yversoek.nl';
                $mailer->SetFrom('info@yversoek.nl', 'Versoek.nl');
                $mailer->AddReplyTo('info@versoek.nl', 'Info Versoek');
                $link = $siteURL.'subscription.php?email_verify='.$verify_code;

                $mailer->Body ="Hello ".$name."\r\n\r\n".
                    "Bedankt voor je interesse in Carpool van Versoek!\r\n\r\n".
                    "Klik op onderstaande link om je email adres te bevestigen:\r\n".$link."\r\n\r\n".
                    "Met vriendelijke groet,\r\n\r\n".
                    "Versoek";

                if($mailer->Send())
                {
                    $response = "ok";
                }
                else
                {
                    $response = "Error in sending email";
                }
            } 
            else
            {
                $response = "no insert";
            }
        } 
    }
    else
    { 
        $response = $errorMsg; 
    } 
    
    // Return response 
    echo $response; 
}
else if(isset($_POST['send_email']))
{
    // Default response 
    $response = 'Error! Something went horribly wrong, please try after some time.' ;
        
    //Input fields validation 
    if(empty($_POST['fname'])){ 
        $pre = !empty($msg)?'<br/>':''; 
        $errorMsg .= $pre.'vul je voornaam in.'; 
    } 

    if(empty($_POST['lname'])){ 
        $pre = !empty($msg)?'<br/>':''; 
        $errorMsg .= $pre.'vul je achternaam in.'; 
    } 

    if(empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){ 
        $pre = !empty($msg)?'<br/>':''; 
        $errorMsg .= $pre.'Geef een geldig email adres op.'; 
    }

    if(empty($_POST['body'])){ 
        $pre = !empty($msg)?'<br/>':''; 
        $errorMsg .= $pre.'typ een bericht.'; 
    } 
    
    // If validation successful 
    if(empty($errorMsg))
    {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $body = $_POST['body'];
        $fromCarpool = (isset($_POST['send_email'])? "Carpool @ " : "");

        $mailer = new PHPMailer(true);
        $mailer->SMTPDebug = SMTP::DEBUG_SERVER;
        $mailer->IsSMTP();
        $mailer->Host = "smtp.gmail.com";
        $mailer->Port = 465;
        $mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mailer->SMTPAuth = true;
        $mailer->Username = "mplatje@gmail.com";
        $mailer->Password = "piqpxlbopjpolnds";
        
        $mailer->AddAddress($email, $name);
        $mailer->Subject = "Bericht verstuurt naar Versoek.nl";
        $mailer->From = "info@versoek.nl";

        $mailer->Body ="Hallo ".$fname." ".$lname.",\r\n\r\n".
            "Bedankt voor je bericht naar Versoek!\r\n\r\n".
            "Wanneer het nodig is, zullen we je zo spoedig mogelijk een reactie sturen.\r\n\r\n".
            "Met vriendelijke groet,\r\n\r\n".
            "Team Versoek";

        if($mailer->Send())
        {
            $mailer2 = new PHPMailer(true);
            $mailer2->SMTPDebug = SMTP::DEBUG_SERVER;
            $mailer2->IsSMTP();
            $mailer2->Host = "smtp.gmail.com";
            $mailer2->Port = 465;
            $mailer2->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mailer2->SMTPAuth = true;
            $mailer2->Username = "mplatje@gmail.com";
            $mailer2->Password = "piqpxlbopjpolnds";
            
            $mailer2->AddAddress("info@versoek.nl", "Team Versoek");
            $mailer2->Subject = "Bericht via contactformulier Carpool.versoek.nl";
            $mailer2->From = $mail;

            $mailer2->Body ="Bericht van ".$fname." ".$lname.",\r\n\r\n".
                $body."\r\n\r\n".
                "-Einde bericht-";

            if($mailer2->Send())
            {
                $response = "ok";
            }
            else
            {
                $response = "Error in sending confirmation email to user";
            }
        }
        else
        {
            $response = "Error in sending email to self";
        }
    }
    else
    { 
        $response = $errorMsg; 
    } 
    
    // Return response 
    echo $response; 
}
else if(!empty($_GET['email_verify']))
{ 
    $verify_code = $_GET['email_verify']; 
    $con = array( 
        'where' => array( 
            'verify_code' => $verify_code 
        ), 
        'return_type' => 'count' 
    ); 

    $rowNum = $subscriber->getRows($con); 
    if($rowNum > 0){ 
        $data = array( 
            'is_verified' => 1 
        ); 
        $con = array( 
            'verify_code' => $verify_code 
        ); 
        $update = $subscriber->update($data, $con); 
        if($update){ 
            $statusMsg = '<p class="success">Jouw email adres is succesvol geverifieerd!.</p>';
        }else{ 
            $statusMsg = '<p class="error">Er was een probleem met het verifieren van je email, probeer het nog eens.</p>'; 
        } 
    }else{ 
        $statusMsg = '<p class="error">Er ging iets mis, controlleer je email en probeer het nog eens.</p>'; 
    }
?>  

    <!DOCTYPE html>
    <html lang="en">
    <head>
    <title>Email Verification by SMiLES Crowd</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <!-- web-fonts -->
    <link href="//fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=latin-ext" rel="stylesheet">

    <!-- Stylesheet file -->
    <link rel="stylesheet" type="text/css" href="css/style.css" />

    </head>
    <body class="subs">
    <div class="container">
        <div class="subscribe box-sizing">
            <div class="sloc-wrap box-sizing">
                <div class="sloc-content">
                    <div class="sloc-text">
                        <div class="sloc-header"><?php echo $statusMsg; ?></div>
                    </div>
                    <a href="https://carpool.versoek.nl" class="cwlink">Klik hier om terug te gaan naar de Versoek pagina</a>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>

<?php 
} 
?>