<?PHP
/*
    Registration/Login script from HTML Form Guide
    V1.0

    This program is free software published under the
    terms of the GNU Lesser General Public License.
    http://www.gnu.org/copyleft/lesser.html
    

This program is distributed in the hope that it will
be useful - WITHOUT ANY WARRANTY; without even the
implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.

For updates, please visit:
http://www.html-form-guide.com/php-form/php-registration-form.html
http://www.html-form-guide.com/php-form/php-login-form.html

*/
require_once("phpmailer/PHPMailer.php");
require_once("phpmailer/Exception.php");
require_once("phpmailer/SMTP.php");
require_once("formvalidator.php");

use PHPMailer\PHPMailer\PhPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class FGMembersite
{
    var $admin_email;
    var $from_address;
    
    var $username;
    var $pwd;
    var $database;
    var $tablename;
    var $connection;
    var $rand_key;
    
    var $error_message;
    
    //-----Initialization -------
    function FGMembersite()
    {
        $this->sitename = 'versoek.nl';
        $this->rand_key = '0iQx5oBk66oVZep';
    }
    
    function InitDB($host,$uname,$pwd,$database,$tablename)
    {
        $this->db_host  = $host;
        $this->username = $uname;
        $this->pwd  = $pwd;
        $this->database  = $database;
        $this->tablename = $tablename;
    }
    
    function SetAdminEmail($email)
    {
        $this->admin_email = $email;
    }
    
    function SetWebsiteName($sitename)
    {
        $this->sitename = $sitename;
    }
    
    function SetRandomKey($key)
    {
        $this->rand_key = $key;
    }
    
    //-------Main Operations ----------------------
    function RegisterUser()
    {
        if(!isset($_POST['submitted']))
        {
           return false;
        }
        
        $formvars = array();
        
        if(!$this->ValidateRegistrationSubmission())
        {
             return false;
        }
        
        $this->CollectRegistrationSubmission($formvars);
        if(!$this->SaveToDatabase($formvars))
        {
            return false;
        }
        
        if(!$this->SendUserConfirmationEmail($formvars))
        {
            return false;
        }

        $this->SendAdminIntimationEmail($formvars);
        
        return true;
    }

    function ConfirmUser()
    {
        if(empty($_GET['code'])||strlen($_GET['code'])<=10)
        {
            $this->HandleError("Vul de gebruikers code in");
            return false;
        }

        $user_rec = array();
        if(!$this->UpdateDBRecForConfirmation($user_rec))
        {
            return false;
        }
        
        $this->SendUserWelcomeEmail($user_rec);
        
        $this->SendAdminIntimationOnRegComplete($user_rec);
        
        return true;
    }    
    
    function Login()
    {
        if(empty($_POST['username']))
        {
            $this->HandleError("Gebruikersnaam ontbreekt!");
            return false;
        }
        
        if(empty($_POST['password']))
        {
            $this->HandleError("Wachtwoord ontbreekt!");
            return false;
        }
        
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        if(!isset($_SESSION)){ session_start(); }
        if(!$this->CheckLoginInDB($username,$password))
        {
            return false;
        }
        
        $_SESSION[$this->GetLoginSessionVar()] = $username;
        
        return true;
    }
    
    function CheckLogin()
    {
         if(!isset($_SESSION)){ session_start(); }

         $sessionvar = $this->GetLoginSessionVar();
         
         if(empty($_SESSION[$sessionvar]))
         {
            return false;
         }
         return true;
    }

    function AddQuestionnaire1ToDatabase()
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return false;
        }  

        $id = $_SESSION['id_of_user'];
        $q1a = $_POST['question1a'];
        $q1b = $_POST['question1b'];
        $q2a = $_POST['question2a'];
        $q2b = $_POST['question2b'];
        $q3a = $_POST['question3a'];
        $q3b = $_POST['question3b'];
        $q4 = $_POST['question4'];
        $q5a = $_POST['question5a'];
        $q5b = $_POST['question5b'];
        $q6 = $_POST['question6'];
        $q7a = $_POST['question7a'];
        $q7b = $_POST['question7b'];
        $q8a = $_POST['question8a'];
        $q8b = $_POST['question8b'];
        $q9 = $_POST['question9'];
        $q10 = $_POST['question10'];
        $q11 = $_POST['question11'];
        $q12 = $_POST['question12'];
        $q13 = $_POST['question13'];
        $q14 = $_POST['question14'];
        $lt = (new \DateTime())->format('Y-m-d H:i:s');

        $sql = "INSERT INTO questionnaire1 (q1a, q1b, q2a, q2b, q3a, q3b, q4, q5a, q5b, q6, q7a, q7b, q8a, q8b, q9, q10, q11, q12, q13, q14, user_id, last_time)
            VALUES ('".$q1a."', '".$q1b."','".$q2a."','".$q2b."', '".$q3a."','".$q3b."','".$q4."', '".$q5a."','".$q5b."','".$q6."', '".$q7a."','".$q7b."','".$q8a."', '".$q8b."','".$q9."','".$q10."','".$q11."', '".$q12."','".$q13."','".$q14."','".$id."', '".$lt."')";

        if (!sqlsrv_query($this->connection, $sql))
        {
            $this->HandleDBError("Error inserting data to the table\nquery:$sql");
            return false;
        }        
        return true;
    }

    function AddRequestToDatabase()
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return false;
        }  

        $id = $_SESSION['id_of_user'];
        $name = $_POST['request_name'];
        $description = $_POST['request_description'];
        $location = $_POST['location'];
        //$price = $_POST['price'];
        //$date = $_POST['date'];

        $sql = "INSERT INTO requests (user_id, item_name, item_description, item_location, item_destination, accepted)
            VALUES ('".$id."', '".$name."','".$description."','".$location."','tbd','0')";

        if (!sqlsrv_query($this->connection, $sql))
        {
            $this->HandleDBError("Error inserting data to the table\nquery:$sql");
            return false;
        }        
        return true;
    }

    function RemoveRequestFromDatabase()
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return false;
        }  

        $id = $_SESSION['id_of_user'];
        $name = $_POST['request_name'];

        $sql = "DELETE FROM requests WHERE user_id='$id' AND item_name='$name'";

        if (!sqlsrv_query($this->connection, $sql))
        {
            $this->HandleDBError("Error removing data from the table\nquery:$sql");
            return false;
        }        
        return true;
    }

    function GetMyRequests()
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return false;
        }  

        $id = $_SESSION['id_of_user'];
        $sql = "SELECT * FROM requests WHERE user_id=$id";
        $query1 = sqlsrv_query($this->connection, $sql);

        return $query1;
    }

    function GetOthersRequests()
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return false;
        }  

        $id = $_SESSION['id_of_user'];
        $sql1 = "SELECT * FROM requests Except SELECT * FROM requests WHERE user_id=$id";
        $query1 = sqlsrv_query($this->connection, $sql1);

        while($row = sqlsrv_fetch_array($query1)) {
            $fromID = $row['user_id'];

            $sql2 = "SELECT * FROM members WHERE id_user=$fromID";
            $query2 = sqlsrv_query($this->connection, $sql2);
            $rowOfUser = sqlsrv_fetch_array($query2);
            $fromName = $rowOfUser["name"];

            $result[] = array("user_name" => $fromName, "user_id" => $row['user_id'], "item_id" => $row['item_id'], "item_name" => $row['item_name'], "item_description" => $row['item_description'], "item_location" => $row['item_location']);
        }

        return $result;
    }

    function GetRequestsFromContacts()
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return false;
        }  

        $id = $_SESSION['id_of_user'];
        $sql1 = "SELECT contacts FROM members WHERE id_user=$id";
        $query1 = sqlsrv_query($this->connection, $sql1);
        $row = sqlsrv_fetch_array($query1);

        $contacts_array = explode(",", $row['contacts']);
        $result = array();

        foreach($contacts_array as $contact_id)
        {
            $sql2 = "SELECT * FROM requests WHERE user_id=$contact_id";
            $query2 = sqlsrv_query($this->connection, $sql2);
            if(!$query2) return $result;

            //get row of each request with user_id
            while($row2 = sqlsrv_fetch_array($query2))
            {
                $status = $row2['accepted'];
                if($status == 0)
                {
                    //get name that belongs to this user_id
                    $sql3 = "SELECT * FROM members WHERE id_user=$contact_id";
                    $query3 = sqlsrv_query($this->connection, $sql3);
                    $rowOfUser = sqlsrv_fetch_array($query3);
                    $contactName = $rowOfUser["name"];

                    $result[] = array("user_name" => $contactName, "user_id" => $row2['user_id'], "item_id" => $row2['item_id'], "item_name" => $row2['item_name'], "item_description" => $row2['item_description'], "item_location" => $row2['item_location']);
                }
            }
        }

        return $result;
    }

    function GetMyTODO()
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return false;
        }  

        $id = $_SESSION['id_of_user'];
        $sql1 = "SELECT * FROM members WHERE id_user=$id";
        $query1 = sqlsrv_query($this->connection, $sql1);
        $row = sqlsrv_fetch_array($query1);
        
        if(!isset($row) || strlen($row['todo']) == 0)
        return array();

        $requests_array = explode(",", $row['todo']);
        foreach($requests_array as $request_id) {
            $sql2 = "SELECT * FROM requests WHERE item_id=$request_id";
            $query2 = sqlsrv_query($this->connection, $sql2);
            $rowOfRequest = sqlsrv_fetch_array($query2);

            $contact_id = $rowOfRequest["user_id"];
            $sql3 = "SELECT name FROM members WHERE id_user=$contact_id";
            $query3 = sqlsrv_query($this->connection, $sql3);
            $rowOfContact = sqlsrv_fetch_array($query3);

            $result[] = array("contact_name" => $rowOfContact["name"], "request_id" => $request_id, "request_name" => $rowOfRequest["item_name"], "request_description" => $rowOfRequest["item_description"], "request_location" => $rowOfRequest["item_location"]);
        }

        return $result;
    }

    function IsInTODO($check_request_id)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return false;
        } 

        $id = $_SESSION['id_of_user'];
        $sql1 = "SELECT todo FROM members WHERE id_user=$id";
        $query1 = sqlsrv_query($this->connection, $sql1);
        $row = sqlsrv_fetch_array($query1);

        $requests_array = explode(",", $row['todo']);
        foreach($requests_array as $request_id) {
            if($request_id == $check_request_id)
                return true;
        }

        return false;
    }
    
    function RemoveFromTODO()
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return false;
        }  

        $request_id = $_POST['request_id'];

        $isTODO = $this->IsInTODO($request_id);
        if($isTODO)
        {
            $id = $_SESSION['id_of_user'];

            $sql1 = "SELECT todo FROM members WHERE id_user=$id";
            $query1 = sqlsrv_query($this->connection, $sql1);
            $row = sqlsrv_fetch_array($query1);

            $requests_array = explode(",", $row['todo']);
            $new_array = array_diff($requests_array, array($request_id));
            $new_array_as_string = implode(",", $new_array);

            $sql2 = "UPDATE members SET todo='".$new_array_as_string."' WHERE id_user='".$id."'";
            sqlsrv_query($this->connection, $sql2);

            $sql3 = "UPDATE requests SET accepted='0' WHERE item_id='".$request_id."'";
            sqlsrv_query($this->connection, $sql3);

            return true;
        }

        return false;
    }

    function AddToTODO()
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return false;
        } 

        //check if somebody alreay accepted this request or request has been cancelled
        $request_id = $_POST['request_id'];
        $sql = "SELECT * FROM requests WHERE item_id=$request_id";
        $query = sqlsrv_query($this->connection, $sql);
        if(!$query) return false;

        $row = sqlsrv_fetch_array($query);
        if(!$row) return false;

        if($row['accepted'] == 1) {
            $this->HandleError("Verzoek was al geaccepteerd!");
            return false;
        }
        else {
            $sql3 = "UPDATE requests SET accepted='1' WHERE item_id='".$request_id."'";
            sqlsrv_query($this->connection, $sql3);
        }

        //find todo list and add id of request to todo list of current user
        $isTODO = $this->IsInTODO($request_id);
        if(!$isTODO)
        {
            $id = $_SESSION['id_of_user'];

            $sql1 = "SELECT todo FROM members WHERE id_user=$id";
            $query1 = sqlsrv_query($this->connection, $sql1);
            $row1 = sqlsrv_fetch_array($query1);

            $new_array_as_string = "".$request_id;
            if(strlen($row1['todo']) > 0) {
                $requests_array = explode(",", $row1['todo']);
                array_push($requests_array, $request_id);
                $new_array_as_string = implode(",", $requests_array);
            }

            $sql2 = "UPDATE members SET todo='".$new_array_as_string."' WHERE id_user='".$id."'";
            sqlsrv_query($this->connection, $sql2);

            return true;
        }

        return false;
    }

    function CompletedTODO()
    {
        //remove from todo list
        $this->RemoveFromTODO();

        //copy from requests to completed
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return false;
        }  

        $request_id = $_POST['request_id'];

        $sql1 = "INSERT INTO completed SELECT * FROM requests WHERE item_id = $request_id";
        sqlsrv_query($this->connection, $sql1);

        $sql2 = "DELETE FROM requests WHERE item_id = $request_id";
        sqlsrv_query($this->connection, $sql2);

        $sql3 = "UPDATE completed SET accepted='2' WHERE item_id = $request_id";
        sqlsrv_query($this->connection, $sql3);

        return true;
    }

    function CancelTODO()
    {
        $this->RemoveFromTODO();
    }

    function GetMyContacts()
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return false;
        }  

        $id = $_SESSION['id_of_user'];
        $sql1 = "SELECT contacts FROM members WHERE id_user=$id";
        $query1 = sqlsrv_query($this->connection, $sql1);
        $row = sqlsrv_fetch_array($query1);

        if(!isset($row) || strlen($row['contacts']) == 0)
            return array();

        $contacts_array = explode(",", $row['contacts']);
        foreach($contacts_array as $contact_id) {
            $sql2 = "SELECT name FROM members WHERE id_user=$contact_id";
            $query2 = sqlsrv_query($this->connection, $sql2);
            $rowOfContact = sqlsrv_fetch_array($query2);

            $result[] = array("contact_id" => $contact_id, "contact_name" => $rowOfContact["name"]);
        }

        return $result;
    }

    function FindContactInMembersDatabase()
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return false;
        }  

        $contact_name = $_POST['contact_name'];
        $sql1 = "SELECT * FROM members WHERE username='$contact_name'";
        $query1 = sqlsrv_query($this->connection, $sql1);
        $row = sqlsrv_fetch_array($query1);

        if($row) {
            $id = $row['id_user'];
            $name = $row['name'];

            //check if id_user is already in contact list
            $isContact = $this->IsInContacts($id);

            return [true, $isContact, $id, $name];
        } else {
            return [false, false, "", $contact_name];
        }
    }

    function IsInContacts($check_contact_id)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return false;
        } 

        $id = $_SESSION['id_of_user'];
        $sql1 = "SELECT contacts FROM members WHERE id_user=$id";
        $query1 = sqlsrv_query($this->connection, $sql1);
        $row = sqlsrv_fetch_array($query1);

        $contacts_array = explode(",", $row['contacts']);
        foreach($contacts_array as $contact_id) {
            if($contact_id == $check_contact_id)
                return true;
        }

        return false;
    }

    function Id2Name($contact_id)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return false;
        } 

        $sql1 = "SELECT name FROM members WHERE id_user='".$contact_id."'";
        $query1 = sqlsrv_query($this->connection, $sql1);
        $row = sqlsrv_fetch_array($query1);

        if(is_null($row))
            return "";

        if(array_key_exists('name', $row))
            return $row['name'];
        else
            return "";
    }
    
    function RemoveFromContacts()
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return false;
        }  

        $contact_id = $_POST['contact_id'];

        $isContact = $this->IsInContacts($contact_id);
        if($isContact)
        {
            $id = $_SESSION['id_of_user'];
            $contact_name = $_POST['contact_name'];

            $sql1 = "SELECT contacts FROM members WHERE id_user=$id";
            $query1 = sqlsrv_query($this->connection, $sql1);
            $row = sqlsrv_fetch_array($query1);

            $contacts_array = explode(",", $row['contacts']);
            $new_array = array_diff($contacts_array, array($contact_id));
            $new_array_as_string = implode(",", $new_array);

            $sql2 = "UPDATE members SET contacts='".$new_array_as_string."' WHERE id_user='".$id."'";
            sqlsrv_query($this->connection, $sql2);

            return true;
        }

        return false;
    }

    function AddToContacts()
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return false;
        } 

        $contact_id = $_POST['contact_id'];

        $isContact = $this->IsInContacts($contact_id);
        if(!$isContact)
        {
            $id = $_SESSION['id_of_user'];
            $contact_id = $_POST['contact_id'];
            $contact_name = $_POST['contact_name'];

            $sql1 = "SELECT contacts FROM members WHERE id_user=$id";
            $query1 = sqlsrv_query($this->connection, $sql1);
            $row = sqlsrv_fetch_array($query1);

            $new_array_as_string = "".$contact_id;
            if(strlen($row['contacts']) > 0) {
                $contacts_array = explode(",", $row['contacts']);
                array_push($contacts_array, $contact_id);
                $new_array_as_string = implode(",", $contacts_array);
            }

            $sql2 = "UPDATE members SET contacts='".$new_array_as_string."' WHERE id_user='".$id."'";
            sqlsrv_query($this->connection, $sql2);

            return true;
        }

        return false;
    }

    function GetMyHistory()
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return false;
        }  

        $id = $_SESSION['id_of_user'];
        $sql1 = "SELECT * FROM members WHERE id_user=$id";
        $query1 = sqlsrv_query($this->connection, $sql1);
        $row = sqlsrv_fetch_array($query1);
        
        if(!isset($row) || strlen($row['history']) == 0)
            return array();

        $requests_array = explode(",", $row['history']);
        foreach($requests_array as $request_id) {
            $sql2 = "SELECT * FROM completed WHERE item_id=$request_id";
            $query2 = sqlsrv_query($this->connection, $sql2);
            $rowOfRequest = sqlsrv_fetch_array($query2);

            $contact_id = $rowOfRequest["user_id"];
            $name = "me";

            if($contact_id != $id)
            {
                $sql3 = "SELECT name FROM members WHERE id_user=$contact_id";
                $query3 = sqlsrv_query($this->connection, $sql3);
                $rowOfContact = sqlsrv_fetch_array($query3);
                $name = $rowOfContact["name"];
            }

            $result[] = array("contact_name" => $name, "request_id" => $request_id, "request_name" => $rowOfRequest["item_name"], "request_description" => $rowOfRequest["item_description"], "request_location" => $rowOfRequest["item_location"]);
        }

        return $result;
    }

    function GetMyDetails()
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return false;
        }

        $id = $_SESSION['id_of_user'];
        $sql = "SELECT * FROM members WHERE id_user=$id";
        $query = sqlsrv_query($this->connection, $sql);
        $row = sqlsrv_fetch_array($query);

        $result[] = array("user_name" => $row["username"], "full_name" => $row["name"], "email" => $row["email"], "phone" => $row["phone_number"]);

        return $result;
    }

    function GetNewsItems()
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");

            return false;
        }  

        $sql = "SELECT * FROM news_items ORDER BY published DESC";
        $query = sqlsrv_query($this->connection, $sql);

        return $query;
    }

    function UserFullName()
    {
        return isset($_SESSION['name_of_user'])?$_SESSION['name_of_user']:'';
    }

    function UserID()
    {
        return isset($_SESSION['id_of_user'])?$_SESSION['id_of_user']:'';
    }
    
    function UserEmail()
    {
        return isset($_SESSION['email_of_user'])?$_SESSION['email_of_user']:'';
    }

    function IsAdmin()
    {
        return isset($_SESSION['is_admin']) ? $_SESSION['is_admin']:'';
    }
    
    function LogOut()
    {
        session_start();
        
        $sessionvar = $this->GetLoginSessionVar();
        
        $_SESSION[$sessionvar]=NULL;
        
        unset($_SESSION[$sessionvar]);
    }
    
    function EmailResetPasswordLink()
    {
        if(empty($_POST['email']))
        {
            $this->HandleError("Email ontbreekt!");
            return false;
        }
        $user_rec = array();
        if(false === $this->GetUserFromEmail($_POST['email'], $user_rec))
        {
            return false;
        }
        if(false === $this->SendResetPasswordLink($user_rec))
        {
            return false;
        }
        return true;
    }
    
    function ResetPassword()
    {
        if(empty($_GET['email']))
        {
            $this->HandleError("Email ontbreekt!");
            return false;
        }
        if(empty($_GET['code']))
        {
            $this->HandleError("reset code ontbreekt!");
            return false;
        }
        $email = trim($_GET['email']);
        $code = trim($_GET['code']);
        
        if($this->GetResetPasswordCode($email) != $code)
        {
            $this->HandleError("Onjuiste reset code!");
            return false;
        }
        
        $user_rec = array();
        if(!$this->GetUserFromEmail($email,$user_rec))
        {
            return false;
        }
        
        $new_password = $this->ResetUserPasswordInDB($user_rec);
        if(false === $new_password || empty($new_password))
        {
            $this->HandleError("Update nieuw wachtwoord mislukt");
            return false;
        }
        
        if(false == $this->SendNewPassword($user_rec,$new_password))
        {
            $this->HandleError("Zenden nieuwe wachtwoord mislukt");
            return false;
        }
        return true;
    }
    
    function ChangePassword()
    {
        if(!$this->CheckLogin())
        {
            $this->HandleError("Niet ingelogd!");
            return false;
        }
        
        if(empty($_POST['oldpwd']))
        {
            $this->HandleError("Oude wachtwoord ontbreekt!");
            return false;
        }
        if(empty($_POST['newpwd']))
        {
            $this->HandleError("Nieuwe wachtwoord ontbreekt!");
            return false;
        }
        
        $user_rec = array();
        if(!$this->GetUserFromEmail($this->UserEmail(),$user_rec))
        {
            return false;
        }
        
        $pwd = trim($_POST['oldpwd']);
        
        if(!password_verify($pwd, $user_rec['password']))
        {
            $this->HandleError("Het oude wachtwoord komt niet overeen!");
            return false;
        }
        $newpwd = trim($_POST['newpwd']);
        
        if(!$this->ChangePasswordInDB($user_rec, $newpwd))
        {
            return false;
        }
        return true;
    }
    
    //-------Public Helper functions -------------
    function GetSelfScript()
    {
        return htmlentities($_SERVER['PHP_SELF']);
    }    
    
    function SafeDisplay($value_name)
    {
        if(empty($_POST[$value_name]))
        {
            return'';
        }
        return htmlentities($_POST[$value_name]);
    }
    
    function RedirectToURL($url)
    {
        header("Location: $url");
        exit;
    }
    
    function GetSpamTrapInputName()
    {
        return 'sp'.md5('KHGdnbvsgst'.$this->rand_key);
    }
    
    function GetErrorMessage()
    {
        if(empty($this->error_message))
        {
            return '';
        }
        $errormsg = nl2br(htmlentities($this->error_message));
        return $errormsg;
    }    
    //-------Private Helper functions-----------
    
    function HandleError($err)
    {
        $this->error_message .= $err."\r\n";
    }
    
    function HandleDBError($err)
    {
        //$this->HandleError($err."\r\n mysqlerror:".sqlsrv_errors());
    }
    
    function GetFromAddress()
    {
        if(!empty($this->from_address))
        {
            return $this->from_address;
        }

        $host = $_SERVER['SERVER_NAME'];

        $from ="nobody@localhost.nl";
        return $from;
    } 
    
    function GetLoginSessionVar()
    {
        $retvar = md5($this->rand_key);
        $retvar = 'usr_'.substr($retvar,0,10);
        return $retvar;
    }
    
    function CheckLoginInDB($username, $password)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return false;
        }          
        $username = $this->SanitizeForSQL($username);

        $nresult = sqlsrv_query($this->connection, 
          "SELECT * FROM $this->tablename WHERE username = '$username'", array(), array( "Scrollable" => 'keyset' )) 
              or die(mssql_error($this->connection));
          
        // check for result 
        $no_of_rows = sqlsrv_num_rows($nresult);
        if($no_of_rows <= 0)
        {
            $this->HandleError("Error inloggen. Naam of wachtwoord is onjuist");
            return false;
        }
        
        $row = sqlsrv_fetch_array($nresult);
        if($row['confirmcode']!= 'y')
        {
            $this->HandleError("Error inloggen. Naam of wachtwoord is onjuist");
            return false;            
        }
        
        if(!password_verify($password , $row['password'] ))
        {
            $this->HandleError("Error inloggen. Naam of wachtwoord is onjuist");
            return false;
        }

        $_SESSION['id_of_user'] = $row['id_user'];
        $_SESSION['name_of_user']  = $row['name'];
        $_SESSION['email_of_user'] = $row['email'];
        $_SESSION['is_admin'] = $row['admin'];
        
        return true;
    }
   
    function UpdateDBRecForConfirmation(&$user_rec)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return false;
        }   
        $confirmcode = $this->SanitizeForSQL($_GET['code']);
        
        $result = sqlsrv_query($this->connection, "SELECT * FROM $this->tablename WHERE confirmcode = '$confirmcode'", array(), array( "Scrollable" => 'keyset' ));
        $no_of_rows = sqlsrv_num_rows($result);
        if(!$result || $no_of_rows <= 0)
        {
            $this->HandleError("Verkeerde code of al bevestigd");
            return false;
        }
        $row = sqlsrv_fetch_array($result);
        $user_rec['name'] = $row['name'];
        $user_rec['email']= $row['email'];
        
        $qry = "Update $this->tablename Set confirmcode='y' Where confirmcode='$confirmcode'";
        
        if(!sqlsrv_query($this->connection, $qry ))
        {
            $this->HandleDBError("Error inserting data to the table\nquery:$qry");
            return false;
        }      
        return true;
    }
    
    function ResetUserPasswordInDB($user_rec)
    {
        $new_password = substr(md5(uniqid()),0,10);
        
        if(false == $this->ChangePasswordInDB($user_rec,$new_password))
        {
            return false;
        }
        return $new_password;
    }
    
    function ChangePasswordInDB($user_rec, $newpwd)
    {
        $newpwd = trim($newpwd);
        $new_password = password_hash($newpwd, PASSWORD_DEFAULT);
        
        $qry = "Update $this->tablename Set password='".$new_password."' Where  id_user=".$user_rec['id_user']."";
        
        if(!sqlsrv_query($this->connection, $qry))
        {
            $this->HandleDBError("Update wachtwoord mislukt \nquery:$qry");
            return false;
        }     
        return true;
    }
    
    function GetUserFromEmail($email,&$user_rec)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return false;
        }   
        $email = $this->SanitizeForSQL($email);
        
        $result = sqlsrv_query($this->connection, "Select * from $this->tablename where email='$email'");  

        if(!$result || sqlsrv_num_rows($result) <= 0)
        {
            $this->HandleError("Er is geen gebruiker met deze email: $email");
            return false;
        }
        $user_rec = sqlsrv_fetch_array($result);

        
        return true;
    }
    
    function SendUserWelcomeEmail(&$user_rec)
    {
        $mailer = new PHPMailer(true);
        $mailer->SMTPDebug = SMTP::DEBUG_SERVER;
        $mailer->IsSMTP();
        $mailer->Host = "smtp.example.com";
        $mailer->Port = 666;
        $mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mailer->SMTPAuth = true;
        $mailer->Username = "user@example.com";
        $mailer->Password = "password";

        //create actual email:
        $mailer->setFrom('admin@versoek.nl', 'Versoek');
        $mailer->AddAddress($user_rec['email'],$user_rec['name']);
        $mailer->CharSet = 'utf-8';
        $mailer->Subject = "Welkom bij ".$this->sitename;
        //$mailer->From = $this->GetFromAddress();        
        $mailer->Body ="Hello ".$user_rec['name']."\r\n".
        "\r\n".
        "Jouw registratie met ".$this->sitename." is voltooid.\r\n".
        "\r\n".
        "Met vriendelijke groet,\r\n".
        $this->sitename.
        "\r\n".
        "Uitschrijven: link";

        if(!$mailer->Send())
        {
            $this->HandleError("Zenden welkom email mislukt.");
            return false;
        }
        return true;
    }
    
    function SendAdminIntimationOnRegComplete(&$user_rec)
    {
        if(empty($this->admin_email))
        {
            return false;
        }

        $mailer = new PHPMailer(true);
        $mailer->SMTPDebug = SMTP::DEBUG_SERVER;
        $mailer->IsSMTP();
        $mailer->Host = "smtp.example.com";
        $mailer->Port = 666;
        $mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mailer->SMTPAuth = true;
        $mailer->Username = "user@example.com";
        $mailer->Password = "password";

        //create actual email:
        $mailer->setFrom('admin@versoek.nl', 'Versoek');
        $mailer->AddAddress($this->admin_email);
        $mailer->Subject = "Registratie voltooid: ".$user_rec['name'];
        //$mailer->From = $this->GetFromAddress();         
        
        $mailer->Body ="Een nieuwe gebruiker geregistreerd bij ".$this->sitename."\r\n".
        "Naam: ".$user_rec['name']."\r\n".
        "Email: ".$user_rec['email']."\r\n";
        
        if(!$mailer->Send())
        {
            return false;
        }
        return true;
    }
    
    function GetResetPasswordCode($email)
    {
       return substr(md5($email.$this->sitename.$this->rand_key),0,10);
    }
    
    function SendResetPasswordLink($user_rec)
    {
        $email = $user_rec['email'];
        
        $mailer = new PHPMailer(true);
        $mailer->SMTPDebug = SMTP::DEBUG_SERVER;
        $mailer->IsSMTP();
        $mailer->Host = "smtp.example.com";
        $mailer->Port = 666;
        $mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mailer->SMTPAuth = true;
        $mailer->Username = "user@example.com";
        $mailer->Password = "password";
        
        $mailer->AddAddress($email,$user_rec['name']);
        $mailer->Subject = "Wachtwoord reset voor ".$this->sitename;
        $mailer->From = $this->GetFromAddress();
        
        $link = $this->GetAbsoluteURLFolder().
                '/resetpwd.php?email='.
                urlencode($email).'&code='.
                urlencode($this->GetResetPasswordCode($email));

        $mailer->Body ="Hallo ".$user_rec['name']."\r\n\r\n".
        "Er was een verzoek om jouw wachtwoord te resetten op ".$this->sitename."\r\n".
        "Gebruik te volgende link om het verzoek te voltooien: \r\n".$link."\r\n".
        "Met vriendelijke groet,\r\n".
        "Webmaster\r\n".
        $this->sitename;
        
        if(!$mailer->Send())
        {
            return false;
        }
        return true;
    }
    
    function SendNewPassword($user_rec, $new_password)
    {
        $email = $user_rec['email'];
        
        $mailer = new PHPMailer(true);
        $mailer->SMTPDebug = SMTP::DEBUG_SERVER;
        $mailer->IsSMTP();
        $mailer->Host = "smtp.example.com";
        $mailer->Port = 666;
        $mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mailer->SMTPAuth = true;
        $mailer->Username = "user@example.com";
        $mailer->Password = "password";
        
        $mailer->AddAddress($email,$user_rec['name']);
        $mailer->Subject = "Jouw nieuwe wachtwoord voor ".$this->sitename;
        $mailer->From = $this->GetFromAddress();
        
        $mailer->Body ="Hallo ".$user_rec['name']."\r\n\r\n".
        "Jouw wachtwoord is succesvol gereset. ".
        "Hier is jouw nieuwe login:\r\n".
        "gebruikersnaam:".$user_rec['username']."\r\n".
        "wachtwoord:$new_password\r\n".
        "\r\n".
        "Login: ".$this->GetAbsoluteURLFolder()."/login.php\r\n".
        "\r\n".
        "Met vriendelijke groet,\r\n".
        "Versoek.nl\r\n".
        $this->sitename;
        
        if(!$mailer->Send())
        {
            return false;
        }
        return true;
    }    
    
    function ValidateRegistrationSubmission()
    {
        //This is a hidden input field. Humans won't fill this field.
        if(!empty($_POST[$this->GetSpamTrapInputName()]) )
        {
            //The proper error is not given intentionally
            $this->HandleError("Automated submission prevention: case 2 failed");
            return false;
        }
        
        $validator = new FormValidator();
        $validator->init();
        $validator->addValidation("name","req","Vul een naam in");
        $validator->addValidation("email","email","Geen geldig email adres ingevuld");
        $validator->addValidation("email","req","Vul een email adres in");
        $validator->addValidation("password","req","Geef een wachtwoord op");
        
        if(!$validator->ValidateForm())
        {
            $error='';
            $error_hash = $validator->GetErrors();
            foreach($error_hash as $inpname => $inp_err)
            {
                $error .= $inpname.':'.$inp_err."\n";
            }
            $this->HandleError($error);
            return false;
        }        
        return true;
    }
    
    function CollectRegistrationSubmission(&$formvars)
    {
        $formvars['name'] = $this->Sanitize($_POST['name']);
	    $formvars['username'] = $this->Sanitize($_POST['username']);
        $formvars['email'] = $this->Sanitize($_POST['email']);
        $formvars['password'] = $this->Sanitize($_POST['password']);
   
    }
    
    function SendUserConfirmationEmail(&$formvars)
    {
        $mailer = new PHPMailer(true);
        $mailer->SMTPDebug = SMTP::DEBUG_SERVER;
        $mailer->IsSMTP();
        $mailer->Host = "smtp.example.com";
        $mailer->Port = 666;
        $mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mailer->SMTPAuth = true;
        $mailer->Username = "user@example.com";
        $mailer->Password = "password";
        //create actual email:
        $mailer->setFrom('user@example.com', 'Matthijs');
        $mailer->AddAddress($formvars['email'],$formvars['name']);
        $mailer->isHTML(true);
        $mailer->Subject = "Jouw registratie bij ".$this->sitename; 
        $confirmcode = $formvars['confirmcode'];
        $confirm_url = $this->GetAbsoluteURLFolder().'/create_account_to_confirm.php?code='.$confirmcode;
        $mailer->Body ="Hallo ".$formvars['name']."\r\n\r\n".
        "Bedankt voor jouw registratie op ".$this->sitename."\r\n".
        "Klik hier om jouw registratie te bevestigen:\r\n".
        "$confirm_url\r\n".
        "\r\n".
        "Met vriendelijke groet,\r\n".
        "Versoek.nl\r\n".
        $this->sitename;        

        if(!$mailer->Send())
        {
            $this->HandleError("Failed sending registration confirmation email.");
            return false;
        }
        return true;
    }
    
    function GetAbsoluteURLFolder()
    {
        $scriptFolder = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';

        $urldir ='';
        $pos = strrpos($_SERVER['REQUEST_URI'],'/');
        if(false !==$pos)
        {
            $urldir = substr($_SERVER['REQUEST_URI'],0,$pos);
        }

        $scriptFolder .= $_SERVER['HTTP_HOST'].$urldir;

        return $scriptFolder;
    }
    
    function SendAdminIntimationEmail(&$formvars)
    {
        if(empty($this->admin_email))
        {
            return false;
        }

        $mailer = new PHPMailer();
        $mailer->CharSet = 'utf-8';
        $mailer->AddAddress($this->admin_email);
        
        $mailer->Subject = "Nieuwe registratie: ".$formvars['name'];
        $mailer->From = $this->GetFromAddress();         
        
        $mailer->Body ="Een nieuwe gebruiker geregistreerd op ".$this->sitename."\r\n".
        "Naam: ".$formvars['name']."\r\n".
        "Email: ".$formvars['email']."\r\n".
        "UserName: ".$formvars['username'];
        
        if(!$mailer->Send())
        {
            return false;
        }
        return true;
    }
    
    function SaveToDatabase(&$formvars)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login mislukt!");
            return "fail 03 - a";//false;
        }
        // if(!$this->Ensuretable())
        // {
        //     return "fail 03 - b";//false;
        // }
        if(!$this->IsFieldUnique($formvars,'email'))
        {
            $this->HandleError("Dit email adres staat al geregistreerd");
            return "fail 03 - c";//false;
        }
        
	    if(!$this->IsFieldUnique($formvars,'username'))
        {
            $this->HandleError("Deze gebruikersnaam bestaat al, probeer een andere naam");
            return "fail 03 - d";//false;
        } 
        
        if(!$this->InsertIntoDB($formvars))
        {
            $this->HandleError("Inserting to Database failed!");
            return false;
        }
        return true;
    }
    
    function IsFieldUnique($formvars,$fieldname)
    {
        $field_val = $this->SanitizeForSQL($formvars[$fieldname]);
        $qry = "select username from $this->tablename where $fieldname='".$field_val."'";
        $result = sqlsrv_query($this->connection, $qry);   
        if($result && sqlsrv_num_rows($result) > 0)
        {
            return false;
        }
        return true;
    }
    
    function DBLogin()
    {
       // $this->connection = mysqli_connect($this->db_host,$this->username,$this->pwd, $this->database);

        $connectionInfo = array( "Database"=>$this->database, "UID"=>$this->username, "PWD"=>$this->pwd);

        $this->connection = sqlsrv_connect( $this->db_host, $connectionInfo);

        if(!$this->connection)
        {   
            $this->HandleDBError("Database login mislukt! Please make sure that the DB login credentials provided are correct");
            return false;
        }

        // if(!mysqli_select_db($this->connection, $this->database))
        // {
        //     $this->HandleDBError('Failed to select database: '.$this->database.' Please make sure that the database name provided is correct');
        //     return false;
        // }

        // if(!sqlsrv_query($this->connection, "SET NAMES 'UTF8'"))
        // {
        //     $this->HandleDBError('Error setting utf8 encoding');
        //     return false;
        // }

        return true;
    }    
    
    function Ensuretable()
    {
        $result = sqlsrv_query($this->connection, "SHOW COLUMNS FROM $this->tablename");   
        if(!$result || sqlsrv_num_rows($result) <= 0)
        {
            return $this->CreateTable();
        }
        return true;
    }
    
    function CreateTable()
    {
    	$qry = "Create Table $this->tablename (".
                "id_user INT NOT NULL AUTO_INCREMENT ,".
                "name VARCHAR( 128 ) NOT NULL ,".
                "email VARCHAR( 64 ) NOT NULL ,".
                "phone_number VARCHAR( 16 ) DEFAULT NULL ,".
                "username VARCHAR( 16 ) NOT NULL ,".
                "password VARCHAR( 255 ) NOT NULL ,".
                "confirmcode VARCHAR(32) ,".
                "PRIMARY KEY ( id_user )".
                ")";
                
        if(!sqlsrv_query($this->connection, $qry))
        {
            $this->HandleDBError("Error creating the table \nquery was\n $qry");
            return false;
        }
        return true;
    }
    
    function InsertIntoDB(&$formvars)
    {
        $confirmcode = $this->MakeConfirmationMd5($formvars['email']);
        $formvars['confirmcode'] = $confirmcode;
        $password = trim($formvars['password']);
        $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
        
        $insert_query = "insert into ".$this->tablename." (
            name,
            email,
            username,	
            password,
            confirmcode,
            admin
            )
            values
            (
            '" . $this->SanitizeForSQL($formvars['name']) . "',
            '" . $this->SanitizeForSQL($formvars['email']) . "',
            '" . $this->SanitizeForSQL($formvars['username']) . "',
            '" . $encrypted_password . "',
            '" . $confirmcode . "',
            '0'
            )";

        if(!sqlsrv_query($this->connection, $insert_query ))
        {
            $this->HandleDBError("Error inserting data to the table\nquery:$insert_query");
            $errors = print_r(sqlsrv_errors(), true);

            return false;
        }        
        return true;
    }

    function MakeConfirmationMd5($email)
    {
        $randno1 = rand();
        $randno2 = rand();
        return md5($email.$this->rand_key.$randno1.''.$randno2);
    }
    function SanitizeForSQL($str)
    {
        if( function_exists( "mssql_real_escape_string" ) )
        {
              $ret_str = mssql_real_escape_string($this->connection, $str );
        }
        else
        {
              $ret_str = addslashes( $str );
        }
        return $ret_str;
    }
    
 /*
    Sanitize() function removes any potential threat from the
    data submitted. Prevents email injections or any other hacker attempts.
    if $remove_nl is true, newline chracters are removed from the input.
    */
    function Sanitize($str,$remove_nl=true)
    {
        $str = $this->StripSlashes($str);

        if($remove_nl)
        {
            $injections = array('/(\n+)/i',
                '/(\r+)/i',
                '/(\t+)/i',
                '/(%0A+)/i',
                '/(%0D+)/i',
                '/(%08+)/i',
                '/(%09+)/i'
                );
            $str = preg_replace($injections,'',$str);
        }

        return $str;
    } 

    function StripSlashes($str)
    {
        $str = stripslashes($str);
        
        return $str;
    }    
}

