<?PHP
    require_once("./include/fg_membersite.php");

    $fgmembersite = new FGMembersite();

    //Provide your site name here
    $fgmembersite->SetWebsiteName('versoek.nl');

    //Provide the email address where you want to get notifications
    $fgmembersite->SetAdminEmail('admin@example.nl');

    //Provide your database login details here:
    //hostname, user name, password, database name and table name
    //note that the script will create the table (for example, fgusers in this case)
    //by itself on submitting register.php for the first time
    $fgmembersite->InitDB(/*hostname*/'sql.versoek.nl', /*username*/'username', /*password*/'sql_password_here', /*database name*/'versoeknl', /*table name*/'news_items');

    //For better security. Get a random string from this link: http://tinyurl.com/randstr
    // and put it here
    $fgmembersite->SetRandomKey('random_key');
?>
