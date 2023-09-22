<?PHP
    require_once("./include/fg_membersite.php");

    $fgmembersite = new FGMembersite();

    //Provide your site name here
    //$fgmembersite->SetWebsiteName('smilescrowd.nl');
    $fgmembersite->SetWebsiteName('versoek.nl');

    //Provide the email address where you want to get notifications
    //$fgmembersite->SetAdminEmail('mplatje@gmail.com');
    $fgmembersite->SetAdminEmail('m.platje@pl.hanze.nl');

    //Provide your database login details here:
    //hostname, user name, password, database name and table name
    //note that the script will create the table (for example, fgusers in this case)
    //by itself on submitting register.php for the first time
    //$fgmembersite->InitDB(/*hostname*/'localhost', /*username*/'root', /*password*/'', /*database name*/'smile', /*table name*/'members');
    $fgmembersite->InitDB(/*hostname*/'sql.versoek.nl', /*username*/'versoeknl', /*password*/'%qM1!qL)UQ', /*database name*/'versoeknl', /*table name*/'news_items');

    //For better security. Get a random string from this link: http://tinyurl.com/randstr
    // and put it here
    $fgmembersite->SetRandomKey('qSRcVS6DrTzrPvr');
?>