<?php
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'problem_already_analysed':
            checkproblemanalysed($_POST['problemid']);
            break;
        case 'add_to_db':
            addtodatabase();
            break;
        case 'get_users':
            getusers();
            break;
    }    
}

function getusers(){
    $host = 'icpcproblemanalysis-db.mysql.database.azure.com';
    $username = 'icpcadminSQL@icpcproblemanalysis-db';
    $password = getenv('SQLAZURECONNSTR_sqldb-key');
    $db_name = 'allicpcdata';

    //Establishes the connection
    $link = mysqli_connect($host, $username, $password, $db_name, 3306);
    if (mysqli_connect_errno()) {
     echo "Connection error";
    }
    //Run the Select query

    $sql = 'SELECT COUNT(userip) as amount, userid FROM allicpcdata.submissions group by userid order by amount DESC';
    $result = mysqli_query($link, $sql);  
    while ($row = $result->fetch_assoc()) {       
        echo $row['userid'] . "|" . $row['amount'], "<!br?>";
    }  
    echo 'end';
    mysqli_close($link);

}

function addtodatabase(){
    $userid = $_POST['userid'];
    $submissions = checkusersubmissionamount($userid);
    if($submissions > 200 || $submissions == "error"){
        echo 'submissionlimit';
    }
    else{
        $host = 'icpcproblemanalysis-db.mysql.database.azure.com';
        $username = 'icpcadminSQL@icpcproblemanalysis-db';
        $password = getenv('SQLAZURECONNSTR_sqldb-key');
        $db_name = 'allicpcdata';

        //Establishes the connection
        $link = mysqli_connect($host, $username, $password, $db_name, 3306);
        if (mysqli_connect_errno()) {
         echo "Connection error";
        }

        //read all data        
        $userid = "'".$_POST['userid']. "',";
        $userip = "'".$_SERVER['REMOTE_ADDR'] . "',";        
        $timestamp = "'". date('Y-m-d H:i:s')."',";
        $problemseen = "'". $_POST['problemseen']. "',";

        $year = "'". $_POST['year'] . "',";
        $competition = "'". $_POST['competition']. "',";
        $problemname = "'".$_POST['problemname']. "',";
        $problemid = $_POST['problemid']. ",";
        $abbriviation = "'". $_POST['problemabbriv'] ."',";
        $category = "'".$_POST['category']. "',";
        $timelimit = "'".$_POST['timelimit']. "',";

        $data = $_POST['userinputs'];
        $inputandoutputeasiness = "'".$data['inputandoutputmanipulation']. "',";
        $codingamount = "'".$data['codingamount']. "',";
        $solutioneasiness = "'".$data['sophisticated']. "',";
        $overalldificulty = "'".$data['hardness']."'";

        $sql = "INSERT INTO allicpcdata.submissions VALUES (''," . $userid .$userip . $timestamp .  $problemseen . $year. $competition .$problemname .$problemid . $abbriviation . $category  . $timelimit  . $inputandoutputeasiness . $codingamount . $solutioneasiness .$overalldificulty . ")";

        if ($link->query($sql) === TRUE) {
            echo "Success!";
        } else {
            echo "An error occured while entering values into database";//. $sql . "<br>" . $link->error;
        }

        mysqli_close($link);
    }
}


function checkproblemanalysed($problemid){
    $host = 'icpcproblemanalysis-db.mysql.database.azure.com';
    $username = 'icpcadminSQL@icpcproblemanalysis-db';
    $password = getenv('SQLAZURECONNSTR_sqldb-key');
    $db_name = 'allicpcdata';

    //Establishes the connection
    $link = mysqli_connect($host, $username, $password, $db_name, 3306);
    if (mysqli_connect_errno()) {
     echo "Connection error";
    }
    //Run the Select query

    $sql = 'SELECT count(submissionid) as amount FROM allicpcdata.submissions WHERE problemid=' . $problemid;
    $result = mysqli_query($link, $sql);
    while ( $row = mysqli_fetch_assoc($result)){
        echo $row['amount'];
    }
    mysqli_close($link);
}

function checkusersubmissionamount($userid){
    $host = 'icpcproblemanalysis-db.mysql.database.azure.com';
    $username = 'icpcadminSQL@icpcproblemanalysis-db';
    $password = getenv('SQLAZURECONNSTR_sqldb-key');
    $db_name = 'allicpcdata';

    //Establishes the connection
    $link = mysqli_connect($host, $username, $password, $db_name, 3306);
    if (mysqli_connect_errno()) {
     echo "Connection error";
    }
    //Run the Select query

    $sql = 'SELECT count(submissionid) as amount FROM allicpcdata.submissions WHERE userid="' . $userid . '"';
    $result = mysqli_query($link, $sql);
    while ( $row = mysqli_fetch_assoc($result)){
        $yo = $row['amount'];
    }
    mysqli_close($link);
}
?>