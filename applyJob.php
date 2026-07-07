<?php

if(isset($_GET['id'])){
    $pid = $_GET['id'];
    $redirectPage = 'jobs.php';
    if (isset($_GET['redirect'])) {
        $requestedRedirect = basename($_GET['redirect']);
        $allowedRedirects = array('jobs.php', 'eligibleJobs.php');
        if (in_array($requestedRedirect, $allowedRedirects, true)) {
            $redirectPage = $requestedRedirect;
        }
    }
    session_start();
    if(isset($_SESSION['sid'])){
        include 'connect.php';
        $sid = $_SESSION['sid'];
        
        $sql = "select * from jobsapplied where pid='$pid' and sid='$sid';";
        $result=$conn->query($sql);
        $count=$result->num_rows;
            if($count>0){
                header('location: ' . $redirectPage . '?msg=dup');
                die();
            }
        
        $sql = "INSERT INTO `jobsapplied` "
                . "(`id`, `date`, `pid`, `sid`, `status`) "
                . "VALUES (NULL, CURRENT_DATE(), '$pid', '$sid', 'Applied');";
        if ($conn->query($sql) === TRUE) {
       
                header('location: ' . $redirectPage . '?msg=success');
                
            }else{
                header('location: ' . $redirectPage . '?msg=failed');
            }
    }else{
        header('location:' . $redirectPage . '?msg=login');
    }
}

?>