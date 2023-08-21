<?php
    session_start();

    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "online_voting";

    $conn = mysqli_connect($host, $user, $password, $dbname);

    if(!$conn){
        die("Connection failed");
    }

    $i = $_GET['i'];

    //Changes made when user votes
    if($i === '1') {
        $can_id = $_GET['can_id'];
        $vot_id = $_SESSION['vot_id'];
        $addr = $_SESSION['addr'];

        $stmt = $conn->prepare("UPDATE candidate_list SET Votes_gained = Votes_gained + 1 WHERE Can_ID = ?");
        $stmt->bind_param("s", $can_id);
        $stmt->execute();

        $stmt = $conn->prepare("UPDATE voters_list SET Flag = 1 WHERE V_ID = ?");
        $stmt->bind_param("s", $vot_id);
        $stmt->execute();

        $stmt = $conn->prepare("INSERT INTO Election (Can_ID, Participation_reg) VALUES (?, ?)");
        $stmt->bind_param("ss", $can_id, $addr);
        $stmt->execute();

        header("Location: http://localhost/Mini%20Project/Online%20Voting%20System/Result.php");
    }

    //Deleting candidate from Admin page
    else if($i === '2') {
        $cid = $_GET['cid'];

        $stmt = $conn->prepare("DELETE FROM candidate_list WHERE Can_ID = ?");
        $stmt->bind_param("s", $cid);
        $stmt->execute();

        header("Location: http://localhost/Mini%20Project/Online%20Voting%20System/admin.php?cid=NULL");
    }

    //Updating candidate information
    else if($i === '3') {
        $cid = $_POST['can_id'];
        $cnam = $_POST['can_name'];
        $party = $_POST['party'];

        $stmt = $conn->prepare("UPDATE candidate_list SET Name = ?, Party = ? WHERE Can_ID = ?");
        $stmt->bind_param("sss", $cnam, $party, $cid);
        $stmt->execute();

        header("Location: http://localhost/Mini%20Project/Online%20Voting%20System/admin.php?cid=NULL");
    }
?>
