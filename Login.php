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

    $v_id = $_POST['voter_ID'];
    $pass = $_POST['password'];

    if($v_id === 'ADMIN' && $pass === '12345') {
        header("Location: http://localhost/Mini%20Project/Online%20Voting%20System/admin.php?cid=NULL");
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM voters_list WHERE V_ID = ?");
    $stmt->bind_param("s", $v_id);
    $stmt->execute();
    $stmt_result = $stmt->get_result();

    if($stmt_result->num_rows>0) {
        $data = $stmt_result->fetch_assoc();
        if($data['Pwd'] === $pass && $data['Flag'] === 0) {
            echo "";
        }
        else if ($data['Flag'] === 1) {
            header("Location: http://localhost/Mini%20Project/Online%20Voting%20System/Result.php");
        }
        else {
            echo "<h2>Invalid credentials, Please enter valid credentials</h2>";
            exit(0);
        }
    }
    else {
        echo "<h2>Invalid Voter ID, Please enter a valid Voter ID</h2>";
        exit(0);
    }

    $_SESSION['vot_id'] = $v_id;
    $_SESSION['name'] = $data['Full_Name'];
    $_SESSION['addr'] = $data['District'];

    $stmt = $conn->prepare("SELECT * FROM candidate_list WHERE Participation_reg = ?");
    $stmt->bind_param("s", $data['District']);
    $stmt->execute();
    $stmt_result = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Choose Candidate</title>
        <link rel="icon" type="image/x-icon" href="Images/Voter.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="PageStyle2.css">
    </head>

    <body>
        <div class="header">
            <a class="title">
                Welcome, <?php echo $_SESSION['name']; ?>
            </a>
            <div class="header-right">
                <a class="active" href="Entry_page.html"><i class="fa fa-fw fa-sign-out"></i>Log-out</a>
                <a class="active" href="Entry_page.html"><i class="fa fa-fw fa-list-alt"></i>Results</a>
            </div>
        </div>
        <div class="table">
            <table>
                <tr>
                  <th><h2>Candidate ID</h2></th>
                  <th><h2>Candidate name</h2></th>
                  <th><h2>Party</h2></th>
                  <th><h2>Party Symbol</h2></th>
                  <th><h2>Selection</h2></th>
                </tr>

                <?php
                    while($rows = $stmt_result->fetch_assoc())
                    {
                ?>
                    <tr>
                        <td><?php echo $rows['Can_ID']; ?></td>
                        <td><?php echo $rows['Name']; ?></td>
                        <td><?php echo $rows['Party']; ?></td>
                        <td>
                            <?php 
                                if($rows['Party'] === 'BJP') {
                            ?>
                                <img src="Images/BJP.png" style="width: 50%; height: 350%;">
                            <?php
                                } 
                            ?>
                            <?php
                                if($rows['Party'] === 'Congress') {
                            ?>
                                <img src="Images/Congress.png" style="width: 50%; height: 350%;">
                            <?php
                                } 
                            ?>
                            <?php
                                if($rows['Party'] === 'JDS') {
                            ?>
                                <img src="Images/JDS.png" style="width: 50%; height: 350%;">
                            <?php
                                } 
                            ?>
                        </td>
                        <td>
                            <a href="Process.php?can_id=<?php echo $rows['Can_ID']; ?>&i=1">
                                <button class="signupbtn">Vote</button>
                            </a>
                        </td>
                    </tr>
                <?php
                    }
                ?>
            </table>
        </div>
    </body>
</html>
