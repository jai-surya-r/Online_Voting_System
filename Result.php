<?php

    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "online_voting";

    $conn = mysqli_connect($host, $user, $password, $dbname);

    if(!$conn){
        die("Connection failed");
    }

    $stmt = $conn->prepare("SELECT * FROM candidate_list");
    $stmt->execute();
    $stmt_result = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Result</title>
        <link rel="icon" type="image/x-icon" href="Images/Voter.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="PageStyle2.css">
    </head>

    <body>
        <div class="header">
            <a class="title">
                Thank you for voting!
            </a>
            <div class="header-right">
                <a class="active" href="Entry_page.html"><i class="fa fa-fw fa-sign-out"></i>Log-out</a>
            </div>
        </div>
        <div class="table">
            <table>
                <tr>
                  <th><h2>Candidate ID</h2></th>
                  <th><h2>Candidate name</h2></th>
                  <th><h2>Party</h2></th>
                  <th><h2>Candidate</h2></th>
                  <th><h2>Votes Gained</h2></th>
                </tr>

                <?php
                    while($rows = $stmt_result->fetch_assoc())
                    {
                ?>
                    <tr>
                    <td><?php echo $rows['Can_ID']; ?></td>
                    <td><?php echo $rows['Name']; ?></td>
                    <td><?php echo $rows['Party']; ?></td>
                    <td><?php echo $rows['Participation_reg']; ?></td>
                    <td><?php echo $rows['Votes_gained']; ?></td>
                    </tr>
                <?php
                    }
                ?>
            </table>
        </div>
    </body>
</html>
