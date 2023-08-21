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

    $stmt = $conn->prepare("SELECT * FROM candidate_list");
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
        <link rel="stylesheet" href="PageStyle.css">
    </head>

    <body>
        <div class="header">
            <a class="title">
                ADMIN PORTAL
            </a>
            <div class="header-right">
                <a class="active" href="Entry_page.html"><i class="fa fa-fw fa-sign-out"></i>Log-out</a>
                <a class="active" href="Result.php"><i class="fa fa-fw fa-list-alt"></i>Results</a>
            </div>
        </div>
        <div class="table">
            <table>
                <tr>
                  <th><h2>Candidate ID</h2></th>
                  <th><h2>Candidate name</h2></th>
                  <th><h2>Party</h2></th>
                  <th><h2>Votes gained</h2></th>
                  <th><h2>Participation region</h2></th>
                  <th><h2>Operation</h2></th>
                </tr>

                <?php
                    while($rows = $stmt_result->fetch_assoc())
                    {
                ?>
                    <tr>
                        <td><?php echo $rows['Can_ID']; ?></td>
                        <td><?php echo $rows['Name']; ?></td>
                        <td><?php echo $rows['Party']; ?></td>
                        <td><?php echo $rows['Votes_gained']; ?></td>
                        <td><?php echo $rows['Participation_reg']; ?></td>
                        <td>
                            <a href="Process.php?cid=<?php echo $rows['Can_ID']; ?>&i=2">
                                <button class="btn">Delete</button>
                            </a><br>
                            <a href="admin.php?cid=<?php echo $rows['Can_ID']; ?>&#id01">
                                <button class="btn" onclick="document.getElementById('id01').style.display='block'">Update</button>
                            </a>
                        </td>
                    </tr>
                <?php
                    }
                ?>
            </table>
        </div><br>
        <div id="id01">
            <?php
            $cid = $_GET['cid'];
                $stmt = $conn->prepare("SELECT * FROM Candidate_list WHERE Can_ID = ?");
                $stmt->bind_param("s", $cid);
                $stmt->execute();
                $stmt_result = $stmt->get_result();
                if ($stmt_result->num_rows > 0) {
                    $res = $stmt_result->fetch_assoc();
            ?>
            <form class="modal-content" action="Process.php?i=3" method="post">
                <div class="container">
                    <label style="font-size: 25px;"><b>Candidate details updataion</b></label><br><br>
                    <label for="can_id"><b>Candidate ID*</b></label>
                    <input type="text" value="<?php echo $res['Can_ID']; ?>" name="can_id" readonly>
                    <label for="can_name"><b>Candidate Name*</b></label>
                    <input type="text" value="<?php echo $res['Name']; ?>" name="can_name" required>
                    <label for="party"><b>Party*</b></label>
                    <select name="party" required>
                        <option value="BJP" selected>Bharatiya Janata Party (BJP)</option>
                        <option value="Congress">Indian National Congress (INC)</option>
                        <option value="JDS">Janata Dal (Secular)</option>
                    </select><br>
                    <label for="p_reg"><b>Participation region*</b></label>
                    <input type="text" value="<?php echo $res['Participation_reg']; ?>" name="p_reg" readonly><br>
                    <div class="clearfix">
                        <button type="submit" class="signupbtn">Update</button><br>
                        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn" style="width: 100%;">Cancel</button>
                    </div>
                </div>
            </form>
            <?php
                }
                else {
                    exit(0);
                }
            ?>
        </div>
    </body>
</html>
