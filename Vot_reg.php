<?php

    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "online_voting";

    $conn = mysqli_connect($host, $user, $password, $dbname);

    if(!$conn){
        die("Connection failed");
    }

    $name = $_POST["fname"];
    $age = filter_input(INPUT_POST, "age", FILTER_VALIDATE_INT);
    $h_addr = $_POST["addr"];
    $district = $_POST["dis"];
    $ph_no = $_POST["phno"];
    $pass = $_POST["psw"];
    $voter_ID = $_POST["V_ID"];

    $sql = "INSERT INTO voters_list (V_ID, Full_Name, Age, H_addr, District, Ph_no, Pwd)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        die(mysqli_error($conn));
    }

    mysqli_stmt_bind_param(
        $stmt,
        "ssissis",
        $voter_ID,
        $name,
        $age,
        $h_addr,
        $district,
        $ph_no,
        $pass
    );

    mysqli_stmt_execute($stmt);

    echo "<h2>Voter successfully registered, Please go back and login to your account.</h2>";

    exit;

?>
