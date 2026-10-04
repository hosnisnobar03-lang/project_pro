<?php

$conn=new mysqli("localhost" , "root" , "" , "project_pro");
if($_SERVER ["REQUEST_METHOD"]=="POST"){
    
    $f_name=$_POST["f_name"];
    $s_name = $_POST["s_name"];
    $th_name = $_POST["th_name"];
    $l_name = $_POST["l_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $birth_date = $_POST["birth_date"];

    if(!preg_match("/^[A-Za-z]+$/" , $f_name)){
        echo "First name must contain letters only";
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email";
        exit;
    }
    if(!preg_match("/^[0-9]{14}$/" , $phone)){
        echo "Phone must be 14 digits";
        exit;
    }
    if (//هاض الشرط اول مره بنفذو 
    strlen($password) < 8 ||
    !preg_match("/[A-Z]/", $password) ||
    !preg_match("/[a-z]/", $password) ||
    !preg_match("/[0-9]/", $password) ||
    !preg_match("/[^a-zA-Z0-9]/", $password)){
    echo "Password is invalid";
    exit;
    }
    if ($confirm_password != $password) {
    echo "Passwords do not match";
    exit;
    }
    if (empty($birth_date)) {
    echo "Birth date is required";
    exit;
    }
    // *****جديييييد**
    $birth = new DateTime($birth_date);
    $today = new DateTime();

    if ($birth > $today) {
        echo "Birth date cannot be in the future";
        exit;
    }
    $min_birth_date = new DateTime();
    $min_birth_date->modify("-16 years");
    
    if ($birth >= $min_birth_date) {
        echo "You must be older than 16";
        exit;
    }

    //******** 
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);// اول مره استعملو عشان تكون بيانات الباسوورد مشفره

    // ال  ENSERT
    $sql = "INSERT INTO users 
    (f_name, s_name, th_name, l_name, email, phone, password, birth_date  , created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ? , now())";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssssssss",
        $f_name,
        $s_name,
        $th_name,
        $l_name,
        $email,
        $phone,
        $hashed_password,
        $birth_date
    );
    if($stmt->execute()){
        // echo "Account created successfully";
        header("location:login.php");
        exit;
    }
    
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow mt-4 mb-4">
                    <div class="card-header text-center">
                        <h3>Create Account</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">First Name</label>
                                    <input type="text" name="f_name" class="form-control" placeholder="First Name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Second Name</label>
                                    <input type="text" name="s_name" class="form-control" placeholder="Second Name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Third Name</label>
                                    <input type="text" name="th_name" class="form-control" placeholder="Third Name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="l_name" class="form-control" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="Phone">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Birth Date</label>
                                <input type="date" name="birth_date" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Create Account</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        Already have an account?
                        <a href="login.php">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>