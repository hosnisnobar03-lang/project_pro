<?php
session_start();

$conn=new mysqli("localhost" , "root" , "" , "project_pro");
$user_id=$_SESSION['user_id'];
$sql=" SELECT * FROM users WHERE id=?";
$stmt=$conn->prepare($sql);
$stmt->bind_param("i" ,$user_id );
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if($_SERVER['REQUEST_METHOD']=="POST"){
    $password=$user["password"];
    $cur_pass=$_POST["current_password"];
    $new_pass=$_POST["new_password"];
    $con_pass=$_POST["confirm_password"];

    
    if(password_verify($cur_pass , $password)){

        if($new_pass == $con_pass){
            if(
                strlen($new_pass) >= 8 &&
                preg_match("/[A-Z]/", $new_pass) &&
                preg_match("/[a-z]/", $new_pass) &&
                preg_match("/[0-9]/", $new_pass) &&
                preg_match("/[^A-Za-z0-9]/", $new_pass)
            ){
                $hashed_password=password_hash($new_pass , PASSWORD_DEFAULT);

                $sql="UPDATE users SET password=? WHERE id=? ";
                $stmt=$conn->prepare($sql);
                $stmt->bind_param('si' ,$hashed_password , $user_id );

                $stmt->execute();
                header("Location: profile.php?success=password_changed");
                exit;
    
            } else {
                echo "Password must contain uppercase, lowercase, number and special character";
            }

        } else {
            echo "New passwords do not match";
        }


    }else{
        echo "Current password is incorrect";
    }

















}





?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Change Password</title>
</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="card shadow border-0 mx-auto" style="max-width: 650px;">

            <div class="card-body p-5">

                <div class="text-center mb-4">

                    <h2 class="fw-bold mb-2">
                        Change Password
                    </h2>

                    <p class="text-muted">
                        Update your account password
                    </p>

                </div>


                <div class="bg-light rounded p-4">

                    <form method="post">

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Current Password
                            </label>

                            <input type="password"
                                   name="current_password"
                                   class="form-control"
                                   placeholder="Current Password">
                        </div>


                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                New Password
                            </label>

                            <input type="password"
                                   name="new_password"
                                   class="form-control"
                                   placeholder="New Password">
                        </div>


                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Confirm New Password
                            </label>

                            <input type="password"
                                   name="confirm_password"
                                   class="form-control"
                                   placeholder="Confirm New Password">
                        </div>


                        <button type="submit"
                                class="btn btn-warning w-100 py-2">
                            Change Password
                        </button>

                    </form>

                </div>


                <a href="welcome.php"
                   class="btn btn-secondary w-100 mt-3 py-2">
                    Back  
                </a>

            </div>

        </div>

    </div>

</body>

</html>