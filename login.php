<?php
session_start();

if(isset($_COOKIE["remember_user"])){
    $user_id=$_COOKIE["remember_user"];
    $_SESSION["user_id"] = $user_id;
    header("Location: welcome.php");
    exit;
}

//echo password_hash("hosni123", PASSWORD_DEFAULT);
//echo password_hash("Hosni03$", PASSWORD_DEFAULT);

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $email=$_POST['email'];
        $password=$_POST['password'];
    
    // البحث عن ال email  في الداتابيس *****
    $conn=new mysqli("localhost" , "root" , "" , "project_pro");
    $sql="SELECT * FROM users WHERE email =? ";
    $stmt = $conn->prepare($sql);
    $stmt -> bind_param("s" , $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows==1){
    $user = $result->fetch_assoc();

    
    //************
    if ($user["locked_until"] != NULL) {
    if (time() < strtotime($user["locked_until"])) {
        echo "Login is temporarily blocked until " . $user["locked_until"];
        exit;
        }
        else{
                $sql = "UPDATE users SET failed_attempts = 0, last_failed_login = NULL,locked_until = NULL WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user["id"]);
                $stmt->execute();

            }
    }


     if (password_verify($password, $user["password"])) {
//**
         if (isset($_POST["remember"])) {
         setcookie("remember_user" , $user["id"] , time()+(7*24*60*60));
         }
         $sql = "UPDATE users SET last_login = NOW() WHERE id = ? ";
         $stmt = $conn->prepare($sql);
         $stmt->bind_param("i", $user["id"]);
         $stmt->execute();

         // NOTE: التعديل: تصفير عدد محاولات الدخول الفاشلة بعد تسجيل الدخول الصحيح
         $sql = "UPDATE users SET failed_attempts = 0, last_failed_login = NULL WHERE id = ?";
         $stmt = $conn->prepare($sql);
         $stmt->bind_param("i", $user["id"]);
         $stmt->execute();

         $_SESSION["user_id"] = $user["id"];
         $_SESSION["user_name"] = $user["f_name"];
         $_SESSION["user_email"] = $user["email"];
         $_SESSION["user_role"] = $user["role"];
     
         if ($user["role"] == "admin") {
             header("Location: admin.php");
         } else {
             header("Location: welcome.php");
         }
          exit;
         }       
        else {//*****************

            $failed_attempts = $user["failed_attempts"] + 1;

            // NOTE: التعديل: إذا وصل المستخدم إلى 3 محاولات فاشلة يتم قفل الحساب لمدة 5 دقائق
            if ($failed_attempts >= 5) {
                $sql = "UPDATE users SET failed_attempts = ?, last_failed_login = NOW(), locked_until = DATE_ADD(NOW(), INTERVAL 5 MINUTE) WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $failed_attempts, $user["id"]);
                $stmt->execute();

                echo "Login is temporarily blocked for 5 minutes";
                exit;
            }

            $sql = "UPDATE users SET failed_attempts = ?, last_failed_login = NOW() WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $failed_attempts, $user["id"]);
            $stmt->execute();

            echo "Invalid password";
        }     
     }else {
         echo "Invalid email";
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
            <div class="col-md-5">
                <div class="card shadow mt-5">
                    <div class="card-header text-center">
                        <h3>Login</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                           <div class="form-check mb-3 ">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    name="remember" 
                                    id="remember"
                                    style="border: 2px solid #135183";
                                >
                                <label class="form-check-label" for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>