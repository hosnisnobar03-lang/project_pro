<?php

    session_start();
    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit;
    }
    $conn=new mysqli("localhost" , "root" , "" , "project_pro");
    // echo "Welcome " . $_SESSION["user_name"];
    // echo "<br>";
    // echo $_SESSION["user_email"];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Welcome</title>
</head>

<body class="bg-light">

    <div class="container">

        <div class="card shadow mt-5 mx-auto" style="max-width: 600px;">

            <div class="card-body text-center">

                <h2 class="mb-3">Welcome</h2>

                <p class="mb-2">
                    <?php echo $_SESSION["user_name"]; ?>
                </p>

                <p class="text-muted">
                    <?php echo $_SESSION["user_email"]; ?>
                </p>


                <?php if (!empty($user["profile_photo"])) { ?>

                    <img src="uploads/<?php echo $user["profile_photo"]; ?>"
                         width="150"
                         height="150"
                         class="rounded-circle mb-3">

                <?php } else { ?>

                    <img src="images/default.png"
                         width="150"
                         height="150"
                         class="rounded-circle mb-3">

                <?php } ?>


                <div class="mt-3">

                    <a href="profile.php" class="btn btn-primary me-2">
                        My Profile
                    </a>

                    <a href="change_pass.php" class="btn btn-warning me-2">
                        Change Password
                    </a>

                    <a href="logout.php" class="btn btn-danger">
                        Logout
                    </a>

                </div>

            </div>

        </div>

    </div>

</body>

</html>