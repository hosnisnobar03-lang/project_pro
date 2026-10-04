<?php

    session_start();
    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit;
    }
    $conn=new mysqli("localhost" , "root" , "" , "project_pro");
    $sql = "SELECT profile_photo FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
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

    <div class="container py-5">

        <div class="card shadow mx-auto border-0" style="max-width: 600px;">

            <div class="card-body text-center p-5">

                <h2 class="mb-2">Welcome</h2>

                <p class="fs-4 mb-1">
                    <?php echo $_SESSION["user_name"]; ?>
                </p>

                <p class="text-muted mb-4">
                    <?php echo $_SESSION["user_email"]; ?>
                </p>


                <?php if (!empty($user["profile_photo"])) { ?>

                    <img src="uploads/<?php echo $user["profile_photo"]; ?>"
                         width="150"
                         height="150"
                         class="rounded-circle mb-4"
                         style="object-fit: cover;">

                <?php } else { ?>

                    <img src="images/default.png"
                         width="150"
                         height="150"
                         class="rounded-circle mb-4"
                         style="object-fit: cover;">

                <?php } ?>


                <div class="row g-3 mt-2">

                    <div class="col-md-6">
                        <a href="profile.php" class="btn btn-primary w-100 py-3">
                            My Profile
                        </a>
                    </div>

                    <div class="col-md-6">
                        <a href="photo.php" class="btn btn-primary w-100 py-3">
                            Profile Photo
                        </a>
                    </div>

                    <div class="col-md-6">
                        <a href="notes.php" class="btn btn-primary w-100 py-3">
                            My Notes
                        </a>
                    </div>

                    <div class="col-md-6">
                        <a href="change_pass.php" class="btn btn-warning w-100 py-3">
                            Change Password
                        </a>
                    </div>

                    <div class="col-12">
                        <a href="logout.php" class="btn btn-danger w-100 py-2">
                            Logout
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>