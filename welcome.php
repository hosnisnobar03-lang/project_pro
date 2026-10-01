<?php

    session_start();
    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit;
    }
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
</head>
<body class="bg-light">

    <div class="container">
        <div class="card shadow mt-5 mx-auto" style="max-width: 600px;">
            <div class="card-body text-center">
                <h2 class="mb-3">Welcome</h2>
                <p class="mb-2"><?php echo $_SESSION["user_name"]; ?></p>
                <p class="text-muted"><?php echo $_SESSION["user_email"]; ?></p>
                <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
            </div>
        </div>
    </div>

</body>
</html>