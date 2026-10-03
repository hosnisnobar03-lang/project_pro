<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET["success"])) {
    echo "Password changed successfully";
}

$conn = new mysqli("localhost", "root", "", "project_pro");
$user_id=$_SESSION["user_id"];
$sql="SELECT * FROM users WHERE id=?";
$stmt=$conn->prepare($sql);
$stmt-> bind_param('i' , $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = $_POST["full_name"];
    $phone = $_POST["phone"];

    if (!preg_match("/^[A-Za-z]+( [A-Za-z]+){3}$/", $full_name)) {
        echo "Full name must contain 4 names";
        exit;
    }
        if(!preg_match("/^[0-9]{14}$/" , $phone)){
        echo "Phone must be 14 digits";
        exit;
    }

    $sql = "UPDATE users SET f_name = ?, phone = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $full_name, $phone, $user_id);
    $stmt->execute();

    header("location: welcome.php")  ;
}




?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>My Profile</title>
</head>

<body class="bg-light">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card shadow mt-5 mb-4">

                    <div class="card-header text-center">
                        <h3>My Profile</h3>
                    </div>

                    <div class="card-body">

                        <div class="text-center mb-4">

                            <?php if (!empty($user["profile_photo"])) { ?>

                                <img src="uploads/<?php echo $user["profile_photo"]; ?>"
                                     width="150"
                                     height="150"
                                     class="rounded-circle">

                            <?php } else { ?>

                                <img src="images/default.png"
                                     width="150"
                                     height="150"
                                     class="rounded-circle">

                            <?php } ?>

                        </div>


                        <div class="mb-3">
                            <p><strong>Name:</strong>
                                <?php echo $user["f_name"]; ?>
                            </p>

                            <p><strong>Email:</strong>
                                <?php echo $user["email"]; ?>
                            </p>

                            <p><strong>Phone:</strong>
                                <?php echo $user["phone"]; ?>
                            </p>

                            <p><strong>Role:</strong>
                                <?php echo $user["role"]; ?>
                            </p>
                        </div>


                        <hr>


                        <h5 class="mb-3">Edit Profile</h5>

                        <form method="post">

                            <div class="mb-3">

                                <label class="form-label">Full Name</label>

                                <input type="text"
                                       name="full_name"
                                       class="form-control"
                                       value="<?php echo $user["f_name"]; ?>">

                            </div>


                            <div class="mb-3">

                                <label class="form-label">Phone</label>

                                <input type="text"
                                       name="phone"
                                       class="form-control"
                                       value="<?php echo $user["phone"]; ?>">

                            </div>


                            <p class="text-muted">
                                Email: <?php echo $user["email"]; ?>
                            </p>


                            <button type="submit" class="btn btn-primary w-100">
                                Save
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>