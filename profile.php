<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET["success"])) {
    echo '<div class="alert alert-success text-center">Password changed successfully</div>';
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

    $f_name = $_POST["f_name"];
    $s_name = $_POST["s_name"];
    $th_name = $_POST["th_name"];
    $l_name = $_POST["l_name"];
    $phone = $_POST["phone"];

    $f_name = trim($_POST["f_name"]);
    $s_name = trim($_POST["s_name"]);
    $th_name = trim($_POST["th_name"]);
    $l_name = trim($_POST["l_name"]);
    $phone = $_POST["phone"];

    if (!preg_match("/^[A-Za-z]+$/", $f_name) ||
        !preg_match("/^[A-Za-z]+$/", $s_name) ||
        !preg_match("/^[A-Za-z]+$/", $th_name) ||
        !preg_match("/^[A-Za-z]+$/", $l_name)) {

        echo "Names must contain letters only";
        exit;
    }
        if(!preg_match("/^[0-9]{14}$/" , $phone)){
        echo "Phone must be 14 digits";
        exit;
    }

    $sql = "UPDATE users SET f_name = ?, s_name = ?, th_name = ?, l_name = ?, phone = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $f_name, $s_name, $th_name, $l_name, $phone, $user_id);
    $stmt->execute();
    $_SESSION["user_name"] = $f_name;

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

    <div class="container py-5">

        <div class="card shadow border-0 mx-auto" style="max-width: 650px;">

            <div class="card-body p-5">

                <div class="text-center mb-4">

                    <h2 class="fw-bold mb-3">
                        My Profile
                    </h2>

                    <?php if (!empty($user["profile_photo"])) { ?>

                        <img src="uploads/<?php echo $user["profile_photo"]; ?>"
                             width="150"
                             height="150"
                             class="rounded-circle shadow"
                             style="object-fit: cover;">

                    <?php } else { ?>

                        <img src="images/default.png"
                             width="150"
                             height="150"
                             class="rounded-circle shadow"
                             style="object-fit: cover;">

                    <?php } ?>

                </div>


                <div class="bg-light rounded p-4 mb-4">

                    <p class="mb-3">
                        <strong>Name:</strong>
                        <?php echo $user["f_name"]; ?>
                    </p>

                    <p class="mb-3">
                        <strong>Email:</strong>
                        <?php echo $user["email"]; ?>
                    </p>

                    <p class="mb-3">
                        <strong>Phone:</strong>
                        <?php echo $user["phone"]; ?>
                    </p>

                    <p class="mb-0">
                        <strong>Role:</strong>
                        <?php echo $user["role"]; ?>
                    </p>

                </div>


                <hr class="mb-4">


                <h5 class="fw-bold mb-3">
                    Edit Profile
                </h5>

                <form method="post">

                    <div class="mb-3">
                        <label class="form-label">First Name</label>

                        <input type="text"
                               name="f_name"
                               class="form-control"
                               value="<?php echo $user["f_name"]; ?>">
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Second Name</label>

                        <input type="text"
                               name="s_name"
                               class="form-control"
                               value="<?php echo $user["s_name"]; ?>">
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Third Name</label>

                        <input type="text"
                               name="th_name"
                               class="form-control"
                               value="<?php echo $user["th_name"]; ?>">
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Last Name</label>

                        <input type="text"
                               name="l_name"
                               class="form-control"
                               value="<?php echo $user["l_name"]; ?>">
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Phone</label>

                        <input type="text"
                               name="phone"
                               class="form-control"
                               value="<?php echo $user["phone"]; ?>">
                    </div>


                    <p class="text-muted mb-4">
                        Email: <?php echo $user["email"]; ?>
                    </p>


                    <button type="submit" class="btn btn-primary w-100 py-2">
                        Save Changes
                    </button>

                    <a href="welcome.php"
                       class="btn btn-secondary w-100 mt-2 py-2">
                        Back to Welcome
                    </a>

                </form>

            </div>

        </div>

    </div>

</body>

</html>