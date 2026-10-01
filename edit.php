<?php
session_start();

if(!isset($_SESSION["user_role"]) || $_SESSION["user_role"] != "admin"){
    header("Location: login.php");
    exit;
}

$id = $_GET["id"];

$conn = new mysqli("localhost", "root", "", "project_pro");

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();





if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $f_name = $_POST["f_name"];
    $s_name = $_POST["s_name"];
    $th_name = $_POST["th_name"];
    $l_name = $_POST["l_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $birth_date = $_POST["birth_date"];
    if(!preg_match("/^[A-Za-z]+$/", $f_name)){
        echo "First name must contain letters only";
        exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email";
            exit;
        }

        if(!preg_match("/^[0-9]{14}$/", $phone)){
            echo "Phone must be 14 digits";
            exit;
        }
        if (empty($birth_date)) {
        echo "Birth date is required";
        exit; }
         

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

        $sql = "SELECT * FROM users WHERE email = ? AND id != ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $email, $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Email already exists";
            exit;
        }


$sql = "UPDATE users SET 
f_name = ?, 
s_name = ?, 
th_name = ?, 
l_name = ?, 
email = ?, 
phone = ?, 
birth_date = ?
WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "sssssssi",
    $f_name,
    $s_name,
    $th_name,
    $l_name,
    $email,
    $phone,
    $birth_date,
    $id
);

if($stmt->execute()){
    header("Location: admin.php");
    exit;
}}
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
                <div class="card shadow mt-5">
                    <div class="card-header text-center">
                        <h3>Edit User</h3>
                    </div>
                    <div class="card-body">
                        <form method="post">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">First Name</label>
                                    <input type="text" name="f_name" class="form-control" value="<?php echo $user["f_name"]; ?>">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Second Name</label>
                                    <input type="text" name="s_name" class="form-control" value="<?php echo $user["s_name"]; ?>">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Third Name</label>
                                    <input type="text" name="th_name" class="form-control" value="<?php echo $user["th_name"]; ?>">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="l_name" class="form-control" value="<?php echo $user["l_name"]; ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo $user["email"]; ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="<?php echo $user["phone"]; ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Birth Date</label>
                                <input type="date" name="birth_date" class="form-control" value="<?php echo $user["birth_date"]; ?>">
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="admin.php" class="btn btn-secondary">Cancel</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>