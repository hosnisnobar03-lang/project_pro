<?php
session_start();

$conn = new mysqli("localhost", "root", "", "project_pro");

$user_id = $_SESSION["user_id"];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ************************ 
    if (isset($_POST["upload"])) {

        $photo = $_FILES["profile_photo"];

        if ($photo["size"] > 2 * 1024 * 1024) {

            $message = "Image must be less than 2MB";

        } elseif (
            $photo["type"] != "image/jpeg" &&
            $photo["type"] != "image/png"
        ) {

            $message = "Only JPG and PNG allowed";

        } elseif (getimagesize($photo["tmp_name"]) == false) {

            $message = "Invalid image";

        } else {

            $photo_name = time() . "_" . $photo["name"];

            move_uploaded_file(
                $photo["tmp_name"],
                "uploads/" . $photo_name
            );

            $sql = "SELECT profile_photo FROM users WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            // حذف الصورة القديمة
            if (
                !empty($user["profile_photo"]) &&
                file_exists("uploads/" . $user["profile_photo"])
            ) {
                unlink("uploads/" . $user["profile_photo"]);
            }

            // حفظ الصورة الجديدة
            $sql = "UPDATE users SET profile_photo = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $photo_name, $user_id);
            $stmt->execute();

            $message = "Photo uploaded successfully";
        }
    }

    // حذف الصورة
    if (isset($_POST["delete"])) {

        $sql = "SELECT profile_photo FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (
            !empty($user["profile_photo"]) &&
            file_exists("uploads/" . $user["profile_photo"])
        ) {
            unlink("uploads/" . $user["profile_photo"]);
        }

        $sql = "UPDATE users SET profile_photo = NULL WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $message = "Photo deleted successfully";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Profile Photo</title>
</head>

<body class="bg-light">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card shadow mt-5">

                    <div class="card-header text-center">
                        <h3>Profile Photo</h3>
                    </div>

                    <div class="card-body text-center">

                        <p class="text-muted">
                            <?php echo $message; ?>
                        </p>


                        <?php
                        $sql = "SELECT profile_photo FROM users WHERE id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();

                        $result = $stmt->get_result();
                        $user = $result->fetch_assoc();

                        if (!empty($user["profile_photo"])) {
                        ?>

                            <img src="uploads/<?php echo $user["profile_photo"]; ?>"
                                 width="150"
                                 height="150"
                                 class="rounded-circle mb-4">

                        <?php
                        } else {
                        ?>

                            <img src="images/default.png"
                                 width="150"
                                 height="150"
                                 class="rounded-circle mb-4">

                        <?php
                        }
                        ?>


                        <form method="post" enctype="multipart/form-data">

                            <div class="mb-3">

                                <input type="file"
                                       name="profile_photo"
                                       class="form-control">

                            </div>

                            <button type="submit"
                                    name="upload"
                                    class="btn btn-primary">
                                Upload / Replace
                            </button>

                        </form>


                        <form method="post" class="mt-3">

                            <button type="submit"
                                    name="delete"
                                    class="btn btn-danger">
                                Delete Photo
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>