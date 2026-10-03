<?php
session_start();

$conn = new mysqli("localhost", "root", "", "project_pro");

$user_id = $_SESSION['user_id'];


if(isset($_POST["update"])){

    $id = $_POST["note_id"];
    $title = $_POST["title"];
    $content = $_POST["content"];

    if(trim($title) == "" || trim($content) == ""){

        echo "Title and content are required";

    } else {

        $sql = "UPDATE notes SET title = ?, content = ?
                WHERE id = ? AND user_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $title, $content, $id, $user_id);
        $stmt->execute();

        header("Location: notes.php");
        exit;
    }
}


if($_SERVER["REQUEST_METHOD"]=="POST" && !isset($_POST["update"])){

    $title = $_POST["title"];
    $content = $_POST["content"];

    if(trim($title) == "" || trim($content) == ""){

        echo "Title and content are required";

    } else {

        $sql="INSERT INTO notes(title, content, user_id) VALUES(?,?,?)";

        $stmt=$conn->prepare($sql);
        $stmt->bind_param("ssi", $title, $content, $user_id);
        $stmt->execute();
    }
}

if(isset($_GET["edit"])){

    $id = $_GET["edit"];

    $sql = "SELECT * FROM notes WHERE id = ? AND user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();

    $edit_result = $stmt->get_result();
    $note = $edit_result->fetch_assoc();
}



if(isset($_GET["delete"])){

    $id = $_GET["delete"];

    $sql = "DELETE FROM notes WHERE id = ? AND user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();

    //echo "Note deleted successfully";
}



$sql = "SELECT * FROM notes WHERE user_id = ? ORDER BY id DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Notes</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="text-center mb-4">
            <h2 class="fw-bold">My Notes</h2>
            <p class="text-muted">Manage your personal notes</p>
        </div>


        <!-- Add / Edit Form -->
        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <h5 class="card-title mb-4">
                    <?php echo isset($note) ? "Edit Note" : "Add New Note"; ?>
                </h5>

                <form method="post">

                    <?php if(isset($note)){ ?>

                        <input type="hidden"
                               name="note_id"
                               value="<?php echo $note["id"]; ?>">

                    <?php } ?>


                    <div class="mb-3">

                        <label class="form-label">Title</label>

                        <input type="text"
                               class="form-control"
                               name="title"
                               value="<?php echo isset($note) ? $note["title"] : ""; ?>">

                    </div>


                    <div class="mb-3">

                        <label class="form-label">Note</label>

                        <textarea class="form-control"
                                  name="content"
                                  rows="5"><?php
                            echo isset($note) ? $note["content"] : "";
                        ?></textarea>

                    </div>


                    <?php if(isset($note)){ ?>

                        <button type="submit"
                                name="update"
                                class="btn btn-primary">
                            Save
                        </button>

                        <a href="notes.php"
                           class="btn btn-secondary">
                            Cancel
                        </a>

                    <?php } else { ?>

                        <button type="submit"
                                class="btn btn-success">
                            Add Note
                        </button>

                    <?php } ?>

                </form>

            </div>

        </div>


        <!-- Notes List -->

        <div class="card shadow-sm">

            <div class="card-body">

                <h5 class="card-title mb-4">My Notes</h5>

                <?php

                if ($result->num_rows == 0) {

                    echo '<div class="alert alert-info">No notes yet</div>';

                } else {

                    while ($note = $result->fetch_assoc()) {

                ?>

                        <div class="border rounded p-3 mb-3">

                            <h5 class="fw-bold">
                                <?php echo $note["title"]; ?>
                            </h5>

                            <p class="text-muted mb-3">
                                <?php echo $note["content"]; ?>
                            </p>


                            <a href="notes.php?edit=<?php echo $note["id"]; ?>"
                               class="btn btn-sm btn-primary">
                                Edit
                            </a>

                            <a href="notes.php?delete=<?php echo $note["id"]; ?>"
                               onclick="return confirm('Are you sure?')"
                               class="btn btn-sm btn-danger">
                                Delete
                            </a>

                        </div>

                <?php

                    }
                }

                ?>

            </div>

        </div>

    </div>

</body>

</html>