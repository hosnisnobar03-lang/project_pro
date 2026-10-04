<?php

session_start();

  if(!isset($_SESSION["user_role"])|| $_SESSION["user_role"]!="admin"){

    header("Location: login.php");

    exit;

  }

//   echo"Welcome ". $_SESSION["user_name"];

//   echo "<br>";

//   echo $_SESSION["user_email"];

  $conn=new mysqli("localhost" , "root" , "" , "project_pro");

  $sql="SELECT * FROM users WHERE role = ? ";

  $user_rule="user";

  $stmt=$conn->prepare($sql);

  $stmt->bind_param("s" , $user_rule);

  $stmt->execute();

  $result=$stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Admin Dashboard</title>
</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h1>Admin Dashboard</h1>

                <p class="text-muted mb-0">
                    Welcome <?php echo $_SESSION["user_name"]; ?>
                </p>
            </div>

            <a href="logout.php" class="btn btn-danger">
                Logout
            </a>

        </div>


        <div class="card shadow">

            <div class="card-header">
                <h4 class="mb-0">Users</h4>
            </div>


            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-striped table-hover align-middle">

                        <thead class="table-dark">

                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Account Creation Date</th>
                                <th>Last Login</th>
                                <th>Edit</th>
                            </tr>

                        </thead>


                        <tbody>

                            <?php while ($user = $result->fetch_assoc()) { ?>

                            <tr>

                                <td>
                                    <?php echo $user["id"]; ?>
                                </td>

                                <td>
                                    <?php
                                    echo $user["f_name"] ." ". $user["s_name"] . " ". $user["th_name"] . " ". $user["l_name"];
                                    ?>
                                </td>

                                <td>
                                    <?php echo $user["email"]; ?>
                                </td>

                                <td>
                                    <?php echo $user["phone"]; ?>
                                </td>

                                <td>
                                    <?php echo $user["created_at"]; ?>
                                </td>

                                <td>
                                    <?php echo $user["last_login"] ?? "لم يسجل الدخول"; ?>
                                </td>

                                <td>

                                    <a href="edit.php?id=<?php echo $user["id"]; ?>"
                                       class="btn btn-sm btn-primary">
                                        Edit
                                    </a>

                                </td>

                            </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</body>

</html>