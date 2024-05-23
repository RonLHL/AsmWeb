<?php

require_once './secret/helper.php';

if(isset($_POST['logout'])){
    if (isset($_COOKIE["login-user"])) {
        // Unset the cookie by setting its expiration time to the past
        setcookie("login-user", "", time() - 3600);
        $message = "LogOut Successful.";
        echo '<script>';
        echo 'alert("' . $message . '");';
        echo 'setTimeout(function() { window.location.href = "home.php"; }, 1000);';
        echo '</script>';
    } else {
        $message = "Error, do not have any cookies.";
        echo '<script>';
        echo 'alert("' . $message . '");';
        echo 'setTimeout(function() { window.location.href = "home.php"; }, 1000);';
        echo '</script>';
    }
}

if(isset($_COOKIE['login-user'])) {
    //retrieve the value from the cookie
    $username = $_COOKIE['login-user'];
} else {
    echo "Cookie 'login-user' is not set.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback History</title>
    <link rel="icon" type="image/x-icon" href="./img/logo.jpg">
    <link href="css/css.css" rel="stylesheet" type="text/css"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include ('admin-header.php'); ?>

    <div>
        <div class="container p-5 bg-light">
            <h1 class="mb-5">Feedback History</h1>
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Feedback ID</th>
                        <th scope="col">Event ID</th>
                        <th scope="col">Feedback Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    if ($con->connect_error) {
                        die("Connection failed: " . $con->connect_error);
                    }
                    $sql = "SELECT * FROM feedback";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        //record returned
                        while ($row = $result->fetch_object()) {
                            printf("<tr>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            </tr>
                            "
                            , $row->feedback_id, $row->event_id, $row->feedback_desc);
                        }
                    }
                    $result->free();
                    $con->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include ('footer.php'); ?>
</body>
</html>
