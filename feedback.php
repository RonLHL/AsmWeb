<?php
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "assignment");

$username = $_GET['username'];
$eventIDs = explode(',', $_GET['event_id']);

function checkError($clnFeedback) {
    $pattern = '/[#$^*]/';
    if (preg_match($pattern, $clnFeedback)) {
        return "<p>The feedback should not contain special characters.</p>";
    }
    return "";
}

function generateFeedbackId($lastFeedbackId) {
    $lastIdNumeric = (int) substr($lastFeedbackId, 1);

    $newIdNumeric = $lastIdNumeric + 1;

    $newFeedbackId = "F" . str_pad($newIdNumeric, strlen($lastFeedbackId) - 1, "0", STR_PAD_LEFT);

    return $newFeedbackId;
}

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}


$sql = "SELECT MAX(feedback_id) AS max_id FROM feedback";
$result = $con->query($sql);

$row = $result->fetch_assoc();
$lastFeedbackId = $row['max_id'];

$con->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Feedback</title>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <style>
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50vh; /* Full viewport height */
        }
        .form-outline {
            width: 100%;
            max-width: 400px;
        }
    </style>
    </head>
    <body>
        <?php include ('memberHeader.php'); ?>
<div class="form-container">
        <form action="" method="POST">
            <div class="form-outline" data-mdb-input-init>
                <input type="text" id="feeeback" class="form-control" maxlength="100" name="feedback" value="" size="40" />
                <div id="feedbacktext" class="form-text">
                    Please enter your feedback here.
                </div>
                <input type="submit" value="Submit" name="btnSubmitFeedback" />
            </div>
        </form>
</div>
        <?php
        if (isset($_POST["btnSubmitFeedback"])) {
            $feedback = trim($_POST["feedback"]);
            $clnFeedback = htmlspecialchars($feedback);
            $error = checkError($clnFeedback);

            if (empty($error)) {
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                foreach ($eventIDs as $eventID) {
                $newFeedbackId = generateFeedbackId($lastFeedbackId);
                $lastFeedbackId = $newFeedbackId;
                $sql = "INSERT INTO feedback (feedback_id, feedback_desc, username, event_id) VALUES(?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("ssss", $newFeedbackId, $clnFeedback, $username, $eventID);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    //insert successfully
                    echo '<script>';
                    echo 'alert(" ' . $username . '. Your Feedback Have been successfully added' . '");';  // Show the alert
                    echo 'setTimeout(function() { window.location.href = "memberEvent.php"; }, 2000);';  // Delay the redirection
                    echo '</script>';
                } else {
                    //unable to insert
                    echo "Database Error, Unable to insert. Please try again!";
                }
                $stmt->close();
                }
                $con->close();
            } else {
                // Display error message
                echo $error;
            }
        }
        ?>
        <?php
        include ('footer.php');
        ?>

    </body>
</html>