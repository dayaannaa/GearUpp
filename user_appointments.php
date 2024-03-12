<?php
    session_start();
    include "connection.php";

    if(!isset($_SESSION['user_id'])) {
        header("Location: user_login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/table.css">


    <link href="assets/css/style.css" rel="stylesheet">
</head>
<style>
    .table-fill { 
        margin: auto;
    }
    .statusContainer {
    background-color: gold;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    width: fit-content;
    margin-left: 83%;
    position: fixed;
    display: block;
    }
    .tableContainer{
        padding: 20px;
    }
</style>
<body>
    <?php
    include "sidebaruser.html";
    ?>

    <section class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Appointments</h2>
                <ol>
                    <li><a href="ui.php">Home</a></li>
                    <li>Appointments</li>
                </ol>
            </div>
        </div>
    </section>
    <br>
    <div class="statusContainer">
    <h3>Pending</h3>
    <?php
    $loggedInUserId = $_SESSION['user_id'];

    // Query for status pending
    $sqlPending = "SELECT ce.event_start_date, ce.event_end_date, a.start_time, a.end_time, a.status 
                   FROM calendar_event_master ce 
                   INNER JOIN appointment a ON ce.event_id = a.event_id 
                   WHERE a.status = 'Pending' AND a.user_id = ?";
    $stmtPending = $conn->prepare($sqlPending);
    $stmtPending->bind_param("i", $loggedInUserId);
    $stmtPending->execute();
    $resultPending = $stmtPending->get_result();

    // Display the result for status pending (text)
    if ($resultPending->num_rows > 0) {
        while ($row = $resultPending->fetch_assoc()) {
            // Convert start time to 12-hour format
            $startTime = date('h:i A', strtotime($row["start_time"]));
            // Convert end time to 12-hour format
            $endTime = date('h:i A', strtotime($row["end_time"]));
            
            echo "<p>Event Date: " . $row["event_start_date"] . "</p>";
            echo "<p>Time: " . $startTime . " - " . $endTime . "</p>";
            echo "<hr>";
        }
    } else {
        echo "<p>No pending appointments found for user ID: " . $loggedInUserId . "</p>";
    }
    ?>
</div>
<div class="tableContainer">
  <br>
    <table class="table-fill">
        <thead>
            <tr>
                <th class="text-center">Start Date</th> 
                <th class="text-center">End Date</th> 
                <th class="text-center">Start Time</th>
                <th class="text-center">End Time</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody class="table-hover">
    <?php
        $sqlSuccess = "SELECT ce.event_start_date, ce.event_end_date, a.start_time, a.end_time, a.status 
                    FROM calendar_event_master ce 
                    INNER JOIN appointment a ON ce.event_id = a.event_id 
                    WHERE a.status = 'Success' AND a.user_id = ?";
        $stmtSuccess = $conn->prepare($sqlSuccess);
        $stmtSuccess->bind_param("i", $loggedInUserId);
        $stmtSuccess->execute();
        $resultSuccess = $stmtSuccess->get_result();

        if ($resultSuccess->num_rows > 0) {
            while ($row = $resultSuccess->fetch_assoc()) {
                echo "<tr>";
                echo "<td class=text-center>" . $row["event_start_date"] . "</td>";
                echo "<td class=text-center>" . $row["event_end_date"] . "</td>";
                echo "<td class=text-center>" . $row["start_time"] . "</td>";
                echo "<td class=text-center>" . $row["end_time"] . "</td>";
                echo "<td class=text-center>" . $row["status"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No successful appointments found for user ID: " . $loggedInUserId . "</p>";
        }
?>

        </tbody>
    </table>
</div>
</body>
</html>
