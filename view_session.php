<?php
include("auth_session.php");
include_once 'db.php'; // Make sure to include db.php before using $conn

// Check for database connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the session ID is provided in the URL
if (isset($_GET['id'])) {
    $session_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Retrieve session data for the provided ID
    $query = "SELECT Sessions.*, 
              CONCAT(Customers.CustomerID, ' - ', Customers.FirstName, ' ', Customers.LastName) AS CustomerFullName, 
              CONCAT(Computers.ComputerID, ' - ', Computers.Location) AS ComputerFullName
              FROM Sessions
              INNER JOIN Customers ON Sessions.CustomerID = Customers.CustomerID
              INNER JOIN Computers ON Sessions.ComputerID = Computers.ComputerID
              WHERE Sessions.SessionID = '$session_id'";

    $result = mysqli_query($conn, $query);

    // Check if query was successful
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Fetch the session details
    $row = mysqli_fetch_assoc($result);

    // Check if the $row variable is set and not empty
    if (!$row || empty($row)) {
        echo "Session not found.";
        exit(); // Terminate script execution
    }
} else {
    // If no ID provided, redirect back to the sessions dashboard
    header("Location: sessions.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>View Session Details</title>
    <link rel="icon" href="includes/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="includes/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="includes/plugins/node-waves/waves.css" rel="stylesheet" />
    <link href="includes/plugins/animate-css/animate.css" rel="stylesheet" />
    <link href="includes/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="includes/css/style.css" rel="stylesheet">
    <link href="includes/css/themes/all-themes.css" rel="stylesheet" />
</head>

<body class="theme-red">
    <?php include("nav.php"); ?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>VIEW SESSION DETAILS</h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <div class="form-group">
                                <label for="CustomerFullName">Customer Name</label>
                                <input type="text" id="CustomerFullName" class="form-control" value="<?php echo htmlspecialchars($row['CustomerFullName']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="ComputerFullName">Computer Name</label>
                                <input type="text" id="ComputerFullName" class="form-control" value="<?php echo htmlspecialchars($row['ComputerFullName']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="StartTime">Start Time</label>
                                <input type="text" id="StartTime" class="form-control" value="<?php echo htmlspecialchars($row['StartTime']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="EndTime">End Time</label>
                                <input type="text" id="EndTime" class="form-control" value="<?php echo htmlspecialchars($row['EndTime']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="TotalTime">Total Time (hours)</label>
                                <input type="text" id="TotalTime" class="form-control" value="<?php echo htmlspecialchars($row['TotalTime']); ?>" disabled>
                            </div>
                            <!-- Add more fields as needed -->
                            <a href="sessions.php" class="btn btn-primary">Back to Sessions</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="includes/plugins/jquery/jquery.min.js"></script>
    <script src="includes/plugins/bootstrap/js/bootstrap.js"></script>
    <script src="includes/plugins/node-waves/waves.js"></script>
    <script src="includes/js/admin.js"></script>
</body>

</html>
