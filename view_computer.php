<?php
include("auth_session.php");
include_once 'db.php'; // Make sure to include db.php before using $conn

// Check for database connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the computer ID is provided in the URL
if(isset($_GET['id'])) {
    $computer_id = $_GET['id'];

    // Retrieve computer data for the provided ID
    $result = mysqli_query($conn, "SELECT * FROM computers WHERE ComputerID = '$computer_id'");

    // Check if query was successful
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Fetch the computer details
    $row = mysqli_fetch_assoc($result);
    
    // Check if the $row variable is set and not empty
    if (!$row || empty($row)) {
        echo "Computer not found.";
        exit(); // Terminate script execution
    }
} else {
    // If no ID provided, redirect back to the computer dashboard
    header("Location: computers.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>View Inventory Item</title>
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
                <h2>
                    VIEW COMPUTER DETAILS
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <div class="form-group">
                                <label for="Location">Location</label>
                                <input type="text" id="Location" class="form-control" value="<?php echo isset($row['Location']) ? $row['Location'] : ''; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="Specifications">Specifications</label>
                                <input type="text" id="Specifications" class="form-control" value="<?php echo isset($row['Specifications']) ? $row['Specifications'] : ''; ?>" disabled>
                            </div>
                            <!-- Add more fields as needed -->
                            <a href="dashboard.php" class="btn btn-primary">Back to Computers</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="includes/plugins/jquery/jquery.min.js"></script>
    <script src="includes/plugins/bootstrap/js/bootstrap.js"></script>
    <script src="includes/plugins/node-waves/waves.js"></script>
    <script src="includes/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="includes/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="includes/js/admin.js"></script>
    <script src="includes/js/pages/tables/jquery-datatable.js"></script>
</body>

</html>
