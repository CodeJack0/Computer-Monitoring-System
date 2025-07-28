<?php
include("auth_session.php");
include_once 'db.php'; // Make sure to include db.php before using $conn

// Check for database connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the customer ID is provided in the URL
if(isset($_GET['id'])) {
    $customer_id = $_GET['id'];

    // Retrieve customer data for the provided ID
    $result = mysqli_query($conn, "SELECT * FROM Customers WHERE CustomerID = '$customer_id'");

    // Check if query was successful
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Fetch the customer details
    $row = mysqli_fetch_assoc($result);
    
    // Check if the $row variable is set and not empty
    if (!$row || empty($row)) {
        echo "Customer not found.";
        exit(); // Terminate script execution
    }
} else {
    // If no ID provided, redirect back to the customer dashboard
    header("Location: customers.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>View Customer Details</title>
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
                    VIEW CUSTOMER DETAILS
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <div class="form-group">
                                <label for="FirstName">First Name</label>
                                <input type="text" id="FirstName" class="form-control" value="<?php echo isset($row['FirstName']) ? $row['FirstName'] : ''; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="LastName">Last Name</label>
                                <input type="text" id="LastName" class="form-control" value="<?php echo isset($row['LastName']) ? $row['LastName'] : ''; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input type="email" id="Email" class="form-control" value="<?php echo isset($row['Email']) ? $row['Email'] : ''; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="Phone">Phone Number</label>
                                <input type="text" id="Phone" class="form-control" value="<?php echo isset($row['Phone']) ? $row['Phone'] : ''; ?>" disabled>
                            </div>
                            <!-- Add more fields as needed -->
                            <a href="customers.php" class="btn btn-primary">Back to Customers</a>
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
