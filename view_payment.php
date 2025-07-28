<?php
include("auth_session.php");
include_once 'db.php'; // Make sure to include db.php before using $conn

// Check for database connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the payment ID is provided in the URL
if(isset($_GET['id'])) {
    $payment_id = $_GET['id'];

    // Retrieve payment data for the provided ID
    $result = mysqli_query($conn, "SELECT p.*, c.FirstName, c.LastName FROM Payments p INNER JOIN Customers c ON p.CustomerID = c.CustomerID WHERE p.PaymentID = '$payment_id'");

    // Check if query was successful
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Fetch the payment details
    $row = mysqli_fetch_assoc($result);
    
    // Check if the $row variable is set and not empty
    if (!$row || empty($row)) {
        echo "Payment not found.";
        exit(); // Terminate script execution
    }
} else {
    // If no ID provided, redirect back to the payment dashboard
    header("Location: payments.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>View Payment Details</title>
    <link rel="icon" href="includes/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="includes/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="includes/plugins/node-waves/waves.css" rel="stylesheet" />
    <link href="includes/plugins/animate-css/animate.css" rel="stylesheet" />
    <link href="includes/css/style.css" rel="stylesheet">
    <link href="includes/css/themes/all-themes.css" rel="stylesheet" />
</head>

<body class="theme-red">
    <?php include("nav.php"); ?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>View Payment Details</h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <div class="form-group">
                                <label for="customer_name">Customer Name</label>
                                <input type="text" id="customer_name" class="form-control" value="<?php echo isset($row['FirstName']) && isset($row['LastName']) ? $row['FirstName'] . ' ' . $row['LastName'] : ''; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="text" id="amount" class="form-control" value="<?php echo isset($row['Amount']) ? $row['Amount'] : ''; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="payment_date">Payment Date</label>
                                <input type="text" id="payment_date" class="form-control" value="<?php echo isset($row['PaymentDate']) ? $row['PaymentDate'] : ''; ?>" disabled>
                            </div>
                            <!-- Add more fields as needed -->
                            <a href="payments.php" class="btn btn-primary">Back to Payments</a>
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
