<?php
include("auth_session.php");

// Check if the form is submitted
if(isset($_POST['save'])) {
    require_once "db.php";

    // Retrieve form data
    $customerID = $_POST['customer_id'];
    $amount = $_POST['amount'];
    $paymentDate = $_POST['payment_date'];

    // Insert new payment into the database
    $sql = "INSERT INTO Payments (CustomerID, Amount, PaymentDate) VALUES ('$customerID', '$amount', '$paymentDate')";
    
    if(mysqli_query($conn, $sql)) {
        echo '<script>alert("Payment has been added.")</script>';
        echo "<script>window.location.href ='payments.php'</script>";
    } else {
        echo "Error: " . $sql . " " . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Payment Management Dashboard</title>
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
    <?php include ("nav.php");   ?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>
                    PAYMENTS
                    <small>Add new payment data</small>
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Add New Payment
                            </h2>
                        </div>
                        <div class="body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="form-group">
                                    <label for="customer_id">Customer</label>
                                    <select id="customer_id" class="form-control" name="customer_id">
                                        <?php
                                        require_once "db.php";
                                        $customerQuery = "SELECT CustomerID, CONCAT(FirstName, ' ', LastName) AS FullName FROM Customers";
                                        $customerResult = mysqli_query($conn, $customerQuery);
                                        while ($row = mysqli_fetch_assoc($customerResult)) {
                                            echo "<option value='" . $row['CustomerID'] . "'>" . $row['FullName'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="number" id="amount" class="form-control" placeholder="Enter amount" name="amount">
                                </div>
                                <div class="form-group">
                                    <label for="payment_date">Payment Date</label>
                                    <input type="date" id="payment_date" class="form-control" name="payment_date">
                                </div>
                                <input type="submit" class="btn btn-primary" name="save" value="Save">
                                <a href="dashboard.php" class="btn btn-danger">Cancel</a>
                            </form>
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
