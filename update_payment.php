<?php
include("auth_session.php");
include_once 'db.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['id'])) {
    die("Payment ID not provided");
}

$payment_id = $_GET['id'];

// Retrieve customer data for dropdown
$customerQuery = "SELECT CustomerID, CONCAT(FirstName, ' ', LastName) AS FullName FROM Customers";
$customerResult = mysqli_query($conn, $customerQuery);

// Retrieve payment data for dropdown
$paymentQuery = "SELECT PaymentID, CONCAT(PaymentID, ' - ', Amount) AS PaymentInfo FROM Payments";
$paymentResult = mysqli_query($conn, $paymentQuery);

$query = "SELECT Payments.*, Customers.FirstName AS CustomerFirstName, Customers.LastName AS CustomerLastName 
          FROM Payments 
          INNER JOIN Customers ON Payments.CustomerID = Customers.CustomerID
          WHERE Payments.PaymentID = $payment_id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) == 0) {
    die("Payment not found");
}

$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'];
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];

    $update_query = "UPDATE Payments SET CustomerID='$customer_id', Amount='$amount', PaymentDate='$payment_date' WHERE PaymentID=$payment_id";
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        echo '<script>alert("Payment information updated successfully.");</script>';
        echo '<script>window.location="payments.php";</script>';
        exit();
    } else {
        echo "Error updating payment: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Update Payment</title>
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
                <h2>Update Payment Information</h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <form method="post">
                                <div class="form-group">
                                    <label for="customer_id">Customer</label>
                                    <select id="customer_id" name="customer_id" class="form-control" required>
                                        <?php
                                        while ($customerRow = mysqli_fetch_assoc($customerResult)) {
                                            $selected = ($customerRow['CustomerID'] == $row['CustomerID']) ? 'selected' : '';
                                            echo "<option value='" . $customerRow['CustomerID'] . "' $selected>" . $customerRow['FullName'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="text" id="amount" name="amount" class="form-control" value="<?php echo $row['Amount']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="payment_date">Payment Date</label>
                                    <input type="datetime-local" id="payment_date" name="payment_date" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($row['PaymentDate'])); ?>" required>
                                </div>
                                <input type="submit" value="Update" class="btn btn-primary">
                                <a href="payments.php" class="btn btn-danger">Cancel</a>
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
    <script src="includes/js/admin.js"></script>
</body>

</html>
