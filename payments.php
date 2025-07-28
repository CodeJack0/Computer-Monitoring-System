<?php
// Include authentication session
include("auth_session.php");
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
    <?php include("nav.php"); ?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>
                    PAYMENTS
                    <small>Manage all your payment data</small>
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Payments
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <a href="add_payment.php" class="btn btn-primary float-right">Add New Payment</a>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <?php
                                // Include database connection
                                include_once 'db.php';
                                // Fetch payments data with joined tables
                                $result = mysqli_query($conn, "SELECT p.PaymentID, c.FirstName AS CustomerFirstName, c.LastName AS CustomerLastName, p.Amount, p.PaymentDate FROM Payments p INNER JOIN Customers c ON p.CustomerID = c.CustomerID");
                                ?>

                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                ?>
                                    <table id="payment_table" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                        <thead>
                                            <tr>
                                                <th>Payment ID</th>
                                                <th>Customer Name</th>
                                                <th>Amount</th>
                                                <th>Payment Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Payment ID</th>
                                                <th>Customer Name</th>
                                                <th>Amount</th>
                                                <th>Payment Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $row["PaymentID"]; ?></td>
                                                    <td><?php echo $row["CustomerFirstName"] . ' ' . $row["CustomerLastName"]; ?></td>
                                                    <td><?php echo $row["Amount"]; ?></td>
                                                    <td><?php echo $row["PaymentDate"]; ?></td>
                                                    <td>
                                                        <a href="view_payment.php?id=<?php echo $row["PaymentID"]; ?>" class="btn btn-primary" title='View Payment'>View</a>
                                                        <a href="update_payment.php?id=<?php echo $row["PaymentID"]; ?>" class="btn btn-success" title='Update Payment'>Update</a>
                                                        <a href="delete_payment.php?id=<?php echo $row["PaymentID"]; ?>" class="btn btn-danger" title='Delete Payment'>Delete</a>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                <?php
                                } else {
                                    echo "No result found";
                                }
                                ?>
                            </div>
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
    <script>
        $(document).ready(function() {
            $('#payment_table').DataTable();
        });
    </script>
</body>

</html>
