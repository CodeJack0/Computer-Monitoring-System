<?php
// Include database connection
include_once 'db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    // Retrieve form data
    $customer_id = $_POST['customer_id'];
    $computer_id = $_POST['computer_id'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $total_time = $_POST['total_time'];

    // Insert session data into the database
    $insert_query = "INSERT INTO Sessions (CustomerID, ComputerID, StartTime, EndTime, TotalTime) 
                     VALUES ('$customer_id', '$computer_id', '$start_time', '$end_time', '$total_time')";

    if (mysqli_query($conn, $insert_query)) {
        // If session data is inserted successfully, redirect to sessions page
        header("Location: sessions.php");
        exit();
    } else {
        // If error occurs during insertion, display error message
        echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
    }
}

// Fetch customers and computers data
$customerResult = mysqli_query($conn, "SELECT * FROM Customers");
$computerResult = mysqli_query($conn, "SELECT * FROM Computers");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Session Management Dashboard</title>
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
                    SESSIONS
                    <small>Add new session data</small>
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Add New Session
                            </h2>
                        </div>
                        <div class="body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="form-group">
                                    <label for="customer_id">Customer</label>
                                    <select id="customer_id" class="form-control" name="customer_id">
                                        <?php
                                        while ($row = mysqli_fetch_array($customerResult)) {
                                            echo "<option value='" . $row['CustomerID'] . "'>" . $row['FirstName'] . " " . $row['LastName'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="computer_id">Computer</label>
                                    <select id="computer_id" class="form-control" name="computer_id">
                                        <?php
                                        while ($row = mysqli_fetch_array($computerResult)) {
                                            echo "<option value='" . $row['ComputerID'] . "'>" . $row['Location'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="start_time">Start Time</label>
                                    <input type="datetime-local" id="start_time" class="form-control" name="start_time">
                                </div>
                                <div class="form-group">
                                    <label for="end_time">End Time</label>
                                    <input type="datetime-local" id="end_time" class="form-control" name="end_time">
                                </div>
                                <div class="form-group">
                                    <label for="total_time">Total Time (hours)</label>
                                    <input type="number" id="total_time" class="form-control" placeholder="Enter total time" name="total_time">
                                </div>
                                <input type="submit" class="btn btn-primary" name="save" value="Save">
                                <a href="sessions.php" class="btn btn-danger">Cancel</a>
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
