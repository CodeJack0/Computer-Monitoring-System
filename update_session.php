<?php
include("auth_session.php");
include_once 'db.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['id'])) {
    die("Session ID not provided");
}

$session_id = $_GET['id'];

// Retrieve customer data for dropdown
$customerQuery = "SELECT CustomerID, CONCAT(FirstName, ' ', LastName) AS FullName FROM Customers";
$customerResult = mysqli_query($conn, $customerQuery);

// Retrieve computer data for dropdown
$computerQuery = "SELECT ComputerID, CONCAT(ComputerID, ' - ', Location) AS ComputerName FROM Computers";
$computerResult = mysqli_query($conn, $computerQuery);

$query = "SELECT Sessions.*, 
          Customers.FirstName AS CustomerFirstName, 
          Customers.LastName AS CustomerLastName, 
          Computers.Location AS ComputerLocation 
          FROM Sessions 
          INNER JOIN Customers ON Sessions.CustomerID = Customers.CustomerID
          INNER JOIN Computers ON Sessions.ComputerID = Computers.ComputerID
          WHERE Sessions.SessionID = $session_id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) == 0) {
    die("Session not found");
}

$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'];
    $computer_id = $_POST['computer_id'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $total_time = $_POST['total_time'];

    $update_query = "UPDATE Sessions SET CustomerID='$customer_id', ComputerID='$computer_id', StartTime='$start_time', EndTime='$end_time', TotalTime='$total_time' WHERE SessionID=$session_id";
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        echo '<script>alert("Session information updated successfully.");</script>';
        echo '<script>window.location="sessions.php";</script>';
        exit();
    } else {
        echo "Error updating session: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Update Session</title>
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
                <h2>Update Session Information</h2>
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
                                    <label for="computer_id">Computer</label>
                                    <select id="computer_id" name="computer_id" class="form-control" required>
                                        <?php
                                        while ($computerRow = mysqli_fetch_assoc($computerResult)) {
                                            $selected = ($computerRow['ComputerID'] == $row['ComputerID']) ? 'selected' : '';
                                            echo "<option value='" . $computerRow['ComputerID'] . "' $selected>" . $computerRow['ComputerName'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="start_time">Start Time</label>
                                    <input type="datetime-local" id="start_time" name="start_time" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($row['StartTime'])); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="end_time">End Time</label>
                                    <input type="datetime-local" id="end_time" name="end_time" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($row['EndTime'])); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="total_time">Total Time (hours)</label>
                                    <input type="number" id="total_time" name="total_time" class="form-control" value="<?php echo $row['TotalTime']; ?>" required>
                                </div>
                                <input type="submit" value="Update" class="btn btn-primary">
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
    <script src="includes/js/admin.js"></script>
</body>

</html>
