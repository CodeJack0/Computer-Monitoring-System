<?php
include("auth_session.php");
include_once 'db.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['id'])) {
    die("Computer ID not provided");
}

$computer_id = $_GET['id'];
$query = "SELECT * FROM computers WHERE ComputerID = $computer_id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) == 0) {
    die("Computer not found");
}

$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $location = $_POST['location'];
    $specifications = $_POST['specifications'];

    $update_query = "UPDATE computers SET Location='$location', Specifications='$specifications' WHERE ComputerID=$computer_id";
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        echo '<script>alert("Computer information updated successfully.");</script>';
        echo '<script>window.location="dashboard.php";</script>';
        exit();
    } else {
        echo "Error updating computer: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Update Computer</title>
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
                <h2>Update Computer Information</h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <form method="post">
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <input type="text" id="location" name="location" class="form-control" value="<?php echo $row['Location']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="specifications">Specifications</label>
                                    <input type="text" id="specifications" name="specifications" class="form-control" value="<?php echo $row['Specifications']; ?>" required>
                                </div>
                                <input type="submit" value="Update" class="btn btn-primary">
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
    <script src="includes/js/admin.js"></script>
</body>
</html>
