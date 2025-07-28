<?php
include("auth_session.php");

// Check if the form is submitted
if(isset($_POST['save'])) {
    require_once "db.php";

    // Retrieve form data
    $location = $_POST['location'];
    $specifications = $_POST['specifications'];

    // Insert new computer into the database
    $sql = "INSERT INTO Computers (Location, Specifications) VALUES ('$location', '$specifications')";
    
    if(mysqli_query($conn, $sql)) {
        echo '<script>alert("Computer has been added.")</script>';
        echo "<script>window.location.href ='dashboard.php'</script>";
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
    <title>Computer Management Dashboard</title>
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
                    COMPUTER MANAGEMENT SYSTEM
                    <small>Add new computer data</small>
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Add New Computer
                            </h2>
                        </div>
                        <div class="body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <input type="text" id="location" class="form-control" placeholder="Enter location" name="location">
                                </div>
                                <div class="form-group">
                                    <label for="specifications">Specifications</label>
                                    <textarea id="specifications" class="form-control" placeholder="Enter specifications" name="specifications"></textarea>
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
