<?php
// Include authentication session
include("auth_session.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Session</title>
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
                    <small>Manage all your session data</small>
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Sessions
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <a href="add_session.php" class="btn btn-primary float-right">Add New Session</a>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <?php
                                // Include database connection
                                include_once 'db.php';
                                // Fetch sessions data with joined tables
                                $result = mysqli_query($conn, "SELECT s.SessionID, c.FirstName AS CustomerFirstName, c.LastName AS CustomerLastName, comp.Location AS ComputerLocation, s.StartTime, s.EndTime, s.TotalTime FROM Sessions s INNER JOIN Customers c ON s.CustomerID = c.CustomerID INNER JOIN Computers comp ON s.ComputerID = comp.ComputerID");
                                ?>

                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                ?>
                                    <table id="session_table" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                        <thead>
                                            <tr>
                                                <th>Session ID</th>
                                                <th>Customer Name</th>
                                                <th>Computer Location</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Total Time (hours)</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Session ID</th>
                                                <th>Customer Name</th>
                                                <th>Computer Location</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Total Time (hours)</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $row["SessionID"]; ?></td>
                                                    <td><?php echo $row["CustomerFirstName"] . ' ' . $row["CustomerLastName"]; ?></td>
                                                    <td><?php echo $row["ComputerLocation"]; ?></td>
                                                    <td><?php echo $row["StartTime"]; ?></td>
                                                    <td><?php echo $row["EndTime"]; ?></td>
                                                    <td><?php echo $row["TotalTime"]; ?></td>
                                                    <td>
                                                        <a href="view_session.php?id=<?php echo $row["SessionID"]; ?>" class="btn btn-primary" title='View Session'>View</a>
                                                        <a href="update_session.php?id=<?php echo $row["SessionID"]; ?>" class="btn btn-success" title='Update Session'>Update</a>
                                                        <a href="delete_session.php?id=<?php echo $row["SessionID"]; ?>" class="btn btn-danger" title='Delete Session'>Delete</a>
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
            $('#session_table').DataTable();
        });
    </script>
</body>
</html>
