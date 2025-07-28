<?php
include("auth_session.php");
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
    <?php include("nav.php"); ?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>
                    COMPUTERS
                    <small>Manage all your computer data</small>
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Computers
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <a href="add_computers.php" class="btn btn-primary float-right">Add New Computer</a>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <?php
                                include_once 'db.php';
                                $result = mysqli_query($conn, "SELECT * FROM computers");
                                ?>

                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                ?>
                                    <table id="computer_table" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                        <thead>
                                            <tr>
                                                <th>Computer ID</th>
                                                <th>Location</th>
                                                <th>Specifications</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Computer ID</th>
                                                <th>Location</th>
                                                <th>Specifications</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $row["ComputerID"]; ?></td>
                                                    <td><?php echo $row["Location"]; ?></td>
                                                    <td><?php echo $row["Specifications"]; ?></td>
                                                    <td>
                                                        <a href="view_computer.php?id=<?php echo $row["ComputerID"]; ?>" class="btn btn-primary" title='View Computer'>View</a>
                                                        <a href="update_computer.php?id=<?php echo $row["ComputerID"]; ?>" class="btn btn-success" title='Update Computer'>Update</a>
                                                        <a href="delete_computer.php?id=<?php echo $row["ComputerID"]; ?>" class="btn btn-danger" title='Delete Computer'>Delete</a>
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
            $('#computer_table').DataTable();
        });
    </script>
</body>
</html>
