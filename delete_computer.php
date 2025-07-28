<?php
// Include database connection
include_once 'db.php';

// Check if the request method is GET and if the 'id' parameter is set
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Assuming your primary key column is named 'ComputerID'
    $computer_id = $_GET["id"]; // Assuming you pass the computer_id via GET parameter

    // If confirmation is received via GET parameter, proceed with deletion
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        // Proceed with deleting the computer record
        $sql_delete_computer = "DELETE FROM computers WHERE ComputerID=?";
        $stmt_delete_computer = mysqli_prepare($conn, $sql_delete_computer);
        mysqli_stmt_bind_param($stmt_delete_computer, "i", $computer_id);

        if (mysqli_stmt_execute($stmt_delete_computer)) {
            // If computer is deleted successfully, display success message and redirect to computers page
            echo "<script>alert('Computer deleted successfully.');</script>"; 
            echo "<script>window.location.href = 'dashboard.php';</script>";     
        } else {
            // If error occurs during computer deletion, display error message
            echo "Error deleting computer: " . mysqli_error($conn);
        }

        // Close the statement for deleting the computer
        mysqli_stmt_close($stmt_delete_computer);
    } else {
        // Display confirmation dialog using JavaScript
        echo '
        <script>
            var confirmed = confirm("Are you sure you want to delete this computer?");
            if (confirmed) {
                // If user confirms deletion, proceed with deletion
                window.location.href = "delete_computer.php?id=' . $computer_id . '&confirm=yes";
            } else {
                // If user cancels deletion, redirect back to computers page
                window.location.href = "dashboard.php";
            }
        </script>
        ';
    }
} else {
    echo "Invalid request method or computer ID is missing.";
}
?>
