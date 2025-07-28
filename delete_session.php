<?php
// Include database connection
include_once 'db.php';

// Check if the request method is GET and if the 'id' parameter is set
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Assuming your primary key column is named 'SessionID'
    $session_id = $_GET["id"]; // Assuming you pass the session_id via GET parameter

    // If confirmation is received via GET parameter, proceed with deletion
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        // Proceed with deleting the session record
        $sql_delete_session = "DELETE FROM Sessions WHERE SessionID=?";
        $stmt_delete_session = mysqli_prepare($conn, $sql_delete_session);
        mysqli_stmt_bind_param($stmt_delete_session, "i", $session_id);

        if (mysqli_stmt_execute($stmt_delete_session)) {
            // If session is deleted successfully, display success message and redirect to sessions page
            echo "<script>alert('Session deleted successfully.');</script>"; 
            echo "<script>window.location.href = 'sessions.php';</script>";     
        } else {
            // If error occurs during session deletion, display error message
            echo "Error deleting session: " . mysqli_error($conn);
        }

        // Close the statement for deleting the session
        mysqli_stmt_close($stmt_delete_session);
    } else {
        // Display confirmation dialog using JavaScript
        echo '
        <script>
            var confirmed = confirm("Are you sure you want to delete this session?");
            if (confirmed) {
                // If user confirms deletion, proceed with deletion
                window.location.href = "delete_session.php?id=' . $session_id . '&confirm=yes";
            } else {
                // If user cancels deletion, redirect back to sessions page
                window.location.href = "sessions.php";
            }
        </script>
        ';
    }
} else {
    echo "Invalid request method or session ID is missing.";
}
?>
