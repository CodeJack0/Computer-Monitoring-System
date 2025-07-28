<?php
// Include database connection
include_once 'db.php';

// Check if the request method is GET and if the 'id' parameter is set
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Assuming your primary key column is named 'PaymentID'
    $payment_id = $_GET["id"]; // Assuming you pass the payment_id via GET parameter

    // If confirmation is received via GET parameter, proceed with deletion
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        // Proceed with deleting the payment record
        $sql_delete_payment = "DELETE FROM Payments WHERE PaymentID=?";
        $stmt_delete_payment = mysqli_prepare($conn, $sql_delete_payment);
        mysqli_stmt_bind_param($stmt_delete_payment, "i", $payment_id);

        if (mysqli_stmt_execute($stmt_delete_payment)) {
            // If payment is deleted successfully, display success message and redirect to payments page
            echo "<script>alert('Payment deleted successfully.');</script>"; 
            echo "<script>window.location.href = 'payments.php';</script>";     
        } else {
            // If error occurs during payment deletion, display error message
            echo "Error deleting payment: " . mysqli_error($conn);
        }

        // Close the statement for deleting the payment
        mysqli_stmt_close($stmt_delete_payment);
    } else {
        // Display confirmation dialog using JavaScript
        echo '
        <script>
            var confirmed = confirm("Are you sure you want to delete this payment?");
            if (confirmed) {
                // If user confirms deletion, proceed with deletion
                window.location.href = "delete_payment.php?id=' . $payment_id . '&confirm=yes";
            } else {
                // If user cancels deletion, redirect back to payments page
                window.location.href = "payments.php";
            }
        </script>
        ';
    }
} else {
    echo "Invalid request method or payment ID is missing.";
}
?>
