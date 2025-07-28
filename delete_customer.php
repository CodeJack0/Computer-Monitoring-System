<?php
// Include database connection
include_once 'db.php';

// Check if the request method is GET and if the 'id' parameter is set
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Assuming your primary key column is named 'CustomerID'
    $customer_id = $_GET["id"]; // Assuming you pass the customer_id via GET parameter

    // If confirmation is received via GET parameter, proceed with deletion
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        // Start transaction
        mysqli_begin_transaction($conn);

        try {
            // Delete related records from the payments table
            $sql_delete_payments = "DELETE FROM Payments WHERE CustomerID=?";
            $stmt_delete_payments = mysqli_prepare($conn, $sql_delete_payments);
            mysqli_stmt_bind_param($stmt_delete_payments, "i", $customer_id);
            mysqli_stmt_execute($stmt_delete_payments);
            mysqli_stmt_close($stmt_delete_payments);

            // Proceed with deleting the customer record
            $sql_delete_customer = "DELETE FROM Customers WHERE CustomerID=?";
            $stmt_delete_customer = mysqli_prepare($conn, $sql_delete_customer);
            mysqli_stmt_bind_param($stmt_delete_customer, "i", $customer_id);
            mysqli_stmt_execute($stmt_delete_customer);
            mysqli_stmt_close($stmt_delete_customer);

            // Commit transaction
            mysqli_commit($conn);

            // If customer is deleted successfully, display success message and redirect to customers page
            echo "<script>alert('Customer deleted successfully.');</script>"; 
            echo "<script>window.location.href = 'customers.php';</script>";     
        } catch (Exception $e) {
            // Rollback transaction if any error occurs
            mysqli_rollback($conn);
            // If error occurs during customer deletion, display error message
            echo "Error deleting customer: " . mysqli_error($conn);
        }
    } else {
        // Display confirmation dialog using JavaScript
        echo '
        <script>
            var confirmed = confirm("Are you sure you want to delete this customer?");
            if (confirmed) {
                // If user confirms deletion, proceed with deletion
                window.location.href = "delete_customer.php?id=' . $customer_id . '&confirm=yes";
            } else {
                // If user cancels deletion, redirect back to customers page
                window.location.href = "customers.php";
            }
        </script>
        ';
    }
} else {
    echo "Invalid request method or customer ID is missing.";
}
?>
