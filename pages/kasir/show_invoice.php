<?php
session_start();
require_once('DB_connection.php');

// Assuming you have an invoice ID passed through GET parameter
if (isset($_GET['invoice_id'])) {
    $invoice_id = $_GET['invoice_id'];

    // Fetch invoice details from the database
    $stmt = $conn->prepare("SELECT * FROM invoices WHERE invoice_id = ?");
    $stmt->bind_param('i', $invoice_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $invoice = $result->fetch_assoc();
    } else {
        echo "Invoice not found";
        exit;
    }

    // Fetch invoice items from the database
    $stmt = $conn->prepare("SELECT * FROM invoice_items WHERE invoice_id = ?");
    $stmt->bind_param('i', $invoice_id);
    $stmt->execute();
    $items_result = $stmt->get_result();

    if ($items_result->num_rows > 0) {
        $invoice_items = $items_result->fetch_all(MYSQLI_ASSOC);
    } else {
        $invoice_items = array();
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Invoice</title>
    <!-- Add your CSS link or style here -->
    <link rel="stylesheet" href="show_invoice.css">
</head>
<body>

    <div class="invoice-container">
        <h1>Invoice <?php echo $invoice['invoice_id']; ?></h1>

        <div class="invoice-details">
            <p>Date: <?php echo $invoice['invoice_date']; ?></p>
            <p>Customer: <?php echo $invoice['customer_name']; ?></p>
            <!-- Add more details as needed -->

            <!-- Loop through and display invoice items -->
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoice_items as $item): ?>
                        <tr>
                            <td><?php echo $item['product_name']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo $item['price']; ?></td>
                            <td><?php echo $item['total']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p class="total-amount">Total Amount: <?php echo $invoice['total_amount']; ?></p>
        </div>
    </div>

</body>
</html>