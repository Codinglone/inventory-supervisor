<?php
// generate_receipt.php

// Assuming you have a database connection here
// Replace 'your_database_credentials' with your actual database connection logic
$link = new mysqli("localhost", "root", "", "inventory_supervisor");

if (!$link) {
    die('Could not connect to the database: ' . mysqli_error($link));
}

// Retrieve the transaction ID from the POST data
$transactionId = isset($_POST['transaction_id']) ? $_POST['transaction_id'] : null;

if ($transactionId) {
    // Fetch transaction details from the database based on the transaction ID
    $query = "SELECT * FROM supermarket_products_transactions WHERE id = $transactionId";
    $result = mysqli_query($link, $query);

    if ($result) {
        $transactionData = mysqli_fetch_assoc($result);
        $total = $transactionData['price_per_unit'] * $transactionData['quantity'];
        // Generate the receipt HTML
        $receiptHTML = "
            <html>
            <head>
                <title>Receipt</title>
                <style>
                    /* Add your receipt styling here */
                    body {
                        font-family: Arial, sans-serif;
                    }
                </style>
            </head>
            <body>
                <h2>Receipt for Transaction ID: $transactionId</h2>
                <p><strong>Product Name:</strong> {$transactionData['product_name']}</p>
                <p><strong>Unit Price in RWF:</strong> {$transactionData['price_per_unit']}</p>
                <p><strong>Quantity:</strong> {$transactionData['quantity']}</p>
                <p><strong>Date Sold:</strong> {$transactionData['dates']}</p>
                <br>
                <br>
                <p><strong>Total:</strong> {$total} FRW</p>
                
                <p style='position: fixed;bottom:0;left:0;'><strong>Powered By:</strong> Yoben Technology</p>
                <!-- Add more details as needed -->

                <!-- You can customize the receipt layout further -->

                <script>
                    // Print the receipt immediately after loading
                    window.onload = function() {
                        window.print();
                        window.onafterprint = function() {
                            // Close the window after printing (optional)
                            window.close();
                        };
                    };
                </script>
            </body>
            </html>
        ";

        // Set content type to HTML and print the receipt
        header('Content-Type: text/html');
        echo $receiptHTML;
    } else {
        echo 'Error fetching transaction details: ' . mysqli_error($link);
    }
} else {
    echo 'Invalid transaction ID';
}

// Close the database connection
mysqli_close($link);
?>
