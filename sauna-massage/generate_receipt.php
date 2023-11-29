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
    $query = "SELECT * FROM sauna_massage_clients WHERE id = $transactionId";
    $result = mysqli_query($link, $query);

    if ($result) {
        $transactionData = mysqli_fetch_assoc($result);
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
                <p><strong>Client Names:</strong> {$transactionData['fullname']}</p>
                <p><strong>Client Phone:</strong> {$transactionData['phone']}</p>
                <p><strong>Client E-mail:</strong> {$transactionData['email']}</p>
                <p><strong>Service Type:</strong> {$transactionData['service_type']}</p>
                <p><strong>Organization:</strong> {$transactionData['membership_type']}</p>
                <br>
                <br>
                <p><strong>Total Amount:</strong> {$transactionData['amount_paid']} FRW</p>
                
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
