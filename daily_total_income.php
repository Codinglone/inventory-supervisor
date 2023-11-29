<?php
// Connect to the database (replace with your actual connection logic)
$link = new mysqli("localhost", "root", "", "inventory_supervisor");

if (!$link) {
    die('Could not connect to the database: ' . mysqli_error($link));
}

// Get the current date
$currentDate = date('Y-m-d'); // Get the current date in the format used in your database

        // Query for gym income
        $gymIncomeQuery = "SELECT SUM(amount_paid) as total_gym_income FROM gym_clients WHERE dates = '$currentDate'";
        $gymIncomeResult = $link->query($gymIncomeQuery);
        $gymIncomeRow = mysqli_fetch_array($gymIncomeResult);
        $totalGymIncome = $gymIncomeRow['total_gym_income'];

        // Query for room income
        $roomIncomeQuery = "SELECT SUM(amount_paid) as total_room_income FROM rooms_clients WHERE checkin_date = '$currentDate'";
        $roomIncomeResult = $link->query($roomIncomeQuery);
        $roomIncomeRow = mysqli_fetch_array($roomIncomeResult);
        $totalRoomIncome = $roomIncomeRow['total_room_income'];

        // Query for sauna & massage income
        $saunaMassageIncomeQuery = "SELECT SUM(amount_paid) as total_sauna_massage_income FROM sauna_massage_clients WHERE dates = '$currentDate'";
        $saunaMassageIncomeResult = $link->query($saunaMassageIncomeQuery);
        $saunaMassageIncomeRow = mysqli_fetch_array($saunaMassageIncomeResult);
        $totalSaunaMassageIncome = $saunaMassageIncomeRow['total_sauna_massage_income'];

        // Add more departments as needed
        $incomeQuery = "SELECT SUM(price * quantity) as total_income FROM restaurent_products_transactions WHERE dates = '$currentDate'";
        $incomeResult = $link->query($incomeQuery);
        $incomeRow = mysqli_fetch_array($incomeResult);
        $totalRestaurentIncome = $incomeRow['total_income'];

        $incomeQueryS = "SELECT SUM(price_per_unit * quantity) as total_income FROM supermarket_products_transactions WHERE dates = '$currentDate'";
        $incomeResultS = $link->query($incomeQueryS);
        $incomeRowS = mysqli_fetch_array($incomeResultS);
        $totalSupermarketIncome = $incomeRowS['total_income'];

        $incomeQueryC = "SELECT SUM(price_per_unit * quantity) as total_income FROM cyber_products_transactions WHERE dates = '$currentDate'";
        $incomeResultC = $link->query($incomeQueryC);
        $incomeRowC = mysqli_fetch_array($incomeResultC);
        $totalCyberIncome = $incomeRowC['total_income'];

        // Calculate the total income from
        $total_income = $totalGymIncome + $totalRoomIncome + $totalSaunaMassageIncome + $totalRestaurentIncome + $totalSupermarketIncome + $totalCyberIncome;

// Insert into the daily_total_income table
$insertQuery = "INSERT INTO daily_total_income (dates, total_income) VALUES ('$currentDate', '$total_income')";
$link->query($insertQuery);

// Close the database connection
mysqli_close($link);
echo "<script>window.location.replace('index.php')</script>";
?>
