<?php
include '../utils/link.php';

if (isset($_GET['tab']) && isset($_GET['page'])) {
    $tabId = $_GET['tab'];
    $page = $_GET['page'];
    $results_per_page = 2;

    // Calculate the offset
    $offset = ($page - 1) * $results_per_page;

    // Load the content based on the tab
    switch ($tabId) {
        case 'cyberProducts':
            // Sample content for Cyber Products tab
            $cyber_sel = $link->query("SELECT * FROM cyber_products LIMIT $offset, $results_per_page");
            while ($rows = mysqli_fetch_array($cyber_sel)) {
                $count += 1;
                echo '
                <tr>
                    <td>' . $rows['id'] . '</td>
                    <td>' . $rows['product_name'] . '</td> 
                    <td>' . $rows['price_per_unit'] . '</td>
                    <td>' . $rows['quantity'] . '</td>
                    <td>
                        <button class="btn btn-danger btn-sm">Delete</button>
                        <button class="btn btn-secondary btn-sm">Update</button>  
                    </td>
                </tr>';
            }

            // Pagination links
            echo '<nav>
                    <ul class="pagination">';
            if ($page > 1) {
                echo '<li class="page-item"><a class="page-link" href="#" data-tab="cyberProducts" data-page="' . ($page - 1) . '">Previous</a></li>';
            }

            $num_products = $link->query("SELECT count(*) AS cnt FROM cyber_products")->fetch_array()['cnt'];
            $total_pages = ceil($num_products / $results_per_page);

            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<li class="page-item"><a class="page-link" href="#" data-tab="cyberProducts" data-page="' . $i . '">' . $i . '</a></li>';
            }

            if ($page < $total_pages) {
                echo '<li class="page-item"><a class="page-link" href="#" data-tab="cyberProducts" data-page="' . ($page + 1) . '">Next</a></li>';
            }

            echo '</ul>
                </nav>';
            break;
        // Add cases for other tabs if needed
    }
}
?>
