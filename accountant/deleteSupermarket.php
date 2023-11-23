<?php
include "../utils/link.php";
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM supermarket_products WHERE id = '$id'";
    $result = $link->query($sql);
    if($result){
        header("location: index.php");
    }
}
?>