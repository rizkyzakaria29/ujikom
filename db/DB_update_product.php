<?php
session_start();
require_once('DB_connection.php');

if(isset($_POST['update_product'])) {
    $id = $_POST['id'];
    $nama_produk = $_POST['nama_produk'];
    $harga_produk = $_POST['harga_produk'];

    $stmt = $conn->prepare("UPDATE products SET nama_produk = ?, harga_produk = ? where id = ?");
    $stmt->bind_param("sii", $nama_produk, $harga_produk, $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "product update successfully!";
        } else{
            echo "no changes made to the product.";
        }
    }else{
        echo "failed to update product.";
    }

    $stmt->close();
    $conn->close();
    header('location: ../pages/kasir/manage_product.php');
    exit;
}
?>