<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus gambar terkait
    $result = $conn->query("SELECT gambar FROM artikel WHERE id_artikel = $id");
    $artikel = $result->fetch_assoc();
    if (!empty($artikel['gambar']) && file_exists("uploads/" . $artikel['gambar'])) {
        unlink("uploads/" . $artikel['gambar']);
    }

    $stmt = $conn->prepare("DELETE FROM artikel WHERE id_artikel=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header('Location: index.php');
}
