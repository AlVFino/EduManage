<?php
include 'koneksi.php';

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['gambar'])) {
    // Menangani file gambar yang diupload
    $gambar = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $gambar_size = $_FILES['gambar']['size'];
    $gambar_error = $_FILES['gambar']['error'];

    // Tentukan lokasi folder tujuan untuk menyimpan gambar
    $upload_dir = 'uploads/';
    $gambar_baru = uniqid() . '-' . basename($gambar);
    $upload_path = $upload_dir . $gambar_baru;

    // Cek apakah file gambar valid
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
    $file_ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));

    if (in_array($file_ext, $allowed_ext)) {
        // Cek jika gambar sudah diupload tanpa error
        if ($gambar_error === 0) {
            // Periksa ukuran file
            if ($gambar_size <= 10 * 1024 * 1024) { // Maksimal 10MB
                // Pindahkan gambar ke folder tujuan
                if (move_uploaded_file($gambar_tmp, $upload_path)) {
                    // Simpan data artikel ke database, termasuk nama gambar
                    $judul = $_POST['judul'];
                    $penulis = $_POST['penulis'];
                    $jenis_artikel = $_POST['jenis_artikel'];
                    $isi = $_POST['isi'];

                    $stmt = $conn->prepare("INSERT INTO artikel (judul, konten, penulis, jenis_artikel, gambar) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssss", $judul, $isi, $penulis, $jenis_artikel, $gambar_baru);
                    $stmt->execute();
                    header('Location: index.php');
                } else {
                    echo "Gagal mengupload gambar.";
                }
            } else {
                echo "Ukuran file terlalu besar, maksimal 10MB.";
            }
        } else {
            echo "Terjadi kesalahan saat mengupload gambar.";
        }
    } else {
        echo "Hanya file gambar dengan ekstensi JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
    }
}
