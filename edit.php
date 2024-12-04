<?php
include 'koneksi.php';

// Ambil data artikel berdasarkan ID yang diberikan
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM artikel WHERE id_artikel = $id");
    $artikel = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $jenis_artikel = $_POST['jenis_artikel'];
    $isi = $_POST['isi'];

    // Cek jika ada gambar baru diunggah
    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $target = "uploads/" . basename($gambar);

        // Cek apakah file gambar berhasil diupload
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
            // Update dengan gambar baru
            $stmt = $conn->prepare("UPDATE artikel SET judul=?, konten=?, penulis=?, jenis_artikel=?, gambar=? WHERE id_artikel=?");
            $stmt->bind_param("sssssi", $judul, $isi, $penulis, $jenis_artikel, $gambar, $id);
        } else {
            // Jika gagal mengupload gambar
            echo "Gagal mengupload gambar.";
        }
    } else {
        // Update tanpa mengubah gambar
        $stmt = $conn->prepare("UPDATE artikel SET judul=?, konten=?, penulis=?, jenis_artikel=? WHERE id_artikel=?");
        $stmt->bind_param("ssssi", $judul, $isi, $penulis, $jenis_artikel, $id);
    }

    if ($stmt->execute()) {
        header('Location: index.php');  // Redirect setelah update berhasil
    } else {
        echo "Terjadi kesalahan saat memperbarui artikel.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Artikel</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    /* Reset default styling */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Body dan font dasar */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        color: #333;
        padding: 20px;
    }

    /* Container utama */
    .container {
        max-width: 800px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    /* Header */
    header {
        text-align: center;
        margin-bottom: 20px;
    }

    h1 {
        font-size: 2rem;
        color: #333;
    }

    /* Form styling */
    form {
        display: flex;
        flex-direction: column;
    }

    /* Label styling */
    label {
        font-size: 1rem;
        margin-bottom: 5px;
        color: #555;
    }

    /* Input dan textarea styling */
    input[type="text"],
    input[type="file"],
    textarea {
        padding: 10px;
        margin-bottom: 15px;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #f9f9f9;
    }

    /* Gambar saat ini */
    img {
        margin-top: 10px;
        border-radius: 5px;
        max-width: 100%;
    }

    /* Button submit */
    input[type="submit"] {
        padding: 10px 15px;
        background-color: #007bff;
        color: #fff;
        font-size: 1rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    /* Gaya tambahan untuk menampilkan gambar saat ini */
    p strong {
        font-weight: bold;
        margin-top: 10px;
    }

    /* Responsif pada layar kecil */
    @media (max-width: 768px) {
        .container {
            padding: 15px;
        }

        form {
            padding: 0 15px;
        }

        h1 {
            font-size: 1.5rem;
        }
    }
</style>

<body>
    <div class="container">
        <header>
            <h1>Edit Artikel</h1>
        </header>

        <form action="edit.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $artikel['id_artikel']; ?>">

            <label for="judul">Judul Artikel</label>
            <input type="text" name="judul" id="judul" value="<?php echo htmlspecialchars($artikel['judul']); ?>" required>

            <label for="penulis">Penulis</label>
            <input type="text" name="penulis" id="penulis" value="<?php echo htmlspecialchars($artikel['penulis']); ?>" required>

            <label for="jenis_artikel">Jenis Artikel</label>
            <input type="text" name="jenis_artikel" id="jenis_artikel" value="<?php echo htmlspecialchars($artikel['jenis_artikel']); ?>" required>

            <label for="isi">Isi Artikel</label>
            <textarea name="isi" id="isi" required><?php echo htmlspecialchars($artikel['konten']); ?></textarea>

            <label for="gambar">Gambar (Jika Ingin Mengubah Gambar)</label>
            <input type="file" name="gambar" id="gambar">

            <?php if (!empty($artikel['gambar'])): ?>
                <p><strong>Gambar Saat Ini:</strong></p>
                <img src="uploads/<?php echo htmlspecialchars($artikel['gambar']); ?>" alt="Gambar Artikel" width="150">
            <?php endif; ?>

            <input type="submit" value="Update Artikel">
        </form>
    </div>
</body>

</html>