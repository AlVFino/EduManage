<?php
// Include file koneksi database
include 'koneksi.php';

// Cek apakah ID artikel ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil artikel berdasarkan ID
    $sql = "SELECT * FROM artikel WHERE id_artikel = $id";
    $query = mysqli_query($conn, $sql);

    // Cek apakah query berhasil
    if (!$query) {
        die("Query Error: " . mysqli_error($conn));
    }

    // Jika artikel tidak ditemukan
    if (mysqli_num_rows($query) == 0) {
        echo "Artikel tidak ditemukan.";
        exit;
    }
} else {
    // Jika ID tidak ditemukan di URL, tampilkan pesan error
    echo "ID artikel tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel</title>
    <style>
        /* Reset beberapa styling default */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
        }

        /* Styling untuk artikel */
        #artikel {
            max-width: 900px;
            margin: 0 auto;
        }

        .all_artikel {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .artikel {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .artikel:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.35);
        }

        .artikel img {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 2px solid rgb(255, 255, 255);
            box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.226);

        }

        .artikel .judul_artikel {
            font-size: 2rem;
            font-weight: bold;
            margin: 10px 0;
        }

        .artikel .jenis_artikel,
        .artikel .nama {
            font-size: 1rem;
            color: #666;
            margin-bottom: 10px;
        }

        .artikel .isi {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #333;
            margin-bottom: 20px;
        }

        .artikel .button {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .artikel .tombol a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            transition: color 0.3s;
        }

        .artikel .tombol a:hover {
            color: #0056b3;
        }

        /* Styling untuk link kembali */
        .artikel .tombol a:last-child {
            color: #28a745;
        }

        .artikel .tombol a:last-child:hover {
            color: #218838;
        }
    </style>
</head>

<body>
    <section id="artikel">
        <div class="all_artikel">
            <?php while ($row = mysqli_fetch_assoc($query)): ?>
                <div class="artikel">
                    <img src="uploads/<?php echo htmlspecialchars($row['gambar']); ?>" alt="Gambar Artikel" width="450">
                    <h4 class="jenis_artikel"><?php echo htmlspecialchars($row['jenis_artikel']); ?></h4>
                    <i class="nama">By : <?php echo htmlspecialchars($row['penulis']); ?></i>
                    <p class="judul_artikel"><?php echo htmlspecialchars($row['judul']); ?></p>
                    <p class="isi" id="isi-<?php echo $row['id_artikel']; ?>"><?php echo nl2br(htmlspecialchars($row['konten'])); ?></p>
                    <div class="button">
                        <div class="tombol">
                            <a href="edit.php?id=<?php echo $row['id_artikel']; ?>">Edit</a> |
                            <a href="delete.php?id=<?php echo $row['id_artikel']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">Delete</a>
                            <a href="index.php">Kembali</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
</body>

</html>