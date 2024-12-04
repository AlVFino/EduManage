<?php
// Include file koneksi database
include 'koneksi.php';

// Ambil semua artikel dari database
$sql = "SELECT * FROM artikel ORDER BY id_artikel DESC";
$query = mysqli_query($conn, $sql);

// Cek apakah query berhasil
if (!$query) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AduManage</title>
    <link rel="icon" href="img/logoBiru.png">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Slab:wght@100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Slab:wght@100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <header id="navbar">
            <div class="logo">
                <img src="img/logoPutih.png" alt="" width="30">
                <p>EduManage</p>
            </div>
            <div class="deskripsi">
                <ul>
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#artikel">Artikel</a></li>
                    <li><a href="#tambahartikel">Tambah Artikel</a></li>
                    <li><a href="#tentang">Tentang Kami</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
        </header>

        <section id="beranda">
            <div class="logo_beranda">
                <img src="img/home.png" alt="">
            </div>
            <div class="deskrip_beranda">
                <h1>Selamat Datang di EduManage</h1>
                <p>Hai! AduManage siap membantu Anda mengelola artikel dengan mudah. Mulai dari menulis, mengedit, hingga menghapus, semua bisa dilakukan dengan praktis di sini!</p>

                <div class="button">
                    <a href="#tambahartikel">Tambahkan Artikel Sekarang</a>
                </div>
            </div>
        </section>

        <section id="artikel">
            <h1>Daftar Artikel</h1>
            <div class="all_artikel">
                <?php while ($row = mysqli_fetch_assoc($query)): ?>
                    <div class="artikel">
                        <img src="uploads/<?php echo htmlspecialchars($row['gambar']); ?>" alt="Gambar Artikel" width="450">
                        <p class="jenis_artikel"><?php echo htmlspecialchars($row['jenis_artikel']); ?></p>
                        <p class="nama">karya : <?php echo htmlspecialchars($row['penulis']); ?></p>
                        <p class="judul_artikel"><?php echo htmlspecialchars($row['judul']); ?></p>
                        <p class="isi" id="isi-<?php echo $row['id_artikel']; ?>"><?php echo nl2br(htmlspecialchars($row['konten'])); ?></p>
                        <div class="button">
                            <div class="tombol">
                                <a href="edit.php?id=<?php echo $row['id_artikel']; ?>">Edit</a> |
                                <a href="delete.php?id=<?php echo $row['id_artikel']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">Delete</a> |
                                <a href="artikel.php?id=<?php echo $row['id_artikel']; ?>">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>




        <section id="tambahartikel">
            <div class="logoTambah">
                <img src="img/tentang.png" alt="Logo">
            </div>
            <div class="form">
                <h1>Tambahkan Karya Terbaikmu di Sini!</h1>
                <form action="submit.php" method="POST" enctype="multipart/form-data">
                    <input type="text" name="judul" placeholder="Judul Artikel" required>
                    <input type="text" name="penulis" placeholder="Penulis" required>
                    <input type="text" name="jenis_artikel" placeholder="Jenis Artikel" required>
                    <textarea name="isi" placeholder="Isi Artikel" required></textarea>
                    <input type="file" name="gambar" accept="image/*"> <!-- Input untuk file gambar -->
                    <input type="submit" name="submit" value="Tambah Artikel">
                </form>

            </div>
        </section>

        <section id="tentang">
            <div class="logo_tentang">
                <img src="img/inputArtikel.png" alt="">
            </div>
            <div class="deskrip_tentang">
                <h1>Tentang AduManage</h1>
                <p>AduManage hadir untuk membantu Anda mengelola artikel dengan mudah dan efisien. Dari menggali ide kreatif hingga memperbarui informasi, kami memastikan setiap langkah menjadi pengalaman yang sederhana dan menyenangkan.</p>
                <p>Platform ini dirancang untuk mendukung produktivitas dan inspirasi Anda, sehingga berbagi informasi menjadi lebih cepat dan lebih bermakna. Jadikan AduManage mitra andalan Anda dalam mengelola konten!</p>
            </div>
        </section>


        <footer id="contact">
            <div class="all_des">
                <div class="des_1">
                    <p class="logo"><img src="img/logoPutih.png" alt="Logo AduManage">AduManage</p>
                    <p class="desc">Platform untuk berbagi informasi, edukasi, dan pengembangan teknologi masa kini.</p>
                </div>

                <div class="des2">
                    <h3>Menu</h3>
                    <ul>
                        <li><a href="">Beranda</a></li>
                        <li><a href="">Artikel</a></li>
                        <li><a href="teknologi.html">Teknologi</a></li>
                        <li><a href="tentang.html">Tentang Kami</a></li>
                    </ul>
                </div>

                <div class="des_3">
                    <h3>EduManage</h3>
                    <ul>
                        <li><a href="bantuan.html">Pusat Bantuan</a></li>
                        <li><a href="faq.html">FAQ</a></li>
                        <li><a href="syarat-ketentuan.html">Syarat & Ketentuan</a></li>
                        <li><a href="privasi.html">Kebijakan Privasi</a></li>
                    </ul>
                </div>

                <div class="des-4">
                    <h3>Kontak Kami</h3>
                    <ul>
                        <li>Email: <a href="mailto:support@adumanage.com">support@adumanage.com</a></li>
                        <li>Telepon: <a href="tel:+621234567890">+62 123 456 7890</a></li>
                        <li>Alamat: Jl. Pendidikan No. 123, Jakarta</li>
                        <li>Jam Operasional: 08:00 - 17:00 WIB</li>
                    </ul>
                </div>
            </div>

            <hr>

            <div class="medsos">
                <p>Ikuti Kami di</p>
                <ul>
                    <li><a href="https://facebook.com/adumanage" target="_blank"><ion-icon name="logo-facebook"></ion-icon></a></li>
                    <li><a href="https://twitter.com/adumanage" target="_blank"><ion-icon name="logo-twitter"></ion-icon></a></li>
                    <li><a href="https://instagram.com/adumanage" target="_blank"><ion-icon name="logo-instagram"></ion-icon></a></li>
                    <li><a href="https://whatsapp.com/company/adumanage" target="_blank"><ion-icon name="logo-whatsapp"></ion-icon></a></li>
                </ul>
                <p>copyright &copy; 2024 AduManage. All rights reserved.</p>
            </div>
        </footer>
    </div>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>