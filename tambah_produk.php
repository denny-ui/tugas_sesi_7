<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "toko_bangunan";

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Inisialisasi variabel
$name = $price = $description = "";
$error = $success = "";

// Proses form saat disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $price = trim($_POST["price"]);
    $description = trim($_POST["description"]);

    if (empty($name) || empty($price) || empty($description)) {
        $error = "Semua field harus diisi.";
    } else {
        $stmt = $conn->prepare("INSERT INTO products (name, price, description, stock) VALUES (?, ?, ?, 0)");
        $stmt->bind_param("sds", $name, $price, $description);
        
        if ($stmt->execute()) {
            $success = "Produk berhasil ditambahkan.";
        } else {
            $error = "Gagal menambahkan produk: " . $conn->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
</head>
<body>
    <h1>Form Tambah Produk</h1>

    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>

    <form method="POST" action="">
        <label>Nama Produk:<br>
            <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">
        </label><br><br>

        <label>Harga:<br>
            <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($price) ?>">
        </label><br><br>

        <label>Deskripsi:<br>
            <textarea name="description"><?= htmlspecialchars($description) ?></textarea>
        </label><br><br>

        <button type="submit">Simpan Produk</button>
    </form>
</body>
</html>
