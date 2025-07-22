<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "toko bangunan";

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil kategori dari parameter GET
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

// Query data produk (dengan filter jika ada kategori)
if ($kategori != '') {
    $stmt = $conn->prepare("SELECT * FROM products WHERE description LIKE ?");
    $like_kategori = "%" . $kategori . "%";
    $stmt->bind_param("s", $like_kategori);
} else {
    $stmt = $conn->prepare("SELECT * FROM products");
}

$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Produk Toko Bangunan</title>
    <style>
        body { font-family: Arial; background-color: #f5f5f5; margin: 0; padding: 0; }
        header { background-color: #007bff; color: white; padding: 1em; text-align: center; }
        .filter { text-align: center; margin: 1em; }
        .products { display: flex; flex-wrap: wrap; gap: 1em; justify-content: center; padding: 1em; }
        .product { background: white; border: 1px solid #ccc; border-radius: 8px; width: 200px; padding: 1em; text-align: center; }
    </style>
</head>
<body>

<header>
    <h1>Toko Bangunan Sejahtera</h1>
</header>

<div class="filter">
    <form method="GET" action="">
        <label>Filter Kategori:
            <select name="kategori" onchange="this.form.submit()">
                <option value="">Semua</option>
                <option value="Semen" <?= $kategori == 'Semen' ? 'selected' : '' ?>>Semen</option>
                <option value="Cat" <?= $kategori == 'Cat' ? 'selected' : '' ?>>Cat</option>
                <option value="Paku" <?= $kategori == 'Paku' ? 'selected' : '' ?>>Paku</option>
            </select>
        </label>
    </form>
</div>

<div class="products">
<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='product'>";
        echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
        echo "<p><strong>Rp" . number_format($row['price'], 0, ',', '.') . "</strong></p>";
        echo "<p>" . htmlspecialchars($row['description']) . "</p>";
        echo "<p><small>Stok: " . $row['stock'] . "</small></p>";
        echo "</div>";
    }
} else {
    echo "<p>Tidak ada produk tersedia.</p>";
}
$stmt->close();
$conn->close();
?>
</div>

</body>
</html>
