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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <span class="navbar-brand">Toko Bangunan Sejahtera</span>
  </div>
</nav>

<div class="container my-4">
    <form method="GET" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <label for="kategori" class="col-form-label">Filter Kategori:</label>
            </div>
            <div class="col-auto">
                <select name="kategori" id="kategori" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua</option>
                    <option value="Semen" <?= $kategori == 'Semen' ? 'selected' : '' ?>>Semen</option>
                    <option value="Cat" <?= $kategori == 'Cat' ? 'selected' : '' ?>>Cat</option>
                    <option value="Paku" <?= $kategori == 'Paku' ? 'selected' : '' ?>>Paku</option>
                </select>
            </div>
        </div>
    </form>

    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Rp<?= number_format($row['price'], 0, ',', '.') ?></h6>
                            <p class="card-text"><?= htmlspecialchars($row['description']) ?></p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Stok: <?= $row['stock'] ?></small>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">Tidak ada produk ditemukan.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
