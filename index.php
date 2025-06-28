<?php
// Thông tin kết nối đến RDS MySQL
$host = 'mydb2.c1i02sci8x5p.us-east-1.rds.amazonaws.com';
$db   = 'myDB';
$user = 'admin';
$pass = 'dieulinh';

try {
    // Kết nối MySQL
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Truy vấn dữ liệu
    $stmt = $pdo->query("SELECT * FROM city");
    $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Tính tổng dân số
    $totalPopulation = 0;
    foreach ($cities as $city) {
        $totalPopulation += $city['population'];
    }

    // Lấy IP nội bộ (private IP)
    function getPrivateIP() {
        $interfaces = shell_exec("hostname -I");
        $ips = explode(' ', trim($interfaces));
        foreach ($ips as $ip) {
            if (strpos($ip, '192.') === 0 || strpos($ip, '10.') === 0 || strpos($ip, '172.') === 0) {
                return $ip;
            }
        }
        return 'Không tìm thấy';
    }

    $privateIP = getPrivateIP();
} catch (PDOException $e) {
    die("Lỗi kết nối CSDL: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Danh sách thành phố</title>
</head>
<body>
    <h1>Private IP: <?= htmlspecialchars($privateIP) ?></h1>
    <h2>Tổng dân số: <?= number_format($totalPopulation) ?></h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Tên TP</th>
            <th>Quốc gia</th>
            <th>Dân số</th>
        </tr>
        <?php foreach ($cities as $city): ?>
            <tr>
                <td><?= htmlspecialchars($city['id']) ?></td>
                <td><?= htmlspecialchars($city['name']) ?></td>
                <td><?= htmlspecialchars($city['country']) ?></td>
                <td><?= number_format($city['population']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
