<?php
// Thiết lập thông tin kết nối đến database

$servername = "database-server-lab7.cocgl5wbv5ga.ap-southeast-
1.rds.amazonaws.com";

$username = "admin";
$password = "12345678";
$dbname = "myDB";
// Tạo kết nối đến database
$conn = new mysqli($servername, $username, $password, $dbname);
// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
    }
    // Kiểm tra nếu form đã submit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy giá trị từ form
    $username = $_POST["username"];
    $password = $_POST["password"];
    // Truy vấn lấy dữ liệu từ database
    $sql = "SELECT * FROM User WHERE username='$username' AND
    password='$password'";
    $result = $conn->query($sql);
    // Kiểm tra số lượng bản ghi trả về
    if ($result->num_rows > 0) {
    // Nếu có, đăng nhập thành công
    echo "Bạn đã đăng nhập thành công";
    // Thực hiện các hành động cần thiết, ví dụ như đưa người dùng vào trang chào mừng
    } else {
    // Nếu không, đăng nhập không thành công
    echo "Bạn đã đăng nhập không thành công"; }
    }
    ?>
    
    <!DOCTYPE html>
    <html>
    
    <head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    </head>
    <body>
    <h2>Đăng nhập</h2>
    <form method="post" action="<?php echo
htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
<label>Tên đăng nhập:</label>
<input type="text" name="username"><br><br>
<label>Mật khẩu:</label>
<input type="password" name="password"><br><br>
<input type="submit" value="Đăng nhập">
</form>
</body>
</html>