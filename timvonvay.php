<?php
// Kết nối CSDL
require_once "config.php";
// Tạo bảng người_dung nếu chưa tồn tại
$sql_create_table = "CREATE TABLE IF NOT EXISTS nguoi_dung (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    ho_ten VARCHAR(100) NOT NULL,
    ngay_sinh DATE NOT NULL,
    email VARCHAR(100) NOT NULL,
    so_dien_thoai VARCHAR(20) NOT NULL,
    hinh_anh VARCHAR(255),
    ngay_dang_ky TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql_create_table) !== TRUE) {
    die("Lỗi tạo bảng: " . $conn->error);
}

// Xử lý form khi submit
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ho_ten = $_POST["ho_ten"];
    $ngay_sinh = $_POST["ngay_sinh"];
    $email = $_POST["email"];
    $so_dien_thoai = $_POST["so_dien_thoai"];
    $hinh_anh = ""; // Mặc định
    
    // Xử lý upload hình ảnh nếu có
    if(isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] == 0) {
        $target_dir = "uploads/";
        
        // Tạo thư mục uploads nếu chưa có
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES["hinh_anh"]["name"], PATHINFO_EXTENSION);
        $new_filename = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;
        
        // Kiểm tra và upload file
        $upload_ok = 1;
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Kiểm tra xem file có phải là ảnh thật hay không
        $check = getimagesize($_FILES["hinh_anh"]["tmp_name"]);
        if($check === false) {
            $message = "File không phải là hình ảnh.";
            $upload_ok = 0;
        }
        
        // Kiểm tra kích thước file
        if ($_FILES["hinh_anh"]["size"] > 5000000) {
            $message = "File quá lớn, vui lòng chọn file nhỏ hơn 5MB.";
            $upload_ok = 0;
        }
        
        // Cho phép các định dạng file nhất định
        if($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "gif") {
            $message = "Chỉ chấp nhận file JPG, JPEG, PNG và GIF.";
            $upload_ok = 0;
        }
        
        // Nếu mọi thứ đều ổn, tiến hành upload
        if ($upload_ok == 1) {
            if (move_uploaded_file($_FILES["hinh_anh"]["tmp_name"], $target_file)) {
                $hinh_anh = $target_file;
            } else {
                $message = "Đã xảy ra lỗi khi upload file.";
            }
        }
    }
    
    // Kiểm tra dữ liệu đầu vào
    if (empty($ho_ten) || empty($ngay_sinh) || empty($email) || empty($so_dien_thoai)) {
        $message = "Vui lòng điền đầy đủ thông tin";
    } else {
        // Lưu thông tin vào CSDL
        $sql = "INSERT INTO nguoi_dung (ho_ten, ngay_sinh, email, so_dien_thoai, hinh_anh) 
                VALUES ('$ho_ten', '$ngay_sinh', '$email', '$so_dien_thoai', '$hinh_anh')";
        
        if ($conn->query($sql) === TRUE) {
            // Lưu thông tin vào session để sử dụng ở các trang tiếp theo
            session_start();
            $_SESSION["user_id"] = $conn->insert_id;
            $_SESSION["ho_ten"] = $ho_ten;
            
            // Chuyển hướng đến trang tiếp theo
            header("Location: xem_von_vay.php");
            exit();
        } else {
            $message = "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm Vốn Vay - LeapFi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
        }
        .container {
            display: flex;
            max-width: 1000px;
            margin: 50px auto;
            background-color: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .form-section {
            flex: 1;
            padding: 30px;
        }
        .image-section {
            flex: 1;
            background-color: #1e40af;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .title {
            background-color: #102a67;
            color: white;
            padding: 15px;
            font-weight: bold;
            border-radius: 20px;
            margin-bottom: 20px;
            text-align: center;
        }
        .subtitle {
            color: #444;
            font-size: 0.9em;
            margin-bottom: 25px;
            text-align: center;
            font-style: italic;
        }
        .form-header {
            font-weight: bold;
            color: #003399;
            margin-bottom: 15px;
            font-size: 1.2em;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 15px;
            font-size: 1em;
            box-sizing: border-box;
        }
        .btn-primary {
            background-color: #1e40af;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1em;
            width: 50%;
            margin: 20px auto 0;
            display: block;
        }
        .btn-primary:hover {
            background-color: #1e3a8a;
        }
        .circle-bg {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background-color: #f97316;
            right: 30px;
            top: 50%;
            transform: translateY(-30%);
            z-index: 1;
        }
        .white-circle {
            position: absolute;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background-color: white;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -40%);
            z-index: 0;
        }
        .brand {
            position: absolute;
            top: 20px;
            right: 20px;
            font-weight: bold;
            font-size: 1.2em;
        }
        .feature-label {
            position: absolute;
            padding: 8px 15px;
            background-color: rgba(255,255,255,0.2);
            border-radius: 20px;
        }
        .sharing {
            left: 100px;
            top: 80px;
        }
        .error-message {
            color: red;
            margin-top: 10px;
            margin-bottom: 10px;
            text-align: center;
        }
        .student-image {
            position: absolute;
            z-index: 2;
            width: 80%;
            max-height: 90%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -45%);
            object-fit: contain;
        }
        .preview-image {
            max-width: 150px;
            max-height: 150px;
            margin: 10px auto;
            display: none;
            border-radius: 10px;
        }
        .file-input-container {
            position: relative;
            text-align: center;
            margin-bottom: 20px;
        }
        .file-input-label {
            padding: 10px 15px;
            background-color: #f0f0f0;
            border-radius: 15px;
            cursor: pointer;
            display: inline-block;
            margin-top: 10px;
        }
        .file-input {
            position: absolute;
            left: -9999px;
        }
    </style>
    <script>
        function previewImage(input) {
            var preview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="form-section">
            <div class="title">BẮT ĐẦU HÀNH TRÌNH TÌM VỐN VAY CỦA BẠN</div>
            <div class="subtitle">Nhập thông tin cá bản, nhận kết quả xét duyệt sẽ có chỉ trong 5 phút</div>
            
            <?php if (!empty($message)): ?>
                <div class="error-message"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <div class="form-header">THÔNG TIN CÁ NHÂN</div>
                
                <div class="form-group">
                    <input type="text" name="ho_ten" class="form-control" placeholder="Họ và tên">
                </div>
                
                <div class="form-group">
                    <input type="date" name="ngay_sinh" class="form-control" placeholder="Ngày sinh">
                </div>
                
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                </div>
                
                <div class="form-group">
                    <input type="tel" name="so_dien_thoai" class="form-control" placeholder="Số điện thoại">
                </div>
                
                <!-- <div class="file-input-container">
                    <div class="form-header">Hình ảnh cá nhân (tùy chọn)</div>
                    <label class="file-input-label">
                        Chọn hình ảnh
                        <input type="file" name="hinh_anh" class="file-input" onchange="previewImage(this)">
                    </label>
                    <img id="imagePreview" class="preview-image" />
                </div> -->
                
                <button type="submit" class="btn-primary">TIẾP THEO</button>
            </form>
        </div>
        
        <div class="image-section">
            <div class="brand">LeapFi</div>
            <div class="feature-label sharing">Sharing</div>
            <div class="white-circle"></div>
            <div class="circle-bg"></div>
            <img src="images/student.png" alt="Student image" class="student-image">
        </div>
    </div>
</body>
</html>