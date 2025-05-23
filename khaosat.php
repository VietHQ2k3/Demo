<?php
// Kết nối cơ sở dữ liệu
require_once "config.php";

// Biến thông báo
$message = "";

// Xử lý khi form được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy và làm sạch dữ liệu từ form
    $ho_ten = trim($_POST['ho_ten'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $dien_thoai = trim($_POST['dien_thoai'] ?? '');

    $thu_dien_form = $_POST['thu_dien_form'] ?? '';
    $qua_trinh_dien_form = $_POST['qua_trinh_dien_form'] ?? '';

    $giao_dien_de_dung = isset($_POST['giao_dien_de_dung']) ? 1 : 0;
    $tim_duoc_thong_tin = isset($_POST['tim_duoc_thong_tin']) ? 1 : 0;
    $mot_so_phan_thieu = isset($_POST['mot_so_phan_thieu']) ? 1 : 0;
    $bi_lac_lung_tung = isset($_POST['bi_lac_lung_tung']) ? 1 : 0;
    $khong_tim_duoc = isset($_POST['khong_tim_duoc']) ? 1 : 0;

    $du_dinh_su_dung = trim($_POST['du_dinh_su_dung'] ?? '');
    $gop_y_cai_thien = trim($_POST['gop_y_cai_thien'] ?? '');

    $goi_access_companion = $_POST['goi_access_companion'] ?? '';
    $goi_access_san_sang_tra = isset($_POST['goi_access_san_sang_tra']) ? intval($_POST['goi_access_san_sang_tra']) : 0;

    $goi_scholarship_support = $_POST['goi_scholarship_support'] ?? '';
    $goi_support_gia_hop_ly = isset($_POST['goi_support_gia_hop_ly']) ? intval($_POST['goi_support_gia_hop_ly']) : 0;

    $goi_scholarship_premium = $_POST['goi_scholarship_premium'] ?? '';

    // Chuẩn bị truy vấn với prepared statement
    $sql = "INSERT INTO khao_sat (
        ho_ten, email, dien_thoai, 
        thu_dien_form, qua_trinh_dien_form, 
        giao_dien_de_dung, tim_duoc_thong_tin, mot_so_phan_thieu, bi_lac_lung_tung, khong_tim_duoc, 
        du_dinh_su_dung, gop_y_cai_thien, 
        goi_access_companion, goi_access_san_sang_tra, 
        goi_scholarship_support, goi_support_gia_hop_ly, 
        goi_scholarship_premium
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param(
            "sssssssssssssisss",
            $ho_ten,
            $email,
            $dien_thoai,
            $thu_dien_form,
            $qua_trinh_dien_form,
            $giao_dien_de_dung,
            $tim_duoc_thong_tin,
            $mot_so_phan_thieu,
            $bi_lac_lung_tung,
            $khong_tim_duoc,
            $du_dinh_su_dung,
            $gop_y_cai_thien,
            $goi_access_companion,
            $goi_access_san_sang_tra,
            $goi_scholarship_support,
            $goi_support_gia_hop_ly,
            $goi_scholarship_premium
        );

        if ($stmt->execute()) {
            $message = '<div class="alert alert-success shadow-sm">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                                <div>
                                    <h5 class="mb-0">Cảm ơn bạn đã hoàn thành khảo sát!</h5>
                                    <p class="mb-0">Phản hồi của bạn giúp chúng tôi cải thiện dịch vụ LeapFi tốt hơn.</p>
                                </div>
                            </div>
                        </div>';
        } else {
            $message = '<div class="alert alert-danger shadow-sm">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                                <div>
                                    <h5 class="mb-0">Đã xảy ra lỗi!</h5>
                                    <p class="mb-0">Vui lòng thử lại sau. Chi tiết lỗi: ' . $stmt->error . '</p>
                                </div>
                            </div>
                        </div>';
        }

        $stmt->close();
    } else {
        $message = '<div class="alert alert-danger shadow-sm">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                            <div>
                                <h5 class="mb-0">Lỗi kết nối cơ sở dữ liệu!</h5>
                                <p class="mb-0">Không thể chuẩn bị truy vấn: ' . $conn->error . '</p>
                            </div>
                        </div>
                    </div>';
    }
}
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khảo sát LeapFi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            --secondary-color: #f0f9ff;
            --text-color: #1e293b;
            --light-bg: #f8fafc;
            --border-color: #e2e8f0;
            --success-color: #10b981;
            --danger-color: #ef4444;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-color);
            padding-bottom: 40px;
        }

        .survey-header {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 20px 0;
            margin-bottom: 30px;
            border-bottom: 3px solid var(--primary-color);
        }

        .logo-area {
            display: flex;
            align-items: center;
        }

        .logo-area .logo-text {
            font-weight: 700;
            font-size: 1.8rem;
            margin-left: 10px;
            background: linear-gradient(45deg, var(--primary-color), #60a5fa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .survey-container {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-top: 10px;
            margin-bottom: 30px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .survey-container:hover {
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--primary-color);
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-color);
        }

        .question-card {
            background-color: #fff;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .question-card:hover {
            border-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
        }

        .question-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            font-size: 0.85rem;
            font-weight: 600;
            margin-right: 10px;
        }

        .question-label {
            font-weight: 600;
            font-size: 1.05rem;
            margin-bottom: 15px;
        }

        .form-check {
            margin-bottom: 12px;
            padding-left: 25px;
        }

        .form-check-input {
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            cursor: pointer;
            padding-left: 5px;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        }

        .hidden-follow-up {
            display: none;
            margin-left: 28px;
            padding: 15px;
            border-radius: 8px;
            background-color: var(--secondary-color);
            margin-top: 10px;
            margin-bottom: 15px;
            border-left: 3px solid var(--primary-color);
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .package-card {
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .package-card:hover {
            border-color: var(--primary-color);
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.15);
        }

        .package-title {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .package-title i {
            margin-right: 10px;
            font-size: 1.3rem;
        }

        .package-price {
            display: inline-block;
            background-color: var(--secondary-color);
            color: var(--primary-color);
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-left: 10px;
        }

        .feature-list {
            padding-left: 0;
            list-style-type: none;
            margin-bottom: 15px;
        }

        .feature-list li {
            padding: 5px 0;
            display: flex;
            align-items: center;
        }

        .feature-list li::before {
            content: "✓";
            display: inline-block;
            color: var(--success-color);
            font-weight: bold;
            margin-right: 10px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 500;
            padding: 10px 25px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .progress-container {
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: white;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .progress {
            height: 8px;
            border-radius: 10px;
        }

        .progress-bar {
            background-color: var(--primary-color);
        }

        .required-asterisk {
            color: var(--danger-color);
            margin-left: 3px;
        }

        .info-icon {
            cursor: pointer;
            color: var(--primary-color);
            margin-left: 5px;
            font-size: 0.9rem;
        }

        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 200px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -100px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }

        /* Animation for form elements */
        .animate-in {
            animation: fadeInUp 0.5s ease forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .survey-container {
                padding: 20px;
            }

            .question-card {
                padding: 15px;
            }
        }

        .thank-you-container {
            text-align: center;
            padding: 40px 20px;
            display: none;
        }

        .thank-you-icon {
            font-size: 5rem;
            color: var(--success-color);
            margin-bottom: 20px;
        }

        .input-group-text {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <div class="survey-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="logo-area">
                        <span class="logo-text">LeapFi</span>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <span class="badge bg-primary">Thời gian hoàn thành: ~3 phút</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Progress Bar -->
        <div class="progress-container" id="progressContainer">
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="surveyProgress"></div>
            </div>
            <div class="d-flex justify-content-between mt-1">
                <small>Bắt đầu</small>
                <small>Hoàn thành</small>
            </div>
        </div>

        <!-- Introduction -->
        <div class="survey-container animate-in">
            <h1 class="text-center mb-4">Khảo sát nhanh – Cùng LeapFi cải thiện trải nghiệm du học của bạn!</h1>

            <div class="card mb-4 border-0 bg-light">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="bi bi-lightbulb-fill text-primary fs-1"></i>
                        </div>
                        <div>
                            <p class="lead mb-0">
                                Chào bạn! Đây là khảo sát ngắn nhằm giúp LeapFi hiểu rõ hơn về nhu cầu, trải nghiệm và mức độ sẵn sàng chi trả
                                của bạn cho các dịch vụ tài chính du học. Thời gian thực hiện chỉ 2–3 phút và mọi thông tin đều được bảo mật tuyệt đối.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo $message; ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="surveyForm">
                <!-- Thông tin cá nhân -->
                <div class="mb-4">
                    <h4 class="section-title">
                        <i class="bi bi-person-circle me-2"></i>Thông tin cá nhân
                    </h4>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="ho_ten" class="form-label">Họ và tên <span class="required-asterisk">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="ho_ten" name="ho_ten" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="email" class="form-label">Email <span class="required-asterisk">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="dien_thoai" class="form-label">Số điện thoại</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                <input type="text" class="form-control" id="dien_thoai" name="dien_thoai">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PHẦN 1 -->
                <h3 class="section-title">
                    <i class="bi bi-star-fill me-2"></i>PHẦN 1 – ĐÁNH GIÁ TRẢI NGHIỆM NỀN TẢNG LEAPFI
                </h3>
                <p class="mb-4">
                    Cảm ơn bạn đã trải nghiệm nền tảng LeapFi – phiên bản thử nghiệm đầu tiên (MVP).
                    Chúng tôi muốn lắng nghe cảm nhận và góp ý từ bạn để cải thiện sản phẩm tốt hơn nữa.
                </p>

                <!-- Câu 1 -->
                <div class="question-card animate-in">
                    <div class="question-label">
                        <span class="question-number">1</span>
                        Bạn có thử điền form đăng ký khoản vay sơ bộ chưa? <span class="required-asterisk">*</span>
                        <small class="text-muted fst-italic">(chỉ chọn 1)</small>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input thu-dien-form" type="radio" name="thu_dien_form" id="thu_dien_form_1" value="Có" required>
                        <label class="form-check-label" for="thu_dien_form_1">Có</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input thu-dien-form" type="radio" name="thu_dien_form" id="thu_dien_form_2" value="Dự định sẽ thử">
                        <label class="form-check-label" for="thu_dien_form_2">Dự định sẽ thử</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input thu-dien-form" type="radio" name="thu_dien_form" id="thu_dien_form_3" value="Không, chưa sẵn sàng">
                        <label class="form-check-label" for="thu_dien_form_3">Không, chưa sẵn sàng</label>
                    </div>

                    <!-- Câu hỏi phụ -->
                    <div id="followup_qua_trinh" class="hidden-follow-up">
                        <div class="question-label">
                            <i class="bi bi-arrow-return-right me-2"></i>
                            Quá trình điền form đăng ký sơ bộ như thế nào?
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="qua_trinh_dien_form" id="qua_trinh_1" value="Nhanh, dễ hiểu">
                            <label class="form-check-label" for="qua_trinh_1">Nhanh, dễ hiểu</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="qua_trinh_dien_form" id="qua_trinh_2" value="Hơi dài và lặp lại">
                            <label class="form-check-label" for="qua_trinh_2">Hơi dài và lặp lại</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="qua_trinh_dien_form" id="qua_trinh_3" value="Mình không rõ mình đang điền đúng không">
                            <label class="form-check-label" for="qua_trinh_3">Mình không rõ mình đang điền đúng không</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="qua_trinh_dien_form" id="qua_trinh_4" value="Khác">
                            <label class="form-check-label" for="qua_trinh_4">Khác:</label>
                            <input type="text" class="form-control mt-2" id="qua_trinh_khac" placeholder="Vui lòng mô tả">
                        </div>
                    </div>
                </div>

                <!-- Câu 2 -->
                <div class="question-card animate-in">
                    <div class="question-label">
                        <span class="question-number">2</span>
                        Trải nghiệm của bạn khi sử dụng nền tảng LeapFi (phiên bản thử nghiệm):
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="giao_dien_de_dung" id="trai_nghiem_1" value="1">
                        <label class="form-check-label" for="trai_nghiem_1">Giao diện dễ dùng, thân thiện</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="tim_duoc_thong_tin" id="trai_nghiem_2" value="1">
                        <label class="form-check-label" for="trai_nghiem_2">Tìm được thông tin mình cần</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="mot_so_phan_thieu" id="trai_nghiem_3" value="1">
                        <label class="form-check-label" for="trai_nghiem_3">Một số phần còn thiếu/chưa rõ ràng</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="bi_lac_lung_tung" id="trai_nghiem_4" value="1">
                        <label class="form-check-label" for="trai_nghiem_4">Mình bị lạc/lúng túng khi sử dụng</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="khong_tim_duoc" id="trai_nghiem_5" value="1">
                        <label class="form-check-label" for="trai_nghiem_5">Mình không tìm được thứ mình cần</label>
                    </div>
                </div>

                <!-- Câu 3 -->
                <div class="question-card animate-in">
                    <div class="question-label">
                        <span class="question-number">3</span>
                        Bạn có dự định tiếp tục sử dụng LeapFi trong tương lai khi cần vay du học không? <span class="required-asterisk">*</span>
                        <small class="text-muted fst-italic">(chỉ chọn 1)</small>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="du_dinh_su_dung" id="du_dinh_1" value="Có, chắc chắn sẽ dùng" required>
                        <label class="form-check-label" for="du_dinh_1">Có, chắc chắn sẽ dùng</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="du_dinh_su_dung" id="du_dinh_2" value="Có thể, nếu được cải thiện thêm">
                        <label class="form-check-label" for="du_dinh_2">Có thể, nếu được cải thiện thêm</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="du_dinh_su_dung" id="du_dinh_3" value="Cần xem thêm đánh giá từ người khác">
                        <label class="form-check-label" for="du_dinh_3">Cần xem thêm đánh giá từ người khác</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="du_dinh_su_dung" id="du_dinh_4" value="Không, mình sẽ chọn cách khác">
                        <label class="form-check-label" for="du_dinh_4">Không, mình sẽ chọn cách khác</label>
                    </div>
                </div>

                <!-- Câu 4 -->
                <div class="question-card animate-in">
                    <div class="question-label">
                        <span class="question-number">4</span>
                        Bạn mong muốn LeapFi cải thiện hoặc bổ sung điều gì tiếp theo?
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" id="gop_y_cai_thien" name="gop_y_cai_thien" rows="3" placeholder="Chia sẻ ý kiến của bạn..."></textarea>
                    </div>
                </div>

                <!-- PHẦN 2 -->
                <h3 class="section-title mt-5">
                    <i class="bi bi-cash-coin me-2"></i>PHẦN 2: GIỚI THIỆU CÁC TÍNH NĂNG VÀ KHẢO SÁT MỨC CHI TRẢ
                </h3>

                <!-- Gói 1 -->
                <div class="package-card animate-in">
                    <h5 class="package-title">
                        <i class="bi bi-stars"></i>
                        Gói Kết nối khoản vay
                        <span class="package-price">299.000đ - 499.000đ</span>
                    </h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light border-0 mb-3">
                                <div class="card-body py-2">
                                    <h6 class="card-title mb-2">
                                        <i class="bi bi-bookmark-check me-2 text-primary"></i>LeapFi Access <small>(6 tháng - 299.000đ)</small>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light border-0 mb-3">
                                <div class="card-body py-2">
                                    <h6 class="card-title mb-2">
                                        <i class="bi bi-bookmark-star me-2 text-primary"></i>LeapFi Companion <small>(12 tháng - 499.000đ)</small>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="feature-list">
                        <li>Ưu tiên xử lý hồ sơ (ưu tiên với ngân hàng)</li>
                        <li>Kho mẫu giấy tờ tài chính & checklist theo quốc gia cụ thể</li>
                        <li>Trợ lý nhắc lịch thông minh (SMS + email)</li>
                        <li>Theo dõi khoản vay và phân tích tài chính cá nhân sau khi được duyệt</li>
                    </ul>

                    <div class="question-label">
                        Nếu có gói dịch vụ như trên, bạn có sẵn sàng chi trả không? <span class="required-asterisk">*</span>
                        <small class="text-muted fst-italic">(chỉ chọn 1)</small>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="goi_access_companion" id="goi_access_1" value="Có, sẵn sàng chi ngay" required>
                        <label class="form-check-label" for="goi_access_1">Có, sẵn sàng chi ngay</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="goi_access_companion" id="goi_access_2" value="Có thể, nếu dùng thử tốt">
                        <label class="form-check-label" for="goi_access_2">Có thể, nếu dùng thử tốt</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="goi_access_companion" id="goi_access_3" value="Không, mình không cần">
                        <label class="form-check-label" for="goi_access_3">Không, mình không cần</label>
                    </div>

                    <div class="mt-3">
                        <label for="goi_access_san_sang_tra" class="form-label">Mình sẵn sàng trả khoảng: (VNĐ)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                            <input type="number" class="form-control" id="goi_access_san_sang_tra" name="goi_access_san_sang_tra" placeholder="Nhập số tiền">
                        </div>
                    </div>
                </div>

                <!-- Gói 2 -->
                <div class="package-card animate-in">
                    <h5 class="package-title">
                        <i class="bi bi-award"></i>
                        Gói Scholarship Support
                        <span class="package-price">1.199.000đ</span>
                    </h5>

                    <ul class="feature-list">
                        <li>Danh sách học bổng cập nhật liên tục</li>
                        <li>Gợi ý học bổng AI-driven theo hồ sơ cá nhân</li>
                        <li>Hướng dẫn từng bước & chiến lược apply học bổng</li>
                        <li>Tài nguyên CV, bài luận, checklist</li>
                    </ul>

                    <div class="question-label">
                        Bạn nghĩ gói này có giá trị thế nào với bạn? <span class="required-asterisk">*</span>
                        <small class="text-muted fst-italic">(chỉ chọn 1)</small>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="goi_scholarship_support" id="goi_support_1" value="Rất hữu ích, mình sẵn sàng trả" required>
                        <label class="form-check-label" for="goi_support_1">Rất hữu ích, mình sẵn sàng trả</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="goi_scholarship_support" id="goi_support_2" value="Chỉ cần một phần, không cần toàn bộ">
                        <label class="form-check-label" for="goi_support_2">Chỉ cần một phần, không cần toàn bộ</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="goi_scholarship_support" id="goi_support_3" value="Mình sẽ thử nếu có bản dùng thử">
                        <label class="form-check-label" for="goi_support_3">Mình sẽ thử nếu có bản dùng thử</label>
                    </div>

                    <div class="mt-3">
                        <label for="goi_support_gia_hop_ly" class="form-label">Giá mình thấy hợp lý là: (VNĐ)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                            <input type="number" class="form-control" id="goi_support_gia_hop_ly" name="goi_support_gia_hop_ly" placeholder="Nhập số tiền">
                        </div>
                    </div>
                </div>

                <!-- Gói 3 -->
                <div class="package-card animate-in">
                    <div class="ribbon-container position-relative">
                        <span class="badge bg-warning position-absolute top-0 end-0 mt-2 me-2">Premium</span>
                    </div>

                    <h5 class="package-title">
                        <i class="bi bi-gem"></i>
                        Gói Scholarship Premium
                        <span class="package-price">3.999.000đ</span>
                    </h5>

                    <p class="mb-3">
                        Scholarship Premium là gói nâng cấp mở rộng từ gói Scholarship Support,
                        bao gồm đầy đủ các tính năng hỗ trợ tự động và tài nguyên học bổng, kèm theo:
                    </p>

                    <ul class="feature-list">
                        <li>Mentoring 1:1 với chuyên gia</li>
                        <li>Chấm điểm & chỉnh sửa bài luận</li>
                        <li>Scholarship roadmap cá nhân hóa</li>
                        <li>Feedback toàn diện hồ sơ (GPA – IELTS – hoạt động – tài chính – thư giới thiệu)</li>
                    </ul>

                    <div class="question-label">
                        Bạn có sẵn sàng trả thêm để được mentor cá nhân không? <span class="required-asterisk">*</span>
                        <small class="text-muted fst-italic">(chỉ chọn 1)</small>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="goi_scholarship_premium" id="goi_premium_1" value="Có, nếu mentor đủ chất lượng" required>
                        <label class="form-check-label" for="goi_premium_1">Có, nếu mentor đủ chất lượng</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="goi_scholarship_premium" id="goi_premium_2" value="Có thể, nếu chia nhỏ thành từng buổi">
                        <label class="form-check-label" for="goi_premium_2">Có thể, nếu chia nhỏ thành từng buổi</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="goi_scholarship_premium" id="goi_premium_3" value="Không, mình thích tự học hơn">
                        <label class="form-check-label" for="goi_premium_3">Không, mình thích tự học hơn</label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center mt-4 animate-in">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-send me-2"></i>Gửi khảo sát
                    </button>
                </div>
            </form>

            <!-- Thank You Message (Hidden by default) -->
            <div class="thank-you-container" id="thankYouContainer">
                <i class="bi bi-check-circle-fill thank-you-icon"></i>
                <h2>Cảm ơn bạn đã hoàn thành khảo sát!</h2>
                <p class="lead">Phản hồi của bạn rất quan trọng với chúng tôi để cải thiện dịch vụ LeapFi.</p>
                <div class="mt-4">
                    <a href="#" class="btn btn-outline-primary">Quay lại trang chủ</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2025 LeapFi. Tất cả các quyền được bảo lưu.</p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="#" class="text-decoration-none text-secondary me-3">Chính sách bảo mật</a>
                    <a href="#" class="text-decoration-none text-secondary">Điều khoản sử dụng</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Hiển thị câu hỏi phụ khi chọn "Có" ---
            const thuDienFormRadios = document.querySelectorAll('.thu-dien-form');
            const followUpQuestion = document.getElementById('followup_qua_trinh');

            if (followUpQuestion && thuDienFormRadios.length > 0) {
                thuDienFormRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        followUpQuestion.style.display = (this.value === 'Có' && this.checked) ? 'block' : 'none';
                    });
                });
            }

            // --- Xử lý input "Khác" ---
            const quaTrinhKhacRadio = document.getElementById('qua_trinh_4');
            const quaTrinhKhacInput = document.getElementById('qua_trinh_khac');

            if (quaTrinhKhacRadio && quaTrinhKhacInput) {
                quaTrinhKhacInput.addEventListener('input', function() {
                    const value = this.value.trim();
                    if (value !== '') {
                        quaTrinhKhacRadio.checked = true;
                        quaTrinhKhacRadio.value = 'Khác: ' + value;
                    }
                });
            }

            // --- Progress bar ---
            const progressBar = document.getElementById('surveyProgress');
            const form = document.getElementById('surveyForm');

            if (form && progressBar) {
                const formElements = Array.from(form.elements).filter(el => ['radio', 'checkbox', 'text', 'email', 'textarea', 'number'].includes(el.type) &&
                    !el.classList.contains('no-progress')
                );
                const requiredElements = Array.from(form.querySelectorAll('[required]'));

                function updateProgress() {
                    const filledRequired = requiredElements.filter(el => {
                        if (el.type === 'radio') {
                            return form.querySelector(`input[name="${el.name}"]:checked`);
                        }
                        return el.value.trim() !== '';
                    });

                    const filledOptional = formElements.filter(el => {
                        if (requiredElements.includes(el)) return false;
                        if (['radio', 'checkbox'].includes(el.type)) return el.checked;
                        return el.value.trim() !== '';
                    });

                    const totalWeight = requiredElements.length * 2 + (formElements.length - requiredElements.length);
                    const currentWeight = filledRequired.length * 2 + filledOptional.length;

                    const progressPercentage = Math.min(Math.round((currentWeight / totalWeight) * 100), 100);
                    progressBar.style.width = progressPercentage + '%';
                    progressBar.setAttribute('aria-valuenow', progressPercentage);
                }

                // Gán sự kiện cho tất cả các phần tử liên quan
                formElements.forEach(el => {
                    el.addEventListener('change', updateProgress);
                    if (el.tagName.toLowerCase() === 'textarea' || el.type === 'text') {
                        el.addEventListener('input', updateProgress);
                    }
                });

                updateProgress();
            }

            // --- Hiệu ứng xuất hiện khi cuộn ---
            const animateElements = document.querySelectorAll('.animate-in');

            function checkIfInView() {
                animateElements.forEach(el => {
                    const rect = el.getBoundingClientRect();
                    if (
                        rect.top >= 0 &&
                        rect.left >= 0 &&
                        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                    ) {
                        el.style.opacity = 1;
                        el.style.transform = 'translateY(0)';
                    }
                });
            }

            // Trigger animation
            setTimeout(checkIfInView, 100);
            window.addEventListener('scroll', checkIfInView);

            // --- Form submission (comment để bật thử nghiệm) ---
            /*
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                form.style.display = 'none';
                const thankYou = document.getElementById('thankYouContainer');
                if (thankYou) thankYou.style.display = 'block';
            });
            */
        });
    </script>


</body>

</html>