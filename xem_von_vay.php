<?php
session_start();
// Kiểm tra xem người dùng đã đăng nhập chưa
require_once "config.php";

// Lấy thông tin người dùng
$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM nguoi_dung WHERE id = $user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Danh sách các quốc gia
$countries = array("Mỹ", "Canada", "Úc", "Anh", "Nhật Bản", "Hàn Quốc", "Singapore", "Pháp", "Đức", "Hà Lan");

// Danh sách các ngành học
$majors = array("Kinh tế", "Công nghệ thông tin", "Kỹ thuật", "Y học", "Khoa học xã hội", "Luật", "Kiến trúc", "Nghệ thuật", "Khoa học tự nhiên", "Khác");

// Khởi tạo biến form
$form_data = [
    'country' => '',
    'start_date' => '',
    'end_date' => '',
    'total_cost' => '',
    'loan_amount' => '',
    'loan_type' => '',
    'repayment_plan' => '',
    'existing_loan' => '',
    'existing_loan_amount' => '',
    'existing_loan_bank' => '',
    'cic_score' => ''
];

// Xử lý form khi submit
$message = "";
$eligibility = null;
$loan_packages = array();
$reasons = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form và lưu vào biến form_data
    $form_data = [
        'country' => $_POST["country"],
        'start_date' => $_POST["start_date"],
        'end_date' => $_POST["end_date"],
        'total_cost' => $_POST["total_cost"],
        'loan_amount' => $_POST["loan_amount"],
        'loan_type' => $_POST["loan_type"],
        'repayment_plan' => $_POST["repayment_plan"],
        'existing_loan' => $_POST["existing_loan"],
        'existing_loan_amount' => isset($_POST["existing_loan_amount"]) ? $_POST["existing_loan_amount"] : '',
        'existing_loan_bank' => isset($_POST["existing_loan_bank"]) ? $_POST["existing_loan_bank"] : '',
        'cic_score' => isset($_POST["cic_score"]) ? $_POST["cic_score"] : ''
    ];

    // Kiểm tra dữ liệu đầu vào
    if (empty($form_data['country']) || empty($form_data['start_date']) || empty($form_data['end_date']) || 
        empty($form_data['total_cost']) || empty($form_data['loan_amount']) || 
        empty($form_data['loan_type']) || empty($form_data['repayment_plan']) || empty($form_data['existing_loan'])) {
        $message = "Vui lòng điền đầy đủ thông tin";
    } else {
        // Chuyển đổi số tiền từ định dạng có dấu phân cách thành số
        $total_cost_clean = str_replace('.', '', $form_data['total_cost']);
        $loan_amount_clean = str_replace('.', '', $form_data['loan_amount']);
        $existing_loan_amount_clean = $form_data['existing_loan'] == "Có" ? str_replace('.', '', $form_data['existing_loan_amount']) : 0;

        // Tạo bảng hồ sơ vay nếu chưa có
        $sql_create_table = "CREATE TABLE IF NOT EXISTS ho_so_vay (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            user_id INT(11) NOT NULL,
            country VARCHAR(50) NOT NULL,
            start_date DATE NOT NULL,
            end_date DATE NOT NULL,
            total_cost DECIMAL(15,2) NOT NULL,
            loan_amount DECIMAL(15,2) NOT NULL,
            loan_type VARCHAR(20) NOT NULL,
            repayment_plan TEXT NOT NULL,
            existing_loan VARCHAR(5) NOT NULL,
            existing_loan_amount DECIMAL(15,2),
            existing_loan_bank VARCHAR(100),
            cic_score VARCHAR(20),
            eligibility VARCHAR(20),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES nguoi_dung(id)
        )";

        if ($conn->query($sql_create_table) !== TRUE) {
            die("Lỗi tạo bảng: " . $conn->error);
        }

        // Lưu thông tin vào CSDL
        $sql = "INSERT INTO ho_so_vay (user_id, country, start_date, end_date, total_cost, loan_amount, loan_type, repayment_plan, existing_loan, existing_loan_amount, existing_loan_bank, cic_score) 
                VALUES ($user_id, '{$form_data['country']}', '{$form_data['start_date']}', '{$form_data['end_date']}', $total_cost_clean, $loan_amount_clean, '{$form_data['loan_type']}', '{$form_data['repayment_plan']}', '{$form_data['existing_loan']}', " . 
                ($form_data['existing_loan'] == "Có" ? "$existing_loan_amount_clean" : "NULL") . ", " . 
                ($form_data['existing_loan'] == "Có" ? "'{$form_data['existing_loan_bank']}'" : "NULL") . ", " . 
                (!empty($form_data['cic_score']) ? "'{$form_data['cic_score']}'" : "NULL") . ")";

        if ($conn->query($sql) === TRUE) {
            $ho_so_id = $conn->insert_id;

            // Tính tỷ lệ vay so với tổng chi phí
            $loan_ratio = ($loan_amount_clean / $total_cost_clean) * 100;

            // Logic đánh giá AI
            $eligible = true;

            // Kiểm tra điều kiện vay
            if ($loan_ratio > 100) {
                $eligible = false;
                $reasons[] = "Số tiền vay vượt quá tổng chi phí du học";
            }

            if ($form_data['existing_loan'] == "Có" && $existing_loan_amount_clean > 200000000) {
                $eligible = false;
                $reasons[] = "Dư nợ vay hiện tại quá cao (> 200 triệu đồng)";
            }

            if (!empty($form_data['cic_score']) && $form_data['cic_score'] < 600) {
                $eligible = false;
                $reasons[] = "Điểm tín dụng CIC thấp (< 600)";
            }

            if ($eligible) {
                $eligibility = "eligible";

                // Lọc các gói vay phù hợp
                // Techcombank
                if ($loan_ratio <= 85) {
                    $loan_packages[] = array(
                        "bank" => "Techcombank",
                        "name" => "Vay du học",
                        "limit" => "tối đa 85% tổng chi phí",
                        "type" => "Thế chấp",
                        "interest" => "từ 10,99%",
                        "term" => "tối thiểu 03 tháng và tối đa là 120 tháng",
                        "grace_period" => "không"
                    );
                }

                // ACB
                if ($loan_ratio <= 80) {
                    $loan_packages[] = array(
                        "bank" => "ACB",
                        "name" => "Vay du học (vay tiêu dùng)",
                        "limit" => "tối đa 70% - 80% tổng chi phí",
                        "type" => "Thế chấp",
                        "interest" => "lãi suất cơ sở 8.7%",
                        "term" => "tối thiểu 03 tháng và tối đa là 120 tháng",
                        "grace_period" => "trả trả hàng tháng hoặc hàng quý; gốc trả góp đều hoặc theo bậc thang"
                    );
                }

                // BIDV
                if ($loan_ratio <= 80) {
                    $loan_packages[] = array(
                        "bank" => "BIDV",
                        "name" => "Vay du học",
                        "limit" => "tối đa 80% tổng chi phí",
                        "type" => "Thế chấp",
                        "interest" => "lãi suất cơ sở 8.6%",
                        "term" => "tối thiểu 03 tháng và tối đa là 120 tháng",
                        "grace_period" => "ân hạn trả nợ gốc lên đến 3 năm"
                    );
                }

                // VPBank
                if ($loan_amount_clean <= 300000000 || $loan_ratio <= 70) {
                    $loan_packages[] = array(
                        "bank" => "VPBank",
                        "name" => "Vay du học",
                        "limit" => "tối đa 300 triệu đồng hoặc 70% học phí khóa học",
                        "type" => "Thế chấp",
                        "interest" => "8.6%",
                        "term" => "5 năm",
                        "grace_period" => ""
                    );
                }

                // VIB
                if ($loan_ratio <= 100) {
                    $loan_packages[] = array(
                        "bank" => "VIB",
                        "name" => "Vay du học",
                        "limit" => "tối đa 100% tổng chi phí",
                        "type" => "Thế chấp",
                        "interest" => "từ 7.49%/năm trong 6 tháng đầu, sau đó áp dụng lãi suất tiết kiệm VND kỳ hạn 12 tháng cộng biên độ cố định 3.99%/năm",
                        "term" => "tối thiểu 03 tháng và tối đa là 120 tháng",
                        "grace_period" => "không"
                    );
                }

                // Sacombank
                if ($loan_ratio <= 100) {
                    $loan_packages[] = array(
                        "bank" => "Sacombank",
                        "name" => "Vay du học",
                        "limit" => "tối đa 100% tổng chi phí",
                        "type" => "Thế chấp",
                        "interest" => "từ 9.6%",
                        "term" => "tối thiểu 03 tháng và tối đa là 120 tháng",
                        "grace_period" => "ân hạn trả nợ gốc lên đến 24 tháng"
                    );
                }

                // VietinBank
                if ($loan_ratio <= 100) {
                    $loan_packages[] = array(
                        "bank" => "VietinBank",
                        "name" => "Vay du học",
                        "limit" => "tối đa 100% tổng chi phí",
                        "type" => "Thế chấp",
                        "interest" => "từ 7,7% (lãi suất ưu đãi trên số tiết kiệm cộng phí chứng minh tài chính)",
                        "term" => "tối thiểu 03 tháng và tối đa là 120 tháng",
                        "grace_period" => "không"
                    );
                }

                // Lọc thêm theo hình thức vay
                if ($form_data['loan_type'] == "Tín chấp") {
                    $loan_packages = array_filter($loan_packages, function($package) {
                        return $package["type"] == "Tín chấp" || $package["type"] == "Thế chấp/Tín chấp";
                    });
                }

                // Nếu không còn gói vay nào phù hợp
                if (empty($loan_packages)) {
                    $eligibility = "ineligible";
                    $reasons[] = "Không tìm thấy gói vay phù hợp với yêu cầu của bạn";
                }
            } else {
                $eligibility = "ineligible";
            }

            // Cập nhật kết quả đánh giá
            $sql = "UPDATE ho_so_vay SET eligibility = '$eligibility' WHERE id = $ho_so_id";
            $conn->query($sql);

            // Chuyển hướng đến trang kết quả
            if ($eligibility == "eligible") {
                $_SESSION["loan_packages"] = $loan_packages;
                header("Location: duudieukien.php");
                exit();
            } else {
                $_SESSION["reasons"] = $reasons;
                header("Location: caithien.php");
                exit();
            }
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
    <title>Tìm kiếm vốn vay du học - LeapFi</title>
    <style>
        /* Reset CSS */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Roboto', Arial, sans-serif;
}

body {
    background-color: #f5f7fa;
    color: #333;
    line-height: 1.6;
}

.container {
    position: relative;
    max-width: 100%;
    min-height: 100vh;
    overflow: hidden;
}

.background-image {
    position: absolute;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.07;
    z-index: -1;
}

.header {
    text-align: center;
    padding: 30px 0 20px;
}

.header h1 {
    color: #1a237e;
    font-size: 28px;
    font-weight: 700;
    letter-spacing: 1px;
}

.form-container {
    max-width: 800px;
    margin: 0 auto 50px;
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    padding: 30px;
    position: relative;
}

.form-group {
    margin-bottom: 25px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #1a237e;
}

input[type="text"],
input[type="date"],
select,
textarea {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 15px;
    transition: all 0.3s;
}

input[type="text"]:focus,
input[type="date"]:focus,
select:focus,
textarea:focus {
    border-color: #303f9f;
    outline: none;
    box-shadow: 0 0 0 3px rgba(48, 63, 159, 0.1);
}

textarea {
    min-height: 100px;
    resize: vertical;
}

.row {
    display: flex;
    gap: 20px;
}

.col {
    flex: 1;
}

.conditional-field {
    display: none;
    padding: 15px;
    background: #f9f9f9;
    border-radius: 6px;
    margin-top: 15px;
    border-left: 3px solid #303f9f;
}

.error-message {
    background-color: #ffebee;
    color: #c62828;
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 20px;
    border-left: 4px solid #c62828;
}

.ai-rating {
    background-color: #e8f5e9;
    border-radius: 8px;
    padding: 20px;
    margin: 30px 0;
    border-left: 4px solid #43a047;
}

.ai-title {
    display: flex;
    align-items: center;
    font-size: 18px;
    font-weight: 600;
    color: #2e7d32;
    margin-bottom: 12px;
}

.ai-icon {
    margin-right: 10px;
    stroke: #2e7d32;
}

.btn-container {
    text-align: center;
    margin-top: 30px;
}

.btn-primary {
    background-color: #1a237e;
    color: white;
    border: none;
    padding: 14px 30px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 4px 12px rgba(26, 35, 126, 0.2);
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.btn-primary:hover {
    background-color: #303f9f;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(26, 35, 126, 0.3);
}

.back-link {
    display: inline-block;
    margin-top: 20px;
    color: #303f9f;
    text-decoration: none;
    font-weight: 500;
}

.back-link:hover {
    text-decoration: underline;
}

/* Custom select styling */
select {
    appearance: none;
    background-image: url("images/anh.png width='12' height='12' fill='%231a237e' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: calc(100% - 15px) center;
    padding-right: 40px;
}

/* System AI banner at the bottom left */
.ai-system-banner {
    position: fixed;
    bottom: 20px;
    left: 20px;
    background-color: #1a237e;
    color: white;
    padding: 12px 15px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    max-width: 250px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 100;
}

.ai-system-banner svg {
    margin-right: 10px;
}

.ai-system-banner p {
    font-size: 12px;
    line-height: 1.4;
}

/* Input fields with icons */
.input-with-icon {
    position: relative;
}

.input-with-icon input {
    padding-left: 40px;
}

.input-with-icon .icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #303f9f;
}

/* Form section dividers */
.form-divider {
    margin: 30px 0;
    border-top: 1px solid #eee;
    position: relative;
}

.form-divider::before {
    content: "";
    position: absolute;
    top: -1px;
    left: 0;
    width: 50px;
    border-top: 3px solid #1a237e;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .form-container {
        padding: 20px;
        margin: 0 15px 30px;
    }
    
    .row {
        flex-direction: column;
        gap: 0;
    }
    
    .btn-primary {
        width: 100%;
    }
    
    .header h1 {
        font-size: 24px;
    }
}
    </style>
    <script>
        // Khi trang được tải, hiển thị/ẩn các trường điều kiện dựa trên giá trị đã chọn
        window.onload = function() {
            toggleExistingLoanFields();
        };

        function toggleExistingLoanFields() {
            var existingLoan = document.getElementById('existing_loan').value;
            var conditionalFields = document.getElementById('existingLoanFields');

            if (existingLoan === 'Có') {
                conditionalFields.style.display = 'block';
            } else {
                conditionalFields.style.display = 'none';
            }
        }

        function formatCurrency(input) {
            // Xóa tất cả các ký tự không phải số
            var value = input.value.replace(/\D/g, '');

            // Format số với dấu phân cách hàng nghìn
            if (value) {
                value = parseInt(value, 10).toLocaleString('vi-VN');
            }

            // Gán giá trị đã format vào input
            input.value = value;
        }
    </script>
</head>
<body>
    <div class="container">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQtLrDRqqhpz6zyIxNaqy1ErqfZOGd0VFIRBA&s" alt="Background" class="background-image">
        <div class="header">
            <h1>THÔNG TIN KHOẢN VAY</h1>
        </div>

        <div class="form-container">
            <?php if (!empty($message)): ?>
                <div class="error-message"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="country">1. Dự định đi du học ở quốc gia nào?</label>
                    <select name="country" id="country" required>
                        <option value="">-- Chọn quốc gia --</option>
                        <?php foreach ($countries as $country): ?>
                            <option value="<?php echo $country; ?>" <?php echo ($form_data['country'] == $country) ? 'selected' : ''; ?>><?php echo $country; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="start_date">2. Thời gian dự kiến bắt đầu khóa học:</label>
                            <input type="date" name="start_date" id="start_date" required value="<?php echo $form_data['start_date']; ?>">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="end_date">Thời gian dự kiến kết thúc khóa học:</label>
                            <input type="date" name="end_date" id="end_date" required value="<?php echo $form_data['end_date']; ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="total_cost">3. Tổng chi phí dự kiến cho khóa học (VND):</label>
                    <input type="text" name="total_cost" id="total_cost" placeholder="Nhập tổng chi phí (học phí và sinh hoạt phí)" required oninput="formatCurrency(this)" value="<?php echo $form_data['total_cost']; ?>">
                </div>

                <div class="form-group">
                    <label for="loan_amount">4. Số tiền cần vay (VND):</label>
                    <input type="text" name="loan_amount" id="loan_amount" placeholder="Nhập số tiền mong muốn vay" required oninput="formatCurrency(this)" value="<?php echo $form_data['loan_amount']; ?>">
                </div>

                <div class="form-group">
                    <label for="loan_type">5. Hình thức vay vốn:</label>
                    <select name="loan_type" id="loan_type" required>
                        <option value="">-- Chọn hình thức vay --</option>
                        <option value="Thế chấp" <?php echo ($form_data['loan_type'] == 'Thế chấp') ? 'selected' : ''; ?>>Thế chấp</option>
                        <option value="Tín chấp" <?php echo ($form_data['loan_type'] == 'Tín chấp') ? 'selected' : ''; ?>>Tín chấp</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="repayment_plan">6. Kế hoạch trả nợ sau khi vay:</label>
                    <textarea name="repayment_plan" id="repayment_plan" placeholder="Mô tả kế hoạch trả nợ của bạn (nguồn thu, thời gian mong muốn trả,...)"><?php echo $form_data['repayment_plan']; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="existing_loan">7. Bạn hiện đang có khoản vay nào không?</label>
                    <select name="existing_loan" id="existing_loan" required onchange="toggleExistingLoanFields()">
                        <option value="">-- Chọn --</option>
                        <option value="Có" <?php echo ($form_data['existing_loan'] == 'Có') ? 'selected' : ''; ?>>Có</option>
                        <option value="Không" <?php echo ($form_data['existing_loan'] == 'Không') ? 'selected' : ''; ?>>Không</option>
                    </select>

                    <div id="existingLoanFields" class="conditional-field">
                        <div class="form-group">
                            <label for="existing_loan_amount">Số tiền vay hiện tại (VND):</label>
                            <input type="text" name="existing_loan_amount" id="existing_loan_amount" placeholder="Nhập số tiền vay hiện tại" oninput="formatCurrency(this)" value="<?php echo $form_data['existing_loan_amount']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="existing_loan_bank">Tại ngân hàng:</label>
                            <input type="text" name="existing_loan_bank" id="existing_loan_bank" placeholder="Tên ngân hàng" value="<?php echo $form_data['existing_loan_bank']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="cic_score">Điểm CIC (nếu biết):</label>
                            <input type="text" name="cic_score" id="cic_score" placeholder="Nhập điểm CIC của bạn (nếu biết)" value="<?php echo $form_data['cic_score']; ?>">
                        </div>
                    </div>
                </div>

                <div class="ai-rating">
                    <div class="ai-title">
                        <svg class="ai-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20z"></path>
                            <path d="M10 8a1 1 0 0 1 4 0v4a1 1 0 0 1-4 0V8z"></path>
                            <path d="M10 16a1 1 0 0 1 4 0v0a1 1 0 0 1-4 0v0z"></path>
                        </svg>
                        Đánh giá sơ bộ AI...
                    </div>
                    <p>Vui lòng điền đầy đủ thông tin để nhận đánh giá về khả năng vay vốn và gợi ý các gói vay phù hợp với nhu cầu của bạn.</p>
                </div>

                <div class="btn-container">
                    <button type="submit" class="btn-primary">GỬI ĐỂ ĐÁNH GIÁ NGAY</button>
                </div>

                <div style="text-align: center;">
                    <a href="timvonvay.php" class="back-link">« Quay lại thông tin cá nhân</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>