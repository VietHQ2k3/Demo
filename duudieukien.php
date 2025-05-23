<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ sơ đủ điều kiện - LeapFi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', Arial, sans-serif;
        }

        body {
            background-color: #f8f9fc;
            color: #333;
            line-height: 1.6;
        }

        .container {
            width: 100%;
            min-height: 100vh;
            position: relative;
        }

        .success-container {
            background: linear-gradient(135deg, #4568dc, #3b5998);
            color: white;
            padding: 60px 20px;
            text-align: center;
            border-radius: 0 0 40px 40px;
            box-shadow: 0 10px 30px rgba(59, 89, 152, 0.25);
            position: relative;
            overflow: hidden;
        }

        .success-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.6;
        }

        .success-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 15px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            position: relative;
            z-index: 1;
        }

        .success-subtitle {
            font-size: 17px;
            opacity: 0.95;
            margin-bottom: 30px;
            line-height: 1.7;
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .celebration-icon {
            font-size: 40px;
            margin: 15px 0;
            position: relative;
            z-index: 1;
            display: inline-block;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {transform: scale(1);}
            50% {transform: scale(1.2);}
            100% {transform: scale(1);}
        }

        .btn-primary {
            background: linear-gradient(135deg, #FF8008, #FFC837);
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 6px 15px rgba(255, 128, 8, 0.3);
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #FFC837, #FF8008);
            opacity: 0;
            transition: opacity 0.3s;
            z-index: -1;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 128, 8, 0.4);
        }

        .btn-primary:hover::before {
            opacity: 1;
        }

        .metrics-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 25px;
            padding: 30px 20px;
            margin-top: 30px;
        }

        .metric-card {
            background-color: #fff;
            border-radius: 20px;
            overflow: hidden;
            width: 320px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .metric-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .metric-header {
            background: linear-gradient(135deg, #20bf55, #01baef);
            color: white;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .metric-header::after {
            content: '';
            position: absolute;
            right: -10px;
            bottom: -10px;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .metric-title {
            font-size: 18px;
            font-weight: 600;
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
        }

        .metric-title i {
            margin-right: 10px;
            font-size: 20px;
        }

        .metric-content {
            padding: 25px;
            position: relative;
        }

        .chart-container {
            width: 100%;
            height: 200px;
            margin-top: 10px;
        }

        .metric-value {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .metric-label {
            color: #777;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .large-metric-card {
            width: 665px;
            background-color: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .large-metric-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .large-metric-header {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: white;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .large-metric-header::after {
            content: '';
            position: absolute;
            right: -10px;
            bottom: -10px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .large-metric-content {
            padding: 25px;
            position: relative;
        }

        .large-chart-container {
            width: 100%;
            height: 250px;
        }

        .description {
            max-width: 900px;
            margin: 50px auto 30px;
            padding: 0 20px;
            text-align: center;
        }

        .description h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .description h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 70px;
            height: 3px;
            background: linear-gradient(135deg, #4568dc, #3b5998);
            border-radius: 3px;
        }

        .description p {
            color: #666;
            font-size: 17px;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .packages-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .package-card {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
            overflow: hidden;
            transition: all 0.3s;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .package-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .package-header {
            background: linear-gradient(135deg, #4568dc, #3b5998);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .package-header::before {
            content: '';
            position: absolute;
            top: -15px;
            left: -15px;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .bank-name {
            font-weight: 700;
            font-size: 20px;
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
        }

        .bank-name i {
            margin-right: 10px;
        }

        .package-name {
            font-size: 16px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .package-content {
            padding: 25px;
        }

        .package-detail {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eef2f7;
            display: flex;
            flex-direction: column;
        }

        .package-detail:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .detail-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .detail-label i {
            margin-right: 10px;
            color: #4568dc;
            font-size: 16px;
        }

        .detail-value {
            color: #333;
            font-size: 16px;
            padding-left: 26px;
        }

        .action-container {
            padding: 40px 20px;
            text-align: center;
            background-color: #f8f9fc;
            border-top: 1px solid #eef2f7;
            margin-top: 20px;
        }

        .btn-secondary {
            background-color: transparent;
            color: #4568dc;
            border: 2px solid #4568dc;
            padding: 15px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            margin: 0 10px;
        }

        .btn-secondary:hover {
            background-color: rgba(69, 104, 220, 0.1);
            color: #3b5998;
            border-color: #3b5998;
        }

        /* Progress bar styles */
        .progress-container {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            position: relative;
            margin: 20px 0;
            height: 10px;
            width: 100%;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            overflow: hidden;
        }

        .progress-bar {
            border-radius: 20px;
            height: 100%;
            width: 90%;
            background: linear-gradient(135deg, #00f260, #0575e6);
            animation: progress-animation 2s ease-in-out;
        }

        @keyframes progress-animation {
            0% {width: 0;}
            100% {width: 90%;}
        }

        .progress-label {
            color: white;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
            text-align: center;
        }

        /* Animation for elements */
        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(20px);}
            to {opacity: 1; transform: translateY(0);}
        }

        /* Animation delays */
        .delay-1 {animation-delay: 0.2s;}
        .delay-2 {animation-delay: 0.4s;}
        .delay-3 {animation-delay: 0.6s;}
        .delay-4 {animation-delay: 0.8s;}

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .large-metric-card {
                width: 100%;
                max-width: 600px;
            }
        }

        @media (max-width: 768px) {
            .metrics-container {
                flex-direction: column;
                align-items: center;
            }
            
            .metric-card, 
            .large-metric-card {
                width: 100%;
                max-width: 450px;
            }
            
            .success-title {
                font-size: 22px;
            }

            .success-subtitle {
                font-size: 15px;
            }

            .package-header {
                flex-direction: column;
                text-align: center;
            }

            .bank-name {
                margin-bottom: 8px;
            }
        }

        @media (max-width: 480px) {
            .metric-card, 
            .large-metric-card {
                max-width: 100%;
            }

            .btn-primary, 
            .btn-secondary {
                width: 100%;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-container">
            <h1 class="success-title fade-in">CHÚC MỪNG! HỒ SƠ CỦA BẠN<br>ĐÃ ĐẠT TIÊU CHÍ SƠ BỘ</h1>
            <div class="celebration-icon fade-in delay-1"><i class="fas fa-award"></i></div>
            <p class="success-subtitle fade-in delay-2">Hệ thống AI của LeapFi đã phân tích thông tin và nhận thấy hồ sơ của bạn đáp ứng các yêu cầu cơ bản cho khoản vay du học. Bước tiếp theo, hãy tiến hành nộp hồ sơ chi tiết để ngân hàng xét duyệt chính thức.</p>
            
            <div class="progress-container fade-in delay-3">
                <div class="progress-bar"></div>
            </div>
            <div class="progress-label fade-in delay-3">Khả năng được duyệt: 90%</div>
            
            <a href="#packages" class="btn-primary fade-in delay-4">XEM ĐÁNH GIÁ CHI TIẾT <i class="fas fa-arrow-right"></i></a>
        </div>

        <div class="metrics-container">
            <div class="metric-card fade-in">
                <div class="metric-header">
                    <h3 class="metric-title"><i class="fas fa-chart-line"></i> Điểm tín dụng tích cực</h3>
                </div>
                <div class="metric-content">
                    <div class="metric-value">780/850</div>
                    <div class="metric-label">Điểm tín dụng của bạn</div>
                    <div class="chart-container">
                        <canvas id="creditScoreChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="metric-card fade-in delay-1">
                <div class="metric-header" style="background: linear-gradient(135deg, #11998e, #38ef7d);">
                    <h3 class="metric-title"><i class="fas fa-graduation-cap"></i> Ngành học tiềm năng</h3>
                </div>
                <div class="metric-content">
                    <div class="metric-value">85%</div>
                    <div class="metric-label">Tỷ lệ việc làm sau tốt nghiệp</div>
                    <div class="chart-container">
                        <canvas id="fieldPotentialChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="large-metric-card fade-in delay-2">
                <div class="large-metric-header">
                    <h3 class="metric-title"><i class="fas fa-check-circle"></i> Tiềm năng xét duyệt cao</h3>
                </div>
                <div class="large-metric-content">
                    <div class="metric-value">90%</div>
                    <div class="metric-label">Tỷ lệ hồ sơ được duyệt tương tự</div>
                    <div class="large-chart-container">
                        <canvas id="approvalPotentialChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="description fade-in">
            <h2>Các gói vay phù hợp với bạn</h2>
            <p>Dựa trên thông tin bạn cung cấp, hệ thống AI của chúng tôi đã xác định các gói vay du học sau đây phù hợp nhất với nhu cầu của bạn.</p>
        </div>

        <div class="packages-container" id="packages">
            <div class="package-card fade-in">
                <div class="package-header">
                    <span class="bank-name"><i class="fas fa-university"></i> Ngân hàng TMCP Ngoại thương Việt Nam</span>
                    <span class="package-name">Gói vay du học premium</span>
                </div>
                <div class="package-content">
                    <div class="package-detail">
                        <div class="detail-label"><i class="fas fa-money-bill-wave"></i> Hạn mức vay:</div>
                        <div class="detail-value">Lên đến 90% tổng chi phí du học</div>
                    </div>
                    <div class="package-detail">
                        <div class="detail-label"><i class="fas fa-tags"></i> Loại hình vay:</div>
                        <div class="detail-value">Vay tín chấp kết hợp thế chấp tài sản</div>
                    </div>
                    <div class="package-detail">
                        <div class="detail-label"><i class="fas fa-percentage"></i> Lãi suất:</div>
                        <div class="detail-value">8.5% - 10.5% / năm</div>
                    </div>
                    <div class="package-detail">
                        <div class="detail-label"><i class="fas fa-calendar-alt"></i> Thời hạn vay:</div>
                        <div class="detail-value">Tối đa 10 năm</div>
                    </div>
                    <div class="package-detail">
                        <div class="detail-label"><i class="fas fa-hourglass-half"></i> Thời gian ân hạn:</div>
                        <div class="detail-value">Tối đa thời gian học tập + 6 tháng</div>
                    </div>
                </div>
            </div>

            <div class="package-card fade-in delay-1">
                <div class="package-header" style="background: linear-gradient(135deg, #2193b0, #6dd5ed);">
                    <span class="bank-name"><i class="fas fa-university"></i> Ngân hàng TMCP Đầu tư và Phát triển Việt Nam</span>
                    <span class="package-name">Gói vay du học tiêu chuẩn</span>
                </div>
                <div class="package-content">
                    <div class="package-detail">
                        <div class="detail-label"><i class="fas fa-money-bill-wave"></i> Hạn mức vay:</div>
                        <div class="detail-value">Lên đến 80% tổng chi phí du học</div>
                    </div>
                    <div class="package-detail">
                        <div class="detail-label"><i class="fas fa-tags"></i> Loại hình vay:</div>
                        <div class="detail-value">Vay thế chấp bất động sản</div>
                    </div>
                    <div class="package-detail">
                        <div class="detail-label"><i class="fas fa-percentage"></i> Lãi suất:</div>
                        <div class="detail-value">9.0% - 11.0% / năm</div>
                    </div>
                    <div class="package-detail">
                        <div class="detail-label"><i class="fas fa-calendar-alt"></i> Thời hạn vay:</div>
                        <div class="detail-value">Tối đa 15 năm</div>
                    </div>
                    <div class="package-detail">
                        <div class="detail-label"><i class="fas fa-hourglass-half"></i> Thời gian ân hạn:</div>
                        <div class="detail-value">Tối đa thời gian học tập + 3 tháng</div>
                    </div>
                </div>
            </div>

            <div class="package-card fade-in delay-2">
                <div class="package-header" style="background: linear-gradient(135deg, #ff8008, #ffc837);">
                    <span class="bank-name"><i class="fas fa-university"></i> Ngân hàng TMCP Á Châu</span>
                    <span class="package-name">Gói vay du học linh hoạt</span>
                </div>
                <div class="package-content">
                    <div class="package-detail">
                        <div class="detail-label"><i class="fas fa-money-bill-wave"></i> Hạn mức vay:</div>
                        <div class="detail-value">Lên đến 70% tổng chi phí du học</div>
                    </div>
                    <div class="package-detail">
                        <div class="detail-label"><i class="fas fa-tags"></i> Loại hình vay:</div>
                        <div class="detail-value">Vay tín chấp hoặc thế chấp</div>
                    </div>
                    <div class="package-detail">
                        <div class="detail-label"><i class="fas fa-percentage"></i> Lãi suất:</div>
                        <div class="detail-value">9.5% - 12.0% / năm</div>
                    </div>
                    <div class="package-detail">
                        <div class="detail-label"><i class="fas fa-calendar-alt"></i> Thời hạn vay:</div>
                        <div class="detail-value">Tối đa 8 năm</div>
                    </div>
                    <div class="package-detail">
                        <div class="detail-label"><i class="fas fa-hourglass-half"></i> Thời gian ân hạn:</div>
                        <div class="detail-value">Bằng thời gian học tập</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="action-container fade-in">
            <a href="huongdannop.php" class="btn-primary">XEM KẾT QUẢ SƠ BỘ & HƯỚNG DẪN NỘP HỒ SƠ <i class="fas fa-file-upload"></i></a>
            <br><br>
            <a href="../hocbongtrangnhung/xem_von_vay.php" class="btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</a>
        </div>
    </div>

    <script>
        // Hàm tạo dữ liệu ngẫu nhiên cho biểu đồ
        function generateRandomData(min, max, count) {
            const data = [];
            for (let i = 0; i < count; i++) {
                data.push(Math.floor(Math.random() * (max - min + 1)) + min);
            }
            return data;
        }

        // Hàm tạo màu gradient cho biểu đồ
        function createGradient(ctx, colors) {
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, colors[0]);
            gradient.addColorStop(1, colors[1]);
            return gradient;
        }

        // Khởi tạo biểu đồ điểm tín dụng
        const creditScoreCtx = document.getElementById('creditScoreChart').getContext('2d');
        const creditScoreGradient = createGradient(creditScoreCtx, ['rgba(69, 104, 220, 0.8)', 'rgba(59, 89, 152, 0.2)']);
        
        new Chart(creditScoreCtx, {
            type: 'line',
            data: {
                labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
                datasets: [{
                    label: 'Điểm tín dụng',
                    data: [710, 730, 745, 760, 770, 780],
                    borderColor: 'rgba(69, 104, 220, 1)',
                    backgroundColor: creditScoreGradient,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#4568dc',
                    pointBorderColor: '#fff',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(69, 104, 220, 0.9)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        padding: 12,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        min: 650,
                        max: 850,
                        ticks: {
                            font: {
                                size: 10
                            }
                        },
                        grid: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 10
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Khởi tạo biểu đồ tiềm năng ngành học
        const fieldPotentialCtx = document.getElementById('fieldPotentialChart').getContext('2d');
        const fieldPotentialGradient = createGradient(fieldPotentialCtx, ['rgba(17, 153, 142, 0.8)', 'rgba(56, 239, 125, 0.2)']);
        
        new Chart(fieldPotentialCtx, {
            type: 'bar',
            data: {
                labels: ['Y1', 'Y2', 'Y3', 'Y4', 'Y5'],
                datasets: [{
                    label: 'Tỷ lệ việc làm',
                    data: [70, 76, 80, 83, 85],
                    backgroundColor: fieldPotentialGradient,
                    borderColor: 'rgba(17, 153, 142, 1)',
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(17, 153, 142, 0.9)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        padding: 12,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        min: 50,
                        max: 100,
                        ticks: {
                            font: {
                                size: 10
                            },
                            callback: function(value) {
                                return value + '%';
                            }
                        },
                        grid: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 10
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Khởi tạo biểu đồ tiềm năng xét duyệt
        const approvalPotentialCtx = document.getElementById('approvalPotentialChart').getContext('2d');
        const approvalPotentialGradient = createGradient(approvalPotentialCtx, ['rgba(106, 17, 203, 0.8)', 'rgba(37, 117, 252, 0.2)']);
        
        new Chart(approvalPotentialCtx, {
            type: 'line',
            data: {
                labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
                datasets: [{
                    label: 'Tỷ lệ xét duyệt',
                    data: [65, 70, 75, 78, 80, 82, 84, 86, 87, 88, 89, 90],
                    borderColor: 'rgba(106, 17, 203, 1)',
                    backgroundColor: approvalPotentialGradient,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#6a11cb',
                    pointBorderColor: '#fff',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(106, 17, 203, 0.9)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        padding: 12,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        min: 50,
                        max: 100,
                        ticks: {
                            font: {
                                size: 11
                            },
                            callback: function(value) {
                                return value + '%';
                            }
                        },
                        grid: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 11
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Thêm hiệu ứng cuộn mượt cho nút bấm
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Thêm hiệu ứng xuất hiện cho các phần tử khi cuộn trang
        const fadeElements = document.querySelectorAll('.fade-in');
        
        function checkFade() {
            fadeElements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < window.innerHeight - elementVisible) {
                    element.style.opacity = "1";
                    element.style.transform = "translateY(0)";
                }
            });
        }

        window.addEventListener('scroll', checkFade);
        window.addEventListener('load', checkFade);
    </script>
</body>
</html>