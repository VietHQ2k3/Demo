<?php
// caithien.php - Loan application improvement page
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ sơ cần cải thiện</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }
        
        html, body {
            height: 100%;
            margin: 0;
            background: linear-gradient(140deg, #0a2463 0%, #1e3a8a 50%, #3454d1 100%);
            color: white;
            overflow-x: hidden;
        }
        
        .container {
            min-height: 100vh;
            width: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .header {
            padding: 30px 0;
            text-align: center;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 1px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            margin-bottom: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }
        
        .assessment {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            margin: 0 5% 40px;
            padding: 30px;
            border-radius: 16px;
            position: relative;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.18);
            max-width: 1200px;
            align-self: center;
            width: 90%;
        }
        
        .assessment-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            background-color: #4f7bf4;
            border-radius: 50%;
            color: white;
            margin-right: 15px;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        
        .assessment-text {
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            font-size: 16px;
            line-height: 1.5;
            font-weight: 500;
        }
        
        .card-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin: 0 5%;
            gap: 30px;
            max-width: 1400px;
            align-self: center;
            width: 90%;
        }
        
        .card {
            background: white;
            color: #333;
            border-radius: 16px;
            padding: 30px;
            flex: 1 1 300px;
            position: relative;
            min-height: 220px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
        }
        
        .card-title {
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 20px;
            color: #1e3a8a;
            position: relative;
            padding-bottom: 10px;
        }
        
        .card-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: #4f7bf4;
            border-radius: 3px;
        }
        
        .card-content {
            margin-bottom: 15px;
            font-size: 15px;
            line-height: 1.6;
            flex-grow: 1;
            color: #555;
        }
        
        .circle-arrow {
            position: absolute;
            right: 20px;
            bottom: 20px;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #ff7e1d 0%, #ff5c00 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 20px;
            box-shadow: 0 4px 10px rgba(255, 94, 0, 0.3);
            transition: transform 0.2s ease;
            cursor: pointer;
        }
        
        .circle-arrow:hover {
            transform: scale(1.1);
        }
        
        .button-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 50px 20px 40px;
            flex-wrap: wrap;
        }
        
        .improvement-button {
            background: linear-gradient(135deg, #ff7e1d 0%, #ff5c00 100%);
            color: white;
            border-radius: 30px;
            padding: 15px 30px;
            text-align: center;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(255, 94, 0, 0.3);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            display: flex;
            align-items: center;
            min-width: 220px;
            justify-content: center;
        }
        
        .improvement-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 94, 0, 0.4);
        }
        
        .improvement-button:active {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(255, 94, 0, 0.3);
        }
        
        .assistant-image {
            position: absolute;
            right: 30px;
            top: -20px;
            width: 100px;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.2));
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .star-effect {
            position: absolute;
            right: 25px;
            top: -40px;
            font-size: 30px;
            color: #FFD700;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
            animation: twinkle 2s ease-in-out infinite;
        }
        
        @keyframes twinkle {
            0% { opacity: 0.7; }
            50% { opacity: 1; }
            100% { opacity: 0.7; }
        }
        
        .button-arrow {
            margin-left: 8px;
        }
        
        @media (max-width: 768px) {
            .assessment {
                margin: 0 15px 30px;
                padding: 20px;
                width: auto;
            }
            
            .card-container {
                margin: 0 15px;
                width: auto;
            }
            
            .button-container {
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }
            
            .header {
                font-size: 24px;
                padding: 20px 0;
            }
            
            .assistant-image {
                width: 80px;
                right: 15px;
                top: -15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            HỒ SƠ CẦN CẢI THIỆN
        </div>
        
        <div class="assessment">
            <div class="assessment-text">
                <span class="assessment-icon">✓</span>
                Hệ thống AI của LeapFi nhận thấy hồ sơ của bạn chưa đáp ứng đủ điều kiện xét duyệt sơ bộ
            </div>
            <div class="assessment-text">
                <span class="assessment-icon">✓</span>
                Dưới đây là những gợi ý giúp bạn tối ưu hồ sơ!
            </div>
            <div class="assistant-image">
                <div class="star-effect">✦✦✦</div>
                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iODAiIGhlaWdodD0iMTIwIiB2aWV3Qm94PSIwIDAgODAgMTIwIiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXRoIGQ9Ik00MCw4MEMzMCw4MCAyMCw3NSAyMCw2MEM1MCw2MCA2MCw2MCA0MCw4MFoiIGZpbGw9IiNmZmY3ZTUiPjwvcGF0aD48cGF0aCBkPSJNNDksNjBDNTYsNjAgNjAsNjUgNTksNzJDNDUsNzIgNDUsNjAgNDksNjBaIiBmaWxsPSIjZmZmN2U1Ij48L3BhdGg+PHBhdGggZD0iTTMwLDYwQzI0LDYwIDIwLDY1IDIxLDcyQzM1LDcyIDM1LDYwIDMwLDYwWiIgZmlsbD0iI2ZmZjdlNSI+PC9wYXRoPjxwYXRoIGQ9Ik00MCw1MEM1Miw1MCA2MCw2MCA2MCw3MEM2MCw4NSA1MCw5MCA0MCw5MEM0MCw5MCA0MCw1MCA0MCw1MFoiIGZpbGw9IiMwMDdiZmYiPjwvcGF0aD48cGF0aCBkPSJNNDAsNTBDMjgsNTAgMjAsNjAgMjAsNzBDMjAsODUgMzAsOTAgNDAsOTBDNDAsOTAgNDAsNTAgNDAsNTBaIiBmaWxsPSIjMDA3YmZmIj48L3BhdGg+PGNpcmNsZSBjeD0iNDAiIGN5PSI0MCIgcj0iMjAiIGZpbGw9IiNmZmY3ZTUiPjwvY2lyY2xlPjxjaXJjbGUgY3g9IjMwIiBjeT0iMzUiIHI9IjUiIGZpbGw9IiMwMDAiPjwvY2lyY2xlPjxjaXJjbGUgY3g9IjUwIiBjeT0iMzUiIHI9IjUiIGZpbGw9IiMwMDAiPjwvY2lyY2xlPjxwYXRoIGQ9Ik0zMCw0NUM0MCw1MiA1MCw0NSA1MCw0NUMzNSw2MCAzMCw0NSAzMCw0NVoiIGZpbGw9IiNmZjc5NzkiPjwvcGF0aD48cGF0aCBkPSJNMTUsMTEwQzE4LDk4IDMwLDk1IDQwLDk1QzUwLDk1IDYyLDk4IDY1LDExMEM2OCwxMjIgMTIsIDEyMiAxNSwxMTBaIiBmaWxsPSIjMDA3YmZmIj48L3BhdGg+PC9zdmc+" alt="Assistant" width="100">
            </div>
        </div>

        <div class="card-container">
            <div class="card">
                <div class="card-title">Thu nhập người bảo lãnh</div>
                <div class="card-content">
                    Hiện tại, mức thu nhập của người bảo lãnh chưa đáp ứng yêu cầu tối thiểu. Hãy bổ sung thông tin hoặc cân nhắc đổi người bảo lãnh phù hợp hơn.
                </div>
                <div class="circle-arrow">➜</div>
            </div>
            
            <div class="card">
                <div class="card-title">Khoản vay mong muốn</div>
                <div class="card-content">
                    Số tiền vay yêu cầu đang cao hơn mức cho phép theo tình trạng tài chính hiện tại. Hãy cân nhắc giảm khoản vay hoặc tăng nguồn tài chính đảm bảo.
                </div>
                <div class="circle-arrow">➜</div>
            </div>
            
            <div class="card">
                <div class="card-title">Chứng minh tài chính</div>
                <div class="card-content">
                    Chưa cung cấp đủ giấy tờ chứng minh tài chính. Vui lòng thêm sổ tiết kiệm hoặc giấy tờ xác nhận tài sản khác.
                </div>
                <div class="circle-arrow">➜</div>
            </div>
        </div>

        <div class="button-container">
            <a href="#" class="improvement-button">CẢI THIỆN HỒ SƠ <span class="button-arrow">➜</span></a>
            <a href="#" class="improvement-button">HƯỚNG DẪN CHI TIẾT <span class="button-arrow">➜</span></a>
        </div>
    </div>
</body>
</html>