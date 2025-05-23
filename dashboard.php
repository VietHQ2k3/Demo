<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
}


?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeapFi - Bệ phóng tài chính cho hành trình du học</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0b20a0;
            --primary-dark: rgb(69, 121, 233);
            --secondary-color: #ff4757;
            --text-light: #ffffff;
            --text-dark: #333333;
            --bg-light: #f5f5f5;
            --bg-dark: #f0f0f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Header Styles */
        header {
            padding: 15px 0;
            color: var(--text-light);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .logo img {
            height: 100px;
        }

        .contact {
            display: flex;
            align-items: center;
        }

        .contact a {
            color: var(--text-light);
            text-decoration: none;
            margin-left: 15px;
            transition: all 0.3s ease;
        }

        .contact a:hover {
            opacity: 0.8;
        }

        .nav-menu {
            display: flex;
            justify-content: center;
            background-color: rgba(0, 0, 0, 0.48);
            margin-bottom: 220px;
        }

        .nav-menu a {
            color: var(--text-light);
            text-decoration: none;
            padding: 10px 20px;
            font-weight: bold;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-menu a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background-color: var(--text-light);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-menu a:hover::after {
            width: 70%;
        }

        .register-btn {
            background-color: var(--primary-dark);
            color: var(--text-light);
            padding: 8px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .register-btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .social-icons {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
        }

        .social-icons-left {
            display: flex;
            align-items: center;
        }

        .social-icons a {
            margin-right: 15px;
            color: var(--text-light);
            text-decoration: none;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            transform: scale(1.2);
        }

        .website-info {
            margin-left: 20px;
            color: var(--text-light);
        }

        .phone-number {
            color: var(--text-light);
            font-weight: bold;
        }

        /* Hero Section */
        .hero {
            background: url('images/bg.jpg') center center / cover no-repeat;
            color: var(--text-light);
            position: relative;
            overflow: hidden;
        }


        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://via.placeholder.com/1600x800/00c2a8/ffffff?text=') no-repeat center center/cover;
            opacity: 0.1;
        }

        .hero-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-text {
            flex: 1;
            text-align: left;
            padding-right: 50px;
        }

        .hero-text h1 {
            font-size: 42px;
            margin-bottom: 20px;
            color: var(--text-light);
            font-weight: 800;
        }

        .scholarship-btn {
            background-color: #f0f0f0;
            color: #0b20a0;
            /* background-color: var(--secondary-color);
            color: var(--text-light); */
            padding: 15px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-top: 20px;
            font-size: 18px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .scholarship-btn:hover {
            background-color: #e63946;
            transform: translateY(-3px);
        }

        .hero-image {
            flex: 1;
            text-align: center;
            position: relative;
        }

        .hero-image img {
            max-width: 300px;
            height: 300px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .logo-box {
            background-color: var(--primary-dark);
            width: 120px;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            margin-top: 50px;
            margin-left: auto;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .logo-box img {
            width: 80%;
            height: auto;
        }

        /* Main Content */
        .content {
            padding: 70px 0;
        }

        .section-title {
            font-size: 28px;
            color: var(--text-dark);
            text-align: center;
            font-weight: bold;
        }

        .divider {
            width: 150px;
            height: 3px;
            background-color: var(--primary-color);
            margin: 0 auto 50px;
        }

        /* Features Section */
        .features {
            padding: 70px 0;
            background-color: var(--bg-light);
        }

        .features-container {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }

        .feature-box {
            flex: 0 0 calc(33.333% - 30px);
            margin: 15px;
            background-color: var(--text-light);
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .feature-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 40px;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .feature-box h3 {
            font-size: 20px;
            margin-bottom: 15px;
            color: var(--text-dark);
        }

        .feature-box p {
            font-size: 16px;
            color: #666;
        }

        /* Form Section */
        .form-section {
            background: url('images/LH.jpg') center center / cover no-repeat;
            color: var(--text-light);
            position: relative;
            overflow: hidden;
            height: 860px;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background:rgba(255, 255, 255, 0.88);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgb(0, 0, 0);
        }

        .form-heading {
            font-size: 24px;
            margin-bottom: 20px;
            color: var(--text-dark);
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(0, 194, 168, 0.2);
        }

        .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
        }

        .form-submit {
            width: 100%;
            padding: 12px 15px;
            background-color: #e63946;
            color: var(--text-light);
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-submit:hover {
            background-color: var(--primary-dark);
        }

        /* Stats Section */
        .stats {
            padding: 50px 0;
            background-color: var(--bg-dark);
        }

        .stats-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .stat-box {
            text-align: center;
            padding: 20px;
        }

        .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 16px;
            color: var(--text-dark);
        }

        /* Testimonials */
        .testimonials {
            padding: 70px 0;
            background-color: var(--bg-light);
        }

        .testimonial-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .testimonial-box {
            background-color: var(--text-light);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            position: relative;
        }

        .testimonial-box::before {
            content: '"';
            position: absolute;
            top: 10px;
            left: 20px;
            font-size: 60px;
            color: rgba(0, 194, 168, 0.1);
            font-family: Georgia, serif;
        }

        .testimonial-text {
            font-style: italic;
            margin-bottom: 20px;
            padding-left: 40px;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
        }

        .testimonial-author img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .author-info h4 {
            margin-bottom: 5px;
            font-size: 18px;
            color: var(--text-dark);
        }

        .author-info p {
            color: #777;
            font-size: 14px;
        }

        /* Partners */
        .partners {
            padding: 50px 0;
            background-color: var(--text-light);
        }

        .partners-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        .partner-logo {
            margin: 15px 30px;
            opacity: 0.7;
            transition: all 0.3s ease;
        }

        .partner-logo:hover {
            opacity: 1;
        }

        .partner-logo img {
            height: 60px;
            filter: grayscale(100%);
            transition: all 0.3s ease;
        }

        .partner-logo:hover img {
            filter: grayscale(0%);
        }

        /* Footer */
        footer {
            background-color: #333;
            color: var(--text-light);
            padding: 50px 0 20px;
        }

        .footer-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .footer-col {
            flex: 1;
            min-width: 250px;
            margin-bottom: 30px;
            padding: 0 15px;
        }

        .footer-col h3 {
            font-size: 18px;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-col h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background-color: var(--primary-color);
        }

        .footer-contact li {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
        }

        .footer-contact li i {
            margin-right: 10px;
            color: var(--primary-color);
        }

        .footer-links li {
            margin-bottom: 10px;
            list-style: none;
        }

        .footer-links a {
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary-color);
            padding-left: 5px;
        }

        .footer-newsletter p {
            margin-bottom: 20px;
        }

        .newsletter-form {
            display: flex;
        }

        .newsletter-input {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 5px 0 0 5px;
        }

        .newsletter-btn {
            padding: 10px 15px;
            background-color: var(--primary-color);
            color: var(--text-light);
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .newsletter-btn:hover {
            background-color: var(--primary-dark);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            margin-top: 40px;
            border-top: 1px solid #444;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .hero-content {
                flex-direction: column;
                text-align: center;
            }

            .hero-text {
                padding-right: 0;
                margin-bottom: 30px;
            }

            .feature-box {
                flex: 0 0 calc(50% - 30px);
            }

            .country-card {
                flex: 0 0 calc(33.333% - 30px);
            }
        }

        @media (max-width: 768px) {
            .nav-menu {
                flex-wrap: wrap;
            }

            .feature-box {
                flex: 0 0 calc(100% - 30px);
            }

            .country-card {
                flex: 0 0 calc(50% - 30px);
            }

            .footer-col {
                flex: 0 0 calc(50% - 30px);
            }
        }

        @media (max-width: 576px) {
            .country-card {
                flex: 0 0 calc(100% - 30px);
            }

            .footer-col {
                flex: 0 0 calc(100% - 30px);
            }
        }
    </style>
</head>

<body>
    <div class="hero">
        <header>
            <div class="nav-menu">
                <div class="header-top">
                    <div class="logo">
                        <img src="images/logo__2_-removebg-preview.png" alt="LeapFI Education Logo">
                    </div>
                    <div class="contact">
                        <a href="timvonvay.php" class="register-btn">ĐĂNG KÝ</a>
                    </div>
                    <a href="#about">About us</a>
                    <!-- funding -->
                    <a href="#funding">Tìm vốn vay</a>
                    <a href="#scholarship">Học bổng</a>
                    <a href="#community">Cộng đồng</a>
                    <a href="#jobs">Việc làm</a>
                </div>

                <div class="social-icons container">
                    <div class="social-icons-left">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                        <a href=""><i class="fas fa-phone-alt"></i></a>
                    </div>

                </div>
            </div>
        </header>

        <section>
            <div class="container hero-content">
                <div class="hero-text">
                    <h1>LeapFi - Bệ phóng tài chính cho hành trình du học</h1>
                    <a href="timvonvay.php" class="scholarship-btn">VAY VỐN DU HỌC</a>
                    <a href="khaosat.php" class="scholarship-btn">KHẢO SÁT NHANH</a>
                </div>
            </div>
        </section>
    </div>


    <section class="countries">
        <div class="container">
            <h2 class="section-title">ĐIỂM ĐẾN DU HỌC PHỔ BIẾN</h2>
            <div class="divider"></div>
            <div class="countries-container">
                <div class="country-card">
                    <img src="images/my.jpg" alt="USA">
                    <div class="country-info">
                        <h3>Mỹ</h3>
                        <p>Mỹ là điểm đến du học hàng đầu với các trường đại học danh tiếng như Harvard, MIT. Du học sinh được tiếp cận nền giáo dục hiện đại, môi trường nghiên cứu tiên tiến và cơ hội nghề nghiệp rộng mở sau tốt nghiệp.</p>
                    </div>
                </div>
                <div class="country-card">
                    <img src="images/Anh.jpg" alt="UK">
                    <div class="country-info">
                        <h3>Anh</h3>
                        <p>Vương quốc Anh nổi tiếng với các trường đại học hàng đầu như Oxford, Cambridge. Hệ thống giáo dục được quốc tế công nhận, môi trường học thuật chuyên sâu, cùng cơ hội học bổng hấp dẫn.</p>
                    </div>
                </div>
                <div class="country-card">
                    <img src="images/UC.jpg" alt="Australia">
                    <div class="country-info">
                        <h3>Úc</h3>
                        <p>Úc thu hút du học sinh bởi chất lượng giáo dục cao, khí hậu ôn hòa và xã hội đa văn hóa. Nhiều trường nằm trong top thế giới, chính sách visa và định cư thuận lợi sau khi tốt nghiệp.</p>
                    </div>
                </div>
                <div class="country-card">
                    <img src="images/canad.jpg" alt="Canada">
                    <div class="country-info">
                        <h3>Canada</h3>
                        <p>Canada được biết đến là quốc gia an toàn, thân thiện và có hệ thống giáo dục xuất sắc. Chính phủ hỗ trợ sinh viên quốc tế bằng các chính sách định cư hấp dẫn và môi trường sống chất lượng cao.</p>
                    </div>
                </div>
                <div class="country-card">
                    <img src="images/sing.jpg" alt="Singapore">
                    <div class="country-info">
                        <h3>Singapore</h3>
                        <p>Là trung tâm giáo dục hàng đầu châu Á, Singapore sở hữu hệ thống trường đại học hiện đại, cơ sở vật chất tiên tiến và chương trình học liên kết với các trường danh tiếng thế giới.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <style>
        .countries {
            padding: 40px 0;
            background-color: #f9f9f9;
        }

        .countries .section-title {
            text-align: center;
            font-size: 32px;
            color: #002b45;
            margin-bottom: 10px;
        }

        .divider {
            width: 80px;
            height: 4px;
            background-color: #0d6efd;
            margin: 0 auto 30px;
            border-radius: 2px;
        }

        .countries-container {
            display: flex;
            overflow-x: auto;
            gap: 20px;
            padding: 0 20px;
            scroll-snap-type: x mandatory;
        }

        .country-card {
            position: relative;
            min-width: 250px;
            height: 300px;
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0;
            scroll-snap-align: start;
            cursor: pointer;
        }

        .country-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.3s ease;
        }

        .country-info {
            position: absolute;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            width: 100%;
            padding: 15px;
            transition: transform 0.3s ease;
            transform: translateY(100%);
        }

        .country-card:hover .country-info {
            transform: translateY(0);
        }

        .country-info h3 {
            margin: 0;
            font-size: 20px;
        }

        .country-info p {
            margin-top: 5px;
            font-size: 14px;
        }
    </style>

    <section class="features" id="about">
        <div class="container">
            <h2 class="section-title">TẠI SAO CHỌN LeapFI EDUCATION?</h2>
            <div class="divider"></div>
            <div class="features-container">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3>Tư Vấn Chuyên Nghiệp</h3>
                    <p>Đội ngũ tư vấn viên giàu kinh nghiệm, được đào tạo bài bản về giáo dục quốc tế và du học.</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-globe-americas"></i>
                    </div>
                    <h3>Đối Tác Toàn Cầu</h3>
                    <p>Hợp tác với hơn 500+ trường đại học và cao đẳng uy tín trên khắp thế giới.</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <h3>Cơ Hội Học Bổng</h3>
                    <p>Tiếp cận hàng nghìn suất học bổng giá trị từ các tổ chức giáo dục quốc tế hàng đầu.</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <h3>Hỗ Trợ Hồ Sơ</h3>
                    <p>Đồng hành từ A-Z trong quá trình chuẩn bị và nộp hồ sơ du học với tỷ lệ thành công cao.</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <h3>Giải Pháp Tài Chính</h3>
                    <p>Tư vấn các phương án tài chính phù hợp, kết nối với các nguồn vốn vay du học ưu đãi.</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Cộng Đồng Hỗ Trợ</h3>
                    <p>Kết nối với cộng đồng du học sinh Việt Nam trên toàn thế giới, chia sẻ kinh nghiệm thực tế.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="stats">
        <div class="container">
            <div class="stats-container">
                <div class="stat-box">
                    <div class="stat-number">15,000+</div>
                    <div class="stat-label">Du học sinh thành công</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Tỷ lệ visa thành công</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Trường đối tác</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">10+</div>
                    <div class="stat-label">Quốc gia du học</div>
                </div>
            </div>
        </div>
    </section>

    <section class="content" id="scholarship">
        <div class="container">
            <h2 class="section-title">ĐĂNG KÝ NHẬN MENTOR HỌC BỔNG 1:1 CÙNG LeapFI EXPERTS</h2>
            <div class="divider"></div>

            <div class="form-container">
                <h3 class="form-heading">Đăng ký tư vấn ngay</h3>
                <form>
                    <div class="form-group">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" class="form-input" placeholder="Nhập họ tên đầy đủ">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-input" placeholder="Nhập số điện thoại">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-input" placeholder="Nhập địa chỉ email">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Quốc gia muốn du học</label>
                        <select class="form-select">
                            <option value="">-- Chọn quốc gia --</option>
                            <option value="us">Mỹ</option>
                            <option value="uk">Anh</option>
                            <option value="au">Úc</option>
                            <option value="ca">Canada</option>
                            <option value="sg">Singapore</option>
                            <option value="sg">Singapore</option>
                            <option value="jp">Nhật Bản</option>
                            <option value="kr">Hàn Quốc</option>
                            <option value="nz">New Zealand</option>
                            <option value="other">Khác</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Bạn quan tâm đến</label>
                        <select class="form-select">
                            <option value="">-- Chọn dịch vụ --</option>
                            <option value="scholarship">Học bổng du học</option>
                            <option value="visa">Tư vấn visa</option>
                            <option value="study">Tư vấn chương trình học</option>
                            <option value="finance">Tài chính du học</option>
                            <option value="other">Khác</option>
                        </select>
                    </div>
                    <button type="submit" class="form-submit">Đăng ký ngay</button>
                </form>
            </div>
        </div>
    </section>

    <section class="testimonials">
        <div class="container">
            <h2 class="section-title">CÂU CHUYỆN THÀNH CÔNG</h2>
            <div class="divider"></div>
            <div class="testimonial-container">
                <div class="testimonial-box">
                    <p class="testimonial-text">
                        "Từ một cậu sinh viên không biết bắt đầu từ đâu, LeapFI đã giúp tôi định hướng và đạt được học bổng toàn phần tại Đại học Harvard. Các mentor tại đây không chỉ hỗ trợ hồ sơ mà còn giúp tôi tự tin hơn trong quá trình phỏng vấn."
                    </p>
                    <div class="testimonial-author">
                        <img src="data:image/jpeg;base64,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" alt="Minh Tuấn">
                        <div class="author-info">
                            <h4>Nguyễn Hữu Huy</h4>
                            <p>Học bổng Harvard University, Mỹ</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-box">
                    <p class="testimonial-text">
                        "Tôi đã thay đổi hướng đi sự nghiệp sau 5 năm làm việc và lo lắng về việc du học ở tuổi 27. LeapFI đã giúp tôi tìm được chương trình phù hợp tại London Business School và hỗ trợ kết nối vốn vay du học với lãi suất ưu đãi."
                    </p>
                    <div class="testimonial-author">
                        <img src="data:image/jpeg;base64,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" alt="Thu Hà">
                        <div class="author-info">
                            <h4>Trần Thu Hà</h4>
                            <p>London Business School, Anh</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="partners">
        <div class="container">
            <h2 class="section-title">ĐỐI TÁC GIÁO DỤC</h2>
            <div class="divider"></div>
            <div class="partners-container">
                <div class="partner-logo">
                    <img src="data:image/jpeg;base64,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" alt="Harvard University">
                </div>
                <div class="partner-logo">
                    <img src="images/oxf.png" alt="Oxford University">
                </div>
                <div class="partner-logo">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAARMAAAC3CAMAAAAGjUrGAAAAaVBMVEX///+jHzSKi4z89/icABSeAB/ixci+dH2hESvr2NqdAByhFi6zV2L37/CcABakITbIjJO+v7+EhYbMzMzv3uDr6+vLk5mfACTWrLCWAACaAAeuRlS5aHLz5+jTpaqbAA3Gh4/lzM98fX4g7gTHAAABz0lEQVR4nO3dwU5TQQCGURAoUBWxolgEW3n/h3R9+43JjYXGyjnrP7P4dm0md05OAAAAAAAAAAAA4Aicjf3F6CWP+tNsln2TXK/PBx5+TFePw9V6MRl9HI42y+lRt+Ojfk5Xi+FqnvX1vk2WpwPvP0xXl1ej1cVOk5vR6PTT9Khv96PR/fedJhfDs2ZZahKalCalSWlSmpQmpUlpUpqUJqVJaVKalCalSWlSmtTxNbm9uRo4322yGa3meTi6Jovt7cD213R1N1zNs306tiZHQJPSpDQpTUqT0qQ0KU1Kk9KkNKmDNzn7OrR7w+tuaN9fd/McvMnn59XA85fparFeDmweX6FAHb7J6t3AarfJ8D+lq8tXKFCalCalSWlSmpQmpUlpUpqUJqVJaVKalCalSWlSmpQmpUlpUpqUJqVJaVKalCalSWlSmpQmpUlpUpqUJqVJaVLzmjxuRtcQd79Z97aaPI2vq04vtb6xJrNoUpqUJqVJaVKalCalSWlSmpQmpUlpUpqUJqVJaVKalCalSWlSmpQmpUlpUpqUJqVJaVKalCalSf0/TWa9NzrLvPdG536zbviS6GG+WTf3ndgDH/WiZwEAAAAAAAAAAMC/6DcAbJjOtbltGAAAAABJRU5ErkJggg==" alt="MIT">
                </div>
                <div class="partner-logo">
                    <img src="data:image/png;base64,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" alt="Stanford">
                </div>
                <div class="partner-logo">
                    <img src="data:image/png;base64,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" alt="Yale">
                </div>
                <div class="partner-logo">
                    <img src="data:image/png;base64,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" alt="NUS">
                </div>
            </div>
        </div>
    </section>

    <section class="features" id="funding">
        <div class="container">
            <h2 class="section-title">GIẢI PHÁP TÀI CHÍNH DU HỌC</h2>
            <div class="divider"></div>
            <div class="features-container">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-university"></i>
                    </div>
                    <h3>Vay Vốn Ngân Hàng</h3>
                    <p>Kết nối với các ngân hàng đối tác có gói vay ưu đãi dành riêng cho du học sinh với lãi suất thấp, thời gian trả nợ linh hoạt.</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3>Học Bổng Toàn Phần</h3>
                    <p>Tư vấn và hỗ trợ chuẩn bị hồ sơ xin học bổng từ các trường đại học và tổ chức giáo dục quốc tế.</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3>Chương Trình Vừa Học Vừa Làm</h3>
                    <p>Giới thiệu các chương trình cho phép sinh viên làm thêm hợp pháp trong quá trình học tập tại nước ngoài.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="content" id="community">
        <div class="container">
            <h2 class="section-title">CỘNG ĐỒNG DU HỌC SINH LeapFI</h2>
            <div class="divider"></div>
            <div style="text-align: center; margin-bottom: 40px;">
                <p style="font-size: 18px; margin-bottom: 20px; max-width: 800px; margin-left: auto; margin-right: auto;">
                    Tham gia cộng đồng du học sinh LeapFI để chia sẻ kinh nghiệm, kết nối và nhận hỗ trợ từ cựu du học sinh tại hơn 20 quốc gia trên thế giới.
                </p>
                <a href="#" class="btn facebook-btn d-inline-flex align-items-center px-3 py-2 text-white rounded" style="background-color: #4267B2; font-weight: 600; text-decoration: none;">
                    <i class="fab fa-facebook-f me-2"></i> Tham gia nhóm Facebook
                </a>
                <style>
                    .facebook-btn:hover {
                        background-color: #365899;
                        text-decoration: none;
                        color: white;
                        box-shadow: 0 4px 8px rgba(66, 103, 178, 0.4);
                        transition: background-color 0.3s ease, box-shadow 0.3s ease;
                    }
                </style>
            </div>
            <!-- Gallery -->
            <div style="display: flex; gap: 10px; justify-content: center; align-items: center;">
                <img src="images/duh1.webp" alt="" style="width: 250px; height: 180px; object-fit: cover;">
                <img src="images/duh2.jpg" alt="" style="width: 250px; height: 180px; object-fit: cover;">
                <img src="images/duh3.jpg" alt="" style="width: 250px; height: 180px; object-fit: cover;">
                <img src="images/duh4.jpg" alt="" style="width: 250px; height: 180px; object-fit: cover;">
            </div>

        </div>
    </section>

    <section class="features" id="jobs">
        <div class="container">
            <h2 class="section-title">CƠ HỘI VIỆC LÀM SAU TỐT NGHIỆP</h2>
            <div class="divider"></div>
            <div class="features-container">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h3>Kết Nối Doanh Nghiệp</h3>
                    <p>LeapFI hợp tác với mạng lưới doanh nghiệp quốc tế, hỗ trợ sinh viên tìm kiếm cơ hội thực tập và việc làm sau khi tốt nghiệp.</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3>Hỗ Trợ Hồ Sơ Việc Làm</h3>
                    <p>Tư vấn chuẩn bị CV, cover letter chuẩn quốc tế và kỹ năng phỏng vấn để tăng cơ hội nhận được việc làm mong muốn.</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-plane-departure"></i>
                    </div>
                    <h3>Visa Làm Việc</h3>
                    <p>Tư vấn các chương trình visa làm việc sau tốt nghiệp và hướng dẫn thủ tục chuyển đổi visa du học sang visa làm việc.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="form-section">
        <div class="container">
            <h2 class="section-title" style="color: black;">ĐĂNG KÝ TƯ VẤN</h2>
            <div style="background-color: black; width: 100px; height: 3px; margin: 0 auto 50px;"></div>
            <div class="form-container">
                <h3 class="form-heading">Liên hệ với chúng tôi</h3>
                <form>
                    <div class="form-group">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" class="form-input" placeholder="Nhập họ tên đầy đủ">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-input" placeholder="Nhập số điện thoại">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-input" placeholder="Nhập địa chỉ email">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nội dung</label>
                        <textarea class="form-input" rows="5" placeholder="Nhập nội dung cần tư vấn"></textarea>
                    </div>
                    <button type="submit" class="form-submit">Gửi yêu cầu</button>
                </form>
            </div>
        </div>
    </section>

    <footer>
        <div class="container footer-container">
            <div class="footer-col">
                <h3>Về LeapFI Education</h3>
                <p>LeapFI Education là đơn vị tư vấn du học hàng đầu tại Việt Nam với hơn 10 năm kinh nghiệm, đã giúp hàng nghìn học sinh, sinh viên thực hiện ước mơ du học tại các quốc gia hàng đầu thế giới.</p>
            </div>
            <div class="footer-col">
                <h3>Liên hệ</h3>
                <ul class="footer-contact">
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Tầng 8, Tòa nhà ABC, 123 Đường XYZ, Quận 1, TP. Hồ Chí Minh</span>
                    </li>
                    <li>
                        <i class="fas fa-phone-alt"></i>
                        <span>1800.55.88.48</span>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <span>info@LeapFI.education</span>
                    </li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Dịch vụ</h3>
                <ul class="footer-links">
                    <li><a href="#">Tư vấn du học</a></li>
                    <li><a href="#">Học bổng du học</a></li>
                    <li><a href="#">Tìm vốn vay du học</a></li>
                    <li><a href="#">Hướng nghiệp sau du học</a></li>
                    <li><a href="#">Visa du học</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Nhận tin tức mới</h3>
                <p>Đăng ký để nhận thông tin về học bổng và sự kiện du học mới nhất</p>
                <div class="newsletter-form">
                    <input type="email" class="newsletter-input" placeholder="Email của bạn">
                    <button class="newsletter-btn"><i class="fas fa-paper-plane"></i></button>
                </div>
                <div style="margin-top: 20px;">
                    <a href="#" style="color: white; margin-right: 15px;"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" style="color: white; margin-right: 15px;"><i class="fab fa-instagram"></i></a>
                    <a href="#" style="color: white; margin-right: 15px;"><i class="fab fa-youtube"></i></a>
                    <a href="#" style="color: white;"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom container">
            <p>&copy; <?php echo date('Y'); ?> LeapFI Education. Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>

    <script>
        // Add smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add active class to current nav item
        const navLinks = document.querySelectorAll('.nav-menu a');
        const sections = document.querySelectorAll('section[id]');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= sectionTop - 200) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href').substring(1) === current) {
                    link.classList.add('active');
                }
            });
        });

        // Testimonial Slider (can be expanded with actual slider functionality)
        // This is a placeholder for adding a slider if needed
        const testimonials = document.querySelectorAll('.testimonial-box');
        let currentTestimonial = 0;

        // Counter animation
        function animateCounter(el, start, end, duration) {
            let startTime = null;

            function animation(currentTime) {
                if (!startTime) startTime = currentTime;
                const timeElapsed = currentTime - startTime;
                const progress = Math.min(timeElapsed / duration, 1);
                const value = Math.floor(progress * (end - start) + start);

                el.innerHTML = value + (el.dataset.suffix || '');

                if (progress < 1) {
                    requestAnimationFrame(animation);
                } else {
                    el.innerHTML = new Intl.NumberFormat().format(end) + (el.dataset.suffix || '');
                }
            }

            requestAnimationFrame(animation);
        }

        // Intersection Observer for stat counters
        const counters = document.querySelectorAll('.stat-number');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    const end = parseInt(target.textContent.replace(/[^0-9]/g, ''));
                    animateCounter(target, 0, end, 2000);
                    observer.unobserve(target);
                }
            });
        }, {
            threshold: 0.5
        });

        counters.forEach(counter => {
            observer.observe(counter);
        });
    </script>
</body>

</html>