<?php
session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin.php');
    exit;
}

require_once 'config.php';

// Lấy thông tin thống kê
// 1. Tổng số người dùng
$query_users = "SELECT COUNT(*) as total_users FROM nguoi_dung";
$result_users = $conn->query($query_users);
$total_users = $result_users->fetch_assoc()['total_users'];

// 2. Tổng số hồ sơ vay
$query_loans = "SELECT COUNT(*) as total_loans FROM ho_so_vay";
$result_loans = $conn->query($query_loans);
$total_loans = $result_loans->fetch_assoc()['total_loans'];

// 3. Số lượng hồ sơ vay đủ điều kiện
$query_eligible = "SELECT COUNT(*) as eligible_loans FROM ho_so_vay WHERE eligibility = 'eligible'";
$result_eligible = $conn->query($query_eligible);
$eligible_loans = $result_eligible->fetch_assoc()['eligible_loans'];

// 4. Phân bố người dùng theo quốc gia
$query_countries = "SELECT h.country as ten_quoc_gia, COUNT(h.id) as count 
                    FROM ho_so_vay h
                    GROUP BY h.country
                    ORDER BY count DESC";
$result_countries = $conn->query($query_countries);
$countries_data = [];
while ($row = $result_countries->fetch_assoc()) {
    $countries_data[] = $row;
}

// 5. Thống kê khảo sát
$query_survey = "SELECT thu_dien_form, COUNT(*) as count FROM khao_sat GROUP BY thu_dien_form";
$result_survey = $conn->query($query_survey);
$survey_data = [];
while ($row = $result_survey->fetch_assoc()) {
    $survey_data[] = $row;
}

// 6. Thống kê mức độ hài lòng giao diện
$query_satisfaction = "SELECT 
                    SUM(giao_dien_de_dung) as easy_ui,
                    SUM(tim_duoc_thong_tin) as found_info,
                    SUM(mot_so_phan_thieu) as missing_parts,
                    SUM(bi_lac_lung_tung) as confused,
                    SUM(khong_tim_duoc) as not_found
                    FROM khao_sat";
$result_satisfaction = $conn->query($query_satisfaction);
$satisfaction_data = $result_satisfaction->fetch_assoc();

// 7. Thống kê dự định sử dụng
$query_intention = "SELECT du_dinh_su_dung, COUNT(*) as count FROM khao_sat GROUP BY du_dinh_su_dung";
$result_intention = $conn->query($query_intention);
$intention_data = [];
while ($row = $result_intention->fetch_assoc()) {
    $intention_data[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng điều khiển Quản trị</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background-color: #4e73df;
            width: 250px;
        }
        .sidebar-heading {
            padding: 0.875rem 1.25rem;
            font-size: 1.2rem;
            color: white;
        }
        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 600;
            padding: 0.75rem 1rem;
            border-radius: 0;
        }
        .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.2);
        }
        .main-content {
            margin-left: 250px;
            padding: 2rem;
        }
        .card {
            border: none;
            border-radius: 5px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            font-weight: bold;
            color: #4e73df;
        }
        .stat-card {
            border-left: 4px solid;
        }
        .card-users {
            border-left-color: #4e73df;
        }
        .card-loans {
            border-left-color: #1cc88a;
        }
        .card-eligible {
            border-left-color: #f6c23e;
        }
        .card-survey {
            border-left-color: #36b9cc;
        }
        .navbar {
            padding: 0.5rem 1rem;
            background-color: white;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        .dropdown-menu-right {
            right: 0;
            left: auto;
        }
        .chart-container {
            height: 300px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-heading">Quản trị hệ thống</div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="admin_dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Tổng quan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Người dùng</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>Hồ sơ vay</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-university"></i>
                    <span>Ngân hàng & Gói vay</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-chart-bar"></i>
                    <span>Khảo sát</span>
                </a>
            </li>
        </ul>
    </div>

    <nav class="navbar sticky-top">
        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center w-100">
                <h4 class="m-0">Tổng quan</h4>
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="me-2"><i class="fas fa-user"></i></span>
                        <?php echo htmlspecialchars($_SESSION['admin_fullname']); ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw me-2"></i> Thông tin cá nhân</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cogs fa-sm fa-fw me-2"></i> Cài đặt</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2"></i> Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="main-content">
        <!-- Thẻ thống kê -->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card card-users h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Người dùng</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_users; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card card-loans h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Hồ sơ vay</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_loans; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card card-eligible h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Hồ sơ đủ điều kiện</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $eligible_loans; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card card-survey h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Khảo sát</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo count($survey_data); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-1"></i>
                        Phân bố hồ sơ theo quốc gia
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="countriesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Thống kê khảo sát
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="surveyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-line me-1"></i>
                        Đánh giá giao diện người dùng
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="satisfactionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Dự định sử dụng dịch vụ
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="intentionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Chart.js - Biểu đồ quốc gia
        const countriesCtx = document.getElementById('countriesChart').getContext('2d');
        const countriesChart = new Chart(countriesCtx, {
            type: 'pie',
            data: {
                labels: [<?php echo implode(', ', array_map(function($item) { return "'" . $item['ten_quoc_gia'] . "'"; }, $countries_data)); ?>],
                datasets: [{
                    data: [<?php echo implode(', ', array_map(function($item) { return $item['count']; }, $countries_data)); ?>],
                    backgroundColor: [
                        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                        '#fd7e14', '#6f42c1', '#20c9a6', '#5a5c69', '#858796'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Chart.js - Biểu đồ khảo sát
        const surveyCtx = document.getElementById('surveyChart').getContext('2d');
        const surveyChart = new Chart(surveyCtx, {
            type: 'bar',
            data: {
                labels: [<?php echo implode(', ', array_map(function($item) { return "'" . ($item['thu_dien_form'] ? $item['thu_dien_form'] : 'Không trả lời') . "'"; }, $survey_data)); ?>],
                datasets: [{
                    label: 'Số lượng',
                    data: [<?php echo implode(', ', array_map(function($item) { return $item['count']; }, $survey_data)); ?>],
                    backgroundColor: [
                        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'
                    ]
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Chart.js - Biểu đồ đánh giá giao diện
        const satisfactionCtx = document.getElementById('satisfactionChart').getContext('2d');
        const satisfactionChart = new Chart(satisfactionCtx, {
            type: 'radar',
            data: {
                labels: [
                    'Giao diện dễ dùng',
                    'Tìm được thông tin',
                    'Một số phần thiếu',
                    'Bị lạc/lúng túng',
                    'Không tìm được'
                ],
                datasets: [{
                    label: 'Đánh giá',
                    data: [
                        <?php echo $satisfaction_data['easy_ui']; ?>,
                        <?php echo $satisfaction_data['found_info']; ?>,
                        <?php echo $satisfaction_data['missing_parts']; ?>,
                        <?php echo $satisfaction_data['confused']; ?>,
                        <?php echo $satisfaction_data['not_found']; ?>
                    ],
                    fill: true,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgb(54, 162, 235)',
                    pointBackgroundColor: 'rgb(54, 162, 235)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(54, 162, 235)'
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    r: {
                        angleLines: {
                            display: true
                        },
                        suggestedMin: 0,
                        suggestedMax: 5
                    }
                }
            }
        });

        // Chart.js - Biểu đồ dự định sử dụng
        const intentionCtx = document.getElementById('intentionChart').getContext('2d');
        const intentionChart = new Chart(intentionCtx, {
            type: 'doughnut',
            data: {
                labels: [<?php echo implode(', ', array_map(function($item) { return "'" . ($item['du_dinh_su_dung'] ? $item['du_dinh_su_dung'] : 'Không trả lời') . "'"; }, $intention_data)); ?>],
                datasets: [{
                    data: [<?php echo implode(', ', array_map(function($item) { return $item['count']; }, $intention_data)); ?>],
                    backgroundColor: [
                        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html>