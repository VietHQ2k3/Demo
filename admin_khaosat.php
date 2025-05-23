<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách khảo sát</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .scrollable-table {
            overflow-x: auto;
            cursor: grab;
        }

        .scrollable-table:active {
            cursor: grabbing;
        }
    </style>

    </style>
</head>

<body class="bg-light">
    <div class="container mt-4">
        <h2 class="mb-4">Danh sách khảo sát học bổng</h2>
        <div class="table-responsive scrollable-table">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Điện thoại</th>
                        <th>Thời gian tạo</th>
                        <th>Thu điền form</th>
                        <th>Quá trình điền form</th>
                        <th>Giao diện dễ dùng</th>
                        <th>Tìm được thông tin</th>
                        <th>Một số phần thiếu</th>
                        <th>Bị lạc/lung tung</th>
                        <th>Không tìm được</th>
                        <th>Dự định sử dụng</th>
                        <th>Góp ý cải thiện</th>
                        <th>Gói Access Companion</th>
                        <th>Trả tiền gói Access</th>
                        <th>Gói hỗ trợ học bổng</th>
                        <th>Gói hỗ trợ giá hợp lý</th>
                        <th>Gói Premium Scholarship</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM khao_sat ORDER BY thoi_gian_tao DESC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0):
                        while ($row = $result->fetch_assoc()):
                    ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= htmlspecialchars($row['ho_ten']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['dien_thoai']) ?></td>
                                <td><?= $row['thoi_gian_tao'] ?></td>
                                <td><?= htmlspecialchars($row['thu_dien_form']) ?></td>
                                <td><?= htmlspecialchars($row['qua_trinh_dien_form']) ?></td>
                                <td><?= $row['giao_dien_de_dung'] ? "Có" : "Không" ?></td>
                                <td><?= $row['tim_duoc_thong_tin'] ? "Có" : "Không" ?></td>
                                <td><?= $row['mot_so_phan_thieu'] ? "Có" : "Không" ?></td>
                                <td><?= $row['bi_lac_lung_tung'] ? "Có" : "Không" ?></td>
                                <td><?= $row['khong_tim_duoc'] ? "Có" : "Không" ?></td>
                                <td><?= htmlspecialchars($row['du_dinh_su_dung']) ?></td>
                                <td><?= nl2br(htmlspecialchars($row['gop_y_cai_thien'])) ?></td>
                                <td><?= htmlspecialchars($row['goi_access_companion']) ?></td>
                                <td><?= htmlspecialchars($row['goi_access_san_sang_tra']) ?></td>
                                <td><?= htmlspecialchars($row['goi_scholarship_support']) ?></td>
                                <td><?= htmlspecialchars($row['goi_support_gia_hop_ly']) ?></td>
                                <td><?= htmlspecialchars($row['goi_scholarship_premium']) ?></td>
                            </tr>
                    <?php
                        endwhile;
                    else:
                        echo "<tr><td colspan='19' class='text-center'>Không có dữ liệu</td></tr>";
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

<script>
    const scrollContainer = document.querySelector(".scrollable-table");

    let isDown = false;
    let startX;
    let scrollLeft;

    scrollContainer.addEventListener("mousedown", (e) => {
        isDown = true;
        scrollContainer.classList.add("active");
        startX = e.pageX - scrollContainer.offsetLeft;
        scrollLeft = scrollContainer.scrollLeft;
    });

    scrollContainer.addEventListener("mouseleave", () => {
        isDown = false;
        scrollContainer.classList.remove("active");
    });

    scrollContainer.addEventListener("mouseup", () => {
        isDown = false;
        scrollContainer.classList.remove("active");
    });

    scrollContainer.addEventListener("mousemove", (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - scrollContainer.offsetLeft;
        const walk = (x - startX) * 1; // tốc độ kéo
        scrollContainer.scrollLeft = scrollLeft - walk;
    });
</script>


</html>