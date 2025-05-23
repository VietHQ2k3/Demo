<?php
// Thư mục chứa tất cả các hồ sơ người dùng
$upload_dir = 'uploads/';

// Kiểm tra nếu thư mục tồn tại
if (!is_dir($upload_dir)) {
    die("Chưa có hồ sơ nào được nộp.");
}

// Quét tất cả thư mục con (mỗi thư mục là 1 hồ sơ)
$hoso_folders = array_filter(glob($upload_dir . 'hoso_*'), 'is_dir');
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Hồ sơ Vay vốn</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h2 { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f5f5f5; }
        a.download-link { color: #007bff; text-decoration: none; }
        a.download-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h2>📂 Danh sách Hồ sơ Vay vốn đã nộp</h2>

    <?php if (empty($hoso_folders)): ?>
        <p>Chưa có hồ sơ nào.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên Hồ sơ</th>
                    <th>Thời gian nộp</th>
                    <th>Tải ZIP</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hoso_folders as $index => $folder): 
                    $folder_name = basename($folder);
                    $zip_path = $folder . '/hoso.zip';
                    $date_str = str_replace('hoso_', '', $folder_name);
                    $formatted_date = DateTime::createFromFormat('Ymd_His', $date_str);
                ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($folder_name) ?></td>
                    <td><?= $formatted_date ? $formatted_date->format('d/m/Y H:i:s') : '-' ?></td>
                    <td>
                        <?php if (file_exists($zip_path)): ?>
                            <a class="download-link" href="<?= $zip_path ?>" download>📥 Tải hồ sơ</a>
                        <?php else: ?>
                            <span style="color: red;">Chưa có file ZIP</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
