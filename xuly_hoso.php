<?php
// Tạo thư mục lưu hồ sơ nếu chưa tồn tại
$upload_dir = 'uploads/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Tạo thư mục con cho từng người dùng theo timestamp
$user_folder = $upload_dir . 'hoso_' . date('Ymd_His') . '/';
mkdir($user_folder, 0777, true);

// Các trường input name cần xử lý
$file_fields = [
    'giay_de_nghi',
    'chung_minh_muc_dich',
    'chung_minh_nhan_than',
    'tai_san_the_chap',
    'chung_minh_thu_nhap',
    'chu_ky_so'
];

foreach ($file_fields as $field) {
    if (isset($_FILES[$field])) {
        // Nếu là nhiều file
        if (is_array($_FILES[$field]['name'])) {
            foreach ($_FILES[$field]['name'] as $index => $filename) {
                if ($_FILES[$field]['error'][$index] === UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES[$field]['tmp_name'][$index];
                    $destination = $user_folder . $field . '_' . basename($filename);
                    move_uploaded_file($tmp_name, $destination);
                }
            }
        } else {
            if ($_FILES[$field]['error'] === UPLOAD_ERR_OK) {
                $tmp_name = $_FILES[$field]['tmp_name'];
                $destination = $user_folder . $field . '_' . basename($_FILES[$field]['name']);
                move_uploaded_file($tmp_name, $destination);
            }
        }
    }
}

// Nén thư mục thành file ZIP
$zip_name = $user_folder . 'hoso.zip';
$zip = new ZipArchive();
if ($zip->open($zip_name, ZipArchive::CREATE) === TRUE) {
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($user_folder),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $name => $file) {
        if (!$file->isDir() && $file != $zip_name) {
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($user_folder));
            $zip->addFile($filePath, $relativePath);
        }
    }
    $zip->close();
}

// Tạo trang xác nhận
echo "<h2>Hồ sơ đã được nộp thành công!</h2>";
echo "<p>Bạn có thể quay lại trang trước hoặc đóng trình duyệt.</p>";

?>
