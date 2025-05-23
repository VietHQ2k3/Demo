<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nộp hồ sơ chính thức - LeapFi</title>
    <style>
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
            width: 100%;
            min-height: 100vh;
            position: relative;
        }

        .header {
            background: linear-gradient(135deg, #1a237e, #0d47a1);
            color: white;
            padding: 30px 20px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .header-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .header-subtitle {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .content-container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 0 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }

        .document-uploader {
            flex: 1 1 600px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .status-tracker {
            flex: 1 1 300px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .section-header {
            background-color: #1a237e;
            color: white;
            padding: 15px 20px;
            font-size: 18px;
            font-weight: 600;
        }

        .section-content {
            padding: 20px;
        }

        .upload-section {
            margin-bottom: 25px;
            border-bottom: 1px solid #eee;
            padding-bottom: 25px;
        }

        .upload-section:last-child {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
        }

        .upload-label {
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
            display: block;
        }

        .upload-description {
            margin-bottom: 15px;
            font-size: 14px;
            color: #666;
        }

        .file-upload-container {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .file-input-container {
            position: relative;
            width: 100%;
        }

        .file-input {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
            z-index: 2;
        }

        .file-input-label {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            border: 2px dashed #3f51b5;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            background-color: #f5f7fa;
        }

        .file-input-label:hover {
            background-color: #e8eaf6;
        }

        .file-input-icon {
            font-size: 24px;
            color: #3f51b5;
        }

        .file-input-text {
            flex: 1;
            color: #555;
        }

        .upload-button {
            padding: 8px 15px;
            background-color: #3f51b5;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .upload-button:hover {
            background-color: #303f9f;
        }

        .file-list {
            margin-top: 15px;
        }

        .file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #f5f7fa;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 8px;
        }

        .file-name {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding-right: 10px;
        }

        .file-actions {
            display: flex;
            gap: 10px;
        }

        .file-delete {
            color: #f44336;
            cursor: pointer;
            font-size: 18px;
        }

        .submit-container {
            margin-top: 30px;
            text-align: center;
        }

        .submit-button {
            background-color: #ff7043;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(255, 112, 67, 0.3);
        }

        .submit-button:hover {
            background-color: #f4511e;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 112, 67, 0.4);
        }

        .status-timeline {
            position: relative;
            padding-left: 30px;
            margin-top: 20px;
        }

        .status-line {
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #e0e0e0;
            z-index: 1;
        }

        .status-item {
            position: relative;
            padding-bottom: 25px;
        }

        .status-item:last-child {
            padding-bottom: 0;
        }

        .status-marker {
            position: absolute;
            left: -30px;
            top: 0;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: white;
            border: 2px solid #e0e0e0;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .status-marker.active {
            border-color: #4caf50;
            background-color: #e8f5e9;
        }

        .status-marker.pending {
            border-color: #ff9800;
            background-color: #fff8e1;
        }

        .status-marker.rejected {
            border-color: #f44336;
            background-color: #ffebee;
        }

        .status-icon {
            font-size: 14px;
        }

        .status-text {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .status-date {
            font-size: 12px;
            color: #757575;
            margin-bottom: 8px;
        }

        .status-description {
            font-size: 14px;
            color: #555;
        }

        .status-note {
            font-size: 13px;
            font-style: italic;
            color: #666;
            margin-top: 5px;
            padding-left: 8px;
            border-left: 2px solid #ff9800;
        }

        .advisor-container {
            margin-top: 30px;
            padding: 15px;
            background-color: #e8eaf6;
            border-radius: 8px;
        }

        .advisor-heading {
            font-weight: 600;
            margin-bottom: 10px;
            color: #1a237e;
        }

        .advisor-info {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .advisor-name {
            font-weight: 600;
        }

        .advisor-contact {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .advisor-icon {
            font-size: 16px;
            color: #1a237e;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #1a237e;
            text-decoration: none;
            font-weight: 600;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .content-container {
                flex-direction: column;
            }

            .header-title {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 class="header-title">NỘP HỒ SƠ CHÍNH THỨC</h1>
            <p class="header-subtitle">Vui lòng tải lên các giấy tờ sau đây để hoàn tất quá trình đăng ký vay vốn du học</p>
        </div>

        <div class="content-container">
            <div class="document-uploader">
                <div class="section-header">Tải lên hồ sơ</div>
                <div class="section-content">
                    <form action="xuly_hoso.php" method="post" enctype="multipart/form-data">
                        <!-- Giấy đề nghị vay vốn -->
                        <div class="upload-section">
                            <label class="upload-label">1. Giấy đề nghị vay vốn</label>
                            <p class="upload-description">Giấy đề nghị vay vốn có đầy đủ thông tin và chữ ký của người vay. Bạn có thể tải <a href="mau_giay_de_nghi.pdf" target="_blank">mẫu tại đây</a>.</p>
                            <div class="file-upload-container">
                                <div class="file-input-container">
                                    <input type="file" name="giay_de_nghi" id="giay_de_nghi" class="file-input" accept=".pdf,.doc,.docx,.jpg,.png">
                                    <label for="giay_de_nghi" class="file-input-label">
                                        <span class="file-input-icon">📄</span>
                                        <span class="file-input-text">Chọn tệp tin</span>
                                    </label>
                                </div>
                            </div>
                            <div class="file-list" id="giay_de_nghi_list"></div>
                        </div>

                        <!-- Giấy tờ chứng minh mục đích vay vốn -->
                        <div class="upload-section">
                            <label class="upload-label">2. Giấy tờ chứng minh mục đích vay vốn</label>
                            <p class="upload-description">Thư mời nhập học, xác nhận học phí, chi phí sinh hoạt, và các giấy tờ liên quan khác.</p>
                            <div class="file-upload-container">
                                <div class="file-input-container">
                                    <input type="file" name="chung_minh_muc_dich" id="chung_minh_muc_dich" class="file-input" accept=".pdf,.doc,.docx,.jpg,.png" multiple>
                                    <label for="chung_minh_muc_dich" class="file-input-label">
                                        <span class="file-input-icon">📄</span>
                                        <span class="file-input-text">Chọn tệp tin (có thể chọn nhiều)</span>
                                    </label>
                                </div>
                            </div>
                            <div class="file-list" id="chung_minh_muc_dich_list"></div>
                        </div>

                        <!-- Giấy tờ chứng minh nhân thân -->
                        <div class="upload-section">
                            <label class="upload-label">3. Giấy tờ chứng minh nhân thân</label>
                            <p class="upload-description">CMND/CCCD, hộ khẩu, và các giấy tờ nhân thân của người vay và người đồng trách nhiệm (nếu có).</p>
                            <div class="file-upload-container">
                                <div class="file-input-container">
                                    <input type="file" name="chung_minh_nhan_than" id="chung_minh_nhan_than" class="file-input" accept=".pdf,.doc,.docx,.jpg,.png" multiple>
                                    <label for="chung_minh_nhan_than" class="file-input-label">
                                        <span class="file-input-icon">📄</span>
                                        <span class="file-input-text">Chọn tệp tin (có thể chọn nhiều)</span>
                                    </label>
                                </div>
                            </div>
                            <div class="file-list" id="chung_minh_nhan_than_list"></div>
                        </div>

                        <!-- Giấy tờ chứng minh tài sản thế chấp -->
                        <div class="upload-section">
                            <label class="upload-label">4. Giấy tờ chứng minh tài sản thế chấp</label>
                            <p class="upload-description">Sổ đỏ, sổ hồng, giấy tờ xe, và các giấy tờ liên quan đến tài sản thế chấp (nếu có).</p>
                            <div class="file-upload-container">
                                <div class="file-input-container">
                                    <input type="file" name="tai_san_the_chap" id="tai_san_the_chap" class="file-input" accept=".pdf,.doc,.docx,.jpg,.png" multiple>
                                    <label for="tai_san_the_chap" class="file-input-label">
                                        <span class="file-input-icon">📄</span>
                                        <span class="file-input-text">Chọn tệp tin (có thể chọn nhiều)</span>
                                    </label>
                                </div>
                            </div>
                            <div class="file-list" id="tai_san_the_chap_list"></div>
                        </div>

                        <!-- Hợp đồng lao động/Chứng minh thu nhập -->
                        <div class="upload-section">
                            <label class="upload-label">5. Hợp đồng lao động/Chứng minh thu nhập</label>
                            <p class="upload-description">Hợp đồng lao động, sao kê lương, bảng lương, và các giấy tờ chứng minh thu nhập khác.</p>
                            <div class="file-upload-container">
                                <div class="file-input-container">
                                    <input type="file" name="chung_minh_thu_nhap" id="chung_minh_thu_nhap" class="file-input" accept=".pdf,.doc,.docx,.jpg,.png" multiple>
                                    <label for="chung_minh_thu_nhap" class="file-input-label">
                                        <span class="file-input-icon">📄</span>
                                        <span class="file-input-text">Chọn tệp tin (có thể chọn nhiều)</span>
                                    </label>
                                </div>
                            </div>
                            <div class="file-list" id="chung_minh_thu_nhap_list"></div>
                        </div>

                        <!-- Chữ ký số -->
                        <div class="upload-section">
                            <label class="upload-label">6. Chữ ký số</label>
                            <p class="upload-description">Vui lòng tải lên tệp chữ ký số của bạn (định dạng .pnj hoặc .pdf).</p>
                            <div class="file-upload-container">
                                <div class="file-input-container">
                                    <input type="file" name="chu_ky_so" id="chu_ky_so" class="file-input" accept=".pnj,.pdf">
                                    <label for="chu_ky_so" class="file-input-label">
                                        <span class="file-input-icon">📄</span>
                                        <span class="file-input-text">Chọn tệp tin</span>
                                    </label>
                                </div>
                            </div>
                            <div class="file-list" id="chu_ky_so_list"></div>
                        </div>


                        <div class="submit-container">
                            <button type="submit" class="submit-button">NỘP HỒ SƠ</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="status-tracker">
                <div class="section-header">Trạng thái hồ sơ</div>
                <div class="section-content">
                    <div class="status-timeline">
                        <div class="status-line"></div>

                        <!-- Đã tiếp nhận hồ sơ -->
                        <div class="status-item">
                            <div class="status-marker active">
                                <span class="status-icon">✓</span>
                            </div>
                            <div class="status-text">Đã tiếp nhận hồ sơ</div>
                            <div class="status-date">20/04/2025</div>
                            <div class="status-description">Hồ sơ của bạn đã được tiếp nhận vào hệ thống</div>
                        </div>

                        <!-- Đang xử lý -->
                        <div class="status-item">
                            <div class="status-marker pending">
                                <span class="status-icon">⋯</span>
                            </div>
                            <div class="status-text">Đang xử lý</div>
                            <div class="status-date">Đang cập nhật</div>
                            <div class="status-description">Chuyên viên đang xem xét hồ sơ của bạn</div>
                        </div>

                        <!-- Duyệt hồ sơ/Cần bổ sung/Từ chối -->
                        <div class="status-item">
                            <div class="status-marker">
                                <span class="status-icon">○</span>
                            </div>
                            <div class="status-text">Duyệt hồ sơ</div>
                            <div class="status-date">Đang cập nhật</div>
                            <div class="status-description">Kết quả phê duyệt hồ sơ</div>
                        </div>

                        <!-- Đã giải ngân -->
                        <div class="status-item">
                            <div class="status-marker">
                                <span class="status-icon">○</span>
                            </div>
                            <div class="status-text">Đã giải ngân thành công</div>
                            <div class="status-date">Đang cập nhật</div>
                            <div class="status-description">Khoản vay đã được giải ngân vào tài khoản</div>
                        </div>
                    </div>

                    <div class="advisor-container">
                        <div class="advisor-heading">Chuyên viên phụ trách</div>
                        <div class="advisor-info">
                            <div class="advisor-name">Nguyễn Trang Nhung</div>
                            <div class="advisor-contact">
                                <span class="advisor-icon">📱</span>
                                <span>0967 237 317</span>
                            </div>
                            <div class="advisor-contact">
                                <span class="advisor-icon">💬</span>
                                <span>0989 872 727 (Zalo)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a href="../hocbongtrangnhung/duudieukien.php" class="back-link">« Quay lại trang trước</a>
    </div>

    <script>
        // JavaScript for handling file uploads and previews
        document.addEventListener('DOMContentLoaded', function() {
            const fileInputs = document.querySelectorAll('.file-input');

            fileInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const fileListId = this.id + '_list';
                    const fileList = document.getElementById(fileListId);
                    fileList.innerHTML = '';

                    if (this.files && this.files.length > 0) {
                        for (let i = 0; i < this.files.length; i++) {
                            const file = this.files[i];
                            const fileItem = document.createElement('div');
                            fileItem.classList.add('file-item');

                            const fileName = document.createElement('div');
                            fileName.classList.add('file-name');
                            fileName.textContent = file.name;

                            const fileActions = document.createElement('div');
                            fileActions.classList.add('file-actions');

                            const deleteButton = document.createElement('span');
                            deleteButton.classList.add('file-delete');
                            deleteButton.innerHTML = '❌';
                            deleteButton.addEventListener('click', function() {
                                fileItem.remove();
                                // Note: This doesn't actually clear the file input
                                // You would need a more complex approach to truly remove files
                            });

                            fileActions.appendChild(deleteButton);
                            fileItem.appendChild(fileName);
                            fileItem.appendChild(fileActions);
                            fileList.appendChild(fileItem);
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>