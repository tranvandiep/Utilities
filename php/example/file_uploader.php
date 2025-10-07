<?php
require_once '../FileUploader.php'; // Nhớ đảm bảo class FileUploader nằm cùng thư mục hoặc đúng đường dẫn

// Khi người dùng submit form upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gọi hàm upload
    $result = FileUploader::uploadFile($_FILES['file_upload'], [
        'user' => 'demo_user',      // Thư mục con sẽ lưu file: uploads/stores/demo_user/YYYY/MM
        'maxSize' => 5 * 1024 * 1024 // Giới hạn dung lượng: 5MB
    ]);

    // Giải mã JSON kết quả trả về
    $data = json_decode($result, true);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Demo Upload File - FileUploader</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background: #f5f5f5;
        }
        .container {
            max-width: 600px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        input[type=file] {
            margin: 10px 0;
        }
        button {
            padding: 10px 20px;
            background: #007bff;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        .result {
            margin-top: 20px;
            background: #fafafa;
            border-left: 5px solid #007bff;
            padding: 10px;
        }
        img {
            max-width: 100%;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>🖼️ Demo Upload File bằng FileUploader</h2>

    <!-- Form upload -->
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="file_upload">Chọn file để tải lên:</label><br>
        <input type="file" name="file_upload" id="file_upload" required><br>
        <button type="submit">Tải lên</button>
    </form>

    <!-- Hiển thị kết quả -->
    <?php if (isset($data)): ?>
        <div class="result">
            <h3>Kết quả:</h3>
            <pre><?php echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></pre>

            <?php if (!empty($data['url']) && $data['status'] == 1): ?>
                <p><strong>Ảnh đã tải lên:</strong></p>
                <img src="<?php echo htmlspecialchars($data['url']); ?>" alt="Uploaded image">
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
