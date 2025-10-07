<?php
/**
 * Class FileUploader
 * ------------------
 * Dùng để xử lý upload file hình ảnh lên server, tự động kiểm tra định dạng,
 * dung lượng, tạo tên file không trùng, tạo thư mục, và trả về URL đầy đủ.
 *
 * ✅ Hỗ trợ: jpg, jpeg, png, bmp, gif, webp, svg, heif, hevc, heic
 * ✅ Tự động tạo thư mục theo cấu trúc: uploads/stores/{user}/{Y/m}
 * ✅ Tự động đổi tên file sang dạng slug không dấu
 * ✅ Tự động tránh trùng tên (file-1.jpg, file-2.jpg, ...)
 * ✅ Trả về JSON chứa thông tin upload
 *
 * @example
 * $result = FileUploader::uploadFile($_FILES['avatar'], ['user' => 'diep', 'maxSize' => 2 * 1024 * 1024]);
 * echo $result;
 */
class FileUploader
{
    /**
     * Upload một file lên server.
     *
     * @param array $file   Mảng $_FILES['fieldname'] từ form upload.
     * @param array $options Tùy chọn:
     *                       - 'user' (string): tên thư mục user con (mặc định 'default')
     *                       - 'maxSize' (int): dung lượng tối đa (bytes), mặc định 5MB
     *
     * @return string JSON trả về có cấu trúc:
     * {
     *   "status": 1 hoặc 0,
     *   "msg": "Thông báo lỗi hoặc thành công",
     *   "url": "Đường dẫn tới file đã upload (nếu thành công)",
     *   "size": "Dung lượng file (bytes)"
     * }
     */
    public static function uploadFile($file, $options = [])
    {
        // Lấy domain hiện tại để sinh URL đầy đủ
        $domain = self::getDomain();

        // Kiểm tra file có tồn tại và hợp lệ không
        if (!isset($file) || !isset($file['name'])) {
            return self::error('Không tìm thấy file tải lên.');
        }

        // Lấy thông tin cơ bản
        $filename = $file['name'];
        $temp_name = $file['tmp_name'];
        $size = filesize($temp_name);

        // Lấy phần mở rộng của file (vd: jpg, png)
        $arr = explode('.', $filename);
        $ext = strtolower(end($arr));

        // Chuyển tên file thành dạng slug không dấu + giữ lại phần mở rộng
        $filename = self::toSlug($arr[0]) . '.' . $ext;

        // Kiểm tra định dạng hợp lệ
        $allowExt = ['jpg', 'jpeg', 'png', 'bmp', 'gif', 'webp', 'svg', 'heif', 'hevc', 'heic', 'image'];
        if (!in_array($ext, $allowExt)) {
            return self::error(
                'Định dạng không hợp lệ. Chỉ chấp nhận jpg, jpeg, png, bmp, gif',
                'https://' . $domain . '/uploads/no-photo.png'
            );
        }

        // Giới hạn dung lượng tối đa (mặc định 5MB)
        $maxSize = isset($options['maxSize']) ? $options['maxSize'] : 5 * 1024 * 1024;
        if ($size > $maxSize) {
            return self::error(
                'Dung lượng file vượt quá giới hạn (' . ($maxSize / 1000000) . 'MB)',
                'https://' . $domain . '/uploads/no-photo.png'
            );
        }

        // Xác định thư mục lưu trữ: uploads/stores/{user}/{Y/m}
        $userFolder = isset($options['user']) ? $options['user'] : 'default';
        $target_dir = "uploads/stores/" . $userFolder . "/" . date('Y/m');

        // Nếu chưa tồn tại thì tạo thư mục (0777: quyền full truy cập)
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Tạo đường dẫn lưu file và xử lý tránh trùng tên (vd: file-1.jpg)
        $path_filename_ext = self::uniquePath($target_dir . '/' . $filename);

        // Tiến hành upload file từ temp vào thư mục đích
        if (move_uploaded_file($temp_name, $path_filename_ext)) {
            return json_encode([
                'status' => 1,
                'url' => 'https://' . $domain . '/' . $path_filename_ext,
                'size' => $size,
                'msg' => 'Tải lên thành công'
            ]);
        } else {
            return self::error('Không thể tải file lên máy chủ.');
        }
    }

    // --------------------------------------------------------------
    // Các hàm phụ trợ (helper functions)
    // --------------------------------------------------------------

    /**
     * Lấy domain hiện tại của server (ví dụ: example.com)
     */
    private static function getDomain()
    {
        return $_SERVER['SERVER_NAME'] ?? 'localhost';
    }

    /**
     * Tạo phản hồi JSON lỗi, tiện dùng khi upload thất bại.
     *
     * @param string $msg Thông báo lỗi.
     * @param string $url (Tùy chọn) URL mặc định khi lỗi (vd: ảnh mặc định).
     */
    private static function error($msg, $url = '')
    {
        return json_encode([
            'status' => 0,
            'msg' => $msg,
            'url' => $url
        ]);
    }

    /**
     * Đảm bảo file không bị trùng tên. Nếu file tồn tại,
     * tự động thêm hậu tố "-1", "-2", ...
     *
     * @param string $path Đường dẫn gốc (vd: uploads/a.jpg)
     * @return string Đường dẫn không trùng (vd: uploads/a-1.jpg)
     */
    private static function uniquePath($path)
    {
        $info = pathinfo($path);
        $base = $info['dirname'] . '/' . $info['filename'];
        $ext = '.' . $info['extension'];
        $i = 1;
        while (file_exists($path)) {
            $path = $base . '-' . $i . $ext;
            $i++;
        }
        return $path;
    }

    /**
     * Chuyển chuỗi có dấu sang slug không dấu, dạng an toàn cho URL/tên file.
     *
     * @example
     * toSlug('Ảnh Chân Dung Đẹp.png') => "anh-chan-dung-dep"
     */
    private static function toSlug($str)
    {
        $str = self::trimVN($str);
        $str = strtolower($str);
        $str = preg_replace('/[^a-z0-9]+/i', '-', $str);
        $str = trim($str, '-');
        return $str;
    }

    /**
     * Loại bỏ dấu tiếng Việt trong chuỗi (phục vụ tạo slug).
     *
     * @example
     * trimVN('Hồ Chí Minh') => "Ho Chi Minh"
     */
    private static function trimVN($str)
    {
        $unicode = [
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd' => 'đ',
            'D' => 'Đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
        ];
        foreach ($unicode as $nonAccent => $accent) {
            $str = preg_replace("/($accent)/i", $nonAccent, $str);
        }
        return $str;
    }
}