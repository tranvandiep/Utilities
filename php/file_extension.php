<?php
/**
 * ---------------------------------------------------------------
 * CHECK FILE TYPE FUNCTIONS
 * ---------------------------------------------------------------
 * Bộ hàm kiểm tra loại tệp tin: hình ảnh, tài liệu, âm thanh, video, text
 * Có thể dùng kết hợp với hệ thống upload hoặc validate file người dùng tải lên.
 * ---------------------------------------------------------------
 */

/**
 * Lấy phần mở rộng của file (extension)
 */
function getFileExtension($filename)
{
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

/**
 * Kiểm tra file hình ảnh (image)
 * Hỗ trợ: jpg, jpeg, png, bmp, gif, webp, svg, heif, hevc, heic
 */
function isImageFile($filename)
{
    $ext = getFileExtension($filename);
    $allowed = ['jpg', 'jpeg', 'png', 'bmp', 'gif', 'webp', 'svg', 'heif', 'hevc', 'heic'];
    return in_array($ext, $allowed);
}

/**
 * Kiểm tra file tài liệu (document)
 * Hỗ trợ: doc, docx, xls, xlsx, ppt, pptx, pdf
 */
function isDocumentFile($filename)
{
    $ext = getFileExtension($filename);
    $allowed = ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf'];
    return in_array($ext, $allowed);
}

/**
 * Kiểm tra file âm thanh (audio)
 * Hỗ trợ: mp3, wav, m4a, ogg, flac, aac
 */
function isAudioFile($filename)
{
    $ext = getFileExtension($filename);
    $allowed = ['mp3', 'wav', 'm4a', 'ogg', 'flac', 'aac'];
    return in_array($ext, $allowed);
}

/**
 * Kiểm tra file video (video)
 * Hỗ trợ: mp4, mov, avi, mkv, webm, flv, wmv
 */
function isVideoFile($filename)
{
    $ext = getFileExtension($filename);
    $allowed = ['mp4', 'mov', 'avi', 'mkv', 'webm', 'flv', 'wmv'];
    return in_array($ext, $allowed);
}

/**
 * Kiểm tra file text (văn bản thuần)
 * Hỗ trợ: txt, csv, log, json, xml, md
 */
function isTextFile($filename)
{
    $ext = getFileExtension($filename);
    $allowed = ['txt', 'csv', 'log', 'json', 'xml', 'md'];
    return in_array($ext, $allowed);
}

/**
 * Hàm tổng hợp: xác định loại file là gì (image / doc / audio / video / text / unknown)
 */
function getFileType($filename)
{
    if (isImageFile($filename)) return 'image';
    if (isDocumentFile($filename)) return 'document';
    if (isAudioFile($filename)) return 'audio';
    if (isVideoFile($filename)) return 'video';
    if (isTextFile($filename)) return 'text';
    return 'unknown';
}

// ----------------- Ví dụ sử dụng -----------------
/*
$filename = "example.mp3";
if (isAudioFile($filename)) {
    echo "Đây là file âm thanh!";
}

echo getFileType("test.pdf"); // Output: document
*/
?>
