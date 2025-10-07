<?php
/**
 * Lấy địa chỉ IP của client đang truy cập.
 *
 * @return string Địa chỉ IP (IPv4 hoặc IPv6), hoặc 'UNKNOWN' nếu không xác định được.
 *
 * @example
 * $ip = getClientIp();
 * echo "Địa chỉ IP của bạn là: $ip";
 */
function getClientIp()
{
    $keys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    ];

    foreach ($keys as $key) {
        if (!empty($_SERVER[$key])) {
            // Có thể chứa nhiều IP, lấy IP đầu tiên
            $ipList = explode(',', $_SERVER[$key]);
            foreach ($ipList as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }
    }

    return 'UNKNOWN';
}

/**
 * Lấy tên miền hiện tại của website.
 *
 * @return string Domain (ví dụ: example.com hoặc localhost)
 *
 * @example
 * echo getDomainName(); // Kết quả: tracnghiemviet.vn
 */
function getDomainName()
{
    // Nếu chạy qua HTTP request (Apache/Nginx)
    if (isset($_SERVER['HTTP_HOST']) && !empty($_SERVER['HTTP_HOST'])) {
        $domain = $_SERVER['HTTP_HOST'];
    } elseif (isset($_SERVER['SERVER_NAME']) && !empty($_SERVER['SERVER_NAME'])) {
        $domain = $_SERVER['SERVER_NAME'];
    } else {
        // Nếu chạy CLI (không qua web server)
        $domain = 'localhost';
    }

    // Loại bỏ port nếu có (vd: localhost:8080 -> localhost)
    $domain = preg_replace('/:\d+$/', '', $domain);

    return $domain;
}

