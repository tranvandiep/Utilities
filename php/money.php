<?php
/**
 * ---------------------------------------------------------------
 * CONVERT NUMBER TO VIETNAMESE CURRENCY TEXT
 * ---------------------------------------------------------------
 * Hàm chuyển số thành chữ tiền tệ tiếng Việt
 * Hỗ trợ tới hàng nghìn tỷ, đọc đúng ngữ pháp tiếng Việt
 * ---------------------------------------------------------------
 * @param int|float|string $number  Số tiền cần chuyển
 * @return string  Kết quả: "Một triệu hai trăm ba mươi bốn nghìn năm trăm sáu mươi bảy đồng"
 * ---------------------------------------------------------------
 */

function convertNumberToVietnameseCurrency($number)
{
    $number = (int)$number;
    if ($number == 0) {
        return 'Không đồng';
    }

    $unitNumbers = ['không', 'một', 'hai', 'ba', 'bốn', 'năm', 'sáu', 'bảy', 'tám', 'chín'];
    $placeValues = ['', 'nghìn', 'triệu', 'tỷ', 'nghìn tỷ', 'triệu tỷ', 'tỷ tỷ'];

    /**
     * Hàm đọc 3 chữ số
     */
    $readThreeDigits = function ($num) use ($unitNumbers) {
        $hundred = floor($num / 100);
        $ten = floor(($num % 100) / 10);
        $unit = $num % 10;
        $result = '';

        if ($hundred > 0) {
            $result .= $unitNumbers[$hundred] . ' trăm';
            if ($ten == 0 && $unit > 0) $result .= ' linh';
        }

        if ($ten > 1) {
            $result .= ' ' . $unitNumbers[$ten] . ' mươi';
            if ($unit == 1) $result .= ' mốt';
        } elseif ($ten == 1) {
            $result .= ' mười';
            if ($unit == 1) $result .= ' một';
        }

        if ($unit > 0 && $ten != 1) {
            if ($unit == 5 && $ten >= 1) $result .= ' lăm';
            else $result .= ' ' . $unitNumbers[$unit];
        }

        return trim($result);
    };

    $i = 0;
    $result = '';

    while ($number > 0) {
        $threeDigits = $number % 1000;
        if ($threeDigits != 0) {
            $prefix = $readThreeDigits($threeDigits);
            $suffix = $placeValues[$i] ?? '';
            $result = trim($prefix . ' ' . $suffix . ' ' . $result);
        }
        $number = floor($number / 1000);
        $i++;
    }

    $result = trim($result);
    $result = mb_strtoupper(mb_substr($result, 0, 1)) . mb_substr($result, 1); // Viết hoa chữ cái đầu
    return $result . ' đồng';
}