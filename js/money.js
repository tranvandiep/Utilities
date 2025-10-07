/**
 * ---------------------------------------------------------------
 * convertNumberToVietnameseCurrency
 * ---------------------------------------------------------------
 * Chuyển số thành chữ tiếng Việt (dạng tiền tệ)
 * Hỗ trợ tới hàng nghìn tỷ
 * ---------------------------------------------------------------
 * @param {number|string} number - Số cần chuyển (vd: 1234567)
 * @returns {string} - Kết quả: "Một triệu hai trăm ba mươi bốn nghìn năm trăm sáu mươi bảy đồng"
 * ---------------------------------------------------------------
 */
function convertNumberToVietnameseCurrency(number) {
  number = parseInt(number, 10);
  if (isNaN(number)) return 'Không hợp lệ';
  if (number === 0) return 'Không đồng';

  const unitNumbers = ['không', 'một', 'hai', 'ba', 'bốn', 'năm', 'sáu', 'bảy', 'tám', 'chín'];
  const placeValues = ['', 'nghìn', 'triệu', 'tỷ', 'nghìn tỷ', 'triệu tỷ', 'tỷ tỷ'];

  function readThreeDigits(num) {
    let hundred = Math.floor(num / 100);
    let ten = Math.floor((num % 100) / 10);
    let unit = num % 10;
    let result = '';

    if (hundred > 0) {
      result += unitNumbers[hundred] + ' trăm';
      if (ten === 0 && unit > 0) result += ' linh';
    }

    if (ten > 0 && ten !== 1) {
      result += ' ' + unitNumbers[ten] + ' mươi';
      if (ten > 1 && unit === 1) result += ' mốt';
    } else if (ten === 1) {
      result += ' mười';
      if (unit === 1) result += ' một';
    }

    if (unit > 0 && ten !== 1) {
      if (unit === 5 && ten >= 1) result += ' lăm';
      else result += ' ' + unitNumbers[unit];
    }

    return result.trim();
  }

  let i = 0;
  let result = '';
  while (number > 0) {
    let threeDigits = number % 1000;
    if (threeDigits !== 0) {
      let prefix = readThreeDigits(threeDigits);
      result = prefix + (placeValues[i] ? ' ' + placeValues[i] : '') + ' ' + result;
    }
    number = Math.floor(number / 1000);
    i++;
  }

  result = result.trim();
  result = result.charAt(0).toUpperCase() + result.slice(1);
  return result + ' đồng';
}
