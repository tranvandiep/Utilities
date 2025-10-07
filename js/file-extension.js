/**
 * ---------------------------------------------------------------
 * CHECK FILE TYPE FUNCTIONS
 * ---------------------------------------------------------------
 * Bộ hàm kiểm tra loại tệp tin: hình ảnh, tài liệu, âm thanh, video, text
 * Có thể dùng kết hợp với hệ thống upload hoặc validate file người dùng chọn.
 * ---------------------------------------------------------------
 */

/**
 * Lấy phần mở rộng của file (extension)
 * @param {string} filename - Tên file (ví dụ: "image.jpg")
 * @returns {string} - phần mở rộng của file (vd: "jpg")
 */
function getFileExtension(filename) {
  const parts = filename.split('.');
  return parts.length > 1 ? parts.pop().toLowerCase() : '';
}

/**
 * Kiểm tra file hình ảnh (image)
 * Hỗ trợ: jpg, jpeg, png, bmp, gif, webp, svg, heif, hevc, heic
 */
function isImageFile(filename) {
  const allowed = ['jpg', 'jpeg', 'png', 'bmp', 'gif', 'webp', 'svg', 'heif', 'hevc', 'heic'];
  return allowed.includes(getFileExtension(filename));
}

/**
 * Kiểm tra file tài liệu (document)
 * Hỗ trợ: doc, docx, xls, xlsx, ppt, pptx, pdf
 */
function isDocumentFile(filename) {
  const allowed = ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf'];
  return allowed.includes(getFileExtension(filename));
}

/**
 * Kiểm tra file âm thanh (audio)
 * Hỗ trợ: mp3, wav, m4a, ogg, flac, aac
 */
function isAudioFile(filename) {
  const allowed = ['mp3', 'wav', 'm4a', 'ogg', 'flac', 'aac'];
  return allowed.includes(getFileExtension(filename));
}

/**
 * Kiểm tra file video (video)
 * Hỗ trợ: mp4, mov, avi, mkv, webm, flv, wmv
 */
function isVideoFile(filename) {
  const allowed = ['mp4', 'mov', 'avi', 'mkv', 'webm', 'flv', 'wmv'];
  return allowed.includes(getFileExtension(filename));
}

/**
 * Kiểm tra file văn bản thuần (text)
 * Hỗ trợ: txt, csv, log, json, xml, md
 */
function isTextFile(filename) {
  const allowed = ['txt', 'csv', 'log', 'json', 'xml', 'md'];
  return allowed.includes(getFileExtension(filename));
}

/**
 * Hàm tổng hợp: xác định loại file (image / document / audio / video / text / unknown)
 */
function getFileType(filename) {
  if (isImageFile(filename)) return 'image';
  if (isDocumentFile(filename)) return 'document';
  if (isAudioFile(filename)) return 'audio';
  if (isVideoFile(filename)) return 'video';
  if (isTextFile(filename)) return 'text';
  return 'unknown';
}

// ---------------------------------------------------------------
// Ví dụ sử dụng
// ---------------------------------------------------------------

// console.log(isAudioFile("example.mp3")); // true
// console.log(getFileType("report.pdf"));  // "document"

module.exports = {
  getFileExtension,
  isImageFile,
  isDocumentFile,
  isAudioFile,
  isVideoFile,
  isTextFile,
  getFileType
};
