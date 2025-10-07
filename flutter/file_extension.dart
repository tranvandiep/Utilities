/// ---------------------------------------------------------------
/// CHECK FILE TYPE FUNCTIONS
/// ---------------------------------------------------------------
/// Bộ hàm kiểm tra loại tệp tin: hình ảnh, tài liệu, âm thanh, video, text.
/// Có thể dùng kết hợp với hệ thống upload hoặc validate file người dùng tải lên.
/// ---------------------------------------------------------------

class FileTypeUtils {
  /// Lấy phần mở rộng của file (extension)
  static String getFileExtension(String filename) {
    final parts = filename.split('.');
    if (parts.length < 2) return '';
    return parts.last.toLowerCase();
  }

  /// Kiểm tra file hình ảnh (image)
  /// Hỗ trợ: jpg, jpeg, png, bmp, gif, webp, svg, heif, hevc, heic
  static bool isImageFile(String filename) {
    final ext = getFileExtension(filename);
    const allowed = [
      'jpg',
      'jpeg',
      'png',
      'bmp',
      'gif',
      'webp',
      'svg',
      'heif',
      'hevc',
      'heic',
    ];
    return allowed.contains(ext);
  }

  /// Kiểm tra file tài liệu (document)
  /// Hỗ trợ: doc, docx, xls, xlsx, ppt, pptx, pdf
  static bool isDocumentFile(String filename) {
    final ext = getFileExtension(filename);
    const allowed = [
      'doc',
      'docx',
      'xls',
      'xlsx',
      'ppt',
      'pptx',
      'pdf',
    ];
    return allowed.contains(ext);
  }

  /// Kiểm tra file âm thanh (audio)
  /// Hỗ trợ: mp3, wav, m4a, ogg, flac, aac
  static bool isAudioFile(String filename) {
    final ext = getFileExtension(filename);
    const allowed = [
      'mp3',
      'wav',
      'm4a',
      'ogg',
      'flac',
      'aac',
    ];
    return allowed.contains(ext);
  }

  /// Kiểm tra file video (video)
  /// Hỗ trợ: mp4, mov, avi, mkv, webm, flv, wmv
  static bool isVideoFile(String filename) {
    final ext = getFileExtension(filename);
    const allowed = [
      'mp4',
      'mov',
      'avi',
      'mkv',
      'webm',
      'flv',
      'wmv',
    ];
    return allowed.contains(ext);
  }

  /// Kiểm tra file văn bản (text)
  /// Hỗ trợ: txt, csv, log, json, xml, md
  static bool isTextFile(String filename) {
    final ext = getFileExtension(filename);
    const allowed = [
      'txt',
      'csv',
      'log',
      'json',
      'xml',
      'md',
    ];
    return allowed.contains(ext);
  }

  /// Hàm tổng hợp: xác định loại file là gì
  /// Trả về: image / document / audio / video / text / unknown
  static String getFileType(String filename) {
    if (isImageFile(filename)) return 'image';
    if (isDocumentFile(filename)) return 'document';
    if (isAudioFile(filename)) return 'audio';
    if (isVideoFile(filename)) return 'video';
    if (isTextFile(filename)) return 'text';
    return 'unknown';
  }
}
