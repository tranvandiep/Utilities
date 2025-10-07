/**
 * ---------------------------------------------------------------
 * CHECK FILE TYPE FUNCTIONS
 * ---------------------------------------------------------------
 * Bộ hàm kiểm tra loại tệp tin: hình ảnh, tài liệu, âm thanh, video, text
 * Có thể dùng kết hợp với hệ thống upload hoặc validate file người dùng chọn.
 * ---------------------------------------------------------------
 */

package com.example.utils

object FileUtils {

    /**
     * Lấy phần mở rộng của file (extension)
     */
    fun getFileExtension(filename: String): String {
        val dotIndex = filename.lastIndexOf(".")
        return if (dotIndex != -1 && dotIndex < filename.length - 1) {
            filename.substring(dotIndex + 1).lowercase()
        } else {
            ""
        }
    }

    /**
     * Kiểm tra file hình ảnh (image)
     * Hỗ trợ: jpg, jpeg, png, bmp, gif, webp, svg, heif, hevc, heic
     */
    fun isImageFile(filename: String): Boolean {
        val allowed = listOf("jpg", "jpeg", "png", "bmp", "gif", "webp", "svg", "heif", "hevc", "heic")
        return getFileExtension(filename) in allowed
    }

    /**
     * Kiểm tra file tài liệu (document)
     * Hỗ trợ: doc, docx, xls, xlsx, ppt, pptx, pdf
     */
    fun isDocumentFile(filename: String): Boolean {
        val allowed = listOf("doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf")
        return getFileExtension(filename) in allowed
    }

    /**
     * Kiểm tra file âm thanh (audio)
     * Hỗ trợ: mp3, wav, m4a, ogg, flac, aac
     */
    fun isAudioFile(filename: String): Boolean {
        val allowed = listOf("mp3", "wav", "m4a", "ogg", "flac", "aac")
        return getFileExtension(filename) in allowed
    }

    /**
     * Kiểm tra file video (video)
     * Hỗ trợ: mp4, mov, avi, mkv, webm, flv, wmv
     */
    fun isVideoFile(filename: String): Boolean {
        val allowed = listOf("mp4", "mov", "avi", "mkv", "webm", "flv", "wmv")
        return getFileExtension(filename) in allowed
    }

    /**
     * Kiểm tra file văn bản thuần (text)
     * Hỗ trợ: txt, csv, log, json, xml, md
     */
    fun isTextFile(filename: String): Boolean {
        val allowed = listOf("txt", "csv", "log", "json", "xml", "md")
        return getFileExtension(filename) in allowed
    }

    /**
     * Hàm tổng hợp: xác định loại file (image / document / audio / video / text / unknown)
     */
    fun getFileType(filename: String): String {
        return when {
            isImageFile(filename) -> "image"
            isDocumentFile(filename) -> "document"
            isAudioFile(filename) -> "audio"
            isVideoFile(filename) -> "video"
            isTextFile(filename) -> "text"
            else -> "unknown"
        }
    }
}
