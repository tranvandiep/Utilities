//
//  FileUtils.swift
//  Created by Diep on 07/10/2025
//
//  ---------------------------------------------------------------
//  CHECK FILE TYPE FUNCTIONS
//  ---------------------------------------------------------------
//  Bộ hàm kiểm tra loại tệp tin: hình ảnh, tài liệu, âm thanh, video, text
//  Có thể dùng kết hợp với hệ thống upload hoặc validate file người dùng chọn.
//  ---------------------------------------------------------------
//

import Foundation

struct FileUtils {
    
    /// Lấy phần mở rộng của file (extension)
    static func getFileExtension(_ filename: String) -> String {
        return URL(fileURLWithPath: filename).pathExtension.lowercased()
    }
    
    /// Kiểm tra file hình ảnh (image)
    /// Hỗ trợ: jpg, jpeg, png, bmp, gif, webp, svg, heif, hevc, heic
    static func isImageFile(_ filename: String) -> Bool {
        let allowed = ["jpg", "jpeg", "png", "bmp", "gif", "webp", "svg", "heif", "hevc", "heic"]
        return allowed.contains(getFileExtension(filename))
    }
    
    /// Kiểm tra file tài liệu (document)
    /// Hỗ trợ: doc, docx, xls, xlsx, ppt, pptx, pdf
    static func isDocumentFile(_ filename: String) -> Bool {
        let allowed = ["doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf"]
        return allowed.contains(getFileExtension(filename))
    }
    
    /// Kiểm tra file âm thanh (audio)
    /// Hỗ trợ: mp3, wav, m4a, ogg, flac, aac
    static func isAudioFile(_ filename: String) -> Bool {
        let allowed = ["mp3", "wav", "m4a", "ogg", "flac", "aac"]
        return allowed.contains(getFileExtension(filename))
    }
    
    /// Kiểm tra file video (video)
    /// Hỗ trợ: mp4, mov, avi, mkv, webm, flv, wmv
    static func isVideoFile(_ filename: String) -> Bool {
        let allowed = ["mp4", "mov", "avi", "mkv", "webm", "flv", "wmv"]
        return allowed.contains(getFileExtension(filename))
    }
    
    /// Kiểm tra file văn bản thuần (text)
    /// Hỗ trợ: txt, csv, log, json, xml, md
    static func isTextFile(_ filename: String) -> Bool {
        let allowed = ["txt", "csv", "log", "json", "xml", "md"]
        return allowed.contains(getFileExtension(filename))
    }
    
    /// Hàm tổng hợp: xác định loại file (image / document / audio / video / text / unknown)
    static func getFileType(_ filename: String) -> String {
        if isImageFile(filename) { return "image" }
        if isDocumentFile(filename) { return "document" }
        if isAudioFile(filename) { return "audio" }
        if isVideoFile(filename) { return "video" }
        if isTextFile(filename) { return "text" }
        return "unknown"
    }
}
