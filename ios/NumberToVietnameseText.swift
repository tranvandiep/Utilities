import Foundation

class NumberToVietnameseText {
    static let numberWords = ["không", "một", "hai", "ba", "bốn", "năm", "sáu", "bảy", "tám", "chín"]
    static let unitWords = ["", "nghìn", "triệu", "tỷ"]

    static func convert(_ number: Int64) -> String {
        if number == 0 { return "Không đồng" }

        var num = number
        var result = ""
        var unitIndex = 0

        while num > 0 {
            let group = Int(num % 1000)
            if group != 0 {
                let groupText = convertGroup(group)
                result = "\(groupText) \(unitWords[unitIndex]) \(result)"
            }
            num /= 1000
            unitIndex += 1
        }

        result = result.trimmingCharacters(in: .whitespacesAndNewlines)
            .replacingOccurrences(of: "\\s+", with: " ", options: .regularExpression)

        return result.prefix(1).uppercased() + result.dropFirst() + " đồng"
    }

    private static func convertGroup(_ number: Int) -> String {
        let hundreds = number / 100
        let tens = (number % 100) / 10
        let ones = number % 10
        var parts: [String] = []

        if hundreds > 0 {
            parts.append("\(numberWords[hundreds]) trăm")
            if tens == 0 && ones > 0 {
                parts.append("linh")
            }
        }

        if tens > 0 && tens != 1 {
            parts.append("\(numberWords[tens]) mươi")
            if ones == 1 {
                parts.append("mốt")
            } else if ones == 5 {
                parts.append("lăm")
            } else if ones > 0 {
                parts.append(numberWords[ones])
            }
        } else if tens == 1 {
            parts.append("mười")
            if ones == 5 {
                parts.append("lăm")
            } else if ones > 0 {
                parts.append(numberWords[ones])
            }
        } else if tens == 0 && ones > 0 && hundreds == 0 {
            parts.append(numberWords[ones])
        } else if tens == 0 && ones > 0 {
            parts.append(numberWords[ones])
        }

        return parts.joined(separator: " ")
    }
}
