object NumberToVietnameseText {

    private val numberWords = arrayOf(
        "không", "một", "hai", "ba", "bốn", "năm", "sáu", "bảy", "tám", "chín"
    )

    private val unitWords = arrayOf(
        "", "nghìn", "triệu", "tỷ"
    )

    fun convert(number: Long): String {
        if (number == 0L) return "Không đồng"

        var num = number
        var result = ""
        var unitIndex = 0

        while (num > 0) {
            val group = (num % 1000).toInt()
            if (group != 0) {
                val groupText = convertGroup(group)
                result = "$groupText ${unitWords[unitIndex]} $result"
            }
            num /= 1000
            unitIndex++
        }

        return result.trim().replace(Regex("\\s+"), " ")
            .replaceFirstChar { it.uppercase() } + " đồng"
    }

    private fun convertGroup(number: Int): String {
        val hundreds = number / 100
        val tens = (number % 100) / 10
        val ones = number % 10
        val sb = StringBuilder()

        if (hundreds > 0) {
            sb.append("${numberWords[hundreds]} trăm")
            if (tens == 0 && ones > 0) sb.append(" linh")
        }

        if (tens > 0 && tens != 1) {
            sb.append(" ${numberWords[tens]} mươi")
            if (ones == 1) sb.append(" mốt")
            else if (ones == 5) sb.append(" lăm")
            else if (ones > 0) sb.append(" ${numberWords[ones]}")
        } else if (tens == 1) {
            sb.append(" mười")
            if (ones == 5) sb.append(" lăm")
            else if (ones > 0) sb.append(" ${numberWords[ones]}")
        } else if (tens == 0 && ones > 0 && hundreds == 0) {
            sb.append(numberWords[ones])
        } else if (tens == 0 && ones > 0) {
            sb.append(" ${numberWords[ones]}")
        }

        return sb.toString().trim()
    }
}