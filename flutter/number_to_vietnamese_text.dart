class NumberToVietnameseText {
  static const List<String> _numberWords = [
    "không",
    "một",
    "hai",
    "ba",
    "bốn",
    "năm",
    "sáu",
    "bảy",
    "tám",
    "chín"
  ];

  static const List<String> _unitWords = [
    "",
    "nghìn",
    "triệu",
    "tỷ"
  ];

  static String convert(num number) {
    if (number == 0) return "Không đồng";

    int integerPart = number.floor();
    String result = "";
    int unitIndex = 0;

    while (integerPart > 0) {
      int group = integerPart % 1000;
      if (group != 0) {
        String groupText = _convertGroup(group);
        result = "$groupText ${_unitWords[unitIndex]} $result";
      }
      integerPart ~/= 1000;
      unitIndex++;
    }

    result = result.trim().replaceAll(RegExp(r'\s+'), ' ');
    return "${result[0].toUpperCase()}${result.substring(1)} đồng";
  }

  static String _convertGroup(int number) {
    int hundreds = number ~/ 100;
    int tens = (number % 100) ~/ 10;
    int ones = number % 10;

    List<String> parts = [];

    if (hundreds > 0) {
      parts.add("${_numberWords[hundreds]} trăm");
      if (tens == 0 && ones > 0) {
        parts.add("linh");
      }
    }

    if (tens > 0 && tens != 1) {
      parts.add("${_numberWords[tens]} mươi");
      if (ones == 1) {
        parts.add("mốt");
      } else if (ones == 5) {
        parts.add("lăm");
      } else if (ones > 0) {
        parts.add(_numberWords[ones]);
      }
    } else if (tens == 1) {
      parts.add("mười");
      if (ones == 5) {
        parts.add("lăm");
      } else if (ones > 0) {
        parts.add(_numberWords[ones]);
      }
    } else if (tens == 0 && ones > 0 && hundreds == 0) {
      parts.add(_numberWords[ones]);
    } else if (tens == 0 && ones > 0) {
      parts.add(_numberWords[ones]);
    }

    return parts.join(" ");
  }
}
