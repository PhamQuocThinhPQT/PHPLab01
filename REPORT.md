# BÁO CÁO BÀI TẬP PHPLAB01: SMARTCAFE BILLING SYSTEM

- **Môn học / Bài tập:** PHP Lab 01 - Biến, Kiểu dữ liệu, Ép kiểu, Biểu thức & Refactoring
- **Sinh viên thực hiện:** tony (phamquocthinh.pqt@gmail.com)
- **Thư mục dự án:** `C:\xampp\htdocs\PHPLab01`
- **URL Localhost:** [http://localhost/PHPLab01/](http://localhost/PHPLab01/)

---

## 1. CẤU TRÚC DỰ ÁN TRƯỚC VÀ SAU REFACTOR (E1)

### Trước khi Refactor (Bản 1-file ban đầu)
```
PHPLab01/
├── index.php      # Chứa toàn bộ hằng số, dữ liệu raw, ép kiểu, tính toán và HTML
└── .gitignore
```

### Sau khi Refactor (Kiến trúc Modular)
```
PHPLab01/
├── index.php                 # Entry point; require_once các module theo thứ tự
├── config/
│   └── constants.php         # Hằng số cấu hình hệ thống (UPPER_SNAKE_CASE)
├── data/
│   └── checkout-data.php     # Raw input data, giữ nguyên numeric string ($rawQuantity = "3")
├── src/
│   └── checkout.php          # Normalization (explicit cast) + Business calculation + Booleans
├── views/
│   └── receipt.php           # Giao diện hóa đơn HTML + định dạng tiền tệ
├── inspect-types.php         # Script CLI kiểm tra type evidence (E2)
├── test-matrix.php           # Script CLI tự động chạy 4 test cases (E5)
├── REPORT.md                 # Tài liệu báo cáo toàn diện
└── .gitignore                # Bỏ qua runtime/IDE/OS files
```

---

## 2. BẰNG CHỨNG KIỂM TRA KIỂU DỮ LIỆU & CASTING (E2)

### Lệnh chạy CLI:
```bash
php inspect-types.php
```

### Kết quả Terminal CLI:
```text
PHPLab01 - TYPE INSPECTION & NORMALIZATION EVIDENCE (E2)

[1] RAW INPUT INSPECTION (Truoc khi casting):
Biến $rawQuantity:
  - gettype($rawQuantity) : string
  - var_dump($rawQuantity) : string(1) "3"
Biến $unitPrice:
  - gettype($unitPrice)   : integer
  - var_dump($unitPrice)   : int(45000)
Biến $productAvailable:
  - gettype($productAvailable) : boolean
  - var_dump($productAvailable) : bool(true)

[2] NORMALIZATION / CASTING (Sau khi ep kieu tuong minh):
Thuc hien: $quantity = (int) $rawQuantity;
  - gettype($quantity)    : integer
  - var_dump($quantity)    : int(3)

[3] BUSINESS CONDITIONS & CALCULATIONS:
  - $canCheckout (Boolean)       : true
  - $subtotal (Intermediate)     : 135.000 VND
  - $isMember (Strict Equality)  : true
  - $isDiscountEligible (Logic)  : true
  - $discount (Ternary calc)     : 13.500 VND
  - $packagingFee               : 15.000 VND
  - $serviceFee                 : 6.075 VND
  - $total Payment               : 142.575 VND
  - Order Status                 : READY TO ORDER

Kết quả: PHP CLI chạy thành công, không có Parse Error.
```

---

## 3. BẰNG CHỨNG MÔI TRƯỜNG XAMPP / APACHE (E3) & GIAO DIỆN HÓA ĐƠN (E4)

* **XAMPP Apache Status:** Đang chạy tại cổng `80` (PID: 6652).
* **URL Localhost:** `http://localhost/PHPLab01/`
* **HTTP Response Code:** `200 OK`
* **Giao diện hóa đơn Browser (E4):**
  * Tiêu đề: SmartCafe - Order Receipt & Billing Details
  * Product: Salt Coffee
  * Unit Price: 45.000 VND | Quantity: x3
  * Subtotal: 135.000 VND
  * Discount (10%): -13.500 VND
  * Packaging Fee: +15.000 VND
  * Service Fee (5%): +6.075 VND
  * **Total Payment: 142.575 VND**
  * Status Badge: `READY TO ORDER` (Xanh lá)

---

## 4. TEST DATA MATRIX (E5)

### Lệnh chạy CLI tự động kiểm tra 4 cases:
```bash
php test-matrix.php
```

### Bảng Test Data Matrix:

| Case | Input chính | Expected (Tính tay trước khi chạy) | Actual (Kết quả code) | Kết luận |
| :--- | :--- | :--- | :--- | :---: |
| **T1 – Happy path** | Price=45.000<br>RawQty="3"<br>Member=MEMBER<br>Available=true | • Qty = 3<br>• Subtotal = 135.000<br>• Discount = 13.500<br>• PackFee = 15.000<br>• ServiceFee = 6.075<br>• **Total = 142.575 VND**<br>• Status = READY TO ORDER | • Qty = 3<br>• Subtotal = 135.000<br>• Discount = 13.500<br>• PackFee = 15.000<br>• ServiceFee = 6.075<br>• **Total = 142.575 VND**<br>• Status = READY TO ORDER | **PASS** |
| **T2 – No benefit** | Price=45.000<br>RawQty="1"<br>Member=GUEST<br>Available=true | • Qty = 1<br>• Subtotal = 45.000<br>• Discount = 0<br>• PackFee = 5.000<br>• ServiceFee = 2.250<br>• **Total = 52.250 VND**<br>• Status = READY TO ORDER | • Qty = 1<br>• Subtotal = 45.000<br>• Discount = 0<br>• PackFee = 5.000<br>• ServiceFee = 2.250<br>• **Total = 52.250 VND**<br>• Status = READY TO ORDER | **PASS** |
| **T3 – Boundary** | Price=50.000<br>RawQty="2"<br>Member=MEMBER<br>Available=true | • Qty = 2<br>• Subtotal = 100.000 (đúng ngưỡng `>= MEMBER_MIN`)<br>• Discount = 10.000<br>• PackFee = 10.000<br>• ServiceFee = 4.500<br>• **Total = 104.500 VND**<br>• Status = READY TO ORDER | • Qty = 2<br>• Subtotal = 100.000<br>• Discount = 10.000<br>• PackFee = 10.000<br>• ServiceFee = 4.500<br>• **Total = 104.500 VND**<br>• Status = READY TO ORDER | **PASS** |
| **T4 – Blocked** | Price=45.000<br>RawQty="0"<br>Member=MEMBER<br>Available=false | • Qty = 0<br>• canCheckout = false (Gate đóng do hết hàng/số lượng 0)<br>• Total = 0 VND<br>• **Status = BLOCKED** | • Qty = 0<br>• canCheckout = false<br>• Total = 0 VND<br>• **Status = BLOCKED** | **PASS** |

---

## 5. GIT REPOSITORY & COMMIT PROGRESSION (E6) & BRANCH / PR DIFF (E7)

### Lịch sử Commit:
```text
docs/test: add manual test evidence and test matrix
merge: merge branch 'refactor/modular-architecture' into main
refactor: split config data logic view
feat: add calculations and receipt
feat: add raw data and constants
chore: initialize PHP assignment
```

### Bằng chứng Branch & Code Diff (E7):
```text
 config/constants.php   |   6 +++
 data/checkout-data.php |   6 +++
 index.php              |  38 ++------------
 src/checkout.php       |  13 +++++
 views/receipt.php      | 138 +++++++++++++++++++++++++++++++++++++++++++++++++
 5 files changed, 167 insertions(+), 34 deletions(-)
```
