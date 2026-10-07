
<?php
$quantity = (int) $rawQuantity;
$canCheckout = $productAvailable && $quantity > 0;
$subtotal = $unitPrice * $quantity;

$isMember = $memberStatus === "MEMBER"; // Kiểm tra khách hàng có là member không?
$isDiscountEligible = $isMember && ($subtotal >= MEMBER_MIN); // Điều kiện giảm giá
$discount = $isDiscountEligible ? ($subtotal * MEMBER_DISCOUNT_RATE) : 0; // Đủ điều kiện giảm, ngược lại thì không giảm
$packagingFee = $quantity * PACKAGING_FEE_PER_ITEM; // phí bao bì
$afterDiscount = $subtotal - $discount; //Trừ chiết khấu
$serviceFee = $afterDiscount * SERVICE_RATE; //Phí dịch vụ
$total = $afterDiscount + $packagingFee + $serviceFee; // Tổng
