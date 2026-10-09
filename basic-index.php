<?php
// Lab01 - SmartCafe Billing

// CONSTANTS
const CURRENCY = "VND";
const MEMBER_DISCOUNT_RATE = 0.10;      // Tỉ lệ giảm giá
const MEMBER_MIN = 100000;              // Mức hóa đơn tối thiểu để được giảm
const PACKAGING_FEE_PER_ITEM = 5000;    // Phí bao bì cho mỗi ly
const SERVICE_RATE = 0.05;              // Phí phục vụ 

// VARIABLES
$productName = "Salt Coffee";
$unitPrice = 45000;
$rawQuantity = "3";             
$memberStatus = "MEMBER";               //"MEMBER" hoặc "GUEST"
$productAvailable = true;            

echo "=== RAW DATA ===" . PHP_EOL;
var_dump($productName);
var_dump($unitPrice);
var_dump($rawQuantity);
var_dump($memberStatus);
var_dump($productAvailable);

$quantity = (int) $rawQuantity;

echo "Raw quantity type: " . gettype($rawQuantity) . PHP_EOL;
echo "Clean quantity type: " . gettype($quantity) . PHP_EOL;

$subtotal = $unitPrice * $quantity;
echo "Subtotal: " . $subtotal . " " . CURRENCY . PHP_EOL;

$isMember = $memberStatus === "MEMBER"; // Kiểm tra khách hàng có là member không?
$isDiscountEligible = $isMember && ($subtotal >= MEMBER_MIN); // Điều kiện giảm giá
$discount = $isDiscountEligible ? ($subtotal * MEMBER_DISCOUNT_RATE) : 0; // Đủ điều kiện giảm, ngược lại thì không giảm
$packagingFee = $quantity * PACKAGING_FEE_PER_ITEM; // phí bao bì
$afterDiscount = $subtotal - $discount; //Trừ chiết khấu
$serviceFee = $afterDiscount * SERVICE_RATE; //Phí dịch vụ
$total = $afterDiscount + $packagingFee + $serviceFee; // Tổng


// Checkout gate
$hasValidQuantity = $quantity > 0;
$isValidCustomer = ($memberStatus === "MEMBER" || $memberStatus === "GUEST");
$canCheckout = $productAvailable && $hasValidQuantity && $isValidCustomer;

var_dump($canCheckout);

$receipt = PHP_EOL . "=== SMARTCAFE RECEIPT ===" . PHP_EOL;
$receipt .= "Product: " . $productName . PHP_EOL;
$receipt .= "Unit Price: " . $unitPrice . " " . CURRENCY . PHP_EOL;
$receipt .= "Quantity: " . $quantity . PHP_EOL;
$receipt .= "Subtotal: " . $subtotal . " " . CURRENCY . PHP_EOL;
$receipt .= "Discount: " . $discount . " " . CURRENCY . PHP_EOL;
$receipt .= "Packaging Fee: " . $packagingFee . " " . CURRENCY . PHP_EOL;
$receipt .= "Service Fee: " . $serviceFee . " " . CURRENCY . PHP_EOL;
$receipt .= "TOTAL: " . $total . " " . CURRENCY . PHP_EOL;

if ($canCheckout) {
    $receipt .= "Status: READY TO ORDER" . PHP_EOL;
} else {
    $receipt .= "Status: BLOCKED" . PHP_EOL;
}

echo $receipt;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SmartCafe Billing</title>
</head>
<body>
    <h1>SmartCafe Receipt</h1>
    
    <p>Product: <?= $productName ?></p>
    <p>Unit Price: <?= $unitPrice ?> <?= CURRENCY ?></p>
    <p>Quantity: <?= $quantity ?></p>
    
    <p>Subtotal: <?= $subtotal ?> <?= CURRENCY ?></p>
    <p>Discount: <?= $discount ?> <?= CURRENCY ?></p>
    <p>Packaging Fee: <?= $packagingFee ?> <?= CURRENCY ?></p>
    <p>Service Fee: <?= $serviceFee ?> <?= CURRENCY ?></p>
    
    <h3>Total: <?= $total ?> <?= CURRENCY ?></h3>
    
    <p>Status: <strong><?= $canCheckout ? "READY TO ORDER" : "BLOCKED" ?></strong></p>
</body>
</html>
