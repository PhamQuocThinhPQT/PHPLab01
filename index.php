<?php
// SmartCafe 1-File Complete Version (Data, Calculation & Receipt)
const CURRENCY = "VND";
const MEMBER_DISCOUNT_RATE = 0.10;
const MEMBER_MIN = 100000;
const PACKAGING_FEE_PER_ITEM = 5000;
const SERVICE_RATE = 0.05;

$productName = "Salt Coffee";
$unitPrice = 45000;
$rawQuantity = "3";
$memberStatus = "MEMBER";
$productAvailable = true;

// Normalize & Calculate
$quantity = (int) $rawQuantity;
$canCheckout = $productAvailable && $quantity > 0;
$subtotal = $unitPrice * $quantity;
$isMember = $memberStatus === "MEMBER";
$isDiscountEligible = $isMember && ($subtotal >= MEMBER_MIN);
$discount = $isDiscountEligible ? ($subtotal * MEMBER_DISCOUNT_RATE) : 0;
$packagingFee = $quantity * PACKAGING_FEE_PER_ITEM;
$afterDiscount = $subtotal - $discount;
$serviceFee = $afterDiscount * SERVICE_RATE;
$total = $afterDiscount + $packagingFee + $serviceFee;
?>
<!doctype html>
<html>
<head><title>SmartCafe Billing</title></head>
<body>
    <h1>SmartCafe Receipt (Single-file)</h1>
    <p>Product: <?= $productName ?></p>
    <p>Total: <?= number_format($total, 0, ',', '.') ?> <?= CURRENCY ?></p>
</body>
</html>
