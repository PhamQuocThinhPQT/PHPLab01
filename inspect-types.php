<?php
/**
 * PHPLab01 - Step 2 & 3: Inspect Types & Normalization Evidence (E2)
 */

echo "==============================================================\n";
echo "   PHPLab01 - TYPE INSPECTION & NORMALIZATION EVIDENCE (E2)   \n";
echo "==============================================================\n\n";

// Require configuration & raw data
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/data/checkout-data.php';

echo "[1] RAW INPUT INSPECTION (Truoc khi casting):\n";
echo "--------------------------------------------------------------\n";
echo "Biến \$rawQuantity:\n";
echo "  - gettype(\$rawQuantity) : " . gettype($rawQuantity) . "\n";
echo "  - var_dump(\$rawQuantity) : ";
var_dump($rawQuantity);

echo "Biến \$unitPrice:\n";
echo "  - gettype(\$unitPrice)   : " . gettype($unitPrice) . "\n";
echo "  - var_dump(\$unitPrice)   : ";
var_dump($unitPrice);

echo "Biến \$productAvailable:\n";
echo "  - gettype(\$productAvailable) : " . gettype($productAvailable) . "\n";
echo "  - var_dump(\$productAvailable) : ";
var_dump($productAvailable);

echo "\n[2] NORMALIZATION / CASTING (Sau khi ep kieu tuong minh):\n";
echo "--------------------------------------------------------------\n";
$quantity = (int) $rawQuantity;
echo "Thuc hien: \$quantity = (int) \$rawQuantity;\n";
echo "  - gettype(\$quantity)    : " . gettype($quantity) . "\n";
echo "  - var_dump(\$quantity)    : ";
var_dump($quantity);

echo "\n[3] BUSINESS CONDITIONS & CALCULATIONS:\n";
echo "--------------------------------------------------------------\n";
require_once __DIR__ . '/src/checkout.php';

echo "  - \$canCheckout (Boolean)       : " . ($canCheckout ? 'true' : 'false') . "\n";
echo "  - \$subtotal (Intermediate)     : " . number_format($subtotal, 0, ',', '.') . " " . CURRENCY . "\n";
echo "  - \$isMember (Strict Equality)  : " . ($isMember ? 'true' : 'false') . "\n";
echo "  - \$isDiscountEligible (Logic)  : " . ($isDiscountEligible ? 'true' : 'false') . "\n";
echo "  - \$discount (Ternary calc)     : " . number_format($discount, 0, ',', '.') . " " . CURRENCY . "\n";
echo "  - \$packagingFee               : " . number_format($packagingFee, 0, ',', '.') . " " . CURRENCY . "\n";
echo "  - \$serviceFee                 : " . number_format($serviceFee, 0, ',', '.') . " " . CURRENCY . "\n";
echo "  - \$total Payment               : " . number_format($total, 0, ',', '.') . " " . CURRENCY . "\n";
echo "  - Order Status                 : " . ($canCheckout ? "READY TO ORDER" : "BLOCKED") . "\n";

echo "\n==============================================================\n";
echo "   KET QUA: PHP CLI chay thanh cong, khong co Parse Error!    \n";
echo "==============================================================\n";
