<?php
/**
 * PHPLab01 - Step 7 & Evidence E5: Test Data Matrix Runner
 */

require_once __DIR__ . '/config/constants.php';

$testCases = [
    [
        'id' => 'T1',
        'name' => 'Happy path',
        'description' => 'Du dieu kien member & vuot nguong 100k',
        'input' => [
            'productName' => 'Salt Coffee',
            'unitPrice' => 45000,
            'rawQuantity' => '3',
            'memberStatus' => 'MEMBER',
            'productAvailable' => true
        ],
        'expected' => [
            'quantity' => 3,
            'canCheckout' => true,
            'subtotal' => 135000,
            'discount' => 13500,
            'packagingFee' => 15000,
            'serviceFee' => 6075,
            'total' => 142575,
            'status' => 'READY TO ORDER'
        ]
    ],
    [
        'id' => 'T2',
        'name' => 'No benefit',
        'description' => 'Khach GUEST, khong du nguong chiet khau',
        'input' => [
            'productName' => 'Salt Coffee',
            'unitPrice' => 45000,
            'rawQuantity' => '1',
            'memberStatus' => 'GUEST',
            'productAvailable' => true
        ],
        'expected' => [
            'quantity' => 1,
            'canCheckout' => true,
            'subtotal' => 45000,
            'discount' => 0,
            'packagingFee' => 5000,
            'serviceFee' => 2250,
            'total' => 52250,
            'status' => 'READY TO ORDER'
        ]
    ],
    [
        'id' => 'T3',
        'name' => 'Boundary',
        'description' => 'Dung tai nguong threshold (subtotal = 100.000)',
        'input' => [
            'productName' => 'Salt Coffee',
            'unitPrice' => 50000,
            'rawQuantity' => '2',
            'memberStatus' => 'MEMBER',
            'productAvailable' => true
        ],
        'expected' => [
            'quantity' => 2,
            'canCheckout' => true,
            'subtotal' => 100000,
            'discount' => 10000,
            'packagingFee' => 10000,
            'serviceFee' => 4500,
            'total' => 104500,
            'status' => 'READY TO ORDER'
        ]
    ],
    [
        'id' => 'T4',
        'name' => 'Blocked',
        'description' => 'San pham het hang hoac so luong = 0',
        'input' => [
            'productName' => 'Salt Coffee',
            'unitPrice' => 45000,
            'rawQuantity' => '0',
            'memberStatus' => 'MEMBER',
            'productAvailable' => false
        ],
        'expected' => [
            'quantity' => 0,
            'canCheckout' => false,
            'subtotal' => 0,
            'discount' => 0,
            'packagingFee' => 0,
            'serviceFee' => 0,
            'total' => 0,
            'status' => 'BLOCKED'
        ]
    ],
];

echo "========================================================================================\n";
echo "                          PHPLab01 - TEST DATA MATRIX (E5)                              \n";
echo "========================================================================================\n\n";

$allPassed = true;

foreach ($testCases as $case) {
    // Extract input
    $productName = $case['input']['productName'];
    $unitPrice = $case['input']['unitPrice'];
    $rawQuantity = $case['input']['rawQuantity'];
    $memberStatus = $case['input']['memberStatus'];
    $productAvailable = $case['input']['productAvailable'];

    // Run business logic
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
    $status = $canCheckout ? "READY TO ORDER" : "BLOCKED";

    $exp = $case['expected'];
    $isPass = ($quantity === $exp['quantity']) &&
              ($canCheckout === $exp['canCheckout']) &&
              (abs($subtotal - $exp['subtotal']) < 0.01) &&
              (abs($discount - $exp['discount']) < 0.01) &&
              (abs($packagingFee - $exp['packagingFee']) < 0.01) &&
              (abs($serviceFee - $exp['serviceFee']) < 0.01) &&
              (abs($total - $exp['total']) < 0.01) &&
              ($status === $exp['status']);

    if (!$isPass) $allPassed = false;

    echo sprintf("[%s] %s (%s)\n", $case['id'], $case['name'], $case['description']);
    echo sprintf("  Input   : Price=%s | RawQty='%s' | Member=%s | Available=%s\n", 
        number_format($unitPrice, 0, ',', '.'), $rawQuantity, $memberStatus, $productAvailable ? 'true' : 'false');
    echo sprintf("  Expected: Subtotal=%s | Discount=%s | Total=%s | Status=%s\n",
        number_format($exp['subtotal'], 0, ',', '.'), number_format($exp['discount'], 0, ',', '.'), number_format($exp['total'], 0, ',', '.'), $exp['status']);
    echo sprintf("  Actual  : Subtotal=%s | Discount=%s | Total=%s | Status=%s\n",
        number_format($subtotal, 0, ',', '.'), number_format($discount, 0, ',', '.'), number_format($total, 0, ',', '.'), $status);
    echo sprintf("  Result  : [%s]\n", $isPass ? 'PASS' : 'FAIL');
    echo "----------------------------------------------------------------------------------------\n";
}

echo $allPassed ? ">> TAT CA 4 TEST CASES DEU PASS 100%!\n" : ">> CO TEST CASE BI LOI!\n";
echo "========================================================================================\n";
