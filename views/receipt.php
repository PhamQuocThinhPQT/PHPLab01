<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCafe Billing</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 40px;
            display: flex;
            justify-content: center;
        }
        .receipt-card {
            background: #fff;
            padding: 28px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            width: 380px;
            border: 1px solid #e1e4e8;
        }
        .receipt-header {
            text-align: center;
            border-bottom: 2px dashed #d1d5db;
            padding-bottom: 16px;
            margin-bottom: 20px;
        }
        .receipt-header h1 {
            margin: 0;
            font-size: 24px;
            color: #1f2937;
        }
        .receipt-header p {
            margin: 4px 0 0;
            color: #6b7280;
            font-size: 13px;
        }
        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
            color: #374151;
        }
        .item-row.bold {
            font-weight: 600;
        }
        .divider {
            border-top: 1px solid #e5e7eb;
            margin: 16px 0;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            font-weight: bold;
            color: #111827;
            margin-top: 10px;
        }
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
            margin-top: 18px;
        }
        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
        }
        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <div class="receipt-card">
        <div class="receipt-header">
            <h1>SmartCafe</h1>
            <p>Order Receipt & Billing Details</p>
        </div>
        
        <div class="item-row">
            <span>Product</span>
            <strong><?= $productName ?></strong>
        </div>
        <div class="item-row">
            <span>Unit Price</span>
            <span><?= number_format($unitPrice, 0, ',', '.') ?> <?= CURRENCY ?></span>
        </div>
        <div class="item-row">
            <span>Quantity</span>
            <span>x<?= $quantity ?></span>
        </div>
        <div class="item-row">
            <span>Member Status</span>
            <span><?= $memberStatus ?></span>
        </div>
        
        <div class="divider"></div>
        
        <div class="item-row">
            <span>Subtotal</span>
            <span><?= number_format($subtotal, 0, ',', '.') ?> <?= CURRENCY ?></span>
        </div>
        <div class="item-row">
            <span>Discount (<?= $isDiscountEligible ? (MEMBER_DISCOUNT_RATE * 100) . '%' : '0%' ?>)</span>
            <span style="color: #059669;">-<?= number_format($discount, 0, ',', '.') ?> <?= CURRENCY ?></span>
        </div>
        <div class="item-row">
            <span>Packaging Fee</span>
            <span>+<?= number_format($packagingFee, 0, ',', '.') ?> <?= CURRENCY ?></span>
        </div>
        <div class="item-row">
            <span>Service Fee (<?= (SERVICE_RATE * 100) ?>%)</span>
            <span>+<?= number_format($serviceFee, 0, ',', '.') ?> <?= CURRENCY ?></span>
        </div>
        
        <div class="divider"></div>
        
        <div class="total-row">
            <span>Total Payment</span>
            <span><?= number_format($total, 0, ',', '.') ?> <?= CURRENCY ?></span>
        </div>
        
        <div class="badge <?= $canCheckout ? 'badge-success' : 'badge-danger' ?>">
            Status: <?= $canCheckout ? "READY TO ORDER" : "BLOCKED" ?>
        </div>
    </div>
</body>
</html>