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