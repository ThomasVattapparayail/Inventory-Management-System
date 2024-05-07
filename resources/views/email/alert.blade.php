<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Low Stock Alert</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .header {
            background: #ff0000;
            color: #fff;
            text-align: center;
            padding: 10px;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 20px 0;
        }
        .footer {
            text-align: center;
            color: #888;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Low Stock Alert</h1>
        </div>
        <div class="content">
            <p>Dear User,</p>
            <p>We would like to inform you that the following item is running low in stock:</p>
            <p><strong>Item Name:</strong> {{ $itemName }}</p>
            <p><strong>Quantity Left:</strong> {{ $quantity }} units</p>
            <p>Please take necessary action to restock this item as soon as possible.</p>
        </div>
        <div class="footer">
            <p>This is an automated email. Please do not reply.</p>
        </div>
    </div>
</body>
</html>
