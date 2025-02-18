<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Display</title>
    <style>
        body {
            background-color: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        .container {
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            width: 300px;
            text-align: center;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 15px;
        }
        .item {
            font-size: 18px;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding: 8px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>POS Trash Items</h1>
        <div>
            <?php foreach($trsh as $trsh): ?>
                <p class="item">
                    <?= htmlspecialchars($trsh['trashName']) ?>
                </p>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
