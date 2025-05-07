<?php date_default_timezone_set('Asia/Manila');?>

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redeem Goods</title>
    <link rel="stylesheet" href="/css/tailwind.min.css">
    <style>
        body {
            background-image: url('<?= base_url("images/systemBg.png") ?>');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
        }
        h1 {
            font-size: 48px;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .user-points {
            font-size: 28px;
            margin-bottom: 30px;
            text-align: center;
        }
        .product-card {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.2s ease-in-out;
        }
        .product-card:hover {
            transform: scale(1.02);
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
        }
        .product-card h2 {
            font-size: 24px;
            margin: 10px 0;
        }
        .product-card p {
            font-size: 20px;
            color: #555;
        }
        input[type="number"] {
            width: 100%;
            padding: 8px;
            font-size: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            text-align: center;
        }
        .btn-primary {
            background-color: #007BFF;
            color: #fff;
            padding: 12px;
            font-size: 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
        .cart-section {
            margin-top: 40px;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            align-items: center;
            justify-content: center;
        }
        .modal img {
            max-width: 90%;
            max-height: 90%;
            border-radius: 10px;
        }
        @media print {
            body * {
                display: none;
            }
            #receipt, #receipt * {
                display: block;
            }
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center p-6 min-h-screen">
<div class="w-full flex items-center justify-between mb-6">
    <div class="flex items-center">
        <a href="/home">
        <img src="<?= base_url('/images/systemlogo.png') ?>" alt="Logo" class="w-16 h-16 mr-4 rounded">
        </a>


        <h1 class="text-3xl font-bold text-black">Redeem Your Goods</h1>
    </div>
</div>

    <div class="text-lg font-semibold mb-4">Number Holder:<span id="name"> <?= strtoupper(esc($name)) ?></span></div>
    <div class="text-lg font-semibold mb-4">Your Points: <span id="totalPoints"><?= number_format(esc($totalPoints), 2) ?></span></div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-4xl">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="p-4 bg-white shadow-md rounded-lg text-center">
                    <img src="<?= base_url('/images/inventory/redeemed/' . esc($product['img'])) ?>" alt="<?= strtoupper(esc($product['item'])) ?>" class="w-full h-40 object-cover mb-4 rounded cursor-pointer" onclick="openModal('<?= base_url('/images/inventory/redeemed/' . esc($product['img'])) ?>')">
                    <h2 class="text-xl font-semibold"> <?= strtoupper(esc($product['item'])) ?> </h2>
                    <p class="text-gray-600 font-semibold"> <?= esc($product['point_price']) ?> Points</p>
                    <p class="text-gray-600 font-bold" id="newQuantity">Stocks: <?= esc($product['quantity']) ?></p>
                    
                    <div class="flex items-center justify-center my-4">

                <?php if(esc($product['quantity']) != 0):?>
        <button onclick="changeQuantity(<?= esc($product['id']) ?>, -1)" 
                class="bg-red-500 text-white px-3 py-1 rounded-l hover:bg-red-600">
            -
        </button>
        <input type="number" id="quantity-<?= esc($product['id']) ?>" 
               min="1" value="1" 
               class="w-16 text-center border-t border-b border-gray-300">
        <button onclick="changeQuantity(<?= esc($product['id']) ?>, 1)" 
                class="bg-green-500 text-white px-3 py-1 rounded-r hover:bg-green-600">
            +
        </button>

        <?php else:?>
            <p class="text-gray-600" style="color:red;">No available Stocks</p>

            <?php endif;?>
    </div>
         <button class="mt-2 w-full bg-blue-500 text-white hover:bg-blue-600 p-2 rounded" 
                            onclick="addToCart(<?= esc($product['id']) ?>, '<?= esc($product['item']) ?>', <?= esc($product['point_price']) ?>, '<?= esc($user_id) ?>')">
                        Add to Cart
                    </button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500">No products available.</p>
        <?php endif; ?>
    </div>
    <!-- Cart Section -->
<div class="fixed top-10 right-10 bg-white shadow-lg rounded-lg p-10 w-80">
    <h2 class="text-2xl font-semibold mb-4 text-center">Your Cart</h2>
    <div id="cart" class="text-black-500 text-center" style="font-size:20px;">Your cart is empty.</div>
    <div id="totalPrice" class="text-lg font-semibold mt-4 text-center">Total Price: 0 Points</div>
    <button id="checkoutButton" 
            onclick="checkout()" 
            class="mt-4 bg-green-500 text-white hover:bg-green-600 p-2 rounded w-full disabled:opacity-50"
            disabled>
        Checkout
    </button>
</div>
 <div id="imageModal" class="modal" onclick="closeModal()">
        <img id="modalImage" src="" alt="Preview">
    </div>

    
    <!-- Receipt Section (Hidden until printing) -->
   <!-- Receipt Section (Hidden until printing) -->
   <div id="receipt" class="hidden">
    <div style="font-family: Arial, sans-serif; width: 200px; margin: 0 auto; text-align: center;">
    <div style="display: flex; justify-content: center;">
    <img src="<?= base_url('/images/logo/city_logo.jfif') ?>" alt="City Logo"
        style="width: 60px; height: 60px; margin-bottom: 5px;">
    <img src="<?= base_url('/images/admin/') . session()->get('img')?>" alt="City Logo"
        style="width: 60px; height: 60px; margin-bottom: 5px;">
</div>

        <h2 style="font-size: 10px; border-bottom: 1px dashed #000;">
            ECO REDEMPTION
        </h2>
        <p style="font-size: 12px;">Date: <?= date('Y-m-d H:i:s', time()) ?></p>
        <p style="font-size: 12px;">Receipt #: <?= uniqid() ?></p>
        <hr style="border: 0; border-bottom: 1px dashed #000;">

        <table style="width: 100%; font-size: 12px; text-align: left; margin-bottom: 10px;">
            <thead>
                <tr>
                    <th style="border-bottom: 1px dashed #000;">Item</th>
                    <th style="border-bottom: 1px dashed #000;">Qty</th>
                    <th style="border-bottom: 1px dashed #000;">Pts</th>
                </tr>
            </thead>
            <tbody id="receipt-items"></tbody>
        </table>

        <hr style="border: 0; border-bottom: 1px dashed #000;">
        <p style="font-size: 12px;"><strong>Total Redeem Points:</strong> <span id="receipt-total">0</span></p>
        <p style="font-size: 12px;"><strong>Current Points:</strong><?= number_format(esc($totalPoints), 2) ?></p> 
        <p style="font-size: 12px;"><strong>Total New Points:</strong> <span id="receipt-total-points">0</span></p>
        <p style="font-size: 12px;">Thank you for redeeming with us!</p>
        <p style="font-size: 10px;">*** System-generated receipt ***</p>
    </div>
</div>


<div id="customAlert" class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 text-center max-w-xs">
        <p id="customAlertMessage" class="text-lg text-gray-800 mb-6" style="font-size:25px;">Message here</p>
        <button onclick="closeNoPointsAlert()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">OK</button>
    </div>
</div>

<div id="customConfirm" class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 text-center max-w-sm">
        <p class="text-lg text-gray-800 mb-6" id="customConfirmMessage" style="font-size:22px;">
            Are you sure you want to redeem these products?
        </p>
        <div class="flex justify-center gap-4">
            <button onclick="confirmCheckout()" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Yes</button>
            <button onclick="cancelCheckout()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">No</button>
        </div>
    </div>
</div>
 

    <script>
        let points = <?= json_encode($totalPoints) ?>;
        let cart = [];

        function changeQuantity(productId, amount) {
    const quantityInput = document.getElementById(`quantity-${productId}`);
    let currentValue = parseInt(quantityInput.value);

    if (isNaN(currentValue)) currentValue = 1;

    const newValue = currentValue + amount;

    if (newValue >= 1) {
        quantityInput.value = newValue;
    }
}


        function openModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imageSrc;
            modal.style.display = 'flex';
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.style.display = 'none';
        }

     function addToCart(productId, productName, price, user_id) {
    const quantityInput = document.getElementById(`quantity-${productId}`);
    const quantity = parseInt(quantityInput.value);
    const totalCost = price * quantity;

    const existingItemIndex = cart.findIndex(item => item.productId === productId);

    if (existingItemIndex !== -1) {
        // Product already in cart, update quantity and totalCost
        cart[existingItemIndex].quantity = parseInt(cart[existingItemIndex].quantity) + quantity;
        cart[existingItemIndex].totalCost = cart[existingItemIndex].quantity * price;
    } else {
        // New product, add to cart
        cart.push({ productId, productName, quantity, totalCost, user_id });
    }

    updateCartDisplay();
}


        function updateCartDisplay() {
            const cartDiv = document.getElementById('cart');
            const totalPriceDiv = document.getElementById('totalPrice');
            const checkoutButton = document.getElementById('checkoutButton');
            cartDiv.innerHTML = '';

            let totalPrice = 0;
            cart.forEach(item => {
                cartDiv.innerHTML += `<p>${item.productName} x${item.quantity} - ${item.totalCost} Points</p>`;
                totalPrice += item.totalCost;
            });

            if (cart.length === 0) {
                cartDiv.innerHTML = 'Your cart is empty.';
                checkoutButton.disabled = true;
                checkoutButton.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                checkoutButton.disabled = false;
                checkoutButton.classList.remove('opacity-50', 'cursor-not-allowed');
            }

            totalPriceDiv.innerText = `Total Price: ${totalPrice} Points`;
        }

        function showNoPointsAlert(message) {
                document.getElementById('customAlertMessage').innerText = message;
                document.getElementById('customAlert').classList.remove('hidden');
            }

            function closeNoPointsAlert() {
                document.getElementById('customAlert').classList.add('hidden');
            }


            function checkout() {
    if (cart.length === 0) {
        alert('Your cart is empty!');
        return;
    }

    const totalPrice = cart.reduce((sum, item) => sum + item.totalCost, 0);

    if (points >= totalPrice) {
        // Show custom confirmation modal
        document.getElementById('customConfirm').classList.remove('hidden');
    } else {
        showNoPointsAlert('Not enough points!');
    }
}


function confirmCheckout() {
    document.getElementById('customConfirm').classList.add('hidden');

    const totalPrice = cart.reduce((sum, item) => sum + item.totalCost, 0);

    fetch('/redeem', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ cart })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            points = data.new_points;
            newQty = data.quantity;
            document.getElementById('totalPoints').innerText = points;
            document.getElementById('newQuantity').innerText = newQty;

            const receiptItems = document.getElementById('receipt-items');
            const receiptTotal = document.getElementById('receipt-total');
            receiptItems.innerHTML = '';

            cart.forEach(item => {
                receiptItems.innerHTML += `
                    <tr>
                        <td>${item.productName}</td>
                        <td>${item.quantity}</td>
                        <td>${item.totalCost}</td>
                    </tr>`;
            });

            receiptTotal.innerText = totalPrice;
            document.getElementById('receipt-total-points').innerText = points;
            updateCartDisplay();
            document.getElementById('receipt').classList.remove('hidden');
            window.print();
            document.getElementById('receipt').classList.add('hidden');
            alert('Redemption successful!');
            // window.location.href = '/home';
            cart = [];
        } else {
            alert('Redemption failed: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function cancelCheckout() {
    document.getElementById('customConfirm').classList.add('hidden');
}

    </script>
</body>
</html>

