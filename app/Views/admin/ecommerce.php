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
<body class="bg-gray-100 min-h-screen p-6">
    <div class="w-full flex items-center justify-between mb-6">
        <div class="flex items-center">
            <a href="/home">
                <img src="<?= base_url('/images/systemlogo.png') ?>" alt="Logo" class="w-16 h-16 mr-4 rounded">
            </a>
            <h1 class="text-3xl font-bold text-black">Redeem Your Goods</h1>

        </div>
        <button onclick="openCustomizeModal()" class="mt-4 bg-green-500 text-white hover:bg-green-600 p-5 rounded">
        Customized Receipt
        </button>

    </div>

    <div class="text-lg font-semibold mb-4">Number Holder: <span id="name"> <?= strtoupper(esc($name)) ?></span></div>
    <div class="text-lg font-semibold mb-4">Your Points: <span id="totalPoints"><?= number_format(esc($totalPoints), 2) ?></span></div>

    <?php if (session()->getFlashdata('msg')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        <?= session()->getFlashdata('msg') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>


    <div class="flex flex-col md:flex-row gap-6">
        <!-- Left Side: Product List -->
        <div class="w-full md:w-3/4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="bg-white shadow-md rounded-lg text-center p-4">
                        <img src="<?= base_url('/images/inventory/redeemed/' . esc($product['img'])) ?>"
                             alt="<?= strtoupper(esc($product['item'])) ?>"
                             class="w-full h-40 object-cover mb-4 rounded cursor-pointer"
                             onclick="openModal('<?= base_url('/images/inventory/redeemed/' . esc($product['img'])) ?>')">
                        <h2 class="text-xl font-semibold"><?= strtoupper(esc($product['item'])) ?></h2>
                        <p class="text-gray-600 font-semibold"><?= esc($product['point_price']) ?> Points</p>
                        <p class="text-gray-600 font-bold" id="newQuantity">Stocks: <?= esc($product['quantity']) ?></p>

                        <div class="flex items-center justify-center my-4">
                            <?php if (esc($product['quantity']) != 0): ?>
                                <button onclick="changeQuantity(<?= esc($product['id']) ?>, -1)"
                                        class="bg-red-500 text-white px-3 py-1 rounded-l hover:bg-red-600">-</button>
                                <input type="number" id="quantity-<?= esc($product['id']) ?>"
                                       min="1" value="1"
                                       class="w-16 text-center border-t border-b border-gray-300">
                                <button onclick="changeQuantity(<?= esc($product['id']) ?>, 1)"
                                        class="bg-green-500 text-white px-3 py-1 rounded-r hover:bg-green-600">+</button>
                            <?php else: ?>
                                <p class="text-red-600">No available Stocks</p>
                            <?php endif; ?>
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

        <!-- Right Side: Cart -->
        <div class="md:w-1/4 bg-white shadow-lg rounded-lg p-6 sticky top-0 self-start">
            <h2 class="text-2xl font-semibold mb-4 text-center">Your Cart</h2>
            <div id="cart" class="text-black-500 text-center text-lg">Your cart is empty.</div>
            <div id="totalPrice" class="text-lg font-semibold mt-4 text-center">Total Price: 0 Points</div>
            <button id="checkoutButton"
                    onclick="checkout()"
                    class="mt-4 bg-green-500 text-white hover:bg-green-600 p-2 rounded w-full disabled:opacity-50"
                    disabled>
                Checkout
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div id="imageModal" class="modal" onclick="closeModal()">
        <img id="modalImage" src="" alt="Preview">
    </div>

    <!-- Receipt Section -->
    <div id="receipt" class="hidden">
        <div style="font-family: Arial, sans-serif; width: 200px; margin: 0 auto; text-align: center;">
            <div style="display: flex; justify-content: center;">
                <img src="<?= base_url('/images/logo/city_logo.jfif') ?>" alt="City Logo"
                     style="width: 60px; height: 60px; margin-bottom: 5px;">
                <img src="<?= base_url('/images/admin/') . session()->get('img')?>" alt="City Logo"
                     style="width: 60px; height: 60px; margin-bottom: 5px;">
            </div>

            <h2 style="font-size: 10px; border-bottom: 1px dashed #000;">ECO REDEMPTION</h2>
            <h2 style="font-size: 10px; border-bottom: 1px dashed #000;"><?= session()->get('receiptCus') !== null ? esc(session()->get('receiptCus')) : esc(session()->get('address')) ?></h2>
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
            <p style="font-size: 12px;"><strong>Current Balance:</strong> <?= number_format(esc($totalPoints), 2) ?></p>
            <p style="font-size: 12px;"><strong>Balance:</strong> <span id="receipt-total-points">0</span></p>
            <p style="font-size: 12px;">Thank you for redeeming with us!</p>
            <p style="font-size: 10px;">*** System-generated receipt ***</p>
        </div>
    </div>

    <!-- Custom Alert -->
    <div id="customAlert" class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 text-center max-w-xs">
            <p id="customAlertMessage" class="text-lg text-gray-800 mb-6" style="font-size:25px;">Message here</p>
            <button onclick="closeNoPointsAlert()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">OK</button>
        </div>
    </div>

    <!-- Custom Confirm -->
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


    <!-- Customize Receipt Modal -->
<div id="customizeModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4 text-center">Customize Receipt</h2>
        <form action="<?= base_url('customReceipt')?>" method="post">
        <label for="customMessage" class="block mb-2 font-medium">Custom Message</label>
        <!-- <input type="text" name="receiptCus"id="customMessage" class="w-full border border-gray-300 rounded p-2 mb-4" placeholder="Enter your message here"> -->

        <textarea name="receiptCus" id="customMessage" required class="w-full border border-gray-300 rounded p-2 mb-4" cols="30" rows="10"></textarea>
        
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full">
                Save
            </button>
        
        </form>
        <div class="flex justify-end space-x-2">
        <button onclick="closeCustomizeModal()" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500 w-full">
                Cancel
            </button>  
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
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('imageModal').style.display = 'none';
        }

        function addToCart(productId, productName, price, user_id) {
            const quantityInput = document.getElementById(`quantity-${productId}`);
            const quantity = parseInt(quantityInput.value);
            const totalCost = price * quantity;

            const existingItemIndex = cart.findIndex(item => item.productId === productId);

            if (existingItemIndex !== -1) {
                cart[existingItemIndex].quantity += quantity;
                cart[existingItemIndex].totalCost = cart[existingItemIndex].quantity * price;
            } else {
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
    cart.forEach((item, index) => {
        totalPrice += item.totalCost;

        cartDiv.innerHTML += `
            <div class="mb-4 border-b pb-2">
                <p class="font-semibold">${item.productName}</p>
                <div class="flex justify-center items-center gap-2 my-1">
                    <button onclick="updateItemQuantity(${index}, -1)" 
                            class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600"
                            ${item.quantity === 1 ? 'disabled class="opacity-50 cursor-not-allowed"' : ''}>
                        -
                    </button>
                    <span>${item.quantity}</span>
                    <button onclick="updateItemQuantity(${index}, 1)" 
                            class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">
                        +
                    </button>
                </div>
                <p class="text-sm text-gray-600">${item.totalCost} Points</p>
                <button onclick="removeCartItem(${index})" 
                        class="text-red-500 text-sm mt-1 hover:underline">
                    Remove
                </button>
            </div>
        `;
    });

    if (cart.length === 0) {
        cartDiv.innerHTML = 'Your cart is empty.';
        checkoutButton.disabled = true;
    } else {
        checkoutButton.disabled = false;
    }

    totalPriceDiv.innerText = `Total Price: ${totalPrice} Points`;
}



function updateItemQuantity(index, delta) {
    const item = cart[index];
    item.quantity += delta;

    if (item.quantity < 1) item.quantity = 1;  // Prevent going below 1

    item.totalCost = item.quantity * (item.totalCost / (item.quantity - delta));
    updateCartDisplay();
}

function removeCartItem(index) {
    cart.splice(index, 1);
    updateCartDisplay();
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
                document.getElementById('customConfirm').classList.remove('hidden');
            } else {
                showNoPointsAlert('Not enough points!');
            }

            cart.length = 0;
            updateCartDisplay();
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
                        document.getElementById('totalPoints').innerText = points;
                        const receiptItems = document.getElementById('receipt-items');
                        const receiptTotal = document.getElementById('receipt-total');
                        receiptItems.innerHTML = '';
                        cart.forEach(item => {
                            receiptItems.innerHTML += `<tr><td>${item.productName}</td><td>${item.quantity}</td><td>${item.totalCost}</td></tr>`;
                        });
                        receiptTotal.innerText = totalPrice;
                        document.getElementById('receipt-total-points').innerText = points;
                        updateCartDisplay();
                        document.getElementById('receipt').classList.remove('hidden');
                        window.print();
                        document.getElementById('receipt').classList.add('hidden');
                        alert('Redemption successful!');
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


        function openCustomizeModal() {
    document.getElementById('customizeModal').classList.remove('hidden');
}

function closeCustomizeModal() {
    document.getElementById('customizeModal').classList.add('hidden');
}

function saveCustomMessage() {
    const message = document.getElementById('customMessage').value.trim();
    if (message !== "") {
        const messageContainer = document.createElement('p');
        messageContainer.innerText = message;
        messageContainer.style.fontSize = '12px';
        messageContainer.style.textAlign = 'center';
        messageContainer.style.marginTop = '10px';

        const receipt = document.getElementById('receipt');
        receipt.appendChild(messageContainer);
    }

    closeCustomizeModal();
}


const textarea = document.getElementById("customMessage");
  textarea.addEventListener("input", function () {
    if (textarea.value.length < 3) {
      textarea.setCustomValidity("Please enter at least 3 characters.");
    } else {
      textarea.setCustomValidity("");
    }
  });
    </script>
</body>
</html>
