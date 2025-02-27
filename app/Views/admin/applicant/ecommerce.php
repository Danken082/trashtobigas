<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="p-6">
    <h1 class="text-2xl font-bold mb-4">Product List</h1>

    <!-- Add New Product Button -->
    <button onclick="openModal()" class="bg-blue-500 text-white p-2 rounded">Add New Product</button>

    <!-- Modal for Adding Product -->
    <div id="productModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-md w-96">
            <h2 class="text-xl font-bold mb-4">Add New Product</h2>
            <form action="/products/store" method="post" enctype="multipart/form-data">
                <input type="text" name="productName" placeholder="Product Name" class="w-full p-2 border mb-2" required>
                <select name="category" class="w-full p-2 border mb-2">
                    <option value="Electronics">Electronics</option>
                    <option value="Clothing">Clothing</option>
                </select>
                <input type="file" name="productImage" class="w-full p-2 border mb-2" required>
                <input type="number" name="price" placeholder="Price" class="w-full p-2 border mb-2" required>
                <input type="number" name="stock" placeholder="Stock" class="w-full p-2 border mb-2" required>
                
                <div class="flex justify-between">
                    <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Add Product</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Product Table -->
    <table class="mt-4 w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Name</th>
                <th class="border p-2">Category</th>
                <th class="border p-2">Image</th>
                <th class="border p-2">Price</th>
                <th class="border p-2">Stock</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td class="border p-2"><?= $product['productName'] ?></td>
                    <td class="border p-2"><?= $product['category'] ?></td>
                    <td class="border p-2"><img src="<?= base_url('uploads/' . $product['productImage']) ?>" width="50"></td>
                    <td class="border p-2">$<?= $product['price'] ?></td>
                    <td class="border p-2"><?= $product['stock'] ?></td>
                    <td class="border p-2">
                        <a href="/products/edit/<?= $product['id'] ?>" class="bg-yellow-500 text-white p-1 rounded">Edit</a>
                        <a href="/products/delete/<?= $product['id'] ?>" class="bg-red-500 text-white p-1 rounded" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- JavaScript for Modal -->
    <script>
        function openModal() {
            document.getElementById("productModal").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("productModal").classList.add("hidden");
        }
    </script>
</body>
</html>
