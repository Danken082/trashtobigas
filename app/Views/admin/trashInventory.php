<!-- trash_sorting.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trash Sorting</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            display: inline-block;
            width: 50%;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        input, select, button {
            padding: 8px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background: #28a745;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #218838;
        }

        /* Table Styles */
        .table-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        table {
            width: 45%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color:rgb(6, 83, 30);
            color: white;
        }

        td img {
            width: 50px;
            height: 50px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        /* Buttons */
        .edit-btn, .delete-btn {
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            transition: 0.3s;
            display: inline-block;
            margin: 3px;
        }

        .edit-btn {
            background-color: #ffc107;
            color: black;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }

        .edit-btn:hover {
            background-color: #e0a800;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        /* Responsive Design */
        @media (max-width: 750px) {
            .container {
                width: 90%;
            }

            table {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="<?= base_url('admin/create') ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" id="trashId" name="trashId">
            <input type="text" placeholder="Trash Name" name="trashName" id="trashName" required>
            <select name="trashType" id="trashType" required>
                <option value="Recyclable">Recyclable</option>
                <option value="Biodegradable">Biodegradable</option>
            </select>
            <input type="file" accept="image/*" name="trashPicture" id="trashPicture">
            <div class="points-container">
                <label for="points">Points: </label>
                <input type="number" id="points" name="points" value="0" min="0" required>
            </div>
            <button type="submit">Save</button>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr><th colspan="5">Recyclable Trash</th></tr>
                <tr><th>Name</th><th>Type</th><th>Picture</th><th>Points</th><th>Actions</th></tr>
            </thead>    
            <tbody>
                <?php foreach ($Inv as $inv): ?>
                    <?php if ($inv['trashType'] === 'Recyclable'): ?>
                        <tr id="trash-<?= $inv['id'] ?>">
                            <td><?= $inv['trashName'] ?></td>
                            <td><?= $inv['trashType'] ?></td>
                            <td><img src="<?= base_url('uploads/' . $inv['trashPicture']) ?>" width="50"></td>
                            <td><?= $inv['points'] ?></td>
                            <td>
                                <a class="edit-btn" href="<?= base_url('admin/viewEdit/' .$inv['id'])?>"
                                   onclick="return confirm('Are you sure you want to edit this item?');">Edit</a>
                                <a class="delete-btn" href="<?= base_url('admin/delete/' .$inv['id'])?>"
                                   onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <table>
            <thead>
                <tr><th colspan="5">Biodegradable Trash</th></tr>
                <tr><th>Name</th><th>Type</th><th>Picture</th><th>Points</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php foreach ($Inv as $inv): ?>
                    <?php if ($inv['trashType'] === 'Biodegradable'): ?>
                        <tr id="trash-<?= $inv['id'] ?>">
                            <td><?= $inv['trashName'] ?></td>
                            <td><?= $inv['trashType'] ?></td>
                            <td><img src="<?= base_url('uploads/' . $inv['trashPicture']) ?>" width="50"></td>
                            <td><?= $inv['points'] ?></td>
                            <td>
                                <a class="edit-btn" href="<?= base_url('admin/viewEdit/' .$inv['id'])?>"
                                   onclick="return confirm('Are you sure you want to edit this item?');">Edit</a>
                                <a class="delete-btn" href="<?= base_url('admin/delete/' .$inv['id'])?>"
                                   onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
