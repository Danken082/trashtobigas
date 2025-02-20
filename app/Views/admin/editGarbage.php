<!-- trash_sorting.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trash Sorting</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 45%; border-collapse: collapse; margin: 20px; float: left; }
        th, td { border: 1px solid black; padding: 10px; text-align: center; }
        th { background-color: #f2f2f2; }
        .container { margin-bottom: 20px; }
        .points-container input { width: 60px; text-align: center; }
        .button-container button { margin: 5px; }
        .edit-btn { background-color: yellow; }
        .delete-btn { background-color: red; color: white; }
    </style>
</head>
<body>

    <div class="container">
        <form action="<?= base_url('admin/edit/' .$edittrsh['id'])?>" method="post"enctype="multipart/form-data">
            <input type="hidden" id="trashId" name="trashId">
            <input type="text" placeholder="Trash Name" name="trashName" id="trashName" value="<?= $edittrsh['trashName']?>" required>
            <select name="trashType" id="trashType" required>
                <option value="<?= $edittrsh['trashType']?>" selected><?= $edittrsh['trashType']?></option>
                <option value="Recyclable">Recyclable</option>
                <option value="Biodegradable">Biodegradable</option>
            </select>
            <input type="file" accept="image/*" name="trashPicture" value="<?= $edittrsh['trashPicture']?>" id="trashPicture">
            <div class="points-container">
                <label for="points">Points: </label>
                <input type="number" id="points" name="points" value="<?= $edittrsh['points']?>" min="0" required>
            </div>
            <button type="submit">update</button>
        </form>
    </div>

    <div>
        <table>
            <thead>
                <tr><th colspan="5">Recyclable Trash</th></tr>
                <tr><th>Name</th><th>Type</th><th>Picture</th><th>Points</th><th>Actions</th></tr>
            </thead>
            <tbody id="recyclableTrashList">
                <?php foreach ($Inv as $inv): ?>
                    <?php if ($inv['trashType'] === 'Recyclable'): ?>
                        <tr id="trash-<?= $inv['id'] ?>">
                            <td><?= $inv['trashName'] ?></td>
                            <td><?= $inv['trashType'] ?></td>
                            <td><img src="<?= base_url('admin/edit/' . $inv['trashPicture']) ?>" width="50"></td>
                            <td><?= $inv['points'] ?></td>
                            <td>
                            <a class="edit-btn" href="<?= base_url('admin/viewEdit/' .$inv['id'])?>"
                            onclick="return confirm('Are you sure you want to edit this item?');">Edit</a>
                                <a class="delete-btn" href="<?= base_url('admin/delete/' .$inv['id'])?>"   onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
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
            <tbody id="biodegradableTrashList">
                <?php foreach ($Inv as $inv): ?>
                    <?php if ($inv['trashType'] === 'Biodegradable'): ?>
                        <tr id="trash-<?= $inv['id'] ?>">
                            <td><?= $inv['trashName'] ?></td>
                            <td><?= $inv['trashType'] ?></td>
                            <td><img src="<?= base_url('uploads/' . $inv['trashPicture']) ?>" width="50"></td>
                            <td><?= $inv['points'] ?></td>
                            <td>
                             <!--<button class="edit-btn" onclick="editTrash(<?= $inv['id'] ?>, '<?= $inv['trashName'] ?>', '<?= $inv['trashType'] ?>', <?= $inv['points'] ?>)">Edit</button>-->
                        <a class="edit-btn" href="<?= base_url('admin/edit/' .$inv['id'])?>"
                          onclick="return confirm('Are you sure you want to edit this item?');">Edit</a>
                             <!-- <button class="delete-btn" onclick="deleteTrash()">Delete</button> -->
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
