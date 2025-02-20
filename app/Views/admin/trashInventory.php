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

<<<<<<< HEAD
    <div class="container">
    <form action="<?= base_url('admin/create')?>" method="post" enctype="multipart/form-data">
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
=======
    <button type="submit">save</button>
    </form>

>>>>>>> b140ca20ddbc9208c64652211f5f12519af1be6e
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
                        <a class="edit-btn" href="<?= base_url('admin/viewEdit/' .$inv['id'])?>"
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

    <script>
        document.getElementById('trashForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            const trashId = document.getElementById('trashId').value;
            const url = trashId ? '<?= base_url('admin/update') ?>/' + trashId : '<?= base_url('admin/create') ?>';

            fetch('<?= base_url('admin/edit') ?>' , {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id','name','type','points=' + encodeURIComponent('id','name','type','points')
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Trash item saved successfully');
                    location.reload();
                } else {
                    alert('Failed to save trash item');
                    console.error('Error:', data);
                }
            })
            .catch(error => console.error('Error:', error));
        });

        function editTrash(id, name, type, points) {
            document.getElementById('trashId').value = id;
            document.getElementById('trashName').value = name;
            document.getElementById('trashType').value = type;
            document.getElementById('points').value = points;
        }

        function deleteTrash(id) {
            if (!confirm("Are you sure you want to delete this item?")) return;

            fetch('<?= base_url('admin/delete') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id=' + encodeURIComponent(id)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('trash-' + id).remove();
                    alert('Trash item deleted successfully!');
                } else {
                    alert('Failed to delete trash item.');
                    console.error('Error:', data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting.');
            });
        }
    </script>

</body>
</html>
