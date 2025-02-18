<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
    <form action="<?= base_url('/insertTrash')?>" method="post" enctype="multipart/form-data">
    <input type="text" placeholder="Trash Name" name="trashName">
    <input type="text" placeholder="Trash Type" name="trashType">
    <input type="file"  accept="image/*" name="trashPicture">

    <button type="submit">save</button>
    </form>
    <!-- <input type="text">
    <input type="text"> -->
    </div>
</body>
</html>