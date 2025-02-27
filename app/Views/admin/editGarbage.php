<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trash Sorting</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <script src="https://unpkg.com/html5-qrcode"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            text-align: center;
            background-image: url('<?= base_url('images/systemBg.png') ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: rgba(255, 255, 255, 0.3);
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 10;
            border-bottom: 2px solid rgba(255, 255, 255, 0.5);
        }
        .logo img {
            height: 50px;
        }
        .profile-logo {
            height: 50px;
        }
        .container {
            max-width: 500px;
            width: 100%;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 15px;
            padding: 30px;
            backdrop-filter: blur(10px);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.25);
            margin-top: 80px;
        }
        input, select, button {
            padding: 10px;
            width: 100%;
            margin-top: 10px;
            border-radius: 10px;
            font-size: 16px;
        }
        button {
            background: linear-gradient(45deg, rgb(17, 173, 113), rgb(228, 112, 199));
            border: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        .table-container {
            margin-top: 20px;
        }
        table {
            width: 100%;
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
        .edit-btn {
            background-color: #ffc107;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .delete-btn {
            background-color: #dc3545;
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <img src="<?= base_url('images/systemlogo.png') ?>" alt="Trash to Rice Logo" />
        </div>
        <a data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
            <img src="<?= base_url('/images/logo/profile-logo.png') ?>" alt="profile-logo" class="profile-logo">
        </a>
    </div>
    
  <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header bg-primary text-white">
    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Menu</h5>
    <button type="button" class="btn-close text-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="list-group">
      <li class="list-group-item">
        <a href="/home" class="text-decoration-none text-dark">
          🏠 Home
        </a>
      </li>
      <li class="list-group-item">
        <a href="/inventory" class="text-decoration-none text-dark">
          📦 Inventory
        </a>
      </li>
      <li class="list-group-item">
        <a href="/applicants" class="text-decoration-none text-dark">
          📋 Applicant Details
        </a>
      </li>
    </ul>
  </div>
</div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
