<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <script src="\js\admin\include\jquery.min.js"></script>

    <title>Inventory</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }
    
    body {
      background: url('<?= base_url('images/systemBg.png') ?>') no-repeat center center/cover;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      color: purple;
      background-color: rgba(255, 255, 255, 0.9);
      position: fixed;
      width: 100%;
      top: 0;
      left: 0;
      z-index: 1000;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .logo img {
      height: 40px;
    }

    .nav-links a {
      color: purple;
      text-decoration: none;
      margin: 0 15px;
      font-weight: bold;
      transition: color 0.3s ease;
    }

    .nav-links a:hover {
      color: #d63384;
    }

    .profile-logo {
      height: 40px;
      border-radius: 50%;
    }

    .container {
      margin-top: 80px;
      width: 100%;
      max-width: 1200px;
      background: rgba(255, 255, 255, 0.9);
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    table {
      border-radius: 10px;
      overflow: hidden;
      font-size:20px;
    }

    table tbody{
        font-size:23px;
    }

    img .img-table{
        height:25px;
        width:25px;
    }

     .img-table {
        height: 100px;
        width: 100px;
        cursor: pointer;
    }
    @media (max-width: 768px) {
      .nav-links {
        flex-direction: column;
        text-align: center;
      }

      .nav-links a {
        display: block;
        margin: 5px 0;
      }

      .container {
        padding: 10px;
      }
    }
</style>
<body>
<div class="navbar">
  <a href="/home">
    <div class="logo">
        <img src="<?= base_url('images/systemlogo.png') ?>" alt="Logo">
    </div>
    </a>
    <a data-bs-toggle="offcanvas" href="#offcanvasExample">
        <img src="<?= base_url('/images/logo/profile-logo.png')?>" alt="Profile" class="profile-logo">
    </a>
</div>

<div class="container">

    <table class="table table-striped table-hover table-bordered">
        <thead class="table-dark">
            <tr>
            <th>Client Name</th>
                <th>Staff Name</th>
                <th>Product Redeem</th>
                <!-- <th>Quantity</th> -->
                <th>Points Use</th>
                <th>Date Redeem</th>
                
            </tr>
        </thead>
        <?php foreach($redeem as $rdm):?>
        <tbody>
        <tr>
            <td><?= $rdm['firstName'] . ' '.  $rdm['lastName']?></td>
            <td><?= $rdm['userName']?></td>
            <td><?= $rdm['item']?></td>
            <td><?= $rdm['points_used']?></td>
            <td><?= $rdm['created_at']?></td>
        </tr>
        </tbody>
        <?php endforeach;?>
    </table>
</div>


<nav>
    <ul class="pagination" id="pagination"></ul>
</nav>
    <script src="/js/admin/include/jquery/jsquery.min.js"></script>
    <script src="/js/admin/include/bootstrap/bootstrap.bundle.min.js"></script>

</body>
</html>
