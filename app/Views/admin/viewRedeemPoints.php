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
  max-width: 100%; /* changed from 1200px */
  background: rgba(255, 255, 255, 0.9);
  padding: 30px;
  border-radius: 15px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}


    table {
  border-radius: 10px;
  overflow: hidden;
  font-size: 22px; /* bigger font */
  width: 100%;
  table-layout: fixed;
}

thead th {
  font-size: 24px; /* make headers bigger */
  text-align: center;
}

table tbody {
  font-size: 22px; /* make body text bigger */
}

table td {
  font-size: 26px;
  vertical-align: middle;
  text-align: center;
  padding: 15px;
}

#filter-date,
#search-name {
  font-size: 23px;
  height: auto;
  padding: 10px 15px;
}


@media (max-width: 768px) {
  table {
    font-size: 18px;
  }

  thead th,
  tbody td {
    font-size: 18px;
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


<div class="d-flex justify-content-between mb-3">
        <div>
          <label for="filterdate">Filter Date: </label>
          <input type="date" id="filter-date" class="form-control" style="font-size: 20px; display: inline-block; width: auto;">
            <input type="text" id="search-name" class="form-control mt-2" placeholder="Search by client name" style="font-size: 20px;">
        </div>
        <div class="align-self-end">
        <!-- Hidden export button to trigger download -->
    <a id="export-link"  class="btn btn-success" style="font-size: 18px;">Export to Report</a>

        </div>
    </div>
    <table class="table table-striped table-hover table-bordered">
        <thead class="table-dark">
            <tr>
               <th>Client Name</th>
                <th>Staff Name</th>
                <th>Product Redeem</th>
                <th>Address</th>
                <th>Points Use</th>
                <th>Current Points</th>
                <th>Date Redeem</th>
                
            </tr>
        </thead>
     
        <?php if (!empty($redeem)): ?>
    <?php foreach($redeem as $rdm): ?>
        <tbody>
        <tr>
            <td><?= $rdm['firstName'] . ' ' . $rdm['lastName'] ?></td>
            <td><?= $rdm['userName'] ?></td>
            <td><?= $rdm['item'] ?></td>
            <td><?= $rdm['address'] ?></td>
            <td><?= $rdm['points_used'] ?></td>
            <td><?= $rdm['totalCurrentPoints'] ?></td>
            <td data-date="<?= date('Y-m-d', strtotime($rdm['created_at'])) ?>">
                <?= date('F j, Y g:i A', strtotime($rdm['created_at'])) ?>
            </td>
        </tr>
        </tbody>
    <?php endforeach; ?>
  <?php else: ?>
      <tbody>
          <tr>
              <td colspan="6" class="text-center">Walang laman</td>
          </tr>
      </tbody>
  <?php endif; ?>

    </table>
</div>


<nav>
    <ul class="pagination" id="pagination"></ul>
</nav>
    <script src="/js/admin/include/jquery/jsquery.min.js"></script>
    <script src="/js/admin/include/bootstrap/bootstrap.bundle.min.js"></script>

    
    <script>

$('#export-link').on('click', function(e) {
        e.preventDefault();
        const selectedDate = $('#filter-date').val();
        const exportUrl = "<?= base_url('report/redemption') ?>?date=" + selectedDate;
        window.location.href = exportUrl;
    });
        

$(document).ready(function() {
    // Set the date input to today
    const today = new Date().toISOString().split('T')[0];
    // $('#filter-date').val(today);

    function filterTable() {
        const selectedDate = $('#filter-date').val();
        const searchName = $('#search-name').val().toLowerCase();

        $('table tbody tr').each(function() {
            const row = $(this);
            const rowDate = row.find('td[data-date]').data('date');
            const clientName = row.find('td:nth-child(1)').text().toLowerCase(); // Assuming 1st column is client name

            if (searchName) {
                // If there's a name typed, ignore date filter
                if (clientName.includes(searchName)) {
                    row.show();
                } else {
                    row.hide();
                }
            } else {
                // No name typed → apply date filter only
                if (!selectedDate || rowDate === selectedDate) {
                    row.show();
                } else {
                    row.hide();
                }
            }
        });
    }

    // Initial filter on page load
    filterTable();

    // Bind events
    $('#filter-date').on('change', filterTable);
    $('#search-name').on('input', filterTable);
});
</script>

</body>
</html>
