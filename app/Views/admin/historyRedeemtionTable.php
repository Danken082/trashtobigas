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

.table-responsive {
  overflow-x: auto;
}

table td, table th {
  word-wrap: break-word;
  word-break: break-word;
  white-space: normal;
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
    <img src="<?= base_url('/images/admin/') . session()->get('img')?>" alt="profile-logo" class="profile-logo">
    </a>
</div>

<div class="container">

<div class="d-flex justify-content-between mb-3">
        <div>
          <label for="Filter Date">Filter Date:</label>
            <input type="date" id="filter-date" class="form-control" style="font-size: 20px; display: inline-block; width: auto;">
            <input type="text" id="search-name" class="form-control mt-2" placeholder="Search by client name" style="font-size: 20px;">
        </div>
        <div class="align-self-end">
        <!-- Hidden export button to trigger download -->
    <a id="export-link"  class="btn btn-success" style="font-size: 18px;">Export to Excel</a>

        </div>
    </div>
    <div class="table-responsive">
    <p style="font-size:20px;">Total Redeemed: <?= $countHistory?> </p>
  <table class="table table-striped table-hover table-bordered" id="history-table">
    <thead class="table-dark">
      <tr>
        <th>Client Name</th>
        <th>Staff Username</th>
        <th>Address</th>
        <th>Gather Points</th>
        <th>Current Points</th>
        <th>Weight</th>
        <th>Cathegory</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($history as $hst): ?>
      <tr>
        <td><?= $hst['firstName'] . ' ' . $hst['lastName']?></td>
        <td><?= $hst['userName']?></td>
        <td><?= $hst['address']?></td>
        <td><?= $hst['gatherPoints']?></td>
        <td><?= $hst['totalCurrentPoints']?></td>
        <td><?= $hst['weight']?></td>
        <td><?= $hst['categ']?></td>
        <td data-date="<?= date('Y-m-d', strtotime($hst['created_at'])) ?>">
          <?= date('F j, Y g:i A', strtotime($hst['created_at'])) ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<nav>
  <ul class="pagination justify-content-center" id="pagination"></ul>
</nav>



    <script src="/js/admin/include/jquery/jsquery.min.js"></script>
    <script src="/js/admin/include/bootstrap/bootstrap.bundle.min.js"></script>

    <script>

      //for exporting report 
      $('#export-link').on('click', function(e) {
        e.preventDefault();
        const selectedDate = $('#filter-date').val();
        const exportUrl = "<?= base_url('report/export') ?>?date=" + selectedDate;
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


$(document).ready(function () {
    const rowsPerPage = 5;
    const rows = $('#history-table tbody tr');
    const rowsCount = rows.length;
    const pageCount = Math.ceil(rowsCount / rowsPerPage);
    const pagination = $('#pagination');

    function displayRows(page) {
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        rows.hide();
        rows.slice(start, end).show();
    }

    function generatePagination() {
        pagination.empty();
        for (let i = 1; i <= pageCount; i++) {
            pagination.append(
                `<li class="page-item"><a class="page-link" href="#">${i}</a></li>`
            );
        }

        pagination.find('li:first').addClass('active');

        pagination.find('a').on('click', function (e) {
            e.preventDefault();
            const page = parseInt($(this).text());

            pagination.find('li').removeClass('active');
            $(this).parent().addClass('active');

            displayRows(page);
        });
    }

    // Initialize
    displayRows(1);
    generatePagination();
});
</script>




</body>
</html>
