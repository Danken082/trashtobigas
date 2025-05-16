<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Trash to Rice Exchange</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <script src="https://unpkg.com/html5-qrcode"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
    
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
      justify-content: center;
      align-items: center;
      height: 100vh;
      padding: 20px;
    }
    
    .profile-logo
    {
        right:100%;
    }
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      color: purple;
      background-color: rgba(255, 255, 255, 0.3);
      position: fixed;
      width: 100%;
      top: 0;
      left: 0;
      z-index: 10;
      border-bottom: 2px solid rgba(255, 255, 255, 0.5);
    }
    
    /* Group logo and search icon/input */
    .logo-search {
      display: flex;
      align-items: center;
      position: relative;
      cursor: pointer;
    }
    
    .logo img {
      height: 50px;
    }
    
    .search-icon {
      margin-left: 15px;
      font-size: 1.5rem;
      color: purple;
    }
    
    /* Hidden search input positioned absolutely to the right of the icon */
    .search-input {
      display: none;
      position: absolute;
      top: 60px; /* Adjust based on navbar height */
      left: 0;
      padding: 6px 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      width: 200px;
      background: #fff;
      z-index: 20;
    }
    
    /* Search result container with a top border for separation */
    #result {
      display: none;
      position: absolute;
      top: calc(60px + 40px); /* 60px from top + approx. 40px input height */
      left: 0;
      width: 200px;
      background: #fff;
      border: 1px solid #ccc;
      border-top: 1px solid #ccc; /* Separation line */
      border-radius: 0 0 5px 5px;
      z-index: 20;
      padding: 5px;
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
    
    /* Responsive Design */
    @media (max-width: 768px) {
      .container {
        width: 90%;
        padding: 20px;
      }
    
      .nav-links {
        display: flex;
        flex-direction: column;
        text-align: center;
      }
    
      .nav-links a {
        display: block;
        margin: 5px 0;
      }
    }

    .profile-logo{
        height:50px;
    }
    .left-align-button {
  position: absolute;
  left: 50px;  /* Adjust this value as needed */
  top: 200px;  /* Adjust based on your design */
}
.pagenotation-controller{
  position: fixed;
  bottom: 50px; /* Adjust the space from the bottom as needed */
  left: 50%;
  transform: translateX(-50%);
  z-index: 20;
  background-color: rgba(255, 255, 255, 0.8); /* Optional: to make it slightly transparent */
  border-radius: 5px;
  padding: 10px;
}



  </style>
</head>
<body>
    <br>  
  <div class="navbar">
    <div>
      <a href="/home">
      <div class="logo">
        <img src="<?= base_url('images/systemlogo.png') ?>" alt="Trash to Rice Logo" />
      </div>
      </a>
      <!-- Search result container -->
    </div>
    <div class="nav-links">
    <a data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
      <p><?= session()->get('userName')?></p>
      <img src="<?= base_url('/images/admin/') . session()->get('img')?>" alt="profile-logo" class="profile-logo">

</a>

      <!-- <a class="btn btn-primary mb-3 btn-register" style="background:purple;color:white;" data-bs-toggle="modal" data-bs-target="#registerModal">Register Applicant</a>
      <a href="">Home</a>
      <a href="https://cityofcalapan.gov.ph/about-calapan-city/">About</a>
      <a href="#">How It Works</a>
      <a href="#">Contact</a> -->
    </div>
  </div>
  <div class="container mt-5">
    <button class="btn btn-primary left-align-button btn-lg" data-bs-toggle="modal" data-bs-target="#saveToPoints">Add Ranges</button>

    <table border="1" class="table table-striped table-hover table-bordered" style="border-radius: 15px; overflow: hidden;">
      <thead class="table-dark">
          <tr>
              <th>Weight</th>
              <th>Category</th>
              <th>Points</th>
              <th>Action</th>
          </tr>
      </thead>
      <tbody id="adminTableBody">
      </tbody>
    </table>
  </div>

  <!-- Pagination section placed below the table -->
  <nav aria-label="Page navigation">
    <ul class="pagination" id="pagination"></ul>
  </nav>



<div class="modal fade modal-lg modal-fullscreen" id="saveToPoints" tabindex="-1" aria-labelledby="saveToPointslabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="saveToPointslabel">Pointing System</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="savePoints" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" name="id" id="itemId">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="MininumWeight" class="form-label">Minimum Weight</label>
                        <input type="number" class="form-control" name="minweight" id="minwieght" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="MaximumWeight" class="form-label">Maximum Weight</label>
                        <input type="number" class="form-control" name="maxweight" id="maxweight" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="points" class="form-label">Points</label>
                        <input type="number" class="form-control" name="points" id="points" step="any" required>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="Category">Category</label>
                      <select name="categ" class="form-control" id="categ">
                        <option disabled selected>--Select Category--</option>
                        <option value="kg/s">Kilo  Grams</option>
                        <option value="gram/s">Gram/s</option>
                      </select>
                    </div>
                    
                </div>
              </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>
</div>


<div class="modal fade modal-lg modal-fullscreen" id="editInventory" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Item</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editForm" action="<?= base_url('edit/rangespoints/')?>" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" name="id" id="id">
                <div class="row">
                <div class="col-md-6 mb-3">
                        <label for="MininumWeight" class="form-label">Minimum Weight</label>
                        <input type="number" class="form-control" name="minweight" id="min_weight" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="MaximumWeight" class="form-label">Maximum Weight</label>
                        <input type="number" class="form-control" name="maxweight" id="max_weight" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="points" class="form-label">Points</label>
                        <input type="number" class="form-control" name="points" id="point" step="any" required>
                        
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="Category">Category</label>
                      <select name="categ" class="form-control" id="categ">
                        <option disabled selected>--Select Category--</option>
                        <option value="kl">Kilo/Kilos</option>
                        <option value="gram">Gram/Grams</option>
                      </select>
                    </div>
                     </div>
              </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>
</div>



<script> 
   $(document).ready(function() {
        let currentPage = 1;
        const rowsPerPage = 6;

        function loadAdminData(page = 1) {
            $.ajax({
                url: "<?= base_url('/points') ?>",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    const start = (page - 1) * rowsPerPage;
                    const end = start + rowsPerPage;
                    const paginatedData = response.slice(start, end);

                    let tableRows = '';

                    if(paginatedData.length === 0 )
                    {
                      tableRows = `<tr>
                                <td colspan="6" class="text-center text-muted">No Range is Available.</td>
                             </tr>`;
                    }
                    else{
                      
                    $.each(paginatedData, function(index, weight) {
                        tableRows += `<tr>
                            <td>${weight.min_weight} - ${weight.max_weight}</td>
                            <td>${weight.categ}</td>
                            <td>${weight.points}</td>
                            <td>
                                <a href="#" class="btn btn-warning btn-lg" 
                                data-bs-toggle="modal" data-bs-target="#editInventory"
                                data-id="${weight.id}"
                                data-minweight="${weight.min_weight}"
                                data-maxweight="${weight.max_weight}"
                                data-points="${weight.points}">Edit</a>
                                <a href="deleteRanges/${weight.id}" onclick="return confirm('Are you sure you want to delete this item?')"class="btn btn-danger btn-lg">Delete</a>
                            </td>
                        </tr>`;
                    });
                    
                  }
                    $("#adminTableBody").html(tableRows);
                    setupPagination(response.length, page);
                }
            });
        }

        function setupPagination(totalRows, currentPage) {
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            let paginationHtml = '';

            for (let i = 1; i <= totalPages; i++) {
                paginationHtml += `<li class="page-item ${i === currentPage ? 'active' : ''} pagenotation-controller" >
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>`;
            }

            $("#pagination").html(paginationHtml);
        }

        $(document).on('click', '.page-link', function(e) {
            e.preventDefault();
            const page = parseInt($(this).data('page'));
            if (page !== currentPage) {
                currentPage = page;
                loadAdminData(page);
            }
        });

    loadAdminData();

    $("#savePoints").submit(function(event) {
        event.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: "<?= base_url('/savePoints') ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.status === "error") {
                    let errorMessage = '<div class="alert alert-danger">';
                    $.each(response.errors, function(key, value) {
                        errorMessage += `<p>${value}</p>`;
                    });
                    errorMessage += '</div>';
                    $("#alert-message").html(errorMessage);
                } else {
                    $("#alert-message").html('<div class="alert alert-success">' + response.message + '</div>');
                    $("#savePoints")[0].reset();
                    setTimeout(() => {
                        $("#saveToPoints").modal('hide');
                        $("#alert-message").html('');
                        loadAdminData();
                    }, 2000);
                }
            }
        });
    });


    // $()
});


document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editInventory'); // Fixed modal ID
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const minweight = button.getAttribute('data-minweight');
        const maxweight = button.getAttribute('data-maxweight');
        const points = button.getAttribute('data-points');

        document.getElementById('id').value = id;
        document.getElementById('min_weight').value = minweight;
        document.getElementById('max_weight').value = maxweight;
        document.getElementById('point').value = points;

        // Removed address — it's not part of your form or table
    });
});





</script>

<nav>
    <ul class="pagination" id="pagination"></ul>
</nav>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
