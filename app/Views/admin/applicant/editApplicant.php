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
  <script src="\js\admin\include\jquery.min.js"></script>
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

    
    .profile-logo {
      height: 40px;
      border-radius: 50%;
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
    
    table tbody{
        font-size:20px;
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
  </style>
</head>
<body>
  <div class="navbar">
    <div class="logo-search" id="searchToggle">
      <div class="logo">
        <img src="<?= base_url('images/systemlogo.png') ?>" alt="Trash to Rice Logo" />
      </div>
    </div>
    <div class="nav-links">
    <a data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
    <img src="<?= base_url('/images/logo/profile-logo.png')?>" alt="profile-logo" class="profile-logo">
</a>

      <!-- <a class="btn btn-primary mb-3 btn-register" style="background:purple;color:white;" data-bs-toggle="modal" data-bs-target="#registerModal">Register Applicant</a>
      <a href="">Home</a>
      <a href="https://cityofcalapan.gov.ph/about-calapan-city/">About</a>
      <a href="#">How It Works</a>
      <a href="#">Contact</a> -->
    </div>
  </div>
  <div class="container mt-5">
        <h2 class="text-center mb-4">Client List</h2>
        <button class="btn btn-primary mb-3 btn-lg" data-bs-toggle="modal" data-bs-target="#registerModal" style="margin-top:5px;">Register Client</button>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID Number</th>
                        <th scope="col">Name</th>
                        <th scope="col">Addres</th>
                        <th scope="col">Birth Day</th>
                        <th scope="col">Points</th>
                        <th scope="col">Contact Number</th>
                        <th scope="col">Email</th>

                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="adminTableBody">

                   </tbody>
            </table>
        </div>
        <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center" id="pagination"></ul>
    </nav>
    </div>
<!--for insert-->
<div class="modal fade modal-lg modal-fullscreen" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Register Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="alert-message"></div>
                <form id="adminRegisterForm">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-control">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Birth Date</label>
                            <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="ContactNo" name="contactNo" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success"  onclick="generateQrCode()">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include_once('include/offsetSidebar.php')?>




  <div class="modal fade modal-lg modal-fullscreen" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" action="<?= base_url('applicant/update') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="itemId">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" name="firstName" id="FirstName" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="lastName" id="LastName" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="Email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="contactNo" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" name="contactNo" id="ContactNo" required>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" id="Address" required>
                        
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="birthDate">Birth Day</label>
                        <input type="date" name="birthdate" class="form-control" id="birth_date" required>
                    </div>
                    <div class="col-md-6 mb-4">
                    <label for="points" class="form-label">Points</label>
                        <input type="number" class="form-control" step="any" name="points" id="points" required>
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


<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrModalLabel">Generated QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="qr-image" style="display: none; max-width: 100%;">
                    <p id="qr-error" class="text-danger" style="display: none;">Failed to generate QR code.</p>
                </div>
            </div>
        </div>
    </div>






    


    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


    <!-- modal for updating applicants-->

    <script>

$("#ContactNo").on("input", function () {
    $(this).val($(this).val().replace(/[^0-9]/g, ""));
});


    //inserting and fetching

    $('#searchToggle').click(function() {
      $('#searchInput').toggle();
      if ($('#searchInput').is(':visible')) {
        $('#searchIcon i').removeClass('bi-search').addClass('bi-x');
        $('#searchInput').focus();
        $('#result').show();
      } else {
        $('#searchIcon i').removeClass('bi-x').addClass('bi-search');
        $('#result').hide();
      }
    });

    


    function generateQrCode() {
            let data = $('#qr-data').val();
            $.post('<?= base_url('qr/generate') ?>', { data: data }, function(response) {
                if (response.qr_code) {
                    $('#qr-image').attr('src', response.qr_code).show();
                    $('#qr-error').hide();
                } else {
                    $('#qr-image').hide();
                    $('#qr-error').show();
                }
            }, 'json');
        }



        $(document).ready(function() {
    let currentPage = 1;
    const recordsPerPage = 3;

    function loadAdminData(page = 1) {
        $.ajax({
            url: "<?= base_url('/admin/list') ?>",
            type: "GET",
            dataType: "json",
            success: function(response) {
                let tableRows = '';
                const startIndex = (page - 1) * recordsPerPage;
                const paginatedData = response.slice(startIndex, startIndex + recordsPerPage);

                $.each(paginatedData, function(index, admin) {
                    tableRows += `<tr>
                        <td>${admin.idNumber}</td>
                        <td>${admin.firstName} ${admin.lastName}</td>
                        <td>${admin.address}</td>
                        <td>${admin.birthdate}</td>
                        <td>${admin.totalPoints}</td>
                        <td>${admin.contactNo}</td>
                        <td>${admin.email}</td>
                        <td><button type="button" class="btn btn-warning btn-lg" data-bs-toggle="modal" data-bs-target="#editModal"
                            data-id="${admin.id}"
                            data-firstname="${admin.firstName}"
                            data-lastname="${admin.lastName}"
                            data-address="${admin.address}"
                            data-contactno="${admin.contactNo}"
                            data-points="${admin.totalPoints}"
                            data-email="${admin.email}"
                            data-birth="${admin.birthdate}">

                            Edit Item</button>

                    
                            
                            <a class="btn btn-danger btn-lg" style="margin-top:5px;"
                            href="<?= base_url('deleteUser/')?>${admin.id}"
                            onclick="return confirm('Are you sure you want to delete this user')">Delete</a></td>
                    </tr>`;
                });

                $('#adminTableBody').html(tableRows);
                setupPagination(response.length, page);
            }
        });
    }

    function setupPagination(totalRecords, currentPage) {
        const totalPages = Math.ceil(totalRecords / recordsPerPage);
        let paginationHtml = '';

        for (let i = 1; i <= totalPages; i++) {
            paginationHtml += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" onclick="loadAdminData(${i})">${i}</a>
            </li>`;
        }

        $('#pagination').html(paginationHtml);
    }

    window.loadAdminData = loadAdminData; // Make accessible globally
    loadAdminData();
 
    $("#adminRegisterForm").submit(function(event) {
    event.preventDefault();
    let formData = $(this).serialize();

    $.ajax({
        url: "<?= base_url('/admin/register') ?>",
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
                $("#adminRegisterForm")[0].reset();
                setTimeout(() => {
                    $("#registerModal").modal('hide');
                    $("#alert-message").html('');
                    loadAdminData();
                }, 2000);
            }
        }
    });
});

});


    //getting the data for the modal
    document.addEventListener('DOMContentLoaded', function () {
        const editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const firstName = button.getAttribute('data-firstname');
            const lastName = button.getAttribute('data-lastname');
            const email = button.getAttribute('data-email');
            const contactNo = button.getAttribute('data-contactno');
            const address = button.getAttribute('data-address');
            const points = button.getAttribute('data-points');
            const birth = button.getAttribute('data-birth')

            document.getElementById('itemId').value = id;
            document.getElementById('FirstName').value = firstName;
            document.getElementById('LastName').value = lastName;
            document.getElementById('Email').value = email;
            document.getElementById('ContactNo').value = contactNo;
            document.getElementById('Address').value = address;
            document.getElementById('points').value = points;
            document.getElementById('birth_date').value = birth;
        });
    });
</script>

<script src="/js/admin/include/jquery/jsquery.min.js"></script>
<script src="/js/admin/include/bootstrap/bootstrap.bundle.min.js"></script>

</body>
</html>
