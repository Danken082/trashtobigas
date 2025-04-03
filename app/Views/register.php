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
        <a href="/">
      <div class="logo">
        <img src="<?= base_url('images/systemlogo.png') ?>" alt="Trash to Rice Logo" />
      </div>
      </a>
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
        <h2 class="text-center mb-4">Users List</h2>
        <button class="btn btn-primary mb-3 btn-lg" data-bs-toggle="modal" data-bs-target="#registerModal" style="margin-top:5px;">Register Barangay User</button>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Username</th>
                        <th scope="col">Name</th>
                        <th scope="col">Contact Number</th>
                        <th scope="col">Address</th>
                        <th scope="col">Role</th>
                        <th scope="col">Status</th>
                        <th scope="col">Updated Date</th>
                        <th scope="col" colspan="2">Action</th>
                    </tr>
                </thead>
                <?php foreach($user as $user):?>
                <tbody id="adminTableBody">

                   </tbody>
                   <?php endforeach;?>
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
                <h5 class="modal-title" id="registerModalLabel">Register User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="alert-message"></div>
                <form action="<?= base_url('registerUser')?>" method="post">
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
                            <label class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="ContactNo" name="contactNo" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-control">
                                <option disabled selected>--Select Role--</option>
                                <option value="Staff">Staff</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" id="userName" name="userName" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                     
                    </div>
                    <button type="submit" class="btn btn-success">Register</button>
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
            <form id="editForm" action="<?= base_url('updateUser') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="itemId">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" id="FirstName" name="firstName" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="LastName" name="lastName" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="ContactNo" name="contactNo" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" required class="form-control">
                                <option disabled selected>--Select Role--</option>
                                <option value="Staff">Staff</option>
                                <option value="Admin">Admin</option>
                            </select>
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
            url: "<?= base_url('/getuser') ?>",
            type: "GET",
            dataType: "json",
            success: function(response) {
                let tableRows = '';
                const startIndex = (page - 1) * recordsPerPage;
                const paginatedData = response.slice(startIndex, startIndex + recordsPerPage);

                $.each(paginatedData, function(index, admin) {
                    tableRows += `<tr>
                        <td>${admin.userName}</td>
                        <td>${admin.firstName} ${admin.lastName}</td>
                        <td>${admin.contactNo}</td>
                        <td>${admin.address}</td>
                        <td>${admin.role}</td>
                        <td>${admin.status}</td>
                        <td>${new Date(admin.updated_at).toLocaleDateString('en-US', { 
                                year: 'numeric', 
                                month: 'long', 
                                day: 'numeric' 
                            })}</td>  
                        <td>
                        
                    
                            
                            <a class="btn btn-danger btn-lg" style="margin-top:5px;"
                            href="<?= base_url('deleteuseradmin/')?>${admin.id}"
                            onclick="return confirm('Are you sure you want to delete this user')">Delete</a></td>

                        <td><a href="<?= base_url('/disableaccount/')?>${admin.id}" class ="btn btn-danger">Disabled Account</a> <a href="<?= base_url('/enableaccount/')?>${admin.id}" class ="btn btn-primary">Enable Account</a></td>
                      
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
            url: "<?= base_url('/registerUser') ?>",
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
                        // loadAdminData();
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
            const contactNo = button.getAttribute('data-contactno');
            const role = button.getAttribute('data-role');
            const status = button.getAttribute('data-status');
            const username = button.getAttribute('data-username');
            const password = button.getAttribute('data-password');

            document.getElementById('itemId').value = id;
            document.getElementById('FirstName').value = firstName;
            document.getElementById('LastName').value = lastName;
            document.getElementById('ContactNo').value = contactNo;
            document.getElementById('role').value = role;
            document.getElementById('status').value = status;
            document.getElementById('username').value = username;
            document.getElementById('password').value = password;
        });
    });
</script>

<script src="/js/admin/include/jquery/jsquery.min.js"></script>
<script src="/js/admin/include/bootstrap/bootstrap.bundle.min.js"></script>

</body>
</html>
