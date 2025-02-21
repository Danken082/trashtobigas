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
    
    .container {
      max-width: 500px;
      width: 100%;
      background: rgba(255, 255, 255, 0.25);
      border-radius: 15px;
      padding: 30px;
      backdrop-filter: blur(10px);
      box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.25);
      border: 2px solid rgba(255, 255, 255, 0.4);
      text-align: center;
      transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
      margin-top: 65px;
      margin-left: auto;
      margin-right: 0;
    }

    .container-details {
      font-size: 100px;
      background: rgba(255, 255, 255, 0.25);
      border-radius: 15px;
      padding: 30px;
      backdrop-filter: blur(10px);
      box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.25);
      border: 2px solid rgba(255, 255, 255, 0.4);
  
      transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
      margin-top: 65px;
      margin-left: auto;
      margin-right: 0;
    }
    
    .container:hover {
      transform: scale(1.03);
      box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.3);
    }
    
    h1 {
      color: rgb(24, 153, 67);
      font-size: 26px;
      font-weight: 600;
      margin-bottom: 10px;
    }
    
    .logo-image {
      height: 120px;
      margin-bottom: 15px;
    }
    
    p {
      font-size: 16px;
      color: #333;
      margin-bottom: 15px;
    }
    
    input,
    button {
      padding: 12px;
      width: 100%;
      margin-top: 10px;
      border-radius: 10px;
      font-size: 16px;
      border: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    input {
      background: #fff;
      color: #333;
      outline: none;
    }
    
    button {
      background: linear-gradient(45deg, rgb(17, 173, 113), rgb(228, 112, 199));
      border: none;
      color: white;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s ease;
    }
    
    button:hover {
      background: linear-gradient(45deg, rgb(48, 180, 81), rgb(56, 197, 87));
      transform: scale(1.05);
    }
    
    .output {
      font-size: 18px;
      font-weight: 500;
      margin-top: 15px;
      color: #444;
    }
    
    #qr-reader {
      width: 100%;
      max-width: 320px;
      display: none;
      margin-top: 10px;
    }
    
    #qr-result {
      font-size: 18px;
      font-weight: bold;
      margin-top: 10px;
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
      <div class="search-icon" id="searchIcon">
        <i class="bi bi-search"></i>
      </div>
      <input type="text" class="search-input" id="searchInput" placeholder="Search..." autocomplete="off"/>
      <!-- Search result container -->
      <div id="result">Search results here...</div>
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
  
  <div class="container-details">
  <h3>Applicant Details:</h3>
                    <p><strong>ID Number:</strong><?= $details['idNumber']?></p>
                    <p><strong>Name:</strong> <?= $details['firstName'] . ' ' . $details['lastName']?></p>
                    <p><strong>Email:</strong><?= $details['email']?></p>
                    <p><strong>Phone:</strong><?= $details['contactNo']?></p>
                    <p><strong>Address:</strong><?= $details['address']?></p>
                    <p><strong>Points:</strong> <?=$details['totalPoints']?></p>
    </div>
  <div class="container">
    <h1>
      <img src="<?= base_url('images/systemlogo.png') ?>" alt="Trash to Rice Logo" class="logo-image" />
    </h1>
    <h2>Convert your recyclable trash into valuable kilos of rice!</h2>
    <input type="number" id="trashWeight" name="trashWeight" placeholder="Enter trash weight (kilo)" />
    <button onclick="convertPoints()">Convert</button>
    <div class="output" id="conversionResult"></div>
    <hr />
  </div>
  
  <!--profileMenu Modal-->
 
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Offcanvas</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div>
      Some text as placeholder. In real life you can have the elements you have chosen. Like, text, images, lists, etc.
    </div>
    <div class="dropdown mt-3">
      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
        Dropdown button
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li><a class="dropdown-item" href="#">Action</a></li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
        <li><a class="dropdown-item" href="#">Something else here</a></li>
      </ul>
    </div>
  </div>
</div>
        
  <!-- Register Modal -->

  
  <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="registerModalLabel">Register Applicant</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="alert-message"></div>
          <form id="adminRegisterForm">
            <div class="mb-3">
              <label class="form-label">First Name</label>
              <input type="text" class="form-control" id="firstName" name="firstName" required />
            </div>
            <div class="mb-3">
              <label class="form-label">Last Name</label>
              <input type="text" class="form-control" id="lastName" name="lastName" required />
            </div>

            <div class="mb-3">
              <label class="form-label">Gender</label>
                <select name="gender" class="form-control">
                    <option value="" selected dispabled>--Select Gender--</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Address</label>
              <input type="text" class="form-control" id="address" name="address" required />
            </div>
            <div class="mb-3">
              <label class="form-label">Birth Date</label>
              <input type="date" class="form-control" id="birthdate" name="birthdate" required />
            </div>
            <div class="mb-3">
              <label class="form-label">Contact Number</label>
              <input type="text" class="form-control" id="contactNo" name="contactNo" required />
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required />
            </div>
            <button type="submit" class="btn btn-success">Register</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <script>
    // Toggle search input, change icon, and toggle result display on click
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

    

    
    function convertPoints() {
      let weight = $("#trashWeight").val();
      if (weight <= 0) {
        alert("Please enter a valid trash weight!");
        return;
      }
      $.ajax({
        url: "<?= base_url('convert-trash/' . $details['id']) ?>",
        type: "POST",  
        data: { trashWeight: weight },
        success: function(response) {
          if (response.status === "success") {
            $("#conversionResult").html(`You earned <strong>${response.points}</strong> points, which equals <strong>${response.riceKilos}</strong> kilo/s of rice!`);
          } else {
            $("#conversionResult").html(`<span style="color: red;">${response.message}</span>`);
          }
        },
        error: function() {
          $("#conversionResult").html(`<span style="color: red;">Error processing request.</span>`);
        }
      });
    }
    
    function generateQrCode() {
      let data = $('#qr-data').val();
      if (!data) {
        alert("Enter some text!");
        return;
      }
      $.post('<?= base_url('qr/generate') ?>', { data: data }, function(response) {
        if (response.qr_code) {
          $('#qr-image').attr('src', response.qr_code).show();
        } else {
          alert("Failed to generate QR code.");
        }
      }, 'json');
    }
    
    let qrScanner;
    function onScanSuccess(decodedText) {
      $('#qr-result').html(`Scanned QR Code: <b>${decodedText}</b>`);
      qrScanner.clear();
      $('#qr-reader').hide();
      $('#stop-scan').hide();
      $('#start-scan').show();
    }
    
    $('#start-scan').click(function() {
      qrScanner = new Html5QrcodeScanner("qr-reader", { fps: 10, qrbox: 250 });
      $('#qr-reader').show();
      $('#start-scan').hide();
      $('#stop-scan').show();
      qrScanner.render(onScanSuccess);
    });
    
    $('#stop-scan').click(function() {
      qrScanner.clear();
      $('#qr-reader').hide();
      $('#stop-scan').hide();
      $('#start-scan').show();
    });

    $(document).ready(function() {
    function loadAdminData() {
        $.ajax({
            url: "<?= base_url('/admin/list') ?>",
            type: "GET", 
            dataType: "json",
            success: function(response) {
                let tableRows = '';
                $.each(response, function(index, admin) {
                    tableRows += `<tr>

                        <td>${admin.firstName}</td>
                        <td>${admin.lastName}</td>
                        <td>${admin.address}</td>
                        <td>${admin.birthdate}</td>
                        <td>${admin.contactNo}</td>
                        <td>${admin.email}</td>
                    </tr>`;
                });
                $("#adminTableBody").html(tableRows);
            }
        });
    }

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
  </script>
  
  <script src="<?= base_url('/js/admin/modal.js')?>"></script>
  <script src="<?= base_url('/js/admin/search.js')?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
