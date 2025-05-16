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
  <link rel="stylesheet" href="/css/main.css">

  <style>
.convertion {
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    color: #fff; /* White text for contrast */
    background-color: #007bff; /* Bootstrap blue */
    border: 2px solid #007bff; /* Match border with background */
    border-radius: 8px;
    text-align: center;
    text-decoration: none;
    transition: all 0.3s ease-in-out;
}


.convertion:hover {
    background-color: #007bff;
    color: #fff;
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
}

  </style>
</head>
<body>
  <div class="navbar">
      <div class="logo">
        <a href="/home">
        <img src="<?= base_url('images/systemlogo.png') ?>" alt="Trash to Rice Logo" />
        </a>
      </div>
    <div class="nav-links">
    <?= session()->get('userName');?> 
    <a data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
    <img src="<?= base_url('/images/admin/') . session()->get('img')?>" alt="profile-logo" class="profile-logo">
</a>

    </div>
  </div>


  
  
  <div class="container-details" style="font-size:100px;">
  <h3>Applicant Details:</h3>
                    <p><strong>ID Number:</strong> <?= $details['idNumber']?></p>
                    <p><strong>Name:</strong> <?= $details['firstName'] . ' ' . $details['lastName']?></p>
                    <p><strong>Email:</strong> <?= $details['email']?></p>
                    <p><strong>Phone:</strong> <?= $details['contactNo']?></p>
                    <p><strong>Address:</strong> <?= $details['address']?></p>
                    <p><strong>Points:</strong> <?= number_format($details['totalPoints'], 2)?></p>
                    <a href="<?= base_url('ecommerce/' . $details['idNumber'])?>" class="convertion">Convert Points To Supplies</a>
    </div>
  <div class="container">
    <h1>
      <img src="<?= base_url('images/systemlogo.png') ?>" alt="Trash to Rice Logo" class="logo-image" />
</h1>


    <h2>Convert your recyclable trash into valuable kilos of rice!</h2>
    <select name="category" id="category" class="form-controll">
      <option disabled selected>--Select Category--</option>
      <option value="kilogram/s">Kilo Gram/s</option>
      <option value="gram/s">Gram/Grams</option>
    </select>
    <input type="number" id="trashWeight" name="trashWeight" placeholder="Enter trash weight" />
    <button onclick="convertPoints()">Convert</button>
    <div class="output" id="conversionResult"></div>
    <hr />
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
  let category = $('#category').val();

  if (weight <= 0 || !category) {
    alert("Please enter a valid trash weight and select a category!");
    return;
  }

  // Confirmation prompt
  if (!confirm("Are you sure you want to convert this trash weight into points?")) {
    return;
  }

  // AJAX request proceeds only if confirmed
  $.ajax({
    url: "<?= base_url('convert-trash/' . $details['id']) ?>",
    type: "POST",  
    data: { trashWeight: weight, category: category },
    success: function(response) {
      if (response.status === "success") {
        $("#conversionResult").html(`Earned <strong>${response.points}</strong> point/s on your <strong>${response.riceKilos}</strong> ${response.categ} of Trash Materials!`);

        // Update totalPoints in container-details
        $(".container-details").find("p:contains('Points:')").html(`<strong>Points:</strong> ${response.totalPoints}`);
        $("#trashWeight").val('');
      } else {
        $("#conversionResult").html(`<span style="color: red;">${response.message}</span>`);
      }
    },
    error: function() {
      alert("An error occurred while converting points. Please try again later.");
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
  <script src="<?= base_url('js/admin/detailstoload.js')?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
