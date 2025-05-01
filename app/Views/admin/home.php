<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="icon" href="<?= base_url('images/favicon.jpeg');?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->

    <script src="https://unpkg.com/html5-qrcode"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
#qr-reader-container {
    position: absolute;
    top: 50%;
    left: 50%;
    width:50%;
    height:50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
    display: none;
    z-index: 50;
}

#stop-scanning {
    background: red;
    color: white;
    padding: 8px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
    width: 100%;
}

#qr-reader {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
}


.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.6);
  display: none;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.modal-overlay.active {
  display: flex;
}
.show-changepassword.block {
  display: flex;
}

.modal-box {
  background: #fff;
  padding: 25px;
  border-radius: 12px;
  max-width: 300px;
  width: 90%;
  box-shadow: 0 5px 15px rgba(0,0,0,0.3);
  position: relative;
}

.close-btn {
  position: absolute;
  top: 12px;
  right: 16px;
  font-size: 24px;
  font-weight: bold;
  color: #333;
  cursor: pointer;
}

.flash-message {
  padding: 1rem 1.5rem;
  border-radius: 8px;
  margin: 1rem 0;
  font-size: 0.95rem;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  box-shadow: 0 4px 10px rgba(0,0,0,0.05);
  animation: slideIn 0.4s ease;
}

.flash-message.success {
  background-color: #e6ffed;
  color: #207a43;
  border-left: 6px solid #34d399;
}

.flash-message.error {
  background-color: #ffe6e6;
  color: #a33a3a;
  border-left: 6px solid #f87171;
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}


    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen relative">

    <!-- Background -->
    <div class="absolute top-0 left-0 w-full h-full bg-cover bg-center blur-sm" style="background-image: url('<?= base_url('images/systemBg.png') ?>');"></div>
    <div id="blur-overlay" class="absolute top-0 left-0 w-full h-full bg-white/30 backdrop-blur-sm z-30 hidden"></div>


    <!-- Search Bar -->
    <div class="absolute top-4 right-4 max-w-lg w-full px-4 z-40">
    <div class="relative">
    <input type="text" id="searchInput" placeholder="Search Client Number..." class="w-full px-4 py-4 rounded-full shadow-lg focus:outline-none border text-lg">

        <i class="fas fa-search absolute right-3 top-3 text-gray-500"></i>
        <div id="searchResults" class="absolute w-full bg-white mt-2 rounded-lg shadow-lg hidden border z-50">
            <ul id="resultsList" class="divide-y divide-gray-300"></ul>
        </div>
    </div>
</div>


    <!-- Page Content -->
    <div class="relative z-10 text-center mt-20">
        <h1 class="text-5xl font-bold text-black mb-8">Welcome!</h1>

        
        <?php if (session()->getFlashdata('msg')): ?>
    <div class="flash-message error">
        <i class="fas fa-cross-circle text-red-500"></i>
        <span><?= session()->getFlashdata('msg') ?></span>
    </div>
<?php endif; ?>

        <div class="grid grid-cols-3 gap-6">
     


        
        <div class="bg-white p-20 rounded-sm shadow-xl flex flex-col items-center w-55 h-55" onclick="openImageModal()">
            <!-- <i class="fa fa-sign-out" aria-hidden="true"></i> -->
            <img src="<?= base_url('images/admin/') . session()->get('img')?>" style="width:100px;" alt="profile img">
                <p class="text-2xl font-semibold">Profile view</p>
            </div>

            <a href="viewInventory"> 
                <div class="bg-white p-20 rounded-sm shadow-xl flex flex-col items-center w-55 h-55">
                    <i class="fas fa-store text-7xl text-orange-500 mb-6"></i>
                    <p class="text-2xl font-semibold">Store</p>
                </div>
            </a> 

            <a href="viewapplicants">
            <div class="bg-white p-20 rounded-sm shadow-xl flex flex-col items-center w-55 h-55">
                <i class="fas fa-users text-7xl text-purple-500 mb-6"></i>
                <p class="text-2xl font-semibold">Clients</p>
            </div>
            </a>
            <?php if(session()->get('role') === 'Admin'):?>

            <a href="ranges">
            <div class="bg-white p-20 rounded-sm shadow-xl flex flex-col items-center w-55 h-55">
                <i class="fas fa-book text-7xl text-red-500 mb-6"></i>
                <p class="text-2xl font-semibold">Point Ranges</p>
            </div>
            </a>
            <a href="register">
            <div class="bg-white p-20 rounded-sm shadow-xl flex flex-col items-center w-55 h-55">
                <i class="fas fa-user text-7xl text-green-500 mb-6"></i>
                <p class="text-2xl font-semibold">Users</p>
            </div>
            </a>
            <?php endif;?>

            
            <a href="<?= base_url('')?>/showredeemed">
            <div class="bg-white p-20 rounded-sm shadow-xl flex flex-col items-center w-55 h-55">
                <i class="fas fa-history text-7xl text-green-500 mb-6"></i>
                <p class="text-2xl font-semibold">View Redeemed History</p>
            </div>
            </a>

            <a href="<?= base_url('')?>/historyPointsConvertion">
            <div class="bg-white p-20 rounded-sm shadow-xl flex flex-col items-center w-55 h-55">
                <i class="fas fa-history text-7xl text-green-500 mb-6"></i>
                <p class="text-2xl font-semibold">Convertion History</p>
            </div>
            </a>

            <a href="#" id="start-scan">
            <div  class="bg-white p-20 rounded-sm shadow-xl flex flex-col items-center w-55 h-55">
                <i class="fas fa-qrcode text-7xl text-gray-400 mb-6"></i>
                <button class="text-2xl font-semibold" >Read by QR</button>
            </div>
            </a>
   
            <a href="<?= base_url('')?>/logout">
            <div class="bg-white p-20 rounded-sm shadow-xl flex flex-col items-center w-55 h-55">
            <i class="fa fa-sign-out" aria-hidden="true"></i>
                <p class="text-2xl font-semibold">Logout</p>
            </div>
            </a>


            <!-- <div class="bg-white p-20 rounded-sm shadow-xl flex flex-col items-center w-55 h-55">
                <i class="fas fa-clock text-7xl text-gray-400 mb-6"></i>
                <p class="text-2xl font-semibold">Time Clock</p>
            </div> -->

<!-- modal previewing image to eid-->
            <div id="imageModal" class="modal-overlay">
  <div class="modal-box">
    <span class="close-btn" onclick="closeImageModal()">&times;</span>
    <h4>Profile Image</h4>

    <form id="imageForm" action="<?= base_url('changeProfileAdmin') ?>" method="post" enctype="multipart/form-data">
      <img id="previewImg" src="<?= base_url('/images/admin/') . session()->get('img') ?>" alt="Preview" style="width: 100%; height: auto; margin-bottom: 10px; border-radius: 10px;">

      <input type="file" name="profile_img" id="profile_img" accept="image/*" style="margin-top: 10px;" onchange="previewSelectedImage(this)">
      <!-- <input type="text" name="username" style="margin-top: 10px;" > -->

      <div style="margin-top: 15px; display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" onclick="closeImageModal()" style="padding: 8px 12px;">Cancel</button>
        <button type="submit" style="padding: 8px 12px; background-color: #2d6a4f; color: #fff; border: none; border-radius: 5px;">Save</button>
      </div>
    </form>
  </div>
</div>
 
   
    <div id="qr-reader-container">
    <div id="qr-reader"></div>
    <button id="stop-scanning">Stop Scanning</button>
</div>


    <div id="qr-result"></div>
        </div>
    </div>
    
    <script>
$(document).ready(function () {
    $('#searchInput').on('keyup', function () {
        let query = $(this).val().trim();
        
        if (query.length > 0) {
            $('#blur-overlay').removeClass('hidden'); // Show blur
            $('#resultsList').html('<li class="p-2 text-gray-500">Loading...</li>');
            $('#searchResults').removeClass('hidden');

            $.ajax({
                url: '<?= base_url('search') ?>',
                type: 'GET',
                data: { query: query },
                success: function (response) {
                    $('#resultsList').empty();
                    if (Array.isArray(response) && response.length > 0) {
                        response.forEach(function (item) {
                            let link = `<?= base_url('applicantdetails') ?>/${item.idNumber}`;
                            $('#resultsList').append(
                                `<li class="p-2 hover:bg-gray-200 cursor-pointer">
                                    <a href="${link}" class="block">${item.idNumber}</a>
                                </li>`
                            );
                        });
                    } else {
                        $('#resultsList').append('<li class="p-2 text-gray-500">No results found</li>');
                    }
                },
                error: function () {
                    $('#resultsList').html('<li class="p-2 text-red-500">Error fetching results</li>');
                }
            });
        } else {
            $('#searchResults').addClass('hidden');
            $('#blur-overlay').addClass('hidden'); // Hide blur
        }
    });

    $(document).click(function (event) {
        if (!$(event.target).closest("#searchInput, #searchResults").length) {
            $('#searchResults').addClass('hidden');
            $('#blur-overlay').addClass('hidden'); // Hide blur
        }
    });

    $(document).on('click', '#resultsList li a', function (e) {
        let href = $(this).attr('href');
        if (href) {
            window.location.href = href;
        }
    });
});

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

$('#start-scan').click(function() {
    $('#qr-reader-container').fadeIn(); // Show scanner box
    qrScanner = new Html5QrcodeScanner("qr-reader", { fps: 10, qrbox: 250 });
    qrScanner.render(onScanSuccess);
    $('#start-scan').hide();
});

$('#stop-scanning').click(function() {
    qrScanner.clear();
    $('#qr-reader-container').fadeOut(); // Hide scanner box
    $('#start-scan').show();
});

// Function that runs when a QR Code is scanned
function onScanSuccess(decodedText) {
    $('#qr-result').html(`Scanned QR Code: <b>${decodedText}</b>`);
    qrScanner.clear();
    $('#qr-reader-container').fadeOut();
    $('#start-scan').show();

    // Redirect to another page with the scanned ID
    window.location.href = `applicantdetails/${decodedText}`;
}



//image previewing
function openImageModal() {
    document.getElementById('imageModal').classList.add('active');
    }

function closeImageModal() {
  document.getElementById('imageModal').classList.remove('active');
  document.getElementById('profile_img').value = '';
}


  function previewSelectedImage(input) {
    const file = input.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        document.getElementById('previewImg').src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  }

</script>

</body>
</html>
