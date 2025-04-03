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


    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen relative">

    <!-- Background -->
    <div class="absolute top-0 left-0 w-full h-full bg-cover bg-center blur-sm" style="background-image: url('<?= base_url('images/systemBg.png') ?>');"></div>

    <!-- Search Bar -->
    <div class="absolute top-4 right-4 w-64">
        <div class="relative">
            <input type="text" id="searchInput" placeholder="Search..." class="w-full px-4 py-2 rounded-full shadow-lg focus:outline-none border">
            <i class="fas fa-search absolute right-3 top-3 text-gray-500"></i>

            <!-- Search Results (Appears below search bar) -->
           
            <div id="searchResults" class="absolute w-full bg-white mt-2 rounded-lg shadow-lg hidden border">
                <ul id="resultsList" class="divide-y divide-gray-300"></ul>
            </div>
            
        </div>
    </div>

    <!-- Page Content -->
    <div class="relative z-10 text-center mt-20">
        <h1 class="text-5xl font-bold text-black mb-8">Welcome!</h1>
        <div class="grid grid-cols-3 gap-6">
     
            <a href="viewInventory"> 
                <div class="bg-white p-20 rounded-sm shadow-xl flex flex-col items-center w-55 h-55">
                    <i class="fas fa-store text-7xl text-orange-500 mb-6"></i>
                    <p class="text-2xl font-semibold">Store</p>
                </div>
            </a> 

            <a href="viewapplicants">
            <div class="bg-white p-20 rounded-sm shadow-xl flex flex-col items-center w-55 h-55">
                <i class="fas fa-users text-7xl text-purple-500 mb-6"></i>
                <p class="text-2xl font-semibold">Applicants</p>
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
            <a href="showredeemed">
            <div class="bg-white p-20 rounded-sm shadow-xl flex flex-col items-center w-55 h-55">
                <i class="fas fa-history text-7xl text-green-500 mb-6"></i>
                <p class="text-2xl font-semibold">View Redeemed History</p>
            </div>
            </a>
            <!-- <div class="bg-white p-20 rounded-sm shadow-xl flex flex-col items-center w-55 h-55">
                <i class="fas fa-clock text-7xl text-gray-400 mb-6"></i>
                <p class="text-2xl font-semibold">Time Clock</p>
            </div> -->
            <a href="#" id="start-scan">
            <div  class="bg-white p-20 rounded-sm shadow-xl flex flex-col items-center w-55 h-55">
                <i class="fas fa-qrcode text-7xl text-gray-400 mb-6"></i>
                <button class="text-2xl font-semibold" >Read by QR</button>
            </div>
            </a>
   
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
                $('#resultsList').html('<li class="p-2 text-gray-500">Loading...</li>'); // Loading indicator
                $('#searchResults').removeClass('hidden');

                $.ajax({
                    url: '<?= base_url('search') ?>',  // Adjust URL as needed
                    type: 'GET',
                    data: { query: query },
                    success: function (response) {
                        $('#resultsList').empty();

                        if (Array.isArray(response) && response.length > 0) {
                            response.forEach(function (item) {
                                let link = `<?= base_url('applicantdetails') ?>/${item.idNumber}`; // Change 'profile' to your target page
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
            }
        });

        // Hide search results when clicking outside
        $(document).click(function (event) {
            if (!$(event.target).closest("#searchInput, #searchResults").length) {
                $('#searchResults').addClass('hidden');
            }
        });

        // Make sure clicking a result navigates correctly
        $(document).on('click', '#resultsList li a', function (e) {
            let href = $(this).attr('href');
            if (href) {
                window.location.href = href; // Navigate to the link
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


</script>

</body>
</html>
