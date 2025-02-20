<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trash to Rice Exchange</title>
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

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    color: purple;
    background-color: rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(10px);
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
    z-index: 10;
    border-bottom: 2px solid rgba(255, 255, 255, 0.5);
}

.logo img {
    height: 50px;
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
    
    margin-top: 280px; /* Pushes the container down */
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

input, button {
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

    </style>
</head>
<body>

    <div class="navbar">
        <div class="logo">
            <img src="<?= base_url('images/systemlogo.png') ?>" alt="Trash to Rice Logo">
        </div>
        <div class="nav-links">
            <a href="<?= base_url('home') ?>">Home</a>
            <a href="https://cityofcalapan.gov.ph/about-calapan-city/">About</a>
            <a href="#">How It Works</a>
            <a href="#">Contact</a>
        </div>
    </div>

    <div class="container">
        <h1>
            <img src="<?= base_url('images/systemlogo.png') ?>" alt="Trash to Rice Logo" class="logo-image">
        </h1>

        <h2>Convert your recyclable trash into valuable kilos of rice!</h2>

        <input type="number" id="trashWeight" name="trashWeight" placeholder="Enter trash weight (kilo)">
        <button onclick="convertPoints()">Convert</button>

        <div class="output" id="result"></div>

        <hr>

        <h2>QR Code Generator</h2>
        <input type="text" id="qr-data" placeholder="Enter text">
        <button onclick="generateQrCode()">Generate QR Code</button>
        <br>
        <img id="qr-image" style="margin-top: 10px; display: none;">

        <h2>QR Code Scanner</h2>
        <button id="start-scan">Start Scan</button>
        <button id="stop-scan" style="display: none;">Stop Scan</button>
        <div id="qr-reader"></div>
        <div id="qr-result"></div>
    </div>

    <script>
        function convertPoints() {
            let weight = $("#trashWeight").val();

            if (weight <= 0) {
                alert("Please enter a valid trash weight!");
                return;
            }

            $.ajax({
                url: "<?= base_url('convert-trash') ?>",
                type: "POST",
                data: { trashWeight: weight },
                success: function(response) {
                    if (response.status === "success") {
                        $("#result").html(`You earned <strong>${response.points}</strong> points, which equals <strong>${response.riceKilos}</strong> kilo/s of rice!`);
                    } else {
                        $("#result").html(`<span style="color: red;">${response.message}</span>`);
                    }
                },
                error: function() {
                    $("#result").html(`<span style="color: red;">Error processing request.</span>`);
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
    </script>

</body>
</html>
