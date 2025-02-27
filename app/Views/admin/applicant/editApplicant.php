<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Generator & Scanner</title>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>QR Code Generator</h2>
        <input type="text" id="qr-data" class="form-control" placeholder="Enter text">
        <button class="btn btn-primary mt-2" onclick="generateQrCode()" data-bs-toggle="modal" data-bs-target="#qrModal">Generate QR Code</button>

        <h2 class="mt-5">QR Code Scanner</h2>
        <button id="start-scan" class="btn btn-success">Start Scan</button>
        <button id="stop-scan" class="btn btn-danger" style="display: none;">Stop Scan</button>
        <div id="qr-reader" style="width: 300px; display: none;"></div>
        <div id="qr-result" class="mt-3"></div>
    </div>

    <!-- QR Code Modal -->
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

    <script>
        let qrScanner;

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

        function onScanSuccess(decodedText) {
            if (isValidURL(decodedText)) {
                window.location.href = decodedText;
            } else {
                $('#qr-result').html(`<a href="${decodedText}" target="_blank">${decodedText}</a>`);
            }
            if (qrScanner) {
                qrScanner.clear();
                $('#qr-reader').hide();
                $('#stop-scan').hide();
                $('#start-scan').show();
            }
        }

        function isValidURL(string) {
            try {
                new URL(string);
                return true;
            } catch (_) {
                return false;
            }
        }

        $('#start-scan').click(function() {
            if (!qrScanner) {
                qrScanner = new Html5QrcodeScanner("qr-reader", { fps: 10, qrbox: 250 });
            }
            $('#qr-reader').show();
            $('#start-scan').hide();
            $('#stop-scan').show();
            qrScanner.render(onScanSuccess);
        });

        $('#stop-scan').click(function() {
            if (qrScanner) {
                qrScanner.clear();
                $('#qr-reader').hide();
                $('#stop-scan').hide();
                $('#start-scan').show();
            }
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
