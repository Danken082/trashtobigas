<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Table</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Applicant List</h2>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#registerModal">Register Applicant</button>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID Number</th>
                        <th scope="col">Name</th>
                        <th scope="col">Addres</th>
                        <th scope="col">Birth Day</th>
                        <th scope="col">Contact Number</th>
                        <th scope="col">Email</th>

                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="adminTableBody">

                   </tbody>
            </table>
        </div>
    </div>
<!--for insert-->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Register Admin</h5>
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
                            <input type="text" class="form-control" id="contactNo" name="contactNo" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success"  onclick="generateQrCode()" data-bs-toggle="modal" data-bs-target="#qrModal">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>




<!--foredit-->
    <div class="modal fade" id="ApplicantDetailsModal" tabindex="-1" aria-labelledby="ApplicantDetails" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ApplicantDetails">Applicant Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID Number</th>
                        <th scope="col">Name</th>
                        <th scope="col">Points</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($applicant as $client): ?>
                    <tr>
                        <td><?= htmlspecialchars($client['idNumber']) ?></td>
                        <td><?= htmlspecialchars($client['firstName']) . ' ' . htmlspecialchars($client['lastName']) ?></td>
                        <td><?= htmlspecialchars($client['totalPoints']) ?></td>
                        <td>
                        <?= htmlspecialchars($client['email']) ?>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        
    
    </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" action="<?= base_url('items/update') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="itemId">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="itemName" class="form-label">First Name</label>
                            <input type="text" class="form-control" name="firstName" id="itemName" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="itemPrice" class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="lastName" id="itemPrice" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="contactNo" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" name="contactNo" id="contactNo" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" id="address" required>
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


    //inserting and fetching

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
    function loadAdminData() {
        $.ajax({
            url: "<?= base_url('/admin/list') ?>",
            type: "GET",
            dataType: "json",
            success: function(response) {
                let tableRows = '';
                $.each(response, function(index, admin) {
                    tableRows += `<tr>

                        <td>${admin.idNumber}</td>
                        <td>${admin.firstName} ${admin.lastName} </td>
                        <td>${admin.address}</td>
                        <td>${admin.birthdate}</td>
                        <td>${admin.contactNo}</td>
                        <td>${admin.email}</td>
                        <td><button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ApplicantDetailsModal">View</button>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal"
                            data-id="${admin.id}"
                            data-firstname="${admin.firstName}"
                            data-lastname="${admin.lastName}"
                            data-email="${admin.address}"
                            data-contactno="${admin.contactNo}"
                            data-address="${admin.email}">
                            Edit Item</button>

                            
                            <a class="btn btn-danger btn-sm"
                            href="<?= base_url('deleteUser/' . $client['id'])?>"
                            onclick="return confirm('Are you sure you want to delete this user')">Delete</a></td>

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
            const email = button.getAttribute('data-email');
            const contactNo = button.getAttribute('data-contactno');
            const address = button.getAttribute('data-address');

            document.getElementById('itemId').value = id;
            document.getElementById('itemName').value = firstName;
            document.getElementById('itemPrice').value = lastName;
            document.getElementById('email').value = email;
            document.getElementById('contactNo').value = contactNo;
            document.getElementById('address').value = address;
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>