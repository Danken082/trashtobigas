<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Table</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Applicant List</h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID Number</th>
                        <th scope="col">Name</th>
                        <th scope="col">Points</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($applicant as $client): ?>
                    <tr>
                        <td><?= htmlspecialchars($client['idNumber']) ?></td>
                        <td><?= htmlspecialchars($client['firstName']) . ' ' . htmlspecialchars($client['lastName']) ?></td>
                        <td><?= htmlspecialchars($client['totalPoints']) ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ApplicantDetailsModal">View</button>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal"
                            data-id="<?= $client['id'] ?>"
                            data-firstname="<?= $client['firstName'] ?>"
                            data-lastname="<?= $client['lastName'] ?>"
                            data-email="<?= $client['email'] ?>"
                            data-contactno="<?= $client['contactNo'] ?>"
                            data-address="<?= $client['address'] ?>">
                            Edit Item</button>
                           <a class="btn btn-danger btn-sm" href="<?= base_url('deleteUser/' . $client['id'])?>">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


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

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


    <!-- modal for updating applicants-->

    <script>
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
</body>
</html>