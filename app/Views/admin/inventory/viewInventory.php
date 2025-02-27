<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Inventory</title>
</head>
<body>

<div class="container">
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#saveToInventory">Add Items</button>

    <table border="1" class="table table-striped table-hover table-bordered" style="border-radius: 15px; overflow: hidden;">
        <thead class="table-dark">
            <tr>
                <th>Item</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Point Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="adminTableBody">
        </tbody>
    </table>
</div>

<div class="modal fade" id="saveToInventory" tabindex="-1" aria-labelledby="saveToInventorylabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="saveToInventorylabel">Inventory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="saveInventory">
                <div class="modal-body">
                    <input type="hidden" name="id" id="itemId">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="itemName" class="form-label">Item</label>
                            <input type="text" class="form-control" name="item" id="itemName" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="itemPrice" class="form-label">Category</label>
                            <input type="text" class="form-control" name="category" id="itemCategory" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="quantity" id="itemQuantity" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="pointsPrice" class="form-label">Point Price</label>
                            <input type="text" class="form-control"  name="pointPrice" id="pointPrice" required>
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


<div class="modal fade" id="editInventory" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
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
                            <label for="itemName" class="form-label">Item</label>
                            <input type="text" class="form-control" name="item" id="itemName" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="itemPrice" class="form-label">Category</label>
                            <input type="text" class="form-control" name="category" id="itemCategory" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="quantity" id="itemQuantity" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pointsPrice" class="form-label">Point Price</label>
                            <input type="text" class="form-control"  name="pointPrice" id="pointPrice" required>
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

<script> 
    $(document).ready(function() {
    function loadAdminData() {
        $.ajax({
            url: "<?= base_url('/displayInventory') ?>",
            type: "GET", 
            dataType: "json",
            success: function(response) {
                let tableRows = '';
                $.each(response, function(index, inventory) {
                    tableRows += `<tr>

                        <td>${inventory.item}</td>
                        <td>${inventory.category}</td>
                        <td>${inventory.quantity}</td>
                        <td>${inventory.point_price}</td>
                        <td><a href="#" class="btn btn-warning btn-sm" 
                        data-bs-toggle="modal" data-bs-target="#editInventory" data-bs-label="inventoryLabel"
                        data-id="${inventory.id}"
                        data-item="${inventory.item}"
                        data-category="${inventory.category}"
                        data-quantity="${inventory.quantity}"
                        data-pointPrice="${inventory.point_price}">edit</a>
                        <a href="" class="btn btn-danger btn-sm" >Delete</a>
                        </td>
                    </tr>`;
                });
                $("#adminTableBody").html(tableRows);
            }
        });
    }

    loadAdminData();

    $("#saveInventory").submit(function(event) {
        event.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: "<?= base_url('/addInventory') ?>",
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
                    $("#saveInventory")[0].reset();
                    setTimeout(() => {
                        $("#saveToInventory").modal('hide');
                        $("#alert-message").html('');
                        loadAdminData();
                    }, 2000);
                }
            }
        });
    });


    // $()
});


document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editInventory'); // Fixed modal ID
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const item = button.getAttribute('data-item');
        const category = button.getAttribute('data-category');
        const quantity = button.getAttribute('data-quantity');
        const pointPrice = button.getAttribute('data-pointPrice'); // Fixed variable name

        document.getElementById('itemId').value = id;
        document.getElementById('itemName').value = item;
        document.getElementById('itemCategory').value = category;
        document.getElementById('itemQuantity').value = quantity;
        document.getElementById('pointPrice').value = pointPrice; // Fixed variable name

        // Removed address — it's not part of your form or table
    });
});



</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
