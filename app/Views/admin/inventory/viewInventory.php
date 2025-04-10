<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <script src="\js\admin\include\jquery.min.js"></script>

    <title>Inventory</title>
</head>
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

    .profile-logo {
      height: 40px;
      border-radius: 50%;
    }

    .container {
      margin-top: 80px;
      width: 100%;
      max-width: 1200px;
      background: rgba(255, 255, 255, 0.9);
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

  table {
  border-radius: 10px;
  overflow: hidden;
  font-size: 22px; /* bigger font */
  width: 100%;
  table-layout: fixed;
}

thead th {
  font-size: 24px; /* make headers bigger */
  text-align: center;
}

table tbody {
  font-size: 22px; /* make body text bigger */
}

table td {
  font-size: 26px;
  vertical-align: middle;
  text-align: center;
  padding: 15px;
}

    img .img-table{
        height:25px;
        width:25px;
    }

     .img-table {
        height: 100px;
        width: 100px;
        cursor: pointer;
    }
    @media (max-width: 768px) {
      .nav-links {
        flex-direction: column;
        text-align: center;
      }

      .nav-links a {
        display: block;
        margin: 5px 0;
      }

      .container {
        padding: 10px;
      }
    }
</style>
<body>
<div class="navbar">
    <a href="<?= base_url('home')?>">
    <div class="logo">
        <img src="<?= base_url('images/systemlogo.png') ?>" alt="Logo">
    </div>
    </a>
    <p><?= session()->get('userName')?></p>
    <a data-bs-toggle="offcanvas" href="#offcanvasExample">
    
        <img src="<?= base_url('/images/logo/profile-logo.png')?>" alt="Profile" class="profile-logo">
    </a>
</div>

<div class="container">
    <button class="btn btn-primary mb-3" style="width:200px; font-size:20px;" data-bs-toggle="modal" data-bs-target="#saveToInventory">Add Item</button>
    <table class="table table-striped table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Item</th>
                <th>Category</th>
                <th>Point Price</th>
                <th>Images</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="adminTableBody"></tbody>
    </table>
</div>



<!-- Image Preview Modal -->
<div class="modal fade modal-lg modal-fullscreen" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagePreviewLabel">Inventory Images</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Preview" style="max-width: 100%; max-height: 500px; border-radius: 10px;">
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-lg modal-fullscreen" id="saveToInventory" tabindex="-1" aria-labelledby="saveToInventorylabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="saveToInventorylabel">Inventory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('addInventory') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id" id="itemId">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="itemName" class="form-label">Item</label>
                            <input type="text" class="form-control" name="item" id="itemName" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="itemPrice" class="form-label">Category</label>
                            <select name="category" class="form-control" id="itemCategory">
                                    <option disabled selected>--Select Category--</option>
                                    <option value="GS">Good Supplies</option>
                                    <option value="SS">School Supplies</option>
                                    <option value="Others">Others</option>
                            </select>
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
                    <div class="col-md-6 mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" accept="image/*" name="img" id="Img" required>
                        </div>

                  </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width:200px; font-size:20px;">Close</button>
                    <button type="submit" class="btn btn-primary" style="width:200px; font-size:20px;">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade modal-lg modal-fullscreen" id="editInventory" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 150%; margin-left: 25%; margin-right: 25%;"> <!-- Adjust width and margins -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" action="<?= base_url('items/update/')?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id" id="item_Id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="itemName" class="form-label">Item</label>
                            <input type="text" class="form-control" name="item" id="item_Name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="itemPrice" class="form-label">Category</label>
                            <select name="category" class="form-control" id="item_Category">
                                <option disabled selected>--Select Category--</option>
                                <option value="GS">Good Supplies</option>
                                <option value="SS">School Supplies</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="quantity" id="item_Quantity" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pointsPrice" class="form-label">Point Price</label>
                            <input type="text" class="form-control" name="pointPrice" id="point_Price" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" name="img" id="Item_image" accept="image/*" onchange="previewImage(event)">
                        <img id="imagePreview" src="" alt="Image Preview" style="display:none; height:100px; width:100px; margin-top:10px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width:200px; font-size:20px;">Close</button>
                    <button type="submit" class="btn btn-primary" style="width:200px; font-size:20px;">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script> 
  $(document).ready(function() {
        let currentPage = 1;
        const rowsPerPage = 6;

        function loadAdminData(page = 1) {
    $.ajax({
        url: "<?= base_url('/displayInventory') ?>",
        type: "GET",
        dataType: "json",
        success: function(response) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const paginatedData = response.slice(start, end);
            let tableRows = '';

            if (paginatedData.length === 0) {
                tableRows = `<tr>
                                <td colspan="6" class="text-center text-muted">No items available in inventory.</td>
                             </tr>`;
            } else {
                $.each(paginatedData, function(index, inventory) {
                    tableRows += `<tr>
                        <td>${inventory.item}</td>
                        <td>${inventory.category}</td>
                        <td>${inventory.point_price}</td>
                        <td>
                            <img class="img-table" src="/images/inventory/redeemed/${inventory.img}" alt="Image" onclick="showImagePreview('/images/inventory/redeemed/${inventory.img}')">
                        </td>
                        <td>
                            <a href="#" class="btn btn-warning btn-lg" 
                               data-bs-toggle="modal" data-bs-target="#editInventory"
                               data-id="${inventory.id}"
                               data-item="${inventory.item}"
                               data-category="${inventory.category}"
                               data-quantity="${inventory.quantity}"
                               data-pointPrice="${inventory.point_price}"
                               data-img="${inventory.img}">Edit</a>
                               
                            <a href="deleteInventory/${inventory.id}" onclick="return confirm('Are you sure you want to delete this item?')" class="btn btn-danger btn-lg">Delete</a>
                        </td>
                    </tr>`;
                });
            }

            $("#adminTableBody").html(tableRows);
            setupPagination(response.length, page);
        }
    });
}


        function setupPagination(totalRows, currentPage) {
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            let paginationHtml = `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                                    <a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a>
                                  </li>`;

            for (let i = 1; i <= totalPages; i++) {
                paginationHtml += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                                       <a class="page-link" href="#" data-page="${i}">${i}</a>
                                   </li>`;
            }

            paginationHtml += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                                   <a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>
                               </li>`;

            $("#pagination").html(paginationHtml);
        }

        $(document).on('click', '#pagination a.page-link', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            if (page) {
                loadAdminData(page);
            }
        });

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
    const editModal = document.getElementById('editInventory');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const item = button.getAttribute('data-item');
        const category = button.getAttribute('data-category');
        const quantity = button.getAttribute('data-quantity');
        const pointPrice = button.getAttribute('data-pointPrice');
        const img = button.getAttribute('data-img');
        const imageSrc = `/images/inventory/redeemed/${button.getAttribute('data-img')}`;

        document.getElementById('item_Id').value = id;
        document.getElementById('item_Name').value = item;
        document.getElementById('item_Category').value = category;

        document.getElementById('item_Quantity').value = quantity;
        document.getElementById('point_Price').value = pointPrice;
        
        // document.getElementById('Item_image').value = img;
        
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.src = imageSrc;
        imagePreview.style.display = 'block';

        
    });
});

function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.src = reader.result;
        imagePreview.style.display = 'block';
    }
    reader.readAsDataURL(event.target.files[0]);
}

function showImagePreview(imageSrc) {
    $('#modalImage').attr('src', imageSrc);
    $('#imagePreviewModal').modal('show');
}
</script>

<nav>
    <ul class="pagination" id="pagination"></ul>
</nav>
    <script src="/js/admin/include/jquery/jsquery.min.js"></script>
    <script src="/js/admin/include/bootstrap/bootstrap.bundle.min.js"></script>

</body>
</html>
