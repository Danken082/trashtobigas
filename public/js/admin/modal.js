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