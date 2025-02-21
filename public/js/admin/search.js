$(document).ready(function () {
    $("#searchInput").on("keyup", function () {
        let query = $(this).val();
        if (query.length > 0) {
            $.ajax({
                url: "/search",
                type: "GET",
                data: { query: query },
                success: function (data) {
                    let resultHTML = "";
                    data.forEach(user => {
                        resultHTML += `<div class="result-item" data-id="${user.id}"><a href="applicantdetails/${user.id}">${user.idNumber}</a></div>`;
                    });

                    $("#result").html(resultHTML);
                }
            });
        } else {
            $("#result").html("");
        }
    });

    $(document).on("click", ".result-item", function () {
        let userId = $(this).data("id");
        $.ajax({
            url: "/user/" + userId,
            type: "GET",
            success: function (data) {
                let userDetails = `
                    <h3>Applicant Details:</h3>
                    <p><strong>ID Number:</strong> ${data.idNumber}</p>
                    <p><strong>Name:</strong> ${data.firstName} ${data.lastName}</p>
                    <p><strong>Email:</strong> ${data.email}</p>
                    <p><strong>Phone:</strong> ${data.contactNo}</p>
                    <p><strong>Address:</strong> ${data.address}</p>
                    <p><strong>Points:</strong> ${data.totalPoints}</p>
                `;
                $("#userDetails").html(userDetails);
                $("#result").html(""); // Hide suggestions after selecting
                $("#searchInput").val(data.firstName); // Fill input with selected name
            }
        });
    });
});