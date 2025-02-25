<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <h2>User List</h2>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <a href="#" class="user-link" data-id="<?= $user['id']; ?>">
                    <?= esc($user['firstName']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <h3>User Details</h3>
    <div id="user-details"></div>

    <script>
        $(document).ready(function() {
            $(".user-link").click(function(e) {
                e.preventDefault(); // Prevent default anchor behavior

                let userId = $(this).data("id");

                $.ajax({
                    url: "<?= base_url('user/getUser'); ?>/" + userId,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        $("#user-details").html(
                            "<p><strong>Username:</strong> " + response.lastName + "</p>" +
                            "<p><strong>Email:</strong> " + response.email + "</p>"
                        );
                    },
                    error: function() {
                        $("#user-details").html("<p>User not found.</p>");
                    }
                });
            });
        });
    </script>

</body>
</html>
