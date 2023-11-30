<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Database Table Display</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        table {
            max-width: 100%;
            overflow-x: auto;
        }

        table th,
        table td {
            white-space: nowrap;
        }
        #message-box {
            display: none;
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="container mt-5">
<div id="alert-container"></div>
    <div class="container">
        <h2 class="mb-4">Register Table</h2>
        
        <div id="message-box" class="alert" role="alert"></div>

        <?php
        include 'data.php';

        // Step 2: Fetch data from the database
        $sql = "SELECT * FROM registration_table";
        $result = $conn->query($sql);

        // Step 3: Display data in an HTML table using Bootstrap
        if ($result->num_rows > 0) {
            echo '<div class="row" id="table-container">';
            echo '<div class="col-md-12">';
            echo '<div class="table-responsive">';
            echo '<table class="table table-hover table-bordered">';
            echo '<thead class="thead-dark"><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Gender</th><th>City</th><th>Address</th><th>Country</th><th>Subject</th><th>Message</th><th>File Url</th><th>Edit</th><th>Delete</th></tr></thead>';
            echo '<tbody>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td class="text-center">' . $row['id'] . '</td>';
                echo '<td class="text-center">' . $row['firstname'] . '</td>';
                echo '<td class="text-center">' . $row['lastname'] . '</td>';
                echo '<td class="text-center">' . $row['email'] . '</td>';
                echo '<td class="text-center">' . $row['gender'] . '</td>';
                echo '<td class="text-center">' . $row['city'] . '</td>';
                echo '<td class="text-center">' . $row['adress'] . '</td>';
                echo '<td class="text-center">' . $row['country'] . '</td>';
                echo '<td class="text-center">' . $row['subject'] . '</td>';
                echo '<td class="text-center">' . $row['message'] . '</td>';
                echo '<td class="text-center"><a href="' . $row['fileurl'] . '">' . $row['fileurl'] . '</a></td>';
                echo '<td class="text-center"><a href="edit.php?id=' . $row['id'] . '" class="btn btn-secondary " id="edit-btn">Edit</a></td>';
                echo '<td class="text-center"><a href="delete.php?id=' . $row['id'] . '" class="btn btn-danger delete-btn">Delete</a></td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        } else {
            echo "0 results";
        }

        // Close the database connection
        $conn->close();
        ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <!-- Add this script section to your HTML file -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        // Event listener for the "Edit" buttons
        $("#edit-btn").click(function (e) {
            e.preventDefault();
            var editUrl = $(this).attr("href");

            // AJAX request to get the edit form
            $.ajax({
                type: 'GET',
                url: editUrl,
                success: function (response) {
                    console.log("Edit success:", response);
                    // Display the edit form in a modal
                    $('#update_form .modal-body').html(response);
                    $('#update_form').modal('show');
                },
                error: function (error) {
                    console.log('Error: ' + error);
                }
            });
        });

        // Event listener for the "Save Changes" button in the edit modal
        $(document).on("submit", "#update_form", function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            // AJAX request to update the record
            $.ajax({
                type: 'POST', // or 'PUT' depending on your server-side implementation
                url: 'update.php', // replace with the actual URL to handle the update
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    // Close the modal
                    $('#update_form').modal('hide');

                    $('#message-box').removeClass('alert-danger').addClass('alert-success').html('Record updated successfully.').show();

                    // Hide the message after a few seconds
                    setTimeout(function () {
                        $('#message-box').hide();
                    }, 3000);

                    // Update the table content
                    // You may need to add logic to selectively update the table row
                    // based on the updated record's ID or other identifier
                    // For simplicity, let's reload the entire page here
                    location.reload();
                },
                error: function (error) {
                    console.log('Error: ' + error);
                }
            });
        });

        // Event listener for the "Delete" buttons
        $(".delete-btn").click(function (e) {
            e.preventDefault();
            var deleteUrl = $(this) .attr("href");

            // Confirm deletion with the user
            if (confirm("Are you sure you want to delete this record?")) {
               
                // AJAX request to delete the record
                $.ajax({
                    type: 'GET', // or 'DELETE' depending on your server-side implementation
                    url: deleteUrl,
                    success: function (response) {
                       
                        // Update the table content
                        // You may need to add logic to selectively remove the table row
                        // based on the deleted record's ID or other identifier
                        // For simplicity, let's reload the entire page here
                        showAlert("Record deleted successfully!", "success");
                        $('#table-container tbody').html($(response).find('tbody').html());
                       
                        // location.reload();
                        // window.location.href = 'reg_table.php'
                       
                    },
                    error: function (error) {
                        console.log('Error: ' + error);
                    }
                });
                
            }
        });
         
        function showAlert(message, type) {
            var alertBox = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                '</div>';

            // Append the alert to a specific container
            $('#alert-container').append(alertBox);

            // Hide the alert after a few seconds
            setTimeout(function () {
                // Remove the oldest alert from the container
                $('#alert-container .alert:first-child').alert('close');
            }, 3000);
        }
   
    });
</script>

</body>

</html>
