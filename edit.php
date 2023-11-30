<?php
include 'data.php';
include 'validate.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve the record with the given ID
    $sql = "SELECT * FROM registration_table WHERE id = $id";
    $result = $conn->query($sql);
    if (!$result) {
        die("Error in query: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Display a form with the existing data for editing
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Updations</title>
            <!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha384-GLhlTQ8iGZt38naSoWXrCUbJSejsq5t9P1nTkceqF5s4itd6d4j9H10t6hbd00dP" crossorigin="anonymous"></script> -->

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
            <style>
                .error {
                    color: red;
                }
            </style>
            <!-- Include your necessary head elements -->
        </head>

        <body>
            <div class="container">
                <h2 style="margin-top: 10%; display:flex; justify-content:center;align-items:center;">Edit Details</h2>
                <div id="alert-container"></div>
                <form action="update.php" method="post" enctype="multipart/form-data" id="update_form">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <!-- Include your form fields pre-filled with existing data -->
                    <!-- <label for="fname">First Name</label>
                    <input type="text" name="fname" value="<?php echo $row['firstname']; ?>" required> -->
                    <div class="form-group col-md-6 float-start p-3">
                        <label for="fname">First Name</label>
                        <input type="text" class="form-control" name="fname" value="<?php echo $row['firstname']; ?>" aria-describedby="fnameHelp" placeholder="Enter your first name">
                        <span class="error">* <?php echo $fnameErr; ?></span>
                    </div>
                    <div class="form-group col-md-6 float-start p-3">
                        <label for="lname">Last Name</label>
                        <input type="text" class="form-control" name="lname" value="<?php echo $row['lastname'];  ?>" aria-describedby="lnameHelp" placeholder="Enter your last name">
                        <span class="error">* <?php echo $lnameErr; ?></span>
                    </div>
                    <div class="form-group col-md-12 float-start p-3">
                        <label for="Email">Email address</label>
                        <input type="email" class="form-control" name="email" id="Email" value="<?php echo $row['email']; ?>" aria-describedby="emailHelp" placeholder="Enter email">
                        <span class="error">* <?php echo $emailErr; ?></span>
                    </div>
                    <div class="form-group form-check col-md-6 float-start p-3 pt-5">
                        <label for="form-check-label">Gender</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="femaleGender" value="Female" <?php echo ($row['gender'] === 'Female') ? ' checked' : ''; ?>>
                            <label class="form-check-label" for="femaleGender">Female</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="maleGender" value="Male" <?php echo ($row['gender'] === 'Male') ? ' checked' : ''; ?>>
                            <label class="form-check-label" for="maleGender">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="otherGender" value="Other" <?php echo ($row['gender'] === 'Other') ? ' checked' : ''; ?>>
                            <label class="form-check-label" for="otherGender">Other</label>
                        </div>
                        <span class="error">* <?php echo $genderErr; ?></span>
                    </div>

                    <div class="form-group col-md-6 float-start p-3">
                        <label for="city">City</label>
                        <input type="text" class="form-control" value="<?php echo $row['city']; ?>" name="city" id="city" placeholder="city">
                        <span class="error">* <?php echo $cityErr; ?></span>
                    </div>
                    <div class="form-group col-md-12 float-start p-3">
                        <label for="address">Address</label>
                        <input class="form-control" name="address" value="<?php echo $row['adress']; ?>" rows="3" style="height:100px;">
                        <span class="error">* <?php echo $addressErr; ?></span>
                    </div>
                    <div class="form-group col-md-6 float-start p-3">
                        <label for="country">Country</label>
                        <select class="form-control" name="country">
                            <option value="">Select Country</option>
                            <option value="India" <?php echo ($row['country'] === 'India') ? ' selected' : ''; ?>>India</option>
                            <option value="China" <?php echo ($row['country'] === 'China') ? ' selected' : ''; ?>>China</option>
                            <option value="Pakistan" <?php echo ($row['country'] === 'Pakistan') ? ' selected' : ''; ?>>Pakistan</option>
                            <option value="Afghanistan" <?php echo ($row['country'] === 'Afghanistan') ? ' selected' : ''; ?>>Afghanistan</option>
                            <option value="Sri Lanka" <?php echo ($row['country'] === 'Sri Lanka') ? ' selected' : ''; ?>>Sri Lanka</option>
                            <option value="Nepal" <?php echo ($row['country'] === 'Nepal') ? ' selected' : ''; ?>>Nepal</option>
                            <option value="Myanmar" <?php echo ($row['country'] === 'Myanmar') ? ' selected' : ''; ?>>Myanmar</option>
                            <option value="Bangladesh" <?php echo ($row['country'] === 'Bangladesh') ? ' selected' : ''; ?>>Bangladesh</option>
                            <option value="Saudi Arabia" <?php echo ($row['country'] === 'Saudi Arabia') ? ' selected' : ''; ?>>Saudi Arabia</option>
                            <option value="Dubai" <?php echo ($row['country'] === 'Dubai') ? ' selected' : ''; ?>>Dubai</option>
                        </select>

                        <span class="error">* <?php echo $countryErr; ?></span>
                    </div>
                    <div class="form-group col-md-6 float-start p-3">
                        <label for="subject">Subject</label>
                        <input type="text" class="form-control" value="<?php echo $row['subject']; ?>" name="subject" id="subject" placeholder="subject">
                        <span class="error">* <?php echo $subjectErr; ?></span>
                    </div>
                    <div class="form-group col-md-6 float-start p-3">
                        <label for="message">Message</label>
                        <input type="text" class="form-control" value="<?php echo $row['message']; ?>" name="message" id="message" placeholder="subject">

                        <span class="error">* <?php echo $messageErr; ?></span>
                    </div>
                    <!-- <div class="form-group col-md-6 float-start p-3">
                        <label for="file">File Upload</label>
                        <input type="file" class="form-control" value="<?php echo $row['fileurl']; ?>" name="file" >
                        <p> Selected file Path:<?php echo $row['fileurl']; ?></p>
                        <span class="error">* <?php echo $fileErr; ?></span>

                    </div> -->
                    <div class="form-group col-md-6 float-start p-3">
                        <label for="file">File Upload</label>
                        <input type="file" class="form-control" name="file">
                        <span class="error">* <?php echo $fileErr; ?></span>

                        <?php if (!empty($row['fileurl'])) : ?>
                            <?php $existingFilePath = $row['fileurl'] ?>
                            <p>Current File: <?php echo $existingFilePath; ?></p>
                            <label>
                                <input type="checkbox" name="deleteFile"> Delete current file
                            </label>
                        <?php endif; ?>
                    </div>
                    <!-- <div class="form-group col-md-6 float-start p-3">
                        <label for="file">File Upload</label>
                        <input type="file" class="form-control" value="<?php echo $row['fileurl']; ?>" name="file" id="file">
                        <span class="error">* <?php echo $fileErr; ?></span>

                    </div> -->
                    <div class="form-check form-group col-md-12 float-start p-3">
                        <input type="checkbox" class="form-check-input pl-5" name="exampleCheck1" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        <span class="error">* <?php echo $checkErr; ?></span>
                    </div>

                    <!-- Repeat for other fields -->

                    <button type="submit" name="submit" value="submit" class="btn btn-secondary" id="update">Update</button>
                </form>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
            <!-- Add this script section to your HTML file -->
            <script src="https://code.jquery.com/jquery-3.6.4.min.js" ></script>

            <!-- Your existing code ... -->

<!-- <script>
    $(document).ready(function() {
        $("#update_form").submit(function(e) {
            e.preventDefault();

            // Perform AJAX request
            $.ajax({
                type: "POST",
                url: "update.php", // Change this to the path of your server-side update script
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    // Display the success or error message
                    if (response.trim() === "success") {
                        // Show success message
                        showAlert("Record updated successfully!", "success");
                    } else {
                        // Show error message
                        showAlert("Failed to update record. Please check your input.", "danger");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        });

        // Function to show a Bootstrap alert message
        function showAlert(message, type) {
            var alertBox = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                '</div>';

            // Append the alert to a specific container
            $('#alert-container').html(alertBox);

            // Hide the alert after a few seconds
            setTimeout(function() {
                $('#alert-container').empty();
            }, 3000);
        }
    });
</script> -->

<!-- Your existing code ... -->


<!-- Add this script section to your HTML file -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
        $("#update_form").submit(function (e) {
            e.preventDefault();

            // Perform AJAX request
            $.ajax({
                type: "POST",
                url: "update.php", // Change this to the path of your server-side update script
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                   
                        showAlert("Record updated successfully!", "success");
                    
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        });

        // Function to show a Bootstrap alert message
        function showAlert(message, type) {
            var alertBox = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                '</div>';

            // Append the alert to a specific container
            $('#alert-container').html(alertBox);

            // Hide the alert after a few seconds
            setTimeout(function () {
                $('#alert-container').empty();
            }, 5000);
        }
    });
</script>



        </body>

        </html>
<?php
    } else {
        echo "Record not found.";
    }
}
?>