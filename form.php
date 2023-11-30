<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP Form Validation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .error {
            color: red;
        }
        .message-box {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>

<body>

    <?php

    include 'data.php';
    $fnameErr = $lnameErr = $emailErr = $genderErr = $cityErr = $addressErr = $countryErr = $subjectErr = $messageErr = $fileErr = $checkErr = "";
    $fname = $lname = $email = $gender = $city = $address = $country = $subject = $message = $file = $check = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate First Name
        if (empty($_POST["fname"])) {
            $fnameErr = "First Name is required";
        } else {
            $fname = test_input($_POST["fname"]);
            // Check if name contains only letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/", $fname)) {
                $fnameErr = "Only letters and white space allowed";
            }
        }

        // Validate Last Name
        if (empty($_POST["lname"])) {
            $lnameErr = "Last Name is required";
        } else {
            $lname = test_input($_POST["lname"]);
            // Check if name contains only letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/", $lname)) {
                $lnameErr = "Only letters and white space allowed";
            }
        }

        // Validate Email
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            // Check if email is valid
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }

        // Validate Gender
        if (empty($_POST["inlineRadioOptions"])) {
            $genderErr = "Gender is required";
        } else {
            $gender = test_input($_POST["inlineRadioOptions"]);
        }


        // Validate City
        if (empty($_POST["city"])) {
            $cityErr = "City is required";
        } else {
            $city = test_input($_POST["city"]);
        }

        // Validate Address
        if (empty($_POST["address"])) {
            $addressErr = "Address is required";
        } else {
            $address = test_input($_POST["address"]);
        }

        // Validate Country
        if (empty($_POST["country"])) {
            $countryErr = "Country is required";
        } else {
            $country = test_input($_POST["country"]);
        }

        // Validate Subject
        if (empty($_POST["subject"])) {
            $subjectErr = "Subject is required";
        } else {
            $subject = test_input($_POST["subject"]);
        }

        // Validate Message
        if (empty($_POST["message"])) {
            $messageErr = "Message is required";
        } else {
            $message = test_input($_POST["message"]);
        }

        // Validate File
        // Add file validation logic if needed

        // Validate Checkbox
        if (empty($_POST["exampleCheck1"])) {
            $checkErr = "Checkbox must be checked";
        } else {
            $check = test_input($_POST["exampleCheck1"]);
        }

        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            $fileErr = "File upload failed";
        }

        if (empty($fnameErr) && empty($lnameErr) && empty($emailErr) && empty($genderErr) && empty($cityErr) && empty($addressErr) && empty($countryErr) && empty($subjectErr) && empty($messageErr) && empty($fileErr) && empty($checkErr)) {
            
            $allowedImageTypes = ["image/jpeg", "image/png", "image/jpg","image/svg","image/gif"];
            
            // Perform file upload and get the file URL
            $uploadDir = "C:/xampp1/htdocs/php/phpformvaliadtion/files/";
            $uploadFile = $uploadDir . basename($_FILES["file"]["name"]);
            if (in_array($_FILES["file"]["type"], $allowedImageTypes)) 
            {
                // Move the uploaded file to the destination directory
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadFile)) {
                    // File upload successful, save the file URL
                    $fileUrl = "http://localhost/php/phpformvaliadtion/files/" . basename($_FILES["file"]["name"]);

                    // Perform database insertion
                    $stmt = $conn->prepare("INSERT INTO registration_table (firstname, lastname, email, gender, city, adress, country, subject, message, fileurl) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                    // Check for a successful prepare
                    if ($stmt) {
                        $stmt->bind_param("ssssssssss", $fname, $lname, $email, $gender, $city, $address, $country, $subject, $message, $fileUrl);

                        // Execute the prepared statement
                        if ($stmt->execute()) {
                            
                            echo "<div class='message-box'>Data Entered successfully</div>";
                            echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
                            echo "<script>
                                \$(document).ready(function () {
                                    setTimeout(function () {
                                        \$('.message-box').fadeOut('slow');
                                    }, 1500); // Hide the message after 1.5 seconds
                                    setTimeout(function () {
                                        // AJAX function to redirect to reg_table.php
                                        \$.ajax({
                                            type: 'GET',
                                            url:'form.php',
                                            success: function (response) {
                                                // Replace the current document with the response (reg_table.php)
                                                document.open();
                                                document.write(response);
                                                document.close();
                                            },
                                            error: function (error) {
                                                console.log('Error: ' + error);
                                            }
                                        });
                                    }, 1500); 
                                });
                            </script>";
                            $fname = $lname = $email = $gender = $city = $address = $country = $subject = $message = $file = $check = "";
                        } else {
                            echo "Error: " . $stmt->error;
                        }

                        // Close the statement
                        $stmt->close();
                    } else {
                        echo "Error in the prepared statement: " . $conn->error;
                    }
                } else {
                    echo "File upload failed!";
                }
            }else {
                echo "<div class='message-box'>Only image files (JPEG, PNG, GIF) are allowed.</div>";
            }
        } else {
        //    echo" <div style='display:flex; justify-content:center; align-items:center; width:80%; backgrpound-color:light-green; >";
            echo"<div class='message-box'><span>Validation errors!!.<br> Please check your input.</span></div>";
            // echo"</div>";
        }

        // ...

    }
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    ?>

    <div class="container">
        <div class="col-md-12 text-center mt-5">
            <h1 class="display-5 h1">Registration Form</h1>
        </div>
        <div class="form p-5">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data"  autocomplete="on">
                <div class="form-group col-md-6 float-start p-3">
                    <label for="fname">First Name</label>
                    <input type="text" class="form-control" name="fname" value="<?php echo $fname; ?>" aria-describedby="fnameHelp" placeholder="Enter your first name">
                    <span class="error">* <?php echo $fnameErr; ?></span>
                </div>
                <div class="form-group col-md-6 float-start p-3">
                    <label for="lname">Last Name</label>
                    <input type="text" class="form-control" name="lname" value="<?php echo $lname; ?>" aria-describedby="lnameHelp" placeholder="Enter your last name">
                    <span class="error">* <?php echo $lnameErr; ?></span>
                </div>
                <div class="form-group col-md-12 float-start p-3">
                    <label for="Email">Email address</label>
                    <input type="email" class="form-control" name="email" id="Email" value="<?php echo $email; ?>" aria-describedby="emailHelp" placeholder="Enter email">
                    <span class="error">* <?php echo $emailErr; ?></span>
                </div>
                <div class="form-group form-check col-md-6 float-start p-3 pt-5">
                    <label for="form-check-label">Gender</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="femaleGender" value="Female" <?php echo ($gender === 'Female') ? ' checked' : ''; ?>>
                        <label class="form-check-label" for="femaleGender">Female</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="maleGender" value="Male" <?php echo ($gender === 'Male') ? ' checked' : ''; ?>>
                        <label class="form-check-label" for="maleGender">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="otherGender" value="Other" <?php echo ($gender === 'Other') ? ' checked' : ''; ?>>
                        <label class="form-check-label" for="otherGender">Other</label>
                    </div>
                    <span class="error">* <?php echo $genderErr; ?></span>
                </div>

                <div class="form-group col-md-6 float-start p-3">
                    <label for="city">City</label>
                    <input type="text" class="form-control" value="<?php echo $city; ?>" name="city" id="city" placeholder="city">
                    <span class="error">* <?php echo $cityErr; ?></span>
                </div>
                <div class="form-group col-md-12 float-start p-3">
                    <label for="address">Address</label>
                    <input class="form-control" name="address" value="<?php echo $address; ?>" rows="3" style="height:100px;">
                    <span class="error">* <?php echo $addressErr; ?></span>
                </div>
                <div class="form-group col-md-6 float-start p-3">
                    <label for="country">Country</label>
                    <select class="form-control" name="country">
                        <option value="">Select Country</option>
                        <option value="India" <?php echo ($country === 'India') ? ' selected' : ''; ?>>India</option>
                        <option value="China" <?php echo ($country === 'China') ? ' selected' : ''; ?>>China</option>
                        <option value="Pakistan" <?php echo ($country === 'Pakistan') ? ' selected' : ''; ?>>Pakistan</option>
                        <option value="Afghanistan" <?php echo ($country === 'Afghanistan') ? ' selected' : ''; ?>>Afghanistan</option>
                        <option value="Sri Lanka" <?php echo ($country === 'Sri Lanka') ? ' selected' : ''; ?>>Sri Lanka</option>
                        <option value="Nepal" <?php echo ($country === 'Nepal') ? ' selected' : ''; ?>>Nepal</option>
                        <option value="Myanmar" <?php echo ($country === 'Myanmar') ? ' selected' : ''; ?>>Myanmar</option>
                        <option value="Bangladesh" <?php echo ($country === 'Bangladesh') ? ' selected' : ''; ?>>Bangladesh</option>
                        <option value="Saudi Arabia" <?php echo ($country === 'Saudi Arabia') ? ' selected' : ''; ?>>Saudi Arabia</option>
                        <option value="Dubai" <?php echo ($country === 'Dubai') ? ' selected' : ''; ?>>Dubai</option>
                    </select>

                    <span class="error">* <?php echo $countryErr; ?></span>
                </div>
                <div class="form-group col-md-6 float-start p-3">
                    <label for="subject">Subject</label>
                    <input type="text" class="form-control" value="<?php echo $subject; ?>" name="subject" id="subject" placeholder="subject">
                    <span class="error">* <?php echo $subjectErr; ?></span>
                </div>
                <div class="form-group col-md-6 float-start p-3">
                    <label for="message">Message</label>
                    <input type="text" class="form-control" value="<?php echo $message; ?>" name="message" id="message" placeholder="subject">

                    <span class="error">* <?php echo $messageErr; ?></span>
                </div>
                <div class="form-group col-md-6 float-start p-3">
                    <label for="file">File Upload</label>
                    <input type="file" class="form-control" value="<?php echo $file; ?>" name="file" id="file">
                    <span class="error">* <?php echo $fileErr; ?></span>

                </div>
                <div class="form-check form-group col-md-12 float-start p-3">
                    <input type="checkbox" class="form-check-input pl-5" name="exampleCheck1" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    <span class="error">* <?php echo $checkErr; ?></span>
                </div>
                <button type="submit" name="submit" value="submit" class="btn btn-primary" onclick="loadDoc()">Submit</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    

</body>

</html>