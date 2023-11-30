<style>
     .message-box {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #d4edda;
            color: #155724;
        }
</style>
<?php
include 'data.php';
// include 'validate.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $gender = $_POST['inlineRadioOptions'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $file = $_FILES['file'];

    // Debugging: Print received file information
    // echo "Debug: File Information - <br>";
    // print_r($file);

    // Check if a new file is selected
    if (is_uploaded_file($file["tmp_name"])) {
        $uploadDir = "C:/xampp1/htdocs/php/phpformvaliadtion/files/";
        $uploadFile = $uploadDir . basename($file["name"]);

        // Debugging: Print file upload information
        // echo "Debug: Uploading File - <br>";
        // echo "Upload Dir: $uploadDir, Upload File: $uploadFile<br>";

        move_uploaded_file($file["tmp_name"], $uploadFile);
        $fileUrl = "http://localhost/php/phpformvaliadtion/files/" . basename($file["name"]);

        // Debugging: Print file URL after upload
        // echo "Debug: File URL After Upload: $fileUrl<br>";

        // Update the file column in the database
        $sqlUpdateFile = "UPDATE registration_table SET fileurl=? WHERE id=?";
        $stmtUpdateFile = $conn->prepare($sqlUpdateFile);
        $stmtUpdateFile->bind_param("si", $fileUrl, $id);
        $stmtUpdateFile->execute();
        $stmtUpdateFile->close();
    } else {
        // No new file uploaded, retrieve existing file URL from the database
        $sqlSelectFile = "SELECT fileurl FROM registration_table WHERE id=?";
        $stmtSelectFile = $conn->prepare($sqlSelectFile);
        $stmtSelectFile->bind_param("i", $id);
        $stmtSelectFile->execute();
        $stmtSelectFile->bind_result($existingFilePath);
        $stmtSelectFile->fetch();
        $stmtSelectFile->close();

        // Debugging: Print existing file path
        // echo "Debug: Existing File Path: $existingFilePath <br>";

        // Set fileUrl to the existing file path or an empty string
        $fileUrl = $existingFilePath ?? '';
    }

    // Debugging: Print final file URL to be updated in the database
    // echo "Debug: Final File URL to Update: $fileUrl<br>";

    // Update the record in the database with other fields
    $sqlUpdateRecord = "UPDATE registration_table SET firstname=?, lastname=?, email=?, gender=?, city=?, adress=?, country=?, subject=?, message=?, fileurl=? WHERE id=?";
    $stmtUpdateRecord = $conn->prepare($sqlUpdateRecord);
    $stmtUpdateRecord->bind_param("ssssssssssi", $fname, $lname, $email, $gender, $city, $address, $country, $subject, $message, $fileUrl, $id);

    if ($stmtUpdateRecord->execute()) {
        
        // echo "Record updated successfully<br>";
        // echo "<div class='message-box'>Record updated successfully</div>";
        // echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
        // echo "<script>
            // \$(document).ready(function () {
            //     setTimeout(function () {
            //         \$('.message-box').fadeOut('slow');
            //     }, 1500); // Hide the message after 1.5 seconds
            //     setTimeout(function () {
            //         // AJAX function to redirect to reg_table.php
            //         \$.ajax({
            //             type: 'GET',
            //             url: 'reg_table.php',
            //             success: function (response) {
            //                 // Replace the current document with the response (reg_table.php)
            //                 window.location.href = 'reg_table.php';
            //                 // document.open();
            //                 // document.write(response);
            //                 // document.close();
            //             },
            //             error: function (error) {
            //                 console.log('Error: ' + error);
            //             }
            //         });
            //     }, 1500); 
            // });
         
            // window.location.href = 'reg_table.php';
        // </script>";
        
    } 
    // else {
    //     echo "Error updating record: " . $stmtUpdateRecord->error;
    // }
    // if ($updateSuccess) {
    //     echo "success";
    // } else {
    //     echo "error";
    // }
    $stmtUpdateRecord->close();
    $conn->close();
}
?>
<!-- <script>
     function loadDoc() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Handle the response here
                alert('Form updated successfully!');
               
            }
        };
        xhttp.open("POST", "reg_table.php", true);
        xhttp.send();
    }
</script> -->
