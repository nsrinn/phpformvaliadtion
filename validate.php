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
       if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
           $uploadDir = "C:/xampp1/htdocs/php/phpformvaliadtion/files/"; // Specify your upload directory
           // Specify your upload directory
           $uploadFile = $uploadDir . basename($_FILES["file"]["name"]);

           // Perform file upload
           if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadFile)) {
               // File upload successful, save the file URL
               $fileUrl = "http://localhost/php/phpformvaliadtion/files/" . basename($_FILES["file"]["name"]);
               // Replace with your domain
           } 
       }
       if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
           // Your existing file upload logic here...

           // Assuming the file upload was successful, proceed to store data in the database
           $sql = "INSERT INTO registration_table (firstname, lastname, email, gender, city, adress, country, subject, message, fileurl)
               VALUES ('$fname', '$lname', '$email', '$gender', '$city', '$address', '$country', '$subject', '$message', '$fileUrl')";

           if ($conn->query($sql) === FALSE) {
               echo "Error inserting data: " . $conn->error;
           } 
       }
   }

   function test_input($data)
   {
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
   }
    ?>