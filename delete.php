<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Database Table Display</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" ></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    
    <style>
        table {
            max-width: 1400px;
            /* height: auto; */

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

    <div class="container mt-5">
        <?php
        include 'data.php'; // Include your database connection file

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
            $id = $_GET['id'];

            // Delete the record from the database
            $sql = "DELETE FROM registration_table WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                ob_start();
                include 'reg_table.php'; // Assuming reg_table.php generates the HTML for the table
                $tableContent = ob_get_clean();
        
                echo $tableContent;
                // Record deleted successfully
                // echo "<div class='message-box'>Record deleted successfully</div>";
                echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
                echo "<script>
                    
                    // \$(document).ready(function () {
                    //     setTimeout(function () {
                    //         \$('.message-box').fadeOut('slow');
                    //     }, 1500); // Hide the message after 3 seconds
                    //     setTimeout(function () {
                    //         // AJAX function to redirect to reg_table.php
                    //         \$.ajax({
                    //             type: 'GET',
                    //             url: 'reg_table.php',
                    //             success: function (response) {
                    //                 // Replace the current document with the response (reg_table.php)
                    //                 document.open();
                    //                 document.write(response);
                    //                 document.close();
                                   
                    //             },
                    //             error: function (error) {
                    //                 console.log('Error: ' + error);
                    //             }
                    //         });
                    //     }, 1500); 
                    //     ;
                    // });
                  </script>";
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        
           
        }
        ?>
    </div>
   
</body>