<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>session announcements table</title>
  <style>
    /* Normal link */
    a {
      padding: 10px;
      color: white;

      background-color: grey;
      text-decoration: none;
      margin-right: 15px;
    }

    /* Visited link */
    a:visited {
      color: purple;
    }
    /* Unvisited link */
    a:link {
      color: brown; /* Changed to lowercase */
    }
    /* Hover effect */
    a:hover {
      background-color: red;
    }

    /* Active link */
    a:active {
      background-color: red;
    }

    /* Extend margin left for search button */
    button.btn {
      margin-left: 15px; /* Adjust this value as needed */
      margin-top: 4px;
    }
    /* Extend margin left for search button */
    input.form-control {
      margin-left: 1300px; /* Adjust this value as needed */

      padding: 8px;
     
    }
  </style>
   <!-- JavaScript validation and content load for insert data-->
        <script>
            function confirmInsert() {
                return confirm('Are you sure you want to insert this record?');
            }
        </script>
  
<header>
   

</head>

<body bgcolor="yellowgreen">
    <h1 style="margin-left: 150px; font-size: 54px;">VIRTUAL SUPPORT GROUP PLATFORM</h1>
    <div class="navbar-links" style="margin-top: 10px; font-size: 30px; background-color: black; color: white; padding: 10px;">
        <a href="home.html" style="color: aliceblue;">HOME</a>
        <a href="service.html" style="color: aliceblue;">ABOUT</a>
        <a href="about.html" style="color: aliceblue;">PRODUCT</a>
        <a href="contact.html" style="color: aliceblue;">CONTACT</a>
        
        <div class="dropdown">
            <a href="#" style="padding: 10px; color: white; background-color: skyblue; text-decoration: none;">TABLES</a>
            <div class="dropdown-content">
                <!-- Links inside the dropdown menu -->
                <a href="anouncements.php">anouncements</a>
                <a href="groupleaders.php">groupleaders</a>
                <a href="attendance.php">attendance</a>
                <a href="groupsessions.php">groupsessions</a>
                <a href="discussiontopics.php">discussiontopics</a>
                <a href="Feedback.php">Feedback</a>
                <a href="members.php">members</a>
                <a href="messages.php">messages</a>
                <a href="polls.php">polls</a>
                <a href="resources.php">resources</a>            
            </div>
        </div>
    </div>

</header>
<section>
<h1> Form</h1>

    <form method="post" onsubmit="return confirmInsert();">
        <label for="member_id">member_id:</label>
        <input type="number" id="member_id" name="member_id"><br><br>

        <label for="member_name">member_name:</label>
        <input type="text" id="member_name" name="member_name" required><br><br>

        <label for="group_leader_id">group_leader_id:</label>
        <input type="number" id="group_leader_id" name="group_leader_id" required><br><br>

        <input type="submit" name="add" value="Insert">

    </form>

    <?php
    // Connection details
    include('connection.php');


    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters with appropriate data types
        $stmt = $connection->prepare("INSERT INTO members (member_id,member_name,group_leader_id) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $member_id,$member_name,$group_leader_id);

        // Set parameters from POST data with validation (optional)
        $member_id = intval($_POST['member_id']); // Ensure integer for ID
        $member_name = htmlspecialchars($_POST['member_name']); // Prevent XSS
        $group_leader_id = htmlspecialchars($_POST['group_leader_id']); // Prevent XSS
        // Execute prepared statement with error handling
        if ($stmt->execute()) {
            echo "New record has been added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $connection->close();
    ?>

<?php
// Connection details
include('connection.php');

// SQL query to fetch data from category table
$sql = "SELECT * FROM members";
$result = $connection->query($sql);

?>
<h2>Data for anouncements Form</h2>
    <table border="1">
        <tr>
            <th>members ID</th>
            <th>members Names</th>
            <th>group leader id</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Define connection parameters
        include('connection.php');


        // Prepare SQL query to retrieve customer.
        $sql = "SELECT * FROM members";
        $result = $connection->query($sql);

        // Check if there are any product
        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                $member_id = $row['member_id']; // Fetch the Id
                echo "<tr>
                    <td>" . $row['member_id'] . "</td>
                    <td>" . $row['member_name'] . "</td>
                    <td>" . $row['group_leader_id'] . "</td>
                    <td><a style='padding:2px' href='delete_members.php?member_id=$member_id'>Delete</a></td> 
                    <td><a style='padding:2px' href='update_members.php?member_id=$member_id'>Update</a></td> 
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No data found</td></tr>";
        }
        // Close the database connection
        $connection->close();
        ?>
    </table>
  </body>
    </section>

  
<footer>
  <center> 
    <b><h2>UR CBE BIT &copy, 2024 & reg</h2></b>
  </center>
</footer>
</body>
</html>