<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Session Announcements Table</title>
  <link rel="stylesheet" type="text/css" href="style.css" media="screen, tv, projection, handheld, print"/>
  <style>
    /* Link Styles */
    a {
      padding: 10px;
      color: white;
      background-color: grey;
      text-decoration: none;
      margin-right: 15px;
    }
    a:visited {
      color: purple;
    }
    a:link {
      color: brown;
    }
    a:hover, a:active {
      background-color: red;
    }

    /* Button and Form Styles */
    button.btn {
      margin-left: 15px;
      margin-top: 4px;
    }
    input.form-control {
      margin-left: 15px;
      padding: 8px;
    }
  </style>
</head>
<body bgcolor="yellowgreen">
<header>
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
        <a href="announcements.php">Announcements</a>
        <a href="groupleaders.php">Group Leaders</a>
        <a href="attendance.php">Attendance</a>
        <a href="groupsessions.php">Group Sessions</a>
        <a href="discussiontopics.php">Discussion Topics</a>
        <a href="feedback.php">Feedback</a>
        <a href="members.php">Members</a>
        <a href="messages.php">Messages</a>
        <a href="polls.php">Polls</a>
        <a href="resources.php">Resources</a>            
      </div>
    </div>
  </div>
</header>
<section>
  <h1>Form</h1>
  <form method="post" onsubmit="return confirmInsert();">
    <label for="resource_id">Resource ID:</label>
    <input type="number" id="resource_id" name="resource_id"><br><br>

    <label for="resource_name">Resource Name:</label>
    <input type="text" id="resource_name" name="resource_name" required><br><br>

    <label for="group_leader_id">Group Leader ID:</label>
    <input type="number" id="group_leader_id" name="group_leader_id" required><br><br>

    <input type="submit" name="add" value="Insert">
  </form>

  <?php
  // Include the database connection
  include('connection.php');

  // Check if the form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Prepare and bind parameters
      $stmt = $connection->prepare("INSERT INTO resources (resource_id, resource_name, group_leader_id) VALUES (?, ?, ?)");
      $stmt->bind_param("iss", $resource_id, $resource_name, $group_leader_id);

      // Set parameters from POST data
      $resource_id = intval($_POST['resource_id']);
      $resource_name = htmlspecialchars($_POST['resource_name']);
      $group_leader_id = intval($_POST['group_leader_id']);

      // Execute prepared statement with error handling
      if ($stmt->execute()) {
          echo "New record has been added successfully!";
      } else {
          echo "Error: " . $stmt->error;
      }

      $stmt->close();
  }

  // Close the database connection
  $connection->close();
  ?>

  <h2>Data for resources Form</h2>
  <table border="1">
    <tr>
      <th>Resource ID</th>
      <th>Resource Name</th>
      <th>Group Leader ID</th>
      <th>Delete</th>
      <th>Update</th>
    </tr>
    <?php
    // Include the database connection
    include('connection.php');

    // SQL query to fetch data from resources table
    $sql = "SELECT * FROM resources";
    $result = $connection->query($sql);

    // Check if there are any resources
    if ($result->num_rows > 0) {
        // Output data for each row
        while ($row = $result->fetch_assoc()) {
            $resource_id = $row['resource_id']; // Fetch the ID
            echo "<tr>
              <td>" . $row['resource_id'] . "</td>
              <td>" . $row['resource_name'] . "</td>
              <td>" . $row['group_leader_id'] . "</td>
              <td><a style='padding:2px' href='delete_resources.php?resource_id=$resource_id'>Delete</a></td> 
              <td><a style='padding:2px' href='update_resources.php?resource_id=$resource_id'>Update</a></td> 
            </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No data found</td></tr>";
    }
    // Close the database connection
    $connection->close();
    ?>
  </table>
</section>
<footer>
  <center><b><h2>UR CBE BIT &copy; 2024 &reg;</h2></b></center>
</footer>
<script>
  // JavaScript function for confirmation on form submission
  function confirmInsert() {
      return confirm('Are you sure you want to insert this record?');
  }
</script>
</body>
</html>
