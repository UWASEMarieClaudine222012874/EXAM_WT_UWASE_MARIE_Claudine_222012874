<?php
include('connection.php');

// Check if Product_Id is set
if (isset($_REQUEST['session_id'])) {
  $session_id = $_REQUEST['session_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM groupsessions WHERE session_id=?");
  $stmt->bind_param("i", $session_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $a = $row['session_id'];
    $b = $row['session_date'];
    $c = $row['group_leader_id'];
  } else {
    echo "anouncement not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<html>
<head>
    <title>Update groupsessions tableform</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update products form -->
    <h2><u>Update Form of groupsessions</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="session_date">session_date:</label>
    <input type="date" name="session_date" value="<?php echo isset($b) ? $b : ''; ?>">
    <br><br>

    <label for="group_leader_id">group_leader_id:</label>
    <input type="number" name="group_leader_id" value="<?php echo isset($c) ? $c : ''; ?>">
    <br><br>
    <input type="submit" name="up" value="Update">

  </form>
</body>
</html>

<?php
if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $session_date = $_POST['session_date'];
  $group_leader_id = $_POST['group_leader_id'];

  // Update the attendee in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE groupsessions SET session_date=?, group_leader_id=? WHERE  session_id=?");
  $stmt->bind_param("sii", $session_date, $group_leader_id, $session_id);
  $stmt->execute();

  // Redirect to product.php
  header('Location: groupsessions.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
