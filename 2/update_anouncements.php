<?php
include('connection.php');

// Check if Product_Id is set
if (isset($_REQUEST['announcement_id'])) {
  $announcement_id = $_REQUEST['announcement_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM announcements WHERE announcement_id=?");
  $stmt->bind_param("i", $announcement_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $a = $row['announcement_id'];
    $b = $row['announcement_text'];
    $c = $row['group_leader_id'];
  } else {
    echo "anouncement not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<html>
<head>
    <title>Update announcements tableform</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update products form -->
    <h2><u>Update Form of announcements</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="announcement_text">announcement_text:</label>
    <input type="text" name="announcement_text" value="<?php echo isset($b) ? $b : ''; ?>">
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
  $announcement_text = $_POST['announcement_text'];
  $group_leader_id = $_POST['group_leader_id'];

  // Update the attendee in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE announcements SET announcement_text=?, group_leader_id=? WHERE  announcement_id=?");
  $stmt->bind_param("sii", $announcement_text, $group_leader_id, $announcement_id);
  $stmt->execute();

  // Redirect to product.php
  header('Location: anouncements.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
