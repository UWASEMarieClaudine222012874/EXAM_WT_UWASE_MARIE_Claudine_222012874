<?php
include('connection.php');

// Check if Product_Id is set
if (isset($_REQUEST['leader_id'])) {
  $leader_id = $_REQUEST['leader_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM groupleaders WHERE leader_id=?");
  $stmt->bind_param("i", $leader_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $a = $row['leader_id'];
    $b = $row['leader_name'];
  } else {
    echo "groupleaders not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<html>
<head>
    <title>Update groupleaders tableform</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update products form -->
    <h2><u>Update Form of groupleaders</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="leader_name">leader_name:</label>
    <input type="text" name="leader_name" value="<?php echo isset($b) ? $b : ''; ?>">
    <br><br>
    <input type="submit" name="up" value="Update">

  </form>
</body>
</html>

<?php
if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $leader_name = $_POST['leader_name'];

  // Update the groupleaders in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE groupleaders SET leader_name=? WHERE  leader_id=?");
  $stmt->bind_param("si", $leader_name, $leader_id);
  $stmt->execute();

  // Redirect to product.php
  header('Location: groupleaders.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
