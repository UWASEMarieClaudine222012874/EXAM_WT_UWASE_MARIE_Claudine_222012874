<?php
include('connection.php');

// Check if Product_Id is set
if (isset($_REQUEST['resource_id'])) {
  $resource_id = $_REQUEST['resource_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM resources WHERE resource_id=?");
  $stmt->bind_param("i", $resource_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $a = $row['resource_id'];
    $b = $row['resource_name'];
    $c = $row['group_leader_id'];
  } else {
    echo "anouncement not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<html>
<head>
    <title>Update resources tableform</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update products form -->
    <h2><u>Update Form of resources</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="resource_name">resource_name:</label>
    <input type="text" name="resource_name" value="<?php echo isset($b) ? $b : ''; ?>">
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
  $resource_name = $_POST['resource_name'];
  $group_leader_id = $_POST['group_leader_id'];

  // Update the resource in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE resources SET resource_name=?, group_leader_id=? WHERE  resource_id=?");
  $stmt->bind_param("sii", $resource_name, $group_leader_id, $resource_id);
  $stmt->execute();

  // Redirect to product.php
  header('Location: resources.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
