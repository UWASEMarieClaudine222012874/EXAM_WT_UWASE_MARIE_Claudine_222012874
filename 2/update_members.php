<?php
include('connection.php');

// Check if member_id is set
if (isset($_REQUEST['member_id'])) {
  $member_id = $_REQUEST['member_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM members WHERE member_id=?");
  $stmt->bind_param("i", $member_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $a = $row['member_id'];
    $b = $row['member_name'];
    $c = $row['group_leader_id'];
  } else {
    echo "members not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<html>
<head>
    <title>Update member tableform</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update products form -->
    <h2><u>Update Form of members</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="member_name">member_name:</label>
    <input type="text" name="member_name" value="<?php echo isset($b) ? $b : ''; ?>">
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
  $member_name = $_POST['member_name'];
  $group_leader_id = $_POST['group_leader_id'];

  // Update the member in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE members SET member_name=?, group_leader_id=? WHERE  member_id=?");
  $stmt->bind_param("sii", $member_name, $group_leader_id, $member_id);
  $stmt->execute();

  // Redirect to product.php
  header('Location: members.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
