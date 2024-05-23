<?php
include('connection.php');

// Check if Product_Id is set
if (isset($_REQUEST['attendance_id'])) {
  $attendance_id = $_REQUEST['attendance_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM attendance WHERE attendance_id=?");
  $stmt->bind_param("i", $attendance_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $a = $row['attendance_id'];
    $b = $row['session_id'];
    $c = $row['member_id'];
  } else {
    echo "attendance not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<html>
<head>
    <title>Update attendance tableform</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update products form -->
    <h2><u>Update Form of attendance</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="session_id">session_id:</label>
    <input type="number" name="session_id" value="<?php echo isset($b) ? $b : ''; ?>">
    <br><br>

    <label for="member_id">member_id:</label>
    <input type="number" name="member_id" value="<?php echo isset($c) ? $c : ''; ?>">
    <br><br>
    <input type="submit" name="up" value="Update">

  </form>
</body>
</html>

<?php
if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $session_id = $_POST['session_id'];
  $member_id = $_POST['member_id'];

  // Update the attendee in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE attendance SET session_id=?, member_id=? WHERE  attendance_id=?");
  $stmt->bind_param("iii", $session_id, $session_id, $attendance_id);
  $stmt->execute();

  // Redirect to product.php
  header('Location: attendance.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
