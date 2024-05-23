<?php
include('connection.php');

// Check if Product_Id is set
if (isset($_REQUEST['poll_id'])) {
  $poll_id = $_REQUEST['poll_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM polls WHERE poll_id=?");
  $stmt->bind_param("i", $poll_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $a = $row['poll_id'];
    $b = $row['poll_question'];
    $c = $row['session_id'];
  } else {
    echo "anouncement not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<html>
<head>
    <title>Update polls tableform</title>
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
    <label for="poll_question">poll_question:</label>
    <input type="text" name="poll_question" value="<?php echo isset($b) ? $b : ''; ?>">
    <br><br>

    <label for="session_id">session_id:</label>
    <input type="number" name="session_id" value="<?php echo isset($c) ? $c : ''; ?>">
    <br><br>
    <input type="submit" name="up" value="Update">

  </form>
</body>
</html>

<?php
if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $poll_question = $_POST['poll_question'];
  $session_id = $_POST['session_id'];

  // Update the attendee in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE polls SET poll_question=?, session_id=? WHERE  poll_id=?");
  $stmt->bind_param("sii", $poll_question, $session_id, $poll_id);
  $stmt->execute();

  // Redirect to product.php
  header('Location: polls.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
