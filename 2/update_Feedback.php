<?php
include('connection.php');

// Check if Product_Id is set
if (isset($_REQUEST['feedback_id'])) {
  $feedback_id = $_REQUEST['feedback_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM Feedback WHERE feedback_id=?");
  $stmt->bind_param("i", $feedback_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $a = $row['feedback_id'];
    $b = $row['feedback_text'];
    $c = $row['session_id'];
  } else {
    echo "feedback_id not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<html>
<head>
    <title>Update feedback tableform</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update products form -->
    <h2><u>Update Form of feedback</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="feedback_text">feedback_text:</label>
    <input type="text" name="feedback_text" value="<?php echo isset($b) ? $b : ''; ?>">
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
  $feedback_text = $_POST['feedback_text'];
  $session_id = $_POST['session_id'];

  // Update the attendee in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE Feedback SET feedback_text=?, session_id=? WHERE  feedback_id=?");
  $stmt->bind_param("sii", $feedback_text, $session_id, $feedback_id);
  $stmt->execute();

  // Redirect to product.php
  header('Location: feedback.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
