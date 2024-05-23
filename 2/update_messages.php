<?php
include('connection.php');

// Check if Product_Id is set
if (isset($_REQUEST['message_id'])) {
  $message_id = $_REQUEST['message_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM messages WHERE message_id=?");
  $stmt->bind_param("i", $message_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $a = $row['message_id'];
    $b = $row['message_text'];
    $c = $row['member_id'];
  } else {
    echo "messages not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<html>
<head>
    <title>Update message tableform</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update products form -->
    <h2><u>Update Form of message</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="message_text">message_text:</label>
    <input type="text" name="message_text" value="<?php echo isset($b) ? $b : ''; ?>">
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
  $message_text = $_POST['message_text'];
  $member_id = $_POST['member_id'];

  // Update the attendee in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE messages SET message_text=?, member_id=? WHERE  message_id=?");
  $stmt->bind_param("sii", $message_text, $member_id, $message_id);
  $stmt->execute();

  // Redirect to product.php
  header('Location: messages.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
