<?php
include('connection.php');

// Check if Product_Id is set
if (isset($_REQUEST['topic_id'])) {
  $topic_id = $_REQUEST['topic_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM discussiontopics WHERE topic_id=?");
  $stmt->bind_param("i", $topic_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $a = $row['topic_id'];
    $b = $row['topic_text'];
    $c = $row['session_id'];
  } else {
    echo "discussiontopics not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<html>
<head>
    <title>Update discussiontopics tableform</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update products form -->
    <h2><u>Update Form of discussiontopics</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="topic_text">topic_text:</label>
    <input type="text" name="topic_text" value="<?php echo isset($b) ? $b : ''; ?>">
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
  $topic_text = $_POST['topic_text'];
  $session_id = $_POST['session_id'];

  // Update the attendee in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE discussiontopics SET topic_text=?, session_id=? WHERE  topic_id=?");
  $stmt->bind_param("sii", $topic_text, $session_id, $topic_id);
  $stmt->execute();

  // Redirect to product.php
  header('Location: discussiontopics.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
