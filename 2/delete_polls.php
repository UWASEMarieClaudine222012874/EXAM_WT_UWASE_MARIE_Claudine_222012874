<?php
    // Connection details
    include('connection.php');

// Check if id is set
if(isset($_REQUEST['poll_id'])) {
    $poll_id = $_REQUEST['poll_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM polls WHERE poll_id=?");
    $stmt->bind_param("i", $poll_id);
    ?>
     <!DOCTYPE html>
    <html>
    <head>
        <title>Delete Record</title>
        <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete this record?");
            }
        </script>
    </head>
    <body>
        <form method="post" onsubmit="return confirmDelete();">
            <center><input type="hidden" name="poll_id" value="<?php echo $poll_id; ?>">
            <input type="submit" value="Delete">
        </form></center>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($stmt->execute()) {
        echo "Record deleted successfully.<br><br> 
             <a href='polls.php'> refresh the page</a>";
    } else {
        echo "Error deleting data: " . $stmt->error;
    }
}
?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "id is not set.";
}

$connection->close();
?>
