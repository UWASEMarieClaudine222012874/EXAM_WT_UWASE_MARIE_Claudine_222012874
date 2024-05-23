<?php
    // Connection details
    include('connection.php');

// Check if id is set
if(isset($_REQUEST['topic_id'])) {
    $topic_id = $_REQUEST['topic_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM discussiontopics WHERE topic_id=?");
    $stmt->bind_param("i", $topic_id);
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
            <center><input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
            <input type="submit" value="Delete">
        </form></center>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($stmt->execute()) {
        echo "Record deleted successfully.<br><br> 
             <a href='discussiontopics.php'> refresh the page</a>";
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
