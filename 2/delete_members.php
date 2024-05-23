<?php
    // Connection details
    include('connection.php');

    // Check if id is set
    if(isset($_REQUEST['member_id'])) {
        $member_id = $_REQUEST['member_id'];

        // Disable foreign key checks
        $connection->query('SET foreign_key_checks = 0');

        // Prepare and execute the DELETE statement
        $stmt = $connection->prepare("DELETE FROM members WHERE member_id=?");
        $stmt->bind_param("i", $member_id);

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
                <center><input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
                <input type="submit" value="Delete">
            </form></center>

            <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($stmt->execute()) {
                echo "Record deleted successfully.<br><br> 
                     <a href='members.php'> refresh the page</a>";
            } else {
                echo "Error deleting data: " . $stmt->error;
            }
        }

        // Re-enable foreign key checks
        $connection->query('SET foreign_key_checks = 1');

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
