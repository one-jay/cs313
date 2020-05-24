<?php
require "crm-db.php";
$db = get_db();
?>

<html>
    <head>

    </head>
    <body>
        
        <?php

            $statement = $db->prepare("SELECT * FROM account");
            $statement->execute();

            while ($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                // The variable "row" now holds the complete record for that
                // row, and we can access the different values based on their
                // name
                $name = $row['name'];
                $street = $row['street'];
                $city = $row['city'];
                $state = $row['state'];
                $zip = $row['zip'];

                echo "<h3>Account: $name </h3><br>
                    <p> Address: $street <br> $city, $state $zip<p>";
            }

        ?>

    </body>
</html>
