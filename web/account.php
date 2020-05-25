<?php
require "crm-db.php";
$db = get_db();
$id = $_GET['id'];
?>

<html>
    <head>

    </head>
    <body>
        <h1>Account: <?=$id?> </h1>

        <h2>Related Contacts:</h2>
        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
        <?php
            $statement = $db->prepare(" SELECT id as contactid, firstname, lastname, phone, email FROM contact
                                        WHERE account = '".$id."' ");
            $statement->execute();

            while ($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                $contactId = $row['contactid'];
                $firstName = $row['firstname'];
                $lastName = $row['lastname'];
                $phone = $row['phone'];
                $email = $row['email'];

                echo "<tr> <td><a href=\"contact.php?id=$contactId\">$firstName</a></td> <td><a href=\"contact.php?id=$contactId\">$lastName</a></td> <td>$phone</td> <td>$email</td> </tr>";
            }
        ?>
        </tbody>
        </table>

        <h2>Related Opportunities:</h2>
        <table>
            <thead>
                <tr>
                    <th>Opportunity ID</th>
                    <th>Stage</th>
                </tr>
            </thead>
            <tbody>
        <?php
            $statement = $db->prepare(" SELECT * FROM opportunity
                                        WHERE account = '".$id."' ");
            $statement->execute();

            while ($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                $oppID = $row['id'];
                $stage = $row['stage'];

                echo "<tr> <td>$oppID</td> <td>$stage</td> </tr>";
            }
        ?>
        </tbody>
        </table>

    </body>
</html>
