<?php
    require "crm-db.php";
    $db = get_db();
?>

<html>
    <head>

    </head>
    <body>
        <h2>Contacts:</h2>

        <table>
            <thead>
                <tr>
                    <th onclick="sortTable(contactsTable,0)">Account Name</th>
                    <th onclick="sortTable(contactsTable,1)">First Name</th>
                    <th onclick="sortTable(contactsTable,2)">Last Name</th>
                    <th onclick="sortTable(contactsTable,3)">Phone</th>
                    <th onclick="sortTable(contactsTable,4)">Email</th>
                </tr>
                
            </thead>
            <tbody>
            <?php
                $sql = 'SELECT contact.id as contactid, account, account.name as name, firstname, lastname, phone, email 
                        FROM contact
                        JOIN account ON contact.account = account.id';
                $statement = $db->prepare($sql);
                $statement->execute();

                while ($row = $statement->fetch(PDO::FETCH_ASSOC))
                {
                    $contactid = $row['contactid'];
                    $accountid = $row['account'];
                    $account = $row['name'];
                    $firstName = $row['firstname'];
                    $lastName = $row['lastname'];
                    $phone = $row['phone'];
                    $email = $row['email'];

                    echo "<tr> <td><a href=\"account.php?id=$accountid\"> $account </a></td> <td><a href=\"contact.php?id=$contactid\"> $firstName </a></td> <td><a href=\"contact.php?id=$contactid\"> $lastName </a></td> <td>$phone</td> <td>$email</td> </tr>";
                }
            ?>
            </tbody>
        </table>

        <script>
            var contactsTable = document.getElementById("contactsTable");
        </script>
    </body>
</html>
