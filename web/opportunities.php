<?php
    require "crm-db.php";
    $db = get_db();
?>

<html>
    <head>

    </head>
    <body>
        <h2>Opportunities:</h2>

        <table>
            <thead>
                <tr>
                    <th>Account Name</th>
                    <th>Opportunity ID</th>
                    <th>Stage</th>
                    <!-- <th>Phone</th>
                    <th>Email</th> -->
                </tr>
                
            </thead>
            <tbody>
            <?php
                $sql = 'SELECT account.name, opportunity.id, stage 
                        FROM opportunity
                        JOIN account ON opportunity.account = account.id';
                $statement = $db->prepare($sql);
                $statement->execute();

                while ($row = $statement->fetch(PDO::FETCH_ASSOC))
                {
                    $account = $row['name'];
                    $id = $row['id'];
                    $stage = $row['stage'];
                    // $phone = $row['phone'];
                    // $email = $row['email'];

                    echo "<tr> <td><a href=\"opportunity.php?id=$id\">$account</a></td> <td>$id</td> <td>$stage</td> </tr>";
                }
            ?>
            </tbody>
        </table>

    </body>
</html>
