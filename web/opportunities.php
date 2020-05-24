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
                $sql = 'SELECT account.id as accountid, account.name, opportunity.id, stage 
                        FROM opportunity
                        JOIN account ON opportunity.account = account.id';
                $statement = $db->prepare($sql);
                $statement->execute();

                while ($row = $statement->fetch(PDO::FETCH_ASSOC))
                {
                    $accountId = $row['accountid'];
                    $account = $row['name'];
                    $id = $row['id'];
                    $stage = $row['stage'];
                    // $phone = $row['phone'];
                    // $email = $row['email'];

                    echo "<tr> <td><a href=\"account.php?id=$accountId\">$account</a></td> <td><a href=\"opportunity.php?id=$id\">$id</a></td> <td>$stage</td> </tr>";
                }
            ?>
            </tbody>
        </table>

    </body>
</html>
