<?php
    require "crm-db.php";
    $db = get_db();
?>

<html>
    <head>

    </head>
    <body>
        <h2>Quotes:</h2>

        <table>
            <thead>
                <tr>
                    <th>Account Name</th>
                    <th>Opportunity ID</th>
                    <th>Quote ID</th>
                    <th>Amount</th>
                    <!-- <th>Phone</th>
                    <th>Email</th> -->
                </tr>
                
            </thead>
            <tbody>
            <?php
                $sql = 'SELECT account.id AS accountid, account.name, opportunity.id AS oppid, quote.id AS quoteid, amount 
                        FROM quote
                        JOIN opportunity ON quote.opportunity = opportunity.id
                        JOIN account ON opportunity.account = account.id';
                $statement = $db->prepare($sql);
                $statement->execute();

                while ($row = $statement->fetch(PDO::FETCH_ASSOC))
                {
                    $accountId = $row['accountid'];
                    $account = $row['name'];
                    $oppId = $row['oppid'];
                    $id = $row['quoteid'];
                    $amount = $row['amount'];
                    // $phone = $row['phone'];
                    // $email = $row['email'];

                    echo "<tr> <td><a href=\"account.php?id=$accountId\">$account</a></td> <td><a href=\"opportunity.php?id=$oppId\">$oppId</a></td> <td><a href=\"quote.php?id=$id\">$id</a></td> <td>$amount</td> </tr>";
                }
            ?>
            </tbody>
        </table>

    </body>
</html>
