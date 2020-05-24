<?php
require "crm-db.php";
$db = get_db();
$id = $_GET['id'];
?>

<html>
    <head>

    </head>
    <body>
        <h1>Opportunity: <?=$id?> </h1>

        <h2>Related Quotes:</h2>
        <table>
            <thead>
                <tr>
                    <th>Quote ID</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
        <?php
            $statement = $db->prepare(" SELECT * FROM quote
                                        WHERE opportunity = '".$id."' ");
            $statement->execute();

            while ($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                $quoteID = $row['id'];
                $amount = $row['amount'];

                echo "<tr> <td><a href=\"quote.php?id=$id\">$quoteID</a></td> <td>$amount</td> </tr>";
            }
        ?>
        </tbody>
        </table>

    </body>
</html>
