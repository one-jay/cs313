<?php
require "crm-db.php";
$db = get_db();
$id = $_GET['id'];
?>

<html>
    <head>

    </head>
    <body>
        <h1>Product: <?=$id?> </h1>

        <h2> Quote Lines:</h2>
        <table>
            <thead>
                <tr>
                    <th>Quote Line ID</th>
                    <th>Quote</th>
                    <th>Quote Price</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
        <?php
            $statement = $db->prepare(" SELECT quoteline.id as quotelineid, quote, price, quantity
                                        FROM quoteline
                                        --JOIN product ON quoteline.product = product.id
                                        WHERE product = '".$id."' ");
            $statement->execute();

            while ($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                $quoteLineId = $row['quotelineid'];
                $quote = $row['quote'];
                $price = $row['price'];
                $quantity = $row['quantity'];

                echo "<tr> <td><a href=\"quoteline.php?id=$quoteLineId\">$quoteLineId</a></td> <td><a href=\"quoteline.php?id=$quote\">$quote</td> <td>$price</td> <td>$quantity</td>  </tr>";
            }
        ?>
        </tbody>
        </table>

    </body>
</html>
