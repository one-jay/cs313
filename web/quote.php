<?php
require "crm-db.php";
$db = get_db();
$id = $_GET['id'];
?>

<html>
    <head>

    </head>
    <body>
        <h1>Quote: <?=$id?> </h1>

        <h2> Quote Lines:</h2>
        <table>
            <thead>
                <tr>
                    <th>Quote Line ID</th>
                    <th>Product</th>
                    <th>List Price</th>
                    <th>Quote Price</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
        <?php
            $statement = $db->prepare(" SELECT quoteline.id as quotelineid, product.name, product.listprice, price, quantity
                                        FROM quoteline
                                        JOIN product ON quoteline.product = product.id
                                        WHERE quote = '".$id."' ");
            $statement->execute();

            while ($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                $quoteLineId = $row['quotelineid'];
                $product = $row['name'];
                $listPrice = $row['listprice'];
                $price = $row['price'];
                $quantity = $row['quantity'];

                echo "<tr> <td><a href=\"quoteline.php?id=$quoteLineId\">$quoteLineId</a></td> <td>$product</td> <td>$price</td> <td>$quantity</td>  </tr>";
            }
        ?>
        </tbody>
        </table>

    </body>
</html>
