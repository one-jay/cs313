<?php
    require "crm-db.php";
    $db = get_db();
?>

<html>
    <head>

    </head>
    <body>
        <h2>Products:</h2>

        <table>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>List Price</th>
                    <!-- <th>Phone</th>
                    <th>Email</th> -->
                </tr>
                
            </thead>
            <tbody>
            <?php
                $sql = 'SELECT *
                        FROM product';
                $statement = $db->prepare($sql);
                $statement->execute();

                while ($row = $statement->fetch(PDO::FETCH_ASSOC))
                {
                    $id = $row['id'];
                    $product = $row['name'];
                    $desc = $row['description'];
                    $listPrice = $row['listprice'];
                    // $phone = $row['phone'];
                    // $email = $row['email'];

                    echo "<tr> <td><a href=\"product.php?id=$id\">$product</a></td> <td>$desc</td> <td>$listPrice</td> </tr>";
                }
            ?>
            </tbody>
        </table>

    </body>
</html>
