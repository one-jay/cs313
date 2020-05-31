<?php
    require "crm-db.php";
    $db = get_db();
    if ($_POST) {
        
        if(isset($_POST['submit'])) {
            try{
                $db = get_db();
                $query = 'INSERT INTO product (name, description, listprice) 
                        VALUES(:name, :description, :listprice)';
                $statement = $db->prepare($query);
                    $statement->bindValue(':name', $_POST['name']);
                    $statement->bindValue(':description', $_POST['description']);
                    $statement->bindValue(':listprice', $_POST['listprice']);
                $statement->execute();
            }catch (Exception $ex){
                echo "Error with DB. Details: $ex";
                die();
            }
        }
    
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
?>

<html>
    <head>

    </head>
    <body>
        <h2>Products:</h2>

        <form action="" method="post">
            <input type="text" name="name" value="Product Name">
            <input type="text" name="description" value="Description">
            <input type="text" name="listprice" value="List Price">
            <input type="submit" name="submit" value="Create New Product">
        </form>

        <table id="productsTable">
            <thead>
                <tr>
                    <th onclick="sortTable(productsTable,0)">Product Name</th>
                    <th onclick="sortTable(productsTable,0)">Description</th>
                    <th onclick="sortTable(productsTable,0)">List Price</th>
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

                    echo "<tr> <td><a href=\"product.php?id=$id\">$product</a></td> <td>$desc</td> <td>$listPrice</td> </tr>";
                }
            ?>
            </tbody>
        </table>

        <script>
            var productsTable = document.getElementById("productsTable");
        </script>
    </body>
</html>
