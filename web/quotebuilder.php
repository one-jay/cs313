<?php
//require "crm-db.php";
//$db = get_db();
//$id = $_GET['id']; 
if ($_POST) {

    // insert quote with quotelines
    if(isset($_POST['updateQuoteLine'])) {
        try{
            $db = get_db();
            $query = 'UPDATE quoteline SET
                            price    = :price,
                            quantity   = :quantity
                        WHERE id = :id';
            $statement = $db->prepare($query);
                $statement->bindValue(':id', $id);
                $statement->bindValue(':price', $_POST['price']);
                $statement->bindValue(':quantity', $_POST['quantity']);
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
        
    <table id="productsTable">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>List Price</th>
                    <th>Quote Price</th>
                    <th>Quantity</th>
                </tr>
                
            </thead>
            <tbody>
            <?php
                $sql = 'SELECT *
                        FROM product';
                $statement = $db->prepare($sql);
                $statement->execute();

                $rowNum = 0;
                while ($row = $statement->fetch(PDO::FETCH_ASSOC))
                {
                    $id = $row['id'];
                    $product = $row['name'];
                    $desc = $row['description'];
                    $listPrice = $row['listprice'];

                    echo 
                        '<tr>'
                            .'<td> <input type="text" name="product'.$rowNum.'" value="'.$product.'" readonly> </td>'
                            .'<td> <input type="text" name="listPrice'.$rowNum.'" value="'.$listPrice.'" readonly> </td>'
                            .'<td> <input type="text" name="quotePrice'.$rowNum.'" value="'.$quotePrice.'"> </td>'
                            .'<td> <input type="text" name="quantity'.$rowNum.'" value="'.$quantity.'"> </td>'
                        .'</tr>';
                    $rowNum++;
                }
            ?>
            </tbody>
        </table>

    </body>
</html>