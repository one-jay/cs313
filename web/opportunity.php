<?php
require "crm-db.php";
$db = get_db();
$id = $_GET['id'];
if ($_POST) {

    // update opportunity
    if(isset($_POST['updateOpp'])) {
        try{
            $db = get_db();
            $query = 'UPDATE opportunity SET
                            stage  = :stage
                        WHERE id = :id';
            $statement = $db->prepare($query);
                $statement->bindValue(':id', $id);
                $statement->bindValue(':stage', $_POST['stage']);
            $statement->execute();
        }catch (Exception $ex){
            echo "Error with DB. Details: $ex";
            die();
        }
    }

    // create quote
    if(isset($_POST['insertQuote'])) {
        try{
            $db = get_db();
            $query = 'INSERT INTO quote (opportunity, amount) 
                    VALUES(:opportunity, :amount)';
            $statement = $db->prepare($query);
                $statement->bindValue(':opportunity', $_POST['opportunity']);
                $statement->bindValue(':amount', $_POST['amount']);
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
    <div class="related">
        <h1>Opportunity: <?=$id?> </h1>

        <h2>Opportunity Details</h2>
        <table>
        <?php
            $statement = $db->prepare(" SELECT * FROM opportunity 
                                        WHERE id = '".$id."'
                                        LIMIT 1 ");
            $statement->execute();

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $account = $row['account'];
                $stage = $row['stage'];
            }
            $details = array(
                'Opportunity ID'    => $id,
                'Account'  => '<a href="account.php?id='.$account.'">'.$account.'</a>',
                'Stage'        => $stage
            );
            foreach($details as $k => $v){
                echo "<tr><th>$k</th><td>$v</td></tr>";
            }
        ?>
        </table>

        <h2>Update Opportunity</h2>
        <form action="" method="post">
            <!-- <input type="text" name="id" value="<?=$id?>"> -->
            <input type="text" name="stage" value="<?=$stage?>">
            <input type="submit" name="updateOpp" value="Update Opportunity">
        </form> 
        </div>

        <div class="related">
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

            <h2>Create New Quote</h2>
            <form action="" method="post">
                <input type="text" name="opportunity" value="<?=$id?>" class="hide">
                <input type="text" name="amount" value="Amount">
                <input type="submit" name="insertQuote" value="Create New Quote">
            </form>
        </div>

        <div class="container">
            <!-- Trigger the modal with a button -->
            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Quote Builder</button>
            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Quote Builder</h4>
                        </div>
                        <div class="modal-body">
                            <p>Some text in the modal.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
