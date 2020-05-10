<?php 
    session_start();
    include('cart-functions.php');

    $products = $_SESSION['products'];
    $amounts = $_SESSION['amounts'];

    $name = $_POST['fname'] . ' ' . $_POST['lname'];
    $address = $_POST['address'];
    $cityStateZip = $_POST['city'] . ', ' . strtoupper($_POST['state']) . ' ' . $_POST['zip'];
?>

<html>
    <head>
    <link rel="stylesheet" href="03prove.css">
        <style>
            #cart{
                position: relative;
                border: 1px solid red;
                width: 70%;
                margin: 0 auto;
            }
            table *{
                font-size: larger;
            }
            img{
                width: 150px;
            }
            td, th{
                align-items: center;
                height: 1em;
                padding: .5em;
                background-color: #eee;
            }
            a{
                border: 1px solid white;
            }
        </style>
    </head>
    <body>
        <h1>Oh No!</h1>
        <p> <?=$name?>, <br> <br>
        we are sorry to inform you, but your address: <br><br>
        <?=$address?> <br>
        <?=$cityStateZip?> <br><br>
         is outside of our area for qualifying delivery. </p>
         <p>Your order below has been cancelled. Better luck next time!</p>
        

         <table>
        <tr>
            <td></td>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
           
        </tr>
    <?php
        if ( isset($_SESSION["cart"]) ) {
        $total = 0;
        foreach ( $_SESSION["cart"] as $i ) {
    ?>
            <tr>
                <td><img src="images/<?=$products[$i];?>.png" alt=""></td>
                <td><?=( $products[$_SESSION["cart"][$i]] ); ?></td>
                <td><?=( $_SESSION["qty"][$i] ); ?></td>
                <td><?=('$ '. $_SESSION["amounts"][$i] ); ?></td>
            </tr>
        <?php
            $total += $_SESSION["amounts"][$i];
            $totalQty += $_SESSION['qty'][$i];
        }
        $_SESSION["total"] = $total; 
        $_SESSION['totalQty'] = $totalQty;
        ?>
        <tr>
            <td></td>
            <td></td>
            <td>--------</td>
            <td>--------</td>

        </tr>
        <tr>
            <td>Total: </td>
            <td></td>
            <td ><?=$totalQty; ?></td>
            <td >$ <span id="totalAmt"><?=$total;?></span></td>
        </tr>
    </table>
    <br>


    <?php
    }
    ?>


    </body>
</html>