<html>
    <head>
    <link rel="stylesheet" href="home.css">
    </head>
    <body>
    <h2>PHP Form Results</h2>    
    <div class="form">
        
    <?php
        echo 'Name: '. $_POST["fullname"]; 

        $email = $_POST["email"];
        echo '<br>Email: <a href="mailto:' .$email. '">' .$email. '</a><br>';
        
        echo 'Major: '. $_POST["major"].'<br>'; 
        echo 'Comments: '. $_POST["comments"].'<br>'; 

        $continents= array('NA'=>'North America', 'SA'=>'South America', 'EU'=>'Europe', 'AS'=>'Asia', 'AU'=>'Australia', 'AF'=>'Africa', 'AN'=>'Antarctica');
        echo 'Continents visited: <br>';
        if(!empty($_POST['check_list'])) {
            foreach($_POST['check_list'] as $check) {  
                //echoes the value set in the HTML form for each checked checkbox.
                    echo $continents[$check] . '<br>'; 
            }
        }

    ?>
    </div>
    </body>
</html>


