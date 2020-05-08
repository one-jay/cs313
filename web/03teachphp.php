<!DOCTYPE html>
<html lang="en-US">
<head>
  <title>CS 313 : 03 Teach</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="home.css">
  <style>
      /* internal styling */
  </style>
</head>

<body>
  <header>
    <h2>CS 313 (CSE 341) - 03 Teach</h2>

  </header> 

  <main>
    
    <form action="03teach.php" method="post">
        Full Name: 
        <input type="text" name="fullname" id=""><br>
        Email: 
        <input type="text" name="email"><br>
        <br>


        <?php
        $majors = array
        (
        array("Computer Science","CS"),
        array("Web Design and Development","WDD"),
        array("Computer Information Technology", "CIT"),
        array("Computer Engineering", "CE")
        );
        
        foreach($majors as $major) {
            echo '<input type="radio" name="major"' . 'value="' . $major[1] . '">' . $major[0].'<br>'; 
        }
        ?>


        <!-- Major: <br>
        <input type="radio" name="major" id="" value="Computer Science">
        Computer Science <br>
        <input type="radio" name="major" id="" value="Web Design and Development">
        Web Design and Development <br>
        <input type="radio" name="major" id="" value="Computer Information Technology">
        Computer Information Technology <br>
        <input type="radio" name="major" id="" value="Computer Engineering">
        Computer Engineering <br>
        <br> -->

        Comments: <br>
        <textarea name="comments" id="" cols="30" rows="10"></textarea>
        <br>
        <br>
        <!-- Continents visited: <br>
        <input type="checkbox" name="NA" id="" value="North America">
        North America <br>
        <input type="checkbox" name="SA" id="" value="South America">
        South America <br>
        <input type="checkbox" name="EU" id="" value="Europe">
        Europe <br>
        <input type="checkbox" name="AS" id="" value="Asia">
        Asia <br>
        <input type="checkbox" name="AU" id="" value="Australia">
        Australia <br>
        <input type="checkbox" name="AF" id="" value="Africa">
        Africa <br>
        <input type="checkbox" name="AN" id="" value="Antarctica">
        Antarctica <br> -->

        <br><br>
        Continents Visited:<br>
        <input type="checkbox" name="check_list[]" value="NA">
        <label for="continent1">North America</label><br>
        <input type="checkbox" name="check_list[]" value="SA">
        <label for="continent2"> South America</label><br>
        <input type="checkbox" name="check_list[]" value="EU">
        <label for="continent3"> Europe</label><br>
        <input type="checkbox" name="check_list[]" value="AS">
        <label for="continent4">Asia</label><br>
        <input type="checkbox" name="check_list[]" value="AU">
        <label for="continent5">Australia</label><br>
        <input type="checkbox" name="check_list[]" value="AF">
        <label for="continent6">Africa</label><br>
        <input type="checkbox" name="check_list[]" value="AN">
        <label for="continent7">Antartica</label><br>
        <br>
        <input type="submit" name="formSubmit" value="Submit">
    </form>

  </main>

  <footer>

  </footer>


</body>
</html>

