<?php
$con = mysqli_connect("localhost", "yohanneska", "wildfog34", "yohanneska_canteen" );
if(mysqli_connect_errno()) {
    echo "Failed to connect to MySQL:".mysqli_connect_error(); die();}
else{
    echo "connected to database";
}

/* specials Query (get weekday)*/
$all_specials_query = "SELECT Weekday FROM specials";
$all_specials_result = mysqli_query($con, $all_specials_query);
if(isset($_GET['special'])){
    $id = $_GET['special'];
}else{
    $id = "Monday";
}
/* specials Query*/
$this_specials_query = "SELECT specials.weekday, specials.FoodID, specials.DrinkID, specials.TreatID, Foods.FItem, Drinks.DItem,
Foods.FoodID, Drinks.DrinkID, Treats.TreatID, Treats.TItem From specials, foods, drinks, treats WHERE specials.DrinkID = drinks.DrinkID
AND specials.FoodID = Foods.FoodID AND Weekday = '" . $id . "'";
$this_specials_result = mysqli_query($con, $this_specials_query);
$this_specials_record = mysqli_fetch_assoc($this_specials_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CANTEEN</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style3-5.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chivo:wght@900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Signika&display=swap" rel="stylesheet">
</head>
<body>
<header>
        <div class="container1">
            <h1>WGC CANTEEN</h1>
            <!--overall search from all products displays on another page - searchresult.php-->
            <form class="overallsearch" action="searchresult.php" method="post">
                <input type="text" name = 'search' placeholder="Search product" id="search_product">
                <button type = "submit" name = "submit"><img class="searchicon" alt="search" src="images/searchicon.png"></button>
            </form>
        </div>

        <ul>
            <!--links to other pages-->
            <li><a href="home3-5.php" >HOME</a></li>
            <li><a href="food3-5.php" >FOOD</a></li>
            <li><a href="drinks3-5.php" >DRINKS</a></li>
            <li><a href="treats3-5.php" >TREATS</a></li>
        </ul>
    <img class="logo" alt="WGC logo" src="wgclogo.png">
</header>

<!--banner image-->
<div class="banner">
    <img class="banner-img" alt="pizza image banner" src="images/homebanner.png">
        <h2 class="center-text">WELCOME</h2>
</div>

<h2 class="title"> Weekly Specials:</h2>

    <!--specials form-->
    <form name='specials_form' id='specials_form' method = 'get' action ='home3-5.php' class="specials_form">
        <select class="specials" id = 'special' name = 'special'>
            <!--options-->
            <?php
            while($all_specials_record = mysqli_fetch_assoc($all_specials_result)){
                echo "<option value = '". $all_specials_record['Weekday'] . "'>";
                echo $all_specials_record['Weekday'];
                echo "</option>";
            }
            ?>
        </select>
        <input type='submit' name='specials_button' value='show me the specials information' class="specials-submit">
    </form>

    <?php
    /*display of weekly specials*/
    echo "<p> DAY: " . $this_specials_record['weekday'] . "<br>";
    echo "<p> FOOD: " . $this_specials_record['FItem'] . "<br>";
    echo "<p> DRINK: " . $this_specials_record['DItem'] . "<br>";
    echo "<p> TREAT: " . $this_specials_record['TItem'] . "<br>";
    ?>

    <p> All items on special for the day are 20% </p>

</main>
</body>
</html>
