<?php
$con = mysqli_connect("localhost", "yohanneska", "wildfog34", "yohanneska_canteen" );
if(mysqli_connect_errno()) {
    echo "Failed to connect to MySQL:".mysqli_connect_error(); die();}
else{
    echo "connected to database";
}

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
    <link href="https://fonts.googleapis.com/css2?family=Bungee&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Signika&display=swap" rel="stylesheet">
</head>
<body>
<header>
        <div class="container1">
            <h1>WGC CANTEEN</h1>
            <form class="homesearch" action="" method="post">
                <input type="text" name = 'search' placeholder="Search product" id="search_product">
                <button type = "submit" name = "submit" placeholder="Go"><i class="full-search"></i></button>
            </form>
        </div>
            <ul>
                <nav>
                    <li><a href="home3-5.php" >HOME</a></li>
                    <li><a href="food3-5.php" >FOOD</a></li>
                    <li><a href="drinks3-5.php" >DRINKS</a></li>
                    <li><a href="treats3-5.php" >TREATS</a></li>
                </nav>
            </ul>
    <img class="logo" src="wgclogo.png">
</header>

</body>

    <div class="hsearchdisplay"></div>
    <?php
    if(isset($_POST['search'])) {
        $search = $_POST['search'];
        $query1 = "(SELECT FItem AS name FROM foods WHERE FItem LIKE '%$search%')
                UNION (SELECT DItem AS name FROM drinks WHERE DItem LIKE '%$search%')
                UNION (SELECT TItem AS name From treats WHERE TItem LIKE '%$search%')";
        $query = mysqli_query($con, $query1);
        $count = mysqli_num_rows($query);
        if($count == 0){
            echo "There was no search results!";
        }else{
            while ($row = mysqli_fetch_array($query)) {
                echo $row ['name'];
                echo "<br>";
            }
        }
    }
    ?>
    </div>
    <h2>Weekly Specials:</h2>

    <!--specials form-->
    <form name='specials_form' id='specials_form' method = 'get' action ='home3-4.php' class="specials_form">
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
    echo "<p> DAY: " . $this_specials_record['weekday'] . "<br>";
    echo "<p> FOOD: " . $this_specials_record['FItem'] . "<br>";
    echo "<p> DRINK: " . $this_specials_record['DItem'] . "<br>";
    echo "<p> TREAT: " . $this_specials_record['TItem'] . "<br>";
    ?>

    <p> All items on special for the day are 20% </p>

</main>
</html>
