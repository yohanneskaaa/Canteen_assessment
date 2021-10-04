<?php
$con = mysqli_connect("localhost", "yohanneska", "wildfog34", "yohanneska_canteen" );
if(mysqli_connect_errno()) {
    echo "Failed to connect to MySQL:".mysqli_connect_error(); die();}
else{
    echo "connected to database";
}

/*Setting variable to sort according to alpha and price*/
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} else {
    $sort = 'alphaAsc';
}
if ($sort == 'alphaAsc') {
    $field = 'FItem';
    $order = 'ASC';

} elseif ($sort == 'costAsc') {
    $field = 'FPrice';
    $order = 'ASC';
} elseif ($sort == 'costDesc') {
    $field = 'FPrice';
    $order = 'DESC';
} elseif ($sort == 'alphaDesc') {
    $field = 'FItem';
    $order = 'DESC';
}

/*Setting variable called filter - used for filters such as vegan, vegetarian etc.*/
if(isset($_GET['filter'])){
    $filter = $_GET['filter'];
}else{
    $filter = "";
}

/*Setting variable to filter foods in fruit category*/
if(isset($_GET['Fruits'])){
    $Fruits = $_GET['Fruits'];
}else{
    $Fruits = "";
}

/*Setting variable to filter foods in savoury category*/
if(isset($_GET['Savoury'])){
    $Savoury = $_GET['Savoury'];
}else{
    $Savoury = "";
}

/*Setting variable to filter foods in sweet category*/
if(isset($_GET['Sweet'])){
    $Sweet = $_GET['Sweet'];
}else{
    $Sweet = "";
}

/*Filter query*/
$filter_query = "SELECT * FROM Foods WHERE $filter = 'Yes' OR $filter = 'N/A'";
$filter_result = mysqli_query($con, $filter_query);

/*Fruits query*/
$fruits_query = "SELECT * FROM Foods WHERE FCategory = 'Fruits'";
$fruits_result = mysqli_query($con, $fruits_query);
$fruits_record = mysqli_fetch_assoc($fruits_result);

/*Savoury query*/
$savoury_query = "SELECT * FROM Foods WHERE FCategory = 'Savoury'";
$savoury_result = mysqli_query($con, $savoury_query);
$savoury_record = mysqli_fetch_assoc($savoury_result);

/*Sweet query*/
$sweet_query = "SELECT * FROM Foods WHERE FCategory = 'Sweet'";
$sweet_result = mysqli_query($con, $sweet_query);
$sweet_record = mysqli_fetch_assoc($sweet_result);


/* Foods Query*/
/*SELECT all FROM foods*/
$all_food_query = "SELECT * From foods ORDER BY $field $order";
$all_food_result = mysqli_query($con, $all_food_query);
$all_food_record = mysqli_fetch_assoc($all_food_result);
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
<main>
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

<div class="banner">
    <img class="banner-img" alt="Burger and fries banner" src="images/foodbanner.png">
        <h2 class="center-text">FOODS</h2>
        <!--Search bar for foods table-->
        <form class="foodsearch" method="post">
            <input type="text" name = 'search'>
            <input type = "submit" name = "submit" value="Search">
        </form>
    </div>

    <div class="foodfilter-box">
    <!--Drop down menu to sort products-->
    <form class="foodfilter" name='sort_form' id='sort_form' method='get' action='food3-5.php'>
        <select id='sort' name='sort' class="sort">
            <!--options-->
            <option value = 'alphaAsc'> Alphabetical A to Z</option>
            <option value = 'alphaDesc'> Alphabetical Z to A</option>
            <option value = 'costAsc'> Price Low to High</option>
            <option value = 'costDesc'> Price High to Low</option>
        </select>
        <input type='submit' name='drop-button' value='>>'>
    </form>

    <!--filter buttons-->
    <form class="foodfilter" action="food3-5.php" method="get">
        <button class="sort-button" id="filter1" name="filter" type="submit" value="Availability">Availability</button>
    </form>
    <form class="foodfilter" action="food3-5.php" method="get">
        <button class="sort-button" id="filter2" name="filter" type="submit" value="Veganfriendly">Veganfriendly</button>
    </form>
    <form class="foodfilter" action="food3-5.php" method="get">
        <button class="sort-button" id="filter3" name="filter" type="submit" value="Vegetarianfriendly">Vegetarianfriendly</button>
    </form>
    <form class="foodfilter" action="food3-5.php" method="get">
        <button class="sort-button" id="filter4" name="filter" type="submit" value="Nutfree">Nutfree</button>
    </form>
    <form class="foodfilter" action="food3-5.php" method="get">
        <button class="sort-button" id="Fruits" name="Fruits" type="submit" value="Category">Fruits</button>
    </form>
    <form class="foodfilter" action="food3-5.php" method="get">
        <button class="sort-button" id="Savoury" name="Savoury" type="submit" value="Category">Savoury</button>
    </form>
    <form class="foodfilter" action="food3-5.php" method="get">
        <button class="sort-button" id="Sweet" name="Sweet" type="submit" value="Category">Sweet</button>
    </form>
    </div>

    <div class="products-box" align="center">
    <?php
    /*Query searching for items in food table*/
    if(isset($_POST['search'])) {
        $search = $_POST['search'];
        $query1 = "SELECT * FROM foods WHERE FItem LIKE '%$search%'";
        $query = mysqli_query($con, $query1);
        $count = mysqli_num_rows($query);

        /*Display of search results*/
        if($count == 0){
            echo "There was no search results!";
        }else{
            while ($row = mysqli_fetch_array($query)) {
                echo "<div class='product-box'>";
                echo "<img class='product-img' src='images/". $row['Imageurl'] . "'>";
                echo "<br>";
                echo $row['FItem'];
                echo "<br>";
                echo "$" . $row['FPrice'];
                echo "</div>";
            }
        }
    }
    /*Display format of results when different filters applied*/
    elseif(isset($_GET['filter'])) {
        while ($rows=$filter_result-> fetch_assoc())
        {
            echo "<div class='product-box'>";
            echo "<img class='product-img' src='images/". $rows['Imageurl'] . "' alt='". $rows['FItem'] ."'>";
            echo "<br>";
            echo $rows['FItem'];
            echo "<br>";
            echo "$" . $rows ['FPrice'];
            echo "</div>";
            }
    }elseif(isset($_GET['Fruits'])) {
        while ($rows=$fruits_result-> fetch_assoc()) {
            echo "<div class='product-box'>";
            echo "<img class='product-img' src='images/" . $rows['Imageurl'] . "'alt='". $rows['FItem'] ."'>";
            echo "<br>";
            echo $rows['FItem'];
            echo "<br>";
            echo "$" . $rows ['FPrice'];
            echo "</div>";
        }
    }elseif(isset($_GET['Savoury'])) {
        while ($rows=$savoury_result->fetch_assoc())
        {
            echo "<div class='product-box'>";
            echo "<img class='product-img' src='images/". $rows['Imageurl'] . "' alt='". $rows['FItem'] ."'>";
            echo "<br>";
            echo $rows['FItem'];
            echo "<br>";
            echo "$" . $rows ['FPrice'];
            echo "</div>";
        }
    }elseif(isset($_GET['Sweet'])) {
        while ($rows=$sweet_result->fetch_assoc())
        {
            echo "<div class='product-box'>";
            echo "<img class='product-img' src='images/". $rows['Imageurl'] . "' alt='". $rows['FItem'] ."'>";
            echo "<br>";
            echo $rows['FItem'];
            echo "<br>";
            echo "$" . $rows ['FPrice'];
            echo "</div>";
        }
    }else{
        while($rows=$all_food_result-> fetch_assoc())
        {
            echo "<div class='product-box'>";
            echo "<img class='product-img' src='images/". $rows['Imageurl'] . "' alt='". $rows['FItem'] ."'>";
            echo "<br>";
            echo $rows['FItem'];
            echo "<br>";
            echo "$" . $rows ['FPrice'];
            echo "</div>";
        }
    }
    ?>
    </div>
</main>
</body>
</html>

