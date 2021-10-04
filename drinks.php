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
    $field = 'DItem';
    $order = 'ASC';

} elseif ($sort == 'costAsc') {
    $field = 'DPrice';
    $order = 'ASC';
} elseif ($sort == 'costDesc') {
    $field = 'DPrice';
    $order = 'DESC';
} elseif ($sort == 'alphaDesc') {
    $field = 'DItem';
    $order = 'DESC';
}

/*Setting variable to filter the drink products in cold category*/
if(isset($_GET['colddrinks'])){
    $colddrinks = $_GET['colddrinks'];
}else{
    $colddrinks = "";
}

/*Setting variable to filter the drink products in hot category*/
if(isset($_GET['hotdrinks'])){
    $hotdrinks = $_GET['hotdrinks'];
}else{
    $hotdrinks = "";
}

/*Setting variable to filter the drink products according to availability*/
if(isset($_GET['availability'])){
    $availability = $_GET['availability'];
}else{
    $availability = "";
}

/* Drinks Query*/
/*SELECT all FROM Drinks (ordering by variables set above)*/
$all_drink_query = "SELECT * From Drinks ORDER BY $field $order";
$all_drink_result = mysqli_query($con, $all_drink_query);
$all_drink_record = mysqli_fetch_assoc($all_drink_result);

/*Cold drinks query*/
/*SELECT all FROM Drinks WHERE DCategory = "cold"*/
$colddrinks_query = "SELECT * FROM Drinks WHERE DCategory = 'cold'";
$colddrinks_result = mysqli_query($con, $colddrinks_query);
$colddrinks_record = mysqli_fetch_assoc($colddrinks_result);

/*Hot drinks query*/
/*SELECT all FROM Drinks WHERE DCategory = "hot"*/
$hotdrinks_query = "SELECT * FROM Drinks WHERE DCategory = 'hot'";
$hotdrinks_result = mysqli_query($con, $hotdrinks_query);
$hotdrinks_record = mysqli_fetch_assoc($hotdrinks_result);

/*Availability query*/
/*SELECT all FROM Drinks WHERE availability = "yes"*/
$availability_query = "SELECT * FROM Drinks WHERE availability = 'yes'";
$availability_result = mysqli_query($con, $availability_query);
$availability_record = mysqli_fetch_assoc($availability_result);
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
    <!--wgc logo-->
    <img class="logo" alt="WGC logo" src="wgclogo.png">
</header>

<!--banner image-->
<div class="banner">
    <img class="banner-img" alt="fruit drinks image as banner" src="images/drinksbanner.png">
        <h2 class="center-text">DRINKS</h2>
        <!--Search bar for drinks table-->
        <form class="drinksearch" method="post">
            <input type="text" name = 'search'>
            <input type = "submit" name = "submit" value="Search">
        </form>
</div>
<main>

    <!--box that holds all the filters-->
    <div class="drinkfilter-box">
    <!--Drop down menu to sort products-->
    <form class="drinkfilter" name='sort_form' id='sort_form' method='get' action='drinks3-5.php'>
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
    <form class="drinkfilter" action="drinks3-5.php" method="get">
        <button class="sort-button" id="availability" name="availability" type="submit" value="Availability">Availability</button>
    </form>
    <form class="drinkfilter" action="drinks3-5.php" method="get">
        <button class="sort-button" id="colddrinks" name="colddrinks" type="submit" value="cold">Cold</button>
    </form>
    <form class="drinkfilter" action="drinks3-5.php" method="get">
        <button class="sort-button" id="hotdrinks" name="hotdrinks" type="submit" value="hot">Hot</button>
    </form>
    </div>

    <div class="products-box" align="center">
    <?php
    /*Query searching for items in drinks table*/
    if(isset($_POST['search'])) {
        $search = $_POST['search'];
        $query1 = "SELECT * FROM drinks WHERE DItem LIKE '%$search%'";
        $query = mysqli_query($con, $query1);
        $count = mysqli_num_rows($query);
        if($count == 0){
            /*search result if there is no like match*/
            echo "There was no search results!";
        }else{
            /*while loop creating an individual box for every product; including image, name and price*/
            while ($row = mysqli_fetch_array($query)) {
                echo "<div class='product-box'>";
                echo "<img class='product-img' src='images/". $row['Imageurl'] . "' alt='". $row['DItem'] ."'>";
                echo "<br>";
                echo $row['DItem'];
                echo "<br>";
                echo "$" . $row ['DPrice'];
                echo "</div>";
            }
        }
    }
    /*Display format of results when different filters applied*/
    elseif(isset($_GET['colddrinks'])) {
        /*while loop creating an individual box for every product; including image, name and price*/
        while ($rows=$colddrinks_result-> fetch_assoc())
        {
            echo "<div class='product-box'>";
            echo "<img class='product-img' src='images/". $rows['Imageurl'] . "' alt='". $rows['DItem'] ."'>";
            echo "<br>";
            echo $rows['DItem'];
            echo "<br>";
            echo "$" . $rows ['DPrice'];
            echo "</div>";
        }
    }elseif(isset($_GET['hotdrinks'])) {
        /*while loop creating an individual box for every product; including image, name and price*/
        while ($rows=$hotdrinks_result-> fetch_assoc())
        {
            echo "<div class='product-box'>";
            echo "<img class='product-img' src='images/". $rows['Imageurl'] . "' alt='". $rows['DItem'] ."'>";
            echo "<br>";
            echo $rows['DItem'];
            echo "<br>";
            echo "$" . $rows ['DPrice'];
            echo "</div>";

        }
    }elseif(isset($_GET['availability'])) {
        /*while loop creating an individual box for every product; including image, name and price*/
        while ($rows=$availability_result-> fetch_assoc()) {
            echo "<div class='product-box'>";
            echo "<img class='product-img' src='images/". $rows['Imageurl'] . "' alt='". $rows['DItem'] ."'>";
            echo "<br>";
            echo $rows['DItem'];
            echo "<br>";
            echo "$" . $rows ['DPrice'];
            echo "</div>";
        }
    }else {
        /*while loop creating an individual box for every product; including image, name and price*/
        while ($rows = $all_drink_result->fetch_assoc()) {
            echo "<div class='product-box'>";
            echo "<img class='product-img' src='images/" . $rows['Imageurl'] . "'alt='". $rows['DItem'] ."'>";
            echo "<br>";
            echo $rows['DItem'];
            echo "<br>";
            echo "$" . $rows ['DPrice'];
            echo "</div>";
        }
    }
        ?>
    </div>
</main>
</body>
</html>