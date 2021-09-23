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
/*SELECT all FROM Drinks*/
$all_drink_query = "SELECT * From Drinks ORDER BY $field $order";
$all_drink_result = mysqli_query($con, $all_drink_query);
$all_drink_record = mysqli_fetch_assoc($all_drink_result);

/*Cold drinks query*/
$colddrinks_query = "SELECT * FROM Drinks WHERE DCategory = 'cold'";
$colddrinks_result = mysqli_query($con, $colddrinks_query);
$colddrinks_record = mysqli_fetch_assoc($colddrinks_result);

/*Hot drinks query*/
$hotdrinks_query = "SELECT * FROM Drinks WHERE DCategory = 'hot'";
$hotdrinks_result = mysqli_query($con, $hotdrinks_query);
$hotdrinks_record = mysqli_fetch_assoc($hotdrinks_result);

/*Availability query*/
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

<div class="banner">
    <img class="banner-img" src="images/drinksbanner.png">
    <div class="banner-text">
        <h2 class="center-text">DRINKS</h2>
    </div>
<main>
    <!--Search bar for drinks table-->
    <form class="drinksearch" action="" method="post">
        <input type="text" name = 'search'>
        <input type = "submit" name = "submit" value="Search">
    </form>

    <h2>DRINKS MENU:</h2>
    <!--Drop down menu to sort products-->
    <form class="drinkfilter" name='sort_form' id='sort_form' method='get' action='drinks3-5.php'>
        <select id='sort' name='sort' onchange='javascript:this.form.submit()'>
            <!--options-->
            <option value = 'alphaAsc'> Alphabetical A to Z</option>
            <option value = 'alphaDesc'> Alphabetical Z to A</option>
            <option value = 'costAsc'> Price Low to High</option>
            <option value = 'costDesc'> Price High to Low</option>
        </select></form>

    <!--filter buttons-->
    <form class="drinkfilter" action="drinks3-5.php" method="get">
        <button id="availability" name="availability" type="submit" value="Availability">Availability</button>
    </form>
    <form class="drinkfilter" action="drinks3-5.php" method="get">
        <button id="colddrinks" name="colddrinks" type="submit" value="cold">Cold</button>
    </form>
    <form class="drinkfilter" action="drinks3-5.php" method="get">
        <button id="hotdrinks" name="hotdrinks" type="submit" value="hot">Hot</button>
    </form>

    <?php
    /*Query searching for items in drinks table*/
    if(isset($_POST['search'])) {
        $search = $_POST['search'];
        $query1 = "SELECT * FROM drinks WHERE DItem LIKE '%$search%'";
        $query = mysqli_query($con, $query1);
        $count = mysqli_num_rows($query);
        if($count == 0){
            echo "There was no search results!";
        }else{
            while ($row = mysqli_fetch_array($query)) {
                echo $row ['DItem'];
                echo "<br>";
            }
        }
    }
    ?>
    <div class="products-box" align="center">
    <?php
    /*Display format of results when different filters applied*/
    if(isset($_GET['colddrinks'])) {
        while ($rows=$colddrinks_result-> fetch_assoc())
        {
            echo "<div class='product-box'>";
            echo "<img class='product-img' src='images/". $rows['Imageurl'] . "'>";
            echo "<br>";
            echo $rows['DItem'];
            echo "<br>";
            echo "$" . $rows ['DPrice'];
            echo "</div>";
        }
    }elseif(isset($_GET['hotdrinks'])) {
        while ($rows=$hotdrinks_result-> fetch_assoc())
        {
            echo "<div class='product-box'>";
            echo "<img class='product-img' src='images/". $rows['Imageurl'] . "'>";
            echo "<br>";
            echo $rows['DItem'];
            echo "<br>";
            echo "$" . $rows ['DPrice'];
            echo "</div>";

        }
    }elseif(isset($_GET['availability'])) {
        while ($rows=$availability_result-> fetch_assoc()) {
            echo "<div class='product-box'>";
            echo "<img class='product-img' src='images/". $rows['Imageurl'] . "'>";
            echo "<br>";
            echo $rows['DItem'];
            echo "<br>";
            echo "$" . $rows ['DPrice'];
            echo "</div>";
        }
    }else {
        while ($rows = $all_drink_result->fetch_assoc()) {
            echo "<div class='product-box'>";
            echo "<img class='product-img' src='images/" . $rows['Imageurl'] . "'>";
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
</html>