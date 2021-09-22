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

/*Hot drinks query*/
$hotdrinks_query = "SELECT * FROM Drinks WHERE DCategory = 'hot'";
$hotdrinks_result = mysqli_query($con, $hotdrinks_query);

/*Availability query*/
$availability_query = "SELECT * FROM Drinks WHERE availability = 'yes'";
$availability_result = mysqli_query($con, $availability_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CANTEEN</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style2-4.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Signika&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <h1>WGC CANTEEN</h1>
    <nav>
        <ul>
            <!--Links to other pages-->
            <li><a href="home2-4.php" >HOME</a></li>
            <li><a href="food2-4.php" >FOOD</a></li>
            <li><a href="drinks2-4.php" >DRINKS</a></li>
            <li><a href="treats2-4.php" >TREATS</a></li>
        </ul>
    </nav>
</header>
<hr>
</body>

<main>
    <!--Search bar for drinks table-->
    <form class="drinksearch" action="" method="post">
        <input type="text" name = 'search'>
        <input type = "submit" name = "submit" value="Search">
    </form>

    <h2>DRINKS MENU:</h2>
    <!--Drop down menu to sort products-->
    <form class="drinkfilter" name='sort_form' id='sort_form' method='get' action='drinks2-3.php'>
        <select id='sort' name='sort' onchange='javascript:this.form.submit()'>
            <!--options-->
            <option value = 'alphaAsc'> Alphabetical A to Z</option>
            <option value = 'alphaDesc'> Alphabetical Z to A</option>
            <option value = 'costAsc'> Price Low to High</option>
            <option value = 'costDesc'> Price High to Low</option>
        </select></form>

    <!--filter buttons-->
    <form class="drinkfilter" action="drinks2-3.php" method="get">
        <button id="availability" name="availability" type="submit" value="Availability">Availability</button>
    </form>
    <form class="drinkfilter" action="drinks2-3.php" method="get">
        <button id="colddrinks" name="colddrinks" type="submit" value="cold">Cold</button>
    </form>
    <form class="drinkfilter" action="drinks2-3.php" method="get">
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

    /*Display format of results when different filters applied*/
    if(isset($_GET['colddrinks'])) {
        while ($colddrinks_record = mysqli_fetch_assoc($colddrinks_result)) {
            echo "<br>";
            echo $colddrinks_record['DItem'];
            echo "<br>";
            echo "$" . $colddrinks_record['DPrice'];
            echo "</a><br><br>";
        }
    }elseif(isset($_GET['hotdrinks'])) {
        while ($hotdrinks_record = mysqli_fetch_assoc($hotdrinks_result)) {
            echo "<br>";
            echo $hotdrinks_record['DItem'];
            echo "<br>";
            echo "$" . $hotdrinks_record['DPrice'];
            echo "</a><br><br>";

        }
    }elseif(isset($_GET['availability'])) {
        while ($availability_record = mysqli_fetch_assoc($availability_result)) {
            echo "<br>";
            echo $availability_record['DItem'];
            echo "<br>";
            echo "$" . $availability_record['DPrice'];
            echo "</a><br><br>";

        }
    }
    ?>
        <table align="center">
            <tr>
                <th>ITEM</th>
                <th>PRICE</th>
                <th>AVAILABILITY</th>
                <th>CATEGORY</th>
            </tr>
            <?php
            while($rows=$all_drink_result-> fetch_assoc())
            {
                ?>
                <tr>
                    <td><?php echo $rows['DItem'];?></td>
                    <td><?php echo $rows['DPrice'];?></td>
                    <td><?php echo $rows['Availability'];?></td>
                    <td><?php echo $rows['DCategory'];?></td>
                </tr>
            <?php
            }
            ?>
        </table>
</main>
</html>