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
    $field = 'TItem';
    $order = 'ASC';

} elseif ($sort == 'costAsc') {
    $field = 'TPrice';
    $order = 'ASC';
} elseif ($sort == 'costDesc') {
    $field = 'TPrice';
    $order = 'DESC';
} elseif ($sort == 'alphaDesc') {
    $field = 'TItem';
    $order = 'DESC';
}

/*Setting variable to filter the treat products according to availability*/
if(isset($_GET['availability'])){
    $availability = $_GET['availability'];
}else{
    $availability = "";
}

/* Treats Query*/
/*SELECT all FROM Treats*/
$all_treats_query = "SELECT * FROM Treats ORDER BY $field $order";
$all_treats_result = mysqli_query($con, $all_treats_query);
$all_treats_record = mysqli_fetch_assoc($all_treats_result);

/*Availability query*/
$availability_query = "SELECT * FROM Treats WHERE availability = 'yes'";
$availability_result = mysqli_query($con, $availability_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CANTEEN</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style2-3.css">
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
            <li><a href="home2-3.php" >HOME</a></li>
            <li><a href="food2-3.php" >FOOD</a></li>
            <li><a href="drinks2-3.php" >DRINKS</a></li>
            <li><a href="treats2-3.php" >TREATS</a></li>
        </ul>
    </nav>
</header>
<hr>
</body>

<main>
    <!--Search bar for treats table-->
    <form class="treatsearch" action="" method="post">
        <input type="text" name = 'search'>
        <input type = "submit" name = "submit" value="Search">
    </form>

    <h2>TREATS MENU:</h2>
    <!--Drop down menu to sort products-->
    <form class="treatfilter" name='sort_form' id='sort_form' method='get' action='treats2-3.php'>
        <select id='sort' name='sort' onchange='javascript:this.form.submit()'>
            <!--options-->
            <option value = 'alphaAsc'> Alphabetical A to Z</option>
            <option value = 'alphaDesc'> Alphabetical Z to A</option>
            <option value = 'costAsc'> Price Low to High</option>
            <option value = 'costDesc'> Price High to Low</option>
        </select></form>

    <!--filter button-->
    <form class="treatfilter" action="treats2-3.php" method="get">
        <button id="availability" name="availability" type="submit" value="Availability">Availability</button>
    </form>

    <?php
    /*Query searching for items in treats table*/
    if(isset($_POST['search'])) {
        $search = $_POST['search'];
        $query1 = "SELECT * FROM treats WHERE TItem LIKE '%$search%'";
        $query = mysqli_query($con, $query1);
        $count = mysqli_num_rows($query);
        if($count == 0){
            echo "There was no search results!";
        }else{
            while ($row = mysqli_fetch_array($query)) {
                echo $row ['TItem'];
                echo "<br>";
            }
        }
    }
    /*Display format of results when availability filter applied*/
    if(isset($_GET['availability'])) {
        while ($availability_record = mysqli_fetch_assoc($availability_result)) {
            echo "<br>";
            echo $availability_record['TItem'];
            echo "<br>";
            echo "$" . $availability_record['TPrice'];
            echo "</a><br><br>";

        }
    }
    ?>
    <table align="center">
        <tr>
            <th>ITEM</th>
            <th>PRICE</th>
            <th>AVAILABILITY</th>
        </tr>
        <?php
        while($rows=$all_treats_result-> fetch_assoc())
        {
            ?>
            <tr>
                <td><?php echo $rows['TItem'];?></td>
                <td><?php echo $rows['TPrice'];?></td>
                <td><?php echo $rows['Availability'];?></td>
            </tr>
            <?php
        }
        ?>
    </table>

</main>
</html>