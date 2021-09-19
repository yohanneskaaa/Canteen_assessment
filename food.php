<?php
$con = mysqli_connect("localhost", "yohanneska", "wildfog34", "yohanneska_canteen" );
if(mysqli_connect_errno()) {
    echo "Failed to connect to MySQL:".mysqli_connect_error(); die();}
else{
    echo "connected to database";
}

$all_foods_query = "SELECT FItem FROM Foods";
$all_foods_result = mysqli_query($con, $all_foods_query);

/* Drinks Query*/
/*SELECT DrinkID, DrinkName FROM Drinks*/
$this_food_query = "SELECT * From foods";
$this_food_result = mysqli_query($con, $this_food_query);
$this_food_record = mysqli_fetch_assoc($this_food_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CANTEEN</title>
    <meta charset="UTF-8">
</head>
<body>
<header>
    <h1>WGC CANTEEN</h1>
    <nav>
        <ul>
            <li><a href="home.php" >HOME</a></li>
            <li><a href="food.php" >FOOD</a></li>
            <li><a href="drinks.php" >DRINKS</a></li>
            <li><a href="treats.php" >TREATS</a></li>
        </ul>
    </nav>
</header>
<hr>
</body>

<main>
    <form action="" method="post">
        <input type="text" name = 'search'>
        <input type = "submit" name = "submit" value="Search">
    </form>

    <?php
    if(isset($_POST['search'])) {
        $search = $_POST['search'];
        $query1 = "SELECT * FROM foods WHERE FItem LIKE '%$search%'";
        $query = mysqli_query($con, $query1);
        $count = mysqli_num_rows($query);
        if($count == 0){
            echo "There was no search results!";
        }else{
            while ($row = mysqli_fetch_array($query)) {
                echo $row ['FItem'];
                echo "<br>";
            }
        }
    }
    ?>
    <h2>FOOD MENU:</h2>
    <table>
        <tr>
            <th>ITEM</th>
            <th>PRICE</th>
            <th>AVAILABILITY</th>
            <th>CATEGORY</th>
        </tr>
        <?php
        while($rows=$this_food_result-> fetch_assoc())
            {
        ?>
        <tr>
            <td><?php echo $rows['FItem'];?></td>
            <td><?php echo $rows['FPrice'];?></td>
            <td><?php echo $rows['Availability'];?></td>
            <td><?php echo $rows['FCategory'];?></td>
        </tr>
        <?php
            }
        ?>
    </table>

</main>
</html>
