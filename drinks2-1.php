<?php
$con = mysqli_connect("localhost", "yohanneska", "wildfog34", "yohanneska_canteen" );
if(mysqli_connect_errno()) {
    echo "Failed to connect to MySQL:".mysqli_connect_error(); die();}
else{
    echo "connected to database";
}

$all_drinks_query = "SELECT DItem FROM Drinks";
$all_drinks_result = mysqli_query($con, $all_drinks_query);

/* Drinks Query*/
/*SELECT DrinkID, DrinkName FROM Drinks*/
$this_drink_query = "SELECT * From Drinks";
$this_drink_result = mysqli_query($con, $this_drink_query);
$this_drink_record = mysqli_fetch_assoc($this_drink_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CANTEEN</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style2-1.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kalam&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Concert+One&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <h1>WGC CANTEEN</h1>
    <nav>
        <ul>
            <li><a href="home2-1.php" >HOME</a></li>
            <li><a href="food2-1.php" >FOOD</a></li>
            <li><a href="drinks2-1.php" >DRINKS</a></li>
            <li><a href="treats2-1.php" >TREATS</a></li>
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
    <h2>DRINKS MENU:</h2>
    <table align="center">
        <tr>
            <th>ITEM</th>
            <th>PRICE</th>
            <th>AVAILABILITY</th>
            <th>CATEGORY</th>
        </tr>
        <?php
        while($rows=$this_drink_result-> fetch_assoc())
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