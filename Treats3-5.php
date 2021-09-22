<?php
$con = mysqli_connect("localhost", "yohanneska", "wildfog34", "yohanneska_canteen" );
if(mysqli_connect_errno()) {
    echo "Failed to connect to MySQL:".mysqli_connect_error(); die();}
else{
    echo "connected to database";
}

$all_treats_query = "SELECT * FROM treats";
$all_treats_result = mysqli_query($con, $all_treats_query);

/* Treats Query*/
/*SELECT all FROM Treats*/
$this_treat_query = "SELECT * From treats";
$this_treat_result = mysqli_query($con, $this_treat_query);
$this_treat_record = mysqli_fetch_assoc($this_treat_result);
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
    <h1>WGC CANTEEN</h1>
    <nav>
        <ul>
            <li><a href="home3-5.php" >HOME</a></li>
            <li><a href="food3-5.php" >FOOD</a></li>
            <li><a href="drinks3-5.php" >DRINKS</a></li>
            <li><a href="treats3-5.php" >TREATS</a></li>
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

    <h2>TREATS</h2>

    <?php
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
                ?>
    <?php
            }
         }
    }
    ?>
        <div class="products-box" align="center">
            <?php
            while($rows=$all_treats_result-> fetch_assoc())
            {
                ?>
                <div class="product-box">
                    <?php
                    echo "<img src='images/". $rows['Imageurl'] . "'>";
                    echo "<br>";
                    echo $rows['TItem'];
                    echo "<br>";
                    echo $rows ['TPrice'];
                    echo "</div>";
            }
            ?>
    </div>
</main>
</html>