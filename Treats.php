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
    <img class="banner-img" src="images/treatsbanner.png">
    <div class="banner-text">
        <h2 class="center-text">TREATS</h2>
    </div>

<main>
    <form class="treatsearch" action="" method="post">
        <input type="text" name = 'search'>
        <input type = "submit" name = "submit" value="Search">
    </form>

    <h2 class="title">TREATS</h2>

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
                    echo "<img class='product-img' src='images/". $rows['Imageurl'] . "'>";
                    echo "<br>";
                    echo $rows['TItem'];
                    echo "<br>";
                    echo "$" . $rows ['TPrice'];
                    echo "</div>";
            }
            ?>
    </div>
</main>
</html>