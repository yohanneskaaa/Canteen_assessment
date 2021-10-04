<?php
$con = mysqli_connect("localhost", "yohanneska", "wildfog34", "yohanneska_canteen" );
if(mysqli_connect_errno()) {
    echo "Failed to connect to MySQL:".mysqli_connect_error(); die();}
else{
    echo "connected to database";
}
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
    <img class="logo" src="wgclogo.png">
</header>
</body>

<h2 class="title"> SEARCH RESULTS:</h2>

<?php
if(isset($_POST['search'])) {
    $search = $_POST['search'];
    /* Union code source https://www.dummies.com/programming/databases/combine-information-from-multiple-mysql-tables-with-union/ */
    $namequery1 = "(SELECT FItem AS name FROM foods WHERE FItem LIKE '%$search%')
                UNION (SELECT DItem AS name FROM drinks WHERE DItem LIKE '%$search%')
                UNION (SELECT TItem AS name From treats WHERE TItem LIKE '%$search%')";
    $namequery = mysqli_query($con, $namequery1);
    $count = mysqli_num_rows($namequery);
    if($count == 0){
        echo "There was no search results!";
    }else{
        while ($row = mysqli_fetch_array($namequery)) {
            echo $row ['name'];
            echo "<br>";
        }
    }
}
?>