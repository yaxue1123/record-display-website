<!DOCTYPE html>
<html>
<head>
    <title>P1 Records Display and Search</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"> </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
    <link rel="stylesheet" href ="style.css">
</head>
<body>

<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#">P1 Records</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="yaxue_p1_browse.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="search.php">Search</a>
                </li>
            </ul>
            <form class="form-inline mt-2 mt-md-0" action="search.php" method="post">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="searchby">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit" value="Search">Search</button>
            </form>
        </div>
    </nav>
</header>

<table>
    <tr>
        <td class="heading"><a href="browse.php?sortby=authors">Author(s)</a></td>
        <td class="heading"><a href="browse.php?sortby=title">Title</a></td>
        <td class="heading"><a href="browse.php?sortby=publication">Publication</a></td>
        <td class="heading"><a href="browse.php?sortby=year">Year</a></td>
        <td class="heading"><a href="browse.php?sortby=type">Type</a></td>
    </tr>

    <?php
    require "dbconnect.php";
    $sortby = $_GET['sortby'];
    $page = $_GET['page'];
    $count = 0;
    $totalpage = 9;
    $start = 0;

    #Use switch in case that a user input illegal url mannually.
    if (!isset($sortby)) {
        $sortby = "itemnum";
    } else {
        switch ($sortby) {
            case "authors":
                $sortby = "authors";
                break;
            case "title":
                $sortby = "title";
                break;
            case "publication":
                $sortby = "publication";
                break;
            case "year":
                $sortby = "year";
                break;
            case "type":
                $sortby = "type";
                break;
            default:
                $sortby = "itemnum";
        }
    }

    #Count the item numbers in records to decide how many pages to display for 25 items per page and the start page.
    $sql = "SELECT count(*) from p1records";
    $count = $mysqli->query($sql)->fetch_assoc()['count(*)'];
    $totalpage = ceil($count / 25);
    if (!isset($page)) $page = 1;
    $start = ($page - 1) * 25;

    #Sql query to retrieve 25 records for each page and sort them according to $sortby collected by clicking url
    $query = "select * from p1records ORDER BY $sortby LIMIT $start,25";

    #Show the display results in the interface
    if ($result = $mysqli->query($query)) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['authors'] . "</td><td><a href=" . $row['url'] . ">" . $row['title']
                . "</a></td><td>" . $row['publication'] . "</td><td>" . $row['year'] . "</td><td>" . $row['type'];
            echo "<p>";
        }
    }


    ?>

</table>
<table class="foottable" cellspacing="0" cellpadding="0">
    <tr>
        <?php
        for ($i = 1; $i <= $totalpage; $i++) {
            ?>
            <td><a href="browse.php?sortby=<?php echo $sortby; ?>&page=<?php echo $i; ?>">
                    <?php if ($i == $page) echo "[" . $i . "]"; else echo $i; ?></a></td>
            <?php
        } ?></tr>
</table>
</body>