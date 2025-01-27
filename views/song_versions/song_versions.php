<?php
if(isset($data))
{
    echo json_encode($data);
    echo "<h1> Song Versions </h1>";
    echo "<table>";
    echo "<tr>";
    echo "<th>Version Name</th>";
    echo "<th>Creator</th>";
    echo "<th>Comment count</th>";
    echo "</tr>";
    foreach($data["versions"] as $version)
    {
        echo "<tr>";
        echo "<td>".$version["name"]."</td>";
        echo "<td>".$version["username"]."</td>";
        echo "<td>".$version["comments_count"]."</td>";
        echo "</tr>";
    }
    echo "</table>";

}