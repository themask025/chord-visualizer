<?php
if(isset($data))
{
    echo "<h2 class=\"results-heading\"> Search Results for \"{$data["song"]["title"]}\" by \"{$data["song"]["performer"]}\" </h2>";
    echo "<hr class=\"results-hr\">";

    echo "<div class=\"results-list\">";
    foreach($data["versions"] as $i => $version)
    {
        echo "<a class=\"results-item\" href=\"/chord-visualizer/version/tabEditor?version_id={$version["id"]}\">";
        echo "<span class=\"results-item-span-top-left\">Version {$i}</span>";
        echo " ";
        echo "<span class=\"results-item-span-bottom-left\">By {$version["username"]}</span>";
        echo " ";
        echo "<span class=\"results-item-span-right\">{$version["comments_count"]} comments</span>";
        echo "</a>";
        echo "<br/>";
    }
    echo "</div>";

}
