<?php
if(isset($data))
{
    echo "<h2 class=\"results-heading\">{$data["search_query"]}</h2>";
    echo "<hr class=\"results-hr\">";

    echo "<div class=\"results-list\">";
    foreach($data["search_results"] as $search_result)
    {
        echo "<a class=\"results-item\" href=\"{$search_result["href"]}\">";
        echo "<span class=\"results-item-span-main\">{$search_result["main"]}</span>";
        echo " ";
        echo "<span class=\"results-item-span-sub\">{$search_result["sub"]}</span>";
        echo " ";
        echo "<span class=\"results-item-span-count\">{$search_result["count"]}</span>";
        echo "</a>";
        echo "<br/>";
    }
    echo "</div>";

}
