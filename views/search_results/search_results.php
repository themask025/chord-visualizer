<?php
require_once(__DIR__ . "/../navigation_bar/index.php");
require_once (__DIR__ . "/../../constants.php");
echo '<link rel="stylesheet"' . ' href="' . BASE_PATH . 'views/search_results/search_results.css" />';
if (isset($data)) {
    echo "<h2 class=\"results-heading\">{$data["search_query"]}</h2>";
    echo "<hr class=\"results-hr\">";

    echo "<div class=\"results-list\">";
    foreach ($data["search_results"] as $search_result) {
        echo "<a class=\"results-item\" href=\"{$search_result["href"]}\">";
        echo "<span class=\"results-item-span-main\">{$search_result["main"]}</span>";
        echo "<span class=\"results-item-span-count\">{$search_result["count"]}</span>";
        echo "<span class=\"results-item-span-sub\">{$search_result["sub"]}</span>";
        echo "</a>";
    }
    echo "</div>";
}
