<?php
// Set variabel untuk template
$page_title = "Dashboard";
$active_menu = "dashboard";

// Include main template loader
require_once 'main.php';

// Define content view
$content_view = 'views/dashboard.php';

// Load template
load_template($page_title, $active_menu, $content_view);
?>