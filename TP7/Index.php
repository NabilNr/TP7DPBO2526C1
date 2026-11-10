<?php
// Tampilkan Layout Header
include __DIR__ . '/view/header.php';

// Routing Halaman Sederhana
$page = isset($_GET['page']) ? $_GET['page'] : 'teams';

if ($page == 'teams') {
    include __DIR__ . '/view/teams.php';
} elseif ($page == 'players') {
    include __DIR__ . '/view/players.php';
} elseif ($page == 'matches') {
    include __DIR__ . '/view/matches.php';
} else {
    echo "<h2>Halaman tidak ditemukan.</h2>";
}

// Tampilkan Layout Footer
include __DIR__ . '/view/footer.php';
?>