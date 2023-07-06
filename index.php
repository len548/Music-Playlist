<?php
    include_once('storage.php');

    session_start();
    $stor_plist = new JsonStorage("playlists.json");
    $playlists = $stor_plist->findAll();
    $stor_tracks = new JsonStorage("tracks.json");
    $search_title = $_POST['search'] ?? '';
    $stor_users = new JsonStorage('users.json');

    if (isset($_SESSION['userid'])) {
        $user = $stor_users -> findById($_SESSION['userid']);
        $user_playlists = $stor_plist -> findAll(['creator' => $_SESSION['userid']]);
    }
    // Perform search
    if (!empty($search_title)) {
        $search_results = $stor_tracks->query(function ($track) use ($search_title) {
            return stripos($track['title'], $search_title) !== false;
        });
    } else {
        $search_results = [];
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Music Playlist Application</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <?php if(!isset($_SESSION['userid'])): ?>
            <h1>Welcome to the Music Playlist Application</h1>
            <p>Discover and create playlists of your favorite music tracks.</p>
            <a href="login.php">Login</a>/<a href="register.php">Register</a>
        <?php else: ?>
            <h1>Hello <?= $user['username'] ?>!</h1>
            <p>Discover and create playlists of your favorite music tracks.</p>
            <a href="logout.php">Logout</a>
        <?php endif; ?>
        
    </header>

    <main>
        <!-- Public playlist-->
        <h2>Public Playlists</h2>
        
        <?php foreach ($playlists as $id => $pl): ?>
            <?php if ($pl['isPublic']): ?>
                <?php $creator = $stor_users -> findById($pl['creator']) ?>
                <div class="playlist">
                    <h3><?= $pl['name'] ?></h3>
                    <p>Number of tracks: <?= count($pl['tracks']) ?></p>
                    <p>Created by: <?= $creator['username'] ?></p>
                    <a href="details.php?id=<?= $id ?>">More</a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        
        <!-- User playlist-->
        <?php if(isset($_SESSION['userid'])): ?>
            <h2>Your Playlists</h2>
            
            <?php if(empty($user_playlists)): ?>
                <p style="color:grey">No playlist</p>
            <?php endif; ?>
            <?php foreach ($user_playlists as $id => $pl): ?>
                <div class="playlist">
                    <h3><?= $pl['name'] ?></h3>
                    <p>Number of tracks: <?= count($pl['tracks']) ?></p>
                    <p>Created by: <?= $user['username'] ?></p>
                    <a href="details.php?id=<?= $id ?>">More</a>
                </div>
            <?php endforeach; ?>
            <!-- Add playlist here-->
            <a href="create_playlist.php">Create a New Playlist</a>
        <?php endif; ?>

        <form class="search-form" action="" method="POST">
            <input type="text" name="search" placeholder="Search by Track Title">
            <button type="submit">Search</button>
        </form>

        <!-- Display search results -->
        <?php if (!empty($search_results)): ?>
            <h2>Search Results</h2>
            <?php foreach ($search_results as $track): ?>
                <div class="track">
                    <h3><?= $track['title'] ?></h3>
                    <p>Artist: <?= $track['artist'] ?></p>
                    <p>Length: <?= $track['length'] ?></p>
                    <p>Year: <?= $track['year'] ?></p>
                    <p>Genres: <?= implode(', ', $track['genres']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php elseif (!empty($search_title)): ?>
            <p>No matching tracks found.</p>
        <?php endif; ?>


    </main>

    <footer>
        <!-- Footer content -->
    </footer>
</body>
</html>
