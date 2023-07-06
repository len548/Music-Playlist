<?php
    include_once('storage.php');

    session_start();
    $plist_id = $_GET['id'];
    $stor_plists = new JsonStorage("playlists.json");
    $pl = $stor_plists -> findById($plist_id);
    $tracks_ids = $pl['tracks'];
    $createdByUser = $pl['creator'] === $_SESSION['userid'];
    
    $stor_tracks = new JsonStorage("tracks.json");
    $total_length = 0;
    foreach($tracks_ids as $id){
        $track = $stor_tracks -> findById($id);
        $total_length = $total_length + $track['length'];
    }

    if($createdByUser){
        $available_tracks = $stor_tracks -> query(function($track) {
            global $tracks_ids;
            return !in_array($track['id'], $tracks_ids);
        });
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Playlist Details</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1><?= $pl['name'] ?></h1>
        <p>Total time: <?= intval($total_length/60) ?>:<?= $total_length%60 ?></p>
        <a href="index.php">Home</a>
    </header>

    <main>
        <h2>Tracks in Playlist</h2>

        <?php foreach($tracks_ids as $track_id): ?>
            <?php $t = $stor_tracks -> findById($track_id) ?>
            <div class="track">
                <h3><?= $t['title'] ?></h3>
                <p>By: <?= $t['artist'] ?></p>
                <p>Length: <?= intval($t['length']/60) ?>:<?= $t['length']%60 ?></p>
                <p>Year: <?= $t['year'] ?></p>
                <p>Genres: <?php print(implode(", ", $t['genres'])) ?></p>
                <?php if($createdByUser): ?>
                    <a href="remove_track_from_pl.php?plist_id=<?= $plist_id ?>&track_id=<?= $track_id ?>">Remove</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        
        <!-- Add track form for logged-in users -->
        <?php if($createdByUser): ?>
            <form class="add-track-form" action="add_track_to_playlist.php?plist_id=<?= $plist_id ?>" method="post">
                <label for="track">Add Song</label>
                <select name="track" for="track" id="track">
                    <?php foreach($available_tracks as $t): ?>
                        <option value="<?= $t['id'] ?>"><?= $t['title'] ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Add to Playlist</button>
            </form>
        <?php endif; ?>

    </main>

    <footer>
        <!-- Footer content -->
    </footer>
</body>
</html>
