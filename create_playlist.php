<?php
    session_start();
    include_once("storage.php");
    $userid = $_SESSION['userid'];
    $stor_plist = new JsonStorage('playlists.json');
    $stor_tracks = new JsonStorage('tracks.json');
    $all_tracks = $stor_tracks -> findAll();

    $name = $_POST['name'] ?? '';
    $chosen_tracks = $_POST['chosen_tracks'] ?? '';
    $isPublic = $_POST['isPublic'] ?? '';
    $success = false;
    $errors = [];

    if($_POST){
        //validate user inputs
        if(empty($name) || empty($chosen_tracks)){
            $errors[] = "All fields are required.";
        }
        else{
            $existingPlaylist = $stor_plist->findOne(['name' => $name]);
            if ($existingPlaylist) {
                $errors[] = "The playlist name is already used.";
            }
        }

        if(!$errors){
            $stor_plist -> add([
                'name' => $name,
                'creator' => $userid,
                'tracks' => $chosen_tracks,
                'isPublic' => $isPublic === 'public' ? true : false
            ]);
            $success = true;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>New Playlist - Music Playlist Application</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1><?php echo $success ? "New playlist added!" : "New playlist" ?></h1>
        <a href="index.php">Home</a>
    </header>
    
    <main>
        <?php if(!$success): ?>
            <h2>New playlist</h2>
            
            <form class="add-playlist-form" action="add_playlist.php" method="post">
                <label for="name">Title:</label>
                <input type="text" name="name" id="name" value="<?= $name ?? '' ?>"><br>
                
                <label>Tracks:</label><br>
                <?php foreach ($all_tracks as $id => $track): ?>
                    <input type="checkbox" name="chosen_tracks[]" value="<?= $id ?>">
                    <label><?= $track['title'] ?></label><br>
                <?php endforeach; ?>

                <label>Visibility:</label>
                <select name="isPublic" id="isPublic">
                    <option value="private" >Private</option>
                    <option value="public" >Public</option>
                </select><br>

                <?php if ($errors): ?>
                    <ul class="error">
                        <?php foreach ($errors as $error) { ?>
                            <span style="color:red"><?php echo $error; ?></span><br>
                        <?php } ?>
                    </ul>
                <?php endif; ?>
                <button type="submit">Create</button>
            </form>
        <?php else: ?>
            <p>New playlist Created!</p>
            <h2>Title: <?= $name ?> </h3>
            <h2>Tracks in Playlist</h2>

            <?php foreach($chosen_tracks as $t_id): ?>
                <?php $t = $stor_tracks -> findById($t_id) ?>
                <div class="track">
                    <h3><?= $t['title'] ?></h3>
                    <p>By: <?= $t['artist'] ?></p>
                    <p>Length: <?= intval($t['length']/60) ?>:<?= $t['length']%60 ?></p>
                    <p>Year: <?= $t['year'] ?></p>
                    <p>Genres: <?php print(implode(", ", $t['genres'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>
</body>
</html>