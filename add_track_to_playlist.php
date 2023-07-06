<?php
    include_once('storage.php');

    session_start();
    $plist_id = $_GET['plist_id'];
    $track_id = $_POST['track'];
    $stor_plists = new JsonStorage("playlists.json");
    $pl = $stor_plists -> findById($plist_id);
    $tracks_ids = $pl['tracks'];
    $tracks_ids[] = $track_id;

    $updated_playlist = [
        'name' => $pl['name'],
        'creator' => $pl['creator'],
        'tracks' => $tracks_ids,
        'isPublic' => $pl['isPublic']
    ];

    $stor_plists -> update($plist_id, $updated_playlist);

    header("Location: details.php?id=". $plist_id);
    exit();

?>