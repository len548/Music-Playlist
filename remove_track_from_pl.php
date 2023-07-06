<?php
    include_once('storage.php');

    session_start();
    $plist_id = $_GET['plist_id'];
    $track_id = $_GET['track_id'];
    
    $stor_plists = new JsonStorage("playlists.json");
    $pl = $stor_plists -> findById($plist_id);
    
    $updated_playlist = [
        'name' => $pl['name'],
        'creator' => $pl['creator'],
        'tracks' => array_values(array_diff($pl['tracks'], [$track_id])),
        'isPublic' => $pl['isPublic']
    ];

    $stor_plists -> update($plist_id, $updated_playlist);

    header("Location: details.php?id=". $plist_id);
    exit();
?>