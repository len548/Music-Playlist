<?php
    include_once("storage.php");
    $stor = new JsonStorage("users.json");
    $existinguser = $stor -> findOne(['username' => 'name1']);
    print_r($existinguser);
?>