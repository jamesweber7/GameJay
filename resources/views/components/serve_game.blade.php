<?php


function include_script($scriptName) 
{
    echo "<script src=" . asset("storage/games/Birfday%20Bash60f4d2f4049ca/$scriptName") . "> </script>";
}

$needToInclude = [
    "p5.js",
    "p5.sound.min.js",
    "sketch.js",
    "Character.js",
    "Player.js",
    "Physics.js",
    "World.js",
    "Level.js",
    "LevelObject.js",
    "CollisionObject.js",
    "BadObject.js",
    "StateObject.js",
    "Cloud.js",
    "Poof.js",
];


foreach ($needToInclude as $fileName) {
    include_script($fileName);
}


?>
