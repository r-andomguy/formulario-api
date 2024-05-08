<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: appplication/json');

include_once('../core/initialize.php');

$post = new Post($db);
$post->id = isset($_GET['id']) ? $_GET['id'] : die();
$post->readById();

$data = array(
    'id' => $post->id,
    'profile' => $post->profile,
    'name' => $post->name,
    'address' => $post->address,
    'neighborhood' => $post->neighborhood,
    'zipCode' => $post->zipCode,
    'state' => $post->state,
    'biography' => $post->biography
);

print_r(json_encode($data));

?>