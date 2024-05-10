<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: appplication/json');

include_once('../core/initialize.php');

$post = new Post($db);
$post->email = isset($_GET['email']) ? $_GET['email'] : die();
$result = $post->readByEmail();

if($result !== false){
    $data = array(
        'profile' => $post->profile,
        'name' => $post->name,
        'email' => $post->email,
        'age' => $post->age,
        'address' => $post->address,
        'neighborhood' => $post->neighborhood,
        'zipCode' => $post->zipCode,
        'state' => $post->state,
        'biography' => $post->biography
    ); 
    
    print_r(json_encode($data));
    
} else {
    http_response_code(404);
    echo json_encode(
        array('message' => 'Nenhum registro foi encontrado.')
    );
}
?>