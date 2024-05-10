<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization');

include_once('../core/initialize.php');

$post = new Post($db);
$data = json_decode(file_get_contents('php://input'));

$post->email = $data->email;

// Verifica se o email existe no banco de dados
if ($post->emailExists()) {

    $post->profile = $data->profile;
    $post->name = $data->name;
    $post->address = $data->address;
    $post->neighborhood = $data->neighborhood;
    $post->zipCode = $data->zipCode;
    $post->state = $data->state;
    $post->biography = $data->biography;

    if ($post->update()) {
        echo json_encode(
            array('message' => 'Registro atualizado com sucesso.')
        );
    } else {
        echo json_encode(
            array('message' => 'Não foi possível atualizar o registro.')
        );
    }
} else {
    echo json_encode(
        array('message' => 'Email não encontrado. Não foi possível atualizar o registro.')
    );
}

?>
