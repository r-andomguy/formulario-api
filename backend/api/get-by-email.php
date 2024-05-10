<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: appplication/json');

include_once('../core/initialize.php');

if ($email !== null) {
    // Iniciar objeto Post e definir o email
    $post = new Post($db);
    $post->email = $email;

    // Tentar buscar os registros com base no email
    $result = $post->readByEmail();

    if ($result !== false) {
        // Registros encontrados, montar array de dados
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

        // Retornar os dados em formato JSON
        echo json_encode($data);
    } else {
        // Nenhum registro encontrado com o email fornecido
        http_response_code(404);
        echo json_encode(array('message' => 'Nenhum registro foi encontrado com o email fornecido.'));
    }
} else {
    // Parâmetro email não foi passado na URL
    http_response_code(400);
    echo json_encode(array('message' => 'O parâmetro email é obrigatório.'));
}

?>
