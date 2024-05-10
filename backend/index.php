<?php

include_once(' ./core/initialize.php');
include_once('./includes/config.php');
include_once('./core/post.php');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

$endpoint = $_SERVER['REQUEST_URI'];


$email = isset($_GET['email']) ? $_GET['email'] : null;

$endpoint = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $endpoint);


switch ($method) {
    case 'GET':
        // Verificar se o endpoint é getAll.php
        if ($endpoint == '/getAll.php') {
            // Iniciar objeto Post e definir o email
            if ($email !== null) {
                $_GET['email'] = $email;
                include_once('api/getAll.php');
            } else {
                http_response_code(400);
                echo json_encode(array('message' => 'O parâmetro email é obrigatório.'));
            }
        } else {
            // Endpoint não suportado
            http_response_code(404);
            echo json_encode(array("message" => "Endpoint não encontrado."));
        }
        break;
    case 'POST':
        if ($endpoint == '/create') {
            include_once('api/create.php');
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Endpoint não encontrado."));
        }
        break;
    case 'PUT':
            if ($endpoint == '/index.php/update') {
                
                if ($email !== null) {
            
                    $_GET['email'] = $email;
                    include_once('api/update.php');
                } else {
                    http_response_code(400);
                    echo json_encode(array('message' => 'O parâmetro email é obrigatório.'));
                }
            } else {
                // Endpoint não suportado
                http_response_code(404);
                echo json_encode(array("message" => "Endpoint não encontrado."));
            }
            break;    
    case 'DELETE':
        if ($endpoint == '/delete') {
            include_once('api/delete.php');
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Endpoint não encontrado."));
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Método não permitido."));
        break;
}

?>
