<?php
    $path = explode('/', $_GET['path']);
    $contents = file_get_contents('db.json');

    $json = json_decode($contents, true);

    $method = $_SERVER['REQUEST_METHOD'];

    header('Content-type: application/json');
    $body = file_get_contents('php://input');

    if($method === 'GET'){
        if($json[$path[0]]){
            echo json_encode($json[$path[0]]);
        } else {
            echo '[]';
        }
    }

    if($method === 'POST'){
        $jsonBody = json_decode($body, true);
        // o id será a hora atual
        $jsonBody['id'] = time();

        // Cria um registro se for um novo valor
        if(!json[$path[0]]){
            $json[$path[0]] = [];
        }

        // Preenche o id
        $json[$path[0]][] = $jsonBody;
        echo json_encode($jsonBody);
        file_put_contents('db.json', json_encode($json));
    }