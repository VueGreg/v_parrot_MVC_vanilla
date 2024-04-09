<?php

namespace Controllers;

use Models\MessagesModel;
use Request\RequestMessage;
use Utils\Controller;

class MessageController extends Controller
{
    public function store(Array $request)
    {
        header('Content-Type: Application/json');
        $request = new RequestMessage();

        if ($request->validation($request->getPost()) === true) {
            $data = $request->getPost();
            $data['date'] = date('Y-m-d H:i:s');
            $data['status'] = 1;

            $message = new MessagesModel();
            $message->query()->create($data);

            $validation['code'] = 200;
            $validation['message'] = "Le message à bien été reçu";
            echo json_encode($validation);
        }else {
            $errors = $request->validation($request->getPost());
            echo json_encode($errors);
        }
        
    }
}