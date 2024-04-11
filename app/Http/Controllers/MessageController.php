<?php

namespace Controllers;

use Models\MessagesModel;
use Request\RequestMessage;
use Utils\Controller;

class MessageController extends Controller
{
    public function store(RequestMessage $request)
    {
        header('Content-Type: Application/json');

        $postData = $request->getPost();
        $validationResult = $request->validation($postData);

        if ($validationResult === true) {
            $data = $postData;
            $data['date'] = date('Y-m-d H:i:s');
            $data['status'] = 1;

            $message = new MessagesModel();
            $message->query()->create($data);

            $response['code'] = 200;
            $response['message'] = "Le message a bien été reçu";
        } else {
            $response['code'] = 400;
            $response['errors'] = $validationResult; // On récupère directement les erreurs de validation
        }

        echo json_encode($response);
    }
}