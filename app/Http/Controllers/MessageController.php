<?php

namespace Controllers;

use Models\MessagesModel;
use Request\RequestMessage;
use Utils\Controller;
use Utils\Model;

class MessageController extends Controller
{
    public function index()
    {
        $model = new MessagesModel();
        $messages = $model->all();
        $count = $model->query()->count()->where('status', "=", 0);

        $data = [
            "count" => $count,
            "messages" => $messages
        ];

        $this->view('dashboard/message', $data);
    }

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