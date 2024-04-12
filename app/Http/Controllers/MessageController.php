<?php

namespace Controllers;

use Models\MessagesModel;
use Request\RequestMessage;
use Utils\Controller;
use Utils\Model;
use Utils\Request;

class MessageController extends Controller
{
    public function index()
    {
        $data = $this->getMessages();
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
            $response['errors'] = $validationResult;
        }

        echo json_encode($response);
    }

    public function update(Request $request)
    {
        header('Content-Type: application/json');

        $model = new MessagesModel();
        $messages = $model->all();
        $id = $request->getPost()['id'];

        foreach ($messages as $message) {
            if ($message->id == $id) {
                $newState = $message->status == 0 ? 1 : 0;
                if ($model->query()->update(['status' => $newState], $id)) {
                    $result = $this->getMessages();
                    echo json_encode($result);
                    return;
                }
            }
        }

        $error = 'Une erreur s\'est produite lors de la mise à jour';
        echo json_encode($error);
    }

    private function getMessages(): Array
    {
        $model = new MessagesModel();
        $messages = $model->query()->select()->where('status', '=', 1)->get();
        $count = $model->query()->count()->where('status', "=", 1)->get();

        $data = [
            "count" => $count,
            "messages" => $messages
        ];

        return $data;
    }
}