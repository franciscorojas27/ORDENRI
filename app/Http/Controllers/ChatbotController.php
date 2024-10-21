<?php
namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $client = new Client();
    try {
        $response = $client->post('http://127.0.0.1:5001/chat', [
            'json' => ['message' => $request->input('message')]
        ]);

        $data = json_decode($response->getBody(), true);
        return response()->json($data);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error en la comunicación con el servidor.'], 500);
    }
    }
}
