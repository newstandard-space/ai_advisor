<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatGptController extends Controller
{
    public function generate(Request $request)
    {
        // OpenAI のアカウントを作成 ( https://beta.openai.com/signup )
        // API Key を取得 ( https://beta.openai.com/account/api-keys )
        $text = $request['text'];

        $timestamp = date('Ymd').substr(explode(".", microtime(true))[1], 0, 3);
        
        // セッション引き継ぎ
        $chats = $request->session()->get('chats', array());
        
        $chats[$timestamp]['id'] = $timestamp;
        $chats[$timestamp]['question'] = $text;
        
        $request->session()->put('chats', $chats);

        $API_KEY = env('CHAT_GPT_API_KEY');

        $header = array(
        'Authorization: Bearer '.$API_KEY,
        'Content-type: application/json',
        );

        $params = json_encode(array(
        'prompt' => $text,
        'model' => 'text-davinci-003',
        'temperature' => 0.5,
        'max_tokens' => 4000,
        'top_p' => 1.0,
        'frequency_penalty' => 0.8,
        'presence_penalty' => 0.0
        ));


        $curl = curl_init('https://api.openai.com/v1/completions');
        $options = array(
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER =>$header,
        CURLOPT_POSTFIELDS => $params,
        CURLOPT_RETURNTRANSFER => true,
        );
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);

        $httpcode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);

        $generatedText = '';

        if (200 == $httpcode) {
            $json_array = json_decode($response, true);
            $choices = $json_array['choices'];
            foreach ($choices as $v) {
                $generatedText.= nl2br($v['text']);
            }
        }

        $chats[$timestamp]['answer'] = $generatedText;
        $request->session()->put('chats', $chats);
        return ['text' => $generatedText];
    }

    public function getAll(Request $request)
    {
        $chats = $request->session()->get('chats', array());
        return ['chats' => $chats];
    }

}