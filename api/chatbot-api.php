<?php
header("Content-Type: application/json");

// Professional Handler - Uses unified bootstrap for context
require_once __DIR__ . '/../src/bootstrap.php';

$data = json_decode(file_get_contents("php://input"), true);
$userMessage = $data['message'] ?? "";

if($userMessage==""){
  echo json_encode(["reply"=>"Please type something"]);
  exit;
}

// AI Key from dynamic settings or config
$apiKey = $sys['gemini_api_key'] ?? "AIzaSyDxnw6bSgncPlgi-9jZ_T3yi-Uh8JEHGU0";

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=".$apiKey;

$postData = [
  "contents" => [
    [
      "parts" => [
        ["text" => "You are a helpful shopping assistant for MenHub Prime website. User says: ".$userMessage]
      ]
    ]
  ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

$response = curl_exec($ch);

if(curl_errno($ch)){
  echo json_encode(["reply"=>"API connection error"]);
  exit;
}

curl_close($ch);

$res = json_decode($response, true);

$reply = $res['candidates'][0]['content']['parts'][0]['text'] ?? "No reply from AI";

echo json_encode(["reply"=>$reply]);
