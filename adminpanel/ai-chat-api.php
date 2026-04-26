<?php
session_start();
if(!isset($_SESSION['admin_id'])){
  header("Location: login.php");
  exit();
}
header("Content-Type: application/json");
include "config/gemini_key.php";

$data = json_decode(file_get_contents("php://input"), true);
$message = $data['message'] ?? "";

if($message==""){
  echo json_encode(["reply"=>"Please type something"]);
  exit;
}

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=".GEMINI_API_KEY;

$postData = [
  "contents" => [
    [
      "parts" => [
        ["text" => "You are a shopping assistant for MenHub Prime website. Answer politely.\nUser: ".$message]
      ]
    ]
  ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if(curl_errno($ch)){
  echo json_encode(["reply"=>"API error"]);
  exit;
}

curl_close($ch);

$res = json_decode($response,true);
$reply = $res['candidates'][0]['content']['parts'][0]['text'] ?? "No response";

echo json_encode(["reply"=>$reply]);