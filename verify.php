<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?error=metodo');
    exit;
}

$recaptcha_secret = getenv('RECAPTCHA_SECRET') ?: '6Lfh780rAAAAAHPQ7fMqYol-n34-hXVtLtOBJslA';

$recaptcha_response = $_POST['g-recaptcha-response'] ?? '';

if (empty($recaptcha_response)) {
    header('Location: index.php?error=recaptcha_missing');
    exit;
}

$verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
$data = [
    'secret'   => $recaptcha_secret,
    'response' => $recaptcha_response,
    'remoteip' => $_SERVER['REMOTE_ADDR']
];


$ch = curl_init($verifyUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$verification = json_decode($response, true);


if (isset($verification['success']) && $verification['success'] === true) {
    $_SESSION['nome'] = $_POST['nome'];
    header('Location: adm.php');
    exit;
} else {
    header('Location: form.php?error=recaptcha_failed');
    exit;
}