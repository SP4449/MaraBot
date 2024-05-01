<?php
// Token de tu bot proporcionado por BotFather
$botToken = 'TU_TOKEN_DEL_BOT';  // Reemplaza 'TU_TOKEN_DEL_BOT' con el token real de tu bot

// Función para enviar mensajes al chat
function enviarMensaje($chatID, $mensaje) {
    $apiToken = 'TU_TOKEN_DEL_BOT'; // Reemplaza 'TU_TOKEN_DEL_BOT' con tu token
    $apiUrl = 'https://api.telegram.org/bot' . $apiToken . '/sendMessage';
    $params = [
        'chat_id' => $chatID,
        'text' => $mensaje
    ];
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

// Recibir la solicitud POST de Telegram
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
    exit;
}

// Extraer el chat ID y el mensaje del usuario
$message = isset($update['message']) ? $update['message'] : "";
$chatID = isset($message['chat']['id']) ? $message['chat']['id'] : "";
$text = isset($message['text']) ? $message['text'] : "";

// Definir los pasillos y sus productos
$pasillos = [
    1 => ["Carne", "Queso", "Jamón"],
    2 => ["Leche", "Yogurth", "Cereal"],
    3 => ["Bebidas", "Jugos"],
    4 => ["Pan", "Pasteles", "Tortas"],
    5 => ["Detergente", "Lavaloza"]
];

// Procesar el mensaje recibido
if ($text == "/start" || $text == "/help") {
    // Mensaje de bienvenida o ayuda
    enviarMensaje($chatID, "Hola! Puedes preguntarme en qué pasillo encontrarás un producto del supermercado.");
} elseif ($text == "/pasillos") {
    // Listar los pasillos y sus productos
    $mensaje = "Pasillos del supermercado:\n";
    foreach ($pasillos as $pasillo => $productos) {
        $mensaje .= "Pasillo $pasillo: " . implode(", ", $productos) . "\n";
    }
    enviarMensaje($chatID, $mensaje);
} else {
    // Buscar el producto en los pasillos
    $encontrado = false;
    foreach ($pasillos as $pasillo => $productos) {
        if (in_array($text, $productos)) {
            enviarMensaje($chatID, "El producto \"$text\" se encuentra en el Pasillo $pasillo.");
            $encontrado = true;
         
