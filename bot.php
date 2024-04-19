<?php
// Reemplaza 'TOKEN_DEL_BOT' con el token de acceso de tu bot
define('BOT_TOKEN', '5926566701:AAFMer3PXhi1XqVGlgI0BM8WDWjhRpwvfyc');


function enviarMensaje($chatID, $mensaje) {
    $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendMessage";
    $params = [
        'chat_id' => $chatID,
        'text' => $mensaje
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

// caca peluda
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
            break;
        }
    }
    if (!$encontrado) {
        enviarMensaje($chatID, "Lo siento, no encontré el producto \"$text\" en ningún pasillo.");
    }
}
