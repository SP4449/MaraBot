<?php
// Token de tu bot proporcionado por BotFather
$botToken = '5926566701:AAFMer3PXhi1XqVGlgI0BM8WDWjhRpwvfyc';  // Reemplaza 'tu_token_de_bot' con el token real de tu bot

// URL de GitHub del archivo bot.php
$webhookURL = 'https://sp4449.github.io/MaraBot/';  // Reemplaza 'tu-usuario' y 'tu-repositorio' con tu nombre de usuario y nombre del repositorio en GitHub

// Construye la URL de la API de Telegram para configurar el webhook
$apiURL = 'https://api.telegram.org/bot' . $botToken . '/setWebhook?url=' . urlencode($webhookURL);

// Realiza la solicitud para configurar el webhook
$response = file_get_contents($apiURL);

// Verifica la respuesta y muestra un mensaje adecuado
if ($response === false) {
    echo 'Error al configurar el webhook';
} else {
    echo 'Webhook configurado correctamente';
}
?>


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
    // Recibir la solicitud POST de Telegram
$update = json_decode(file_get_contents('php://input'), true);

// Obtener el mensaje del usuario
$message = $update['message']['text'];

// Definir las respuestas según el mensaje
$answers = [
    'Carne' => 'Puedes encontrar la carne en el Pasillo 1.',
    'Queso' => 'El queso está en el Pasillo 1.',
    'Jamón' => 'Ve al Pasillo 1 para encontrar el jamón.',
    'Leche' => 'La leche se encuentra en el Pasillo 2.',
    'Yogurth' => 'Dirígete al Pasillo 2 para encontrar yogurth.',
    'Cereal' => 'En el Pasillo 2 están los cereales.',
    'Bebidas' => 'Las bebidas están en el Pasillo 3.',
    'Jugos' => 'Puedes encontrar jugos en el Pasillo 3.',
    'Pan' => 'El pan está en el Pasillo 4.',
    'Pasteles' => 'Los pasteles están en el Pasillo 4.',
    'Tortas' => 'En el Pasillo 4 están las tortas.',
    'Detergente' => 'El detergente se encuentra en el Pasillo 5.',
    'Lavaloza' => 'Dirígete al Pasillo 5 para encontrar lavaloza.',
];

// Verificar si el mensaje coincide con alguna respuesta
$response = isset($answers[$message]) ? $answers[$message] : 'Lo siento, no entiendo la pregunta.';

// Enviar la respuesta al usuario
$responseData = [
    'chat_id' => $update['message']['chat']['id'],
    'text' => $response,
];

// Enviar la respuesta de vuelta a Telegram
$apiToken = 'TU_TOKEN_DEL_BOT'; // Reemplaza con tu token
$apiUrl = 'https://api.telegram.org/bot' . $apiToken . '/sendMessage';
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $responseData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$result = curl_exec($ch);
curl_close($ch);

    }
}

}
