<?php

$botToken = 'bot_token';
$chatId = 'group_id'; //telegram group
$apiUrl = "https://api.telegram.org/bot{$botToken}/sendMessage";

$users = json_decode(file_get_contents('users.json'), true);

$currentDate = date('Y-m-d');


foreach ($users as $user) {
    $name = $user['name'];
    $birthdate = $user['birthdate'];

    if (substr($birthdate, 5) === substr($currentDate, 5)) {
        $message = "Herzlichen Glückwunsch, {$name}! Alles Gute zum Geburtstag!";

        $data = [
            'chat_id' => $chatId,
            'text' => $message
        ];

        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($data)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($apiUrl, false, $context);

        if ($result === false) {
            echo "Fehler beim Senden der Glückwunsch-Nachricht an {$name}.";
        } else {
            echo "Glückwunsch-Nachricht erfolgreich an {$name} gesendet!";
        }
    }
}