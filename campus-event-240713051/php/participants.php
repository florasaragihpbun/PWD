<?php
header("Content-Type: application/json; charset=UTF-8");

$file = "../data/participants.txt";
$email = trim($_GET["email"] ?? "");

$response = [
    "success" => true,
    "exists" => false,
    "total_participants" => 0
];

if (!file_exists($file)) {
    $response["success"] = false;
    $response["message"] = "File data peserta tidak ditemukan.";
    echo json_encode($response);
    exit;
}

$participants = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$response["total_participants"] = count($participants);

if ($email !== "") {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["success"] = false;
        $response["message"] = "Format email tidak valid.";
        echo json_encode($response);
        exit;
    }

    foreach ($participants as $participant) {
        $fields = array_map("trim", explode("|", $participant));
        $emailIndex = count($fields) >= 6 ? 2 : 1;
        $savedEmail = strtolower($fields[$emailIndex] ?? "");

        if ($savedEmail === strtolower($email)) {
            $response["exists"] = true;
            break;
        }
    }
}

echo json_encode($response);