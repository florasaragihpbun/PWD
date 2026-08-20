<?php
const DATA_FILE = __DIR__ . "/../data/participants.txt";

function showMessage(string $title, string $message, bool $success = false): void
{
	$safeTitle = htmlspecialchars($title, ENT_QUOTES, "UTF-8");
	$safeMessage = htmlspecialchars($message, ENT_QUOTES, "UTF-8");
	$statusClass = $success ? "success" : "error";

	echo "<!DOCTYPE html>\n";
	echo "<html lang=\"id\">\n<head>\n";
	echo "<meta charset=\"UTF-8\" />\n";
	echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />\n";
	echo "<title>Hasil Pendaftaran</title>\n";
	echo "<style>.message { max-width: 600px; margin: 40px auto; padding: 20px; font-family: Arial, sans-serif; border: 1px solid #ccc; } .success { color: #176b36; } .error { color: #a32626; }</style>\n";
	echo "</head>\n<body>\n";
	echo "<main class=\"message {$statusClass}\">\n";
	echo "<h1>{$safeTitle}</h1>\n<p>{$safeMessage}</p>\n";
	echo "<a href=\"../registration.xhtml\">Kembali ke formulir pendaftaran</a>\n";
	echo "</main>\n</body>\n</html>";
	exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
	showMessage("Permintaan tidak valid", "Formulir harus dikirim menggunakan metode POST.");
}

$name = trim($_POST["name"] ?? "");
$email = strtolower(trim($_POST["email"] ?? ""));
$phone = trim($_POST["phone"] ?? "");
$institution = trim($_POST["institution"] ?? "");
$date = date("Y-m-d H:i:s");

function makeID() {
	$prefix = "UAJY";
	$timestamp = time();
	$randomNumber = rand(1000, 9999);
	return "{$prefix}-{$timestamp}-{$randomNumber}";
}

if ($name === "" || $email === "" || $phone === "" || $institution === "") {
	showMessage("Pendaftaran gagal", "Semua field wajib diisi.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	showMessage("Pendaftaran gagal", "Format email tidak valid.");
}

if (!preg_match("/^\d{10,15}$/", $phone)) {
	showMessage("Pendaftaran gagal", "Nomor telepon harus terdiri dari 10 sampai 15 digit.");
}

if (!file_exists(DATA_FILE) && !touch(DATA_FILE)) {
	showMessage("Pendaftaran gagal", "File data peserta tidak dapat dibuat.");
}

$participants = file(DATA_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($participants as $participant) {
	$fields = array_map("trim", explode("|", $participant));
	$savedEmail = strtolower($fields[2] ?? $fields[1] ?? "");

	if ($savedEmail === $email) {
		showMessage("Pendaftaran gagal", "Email tersebut sudah terdaftar.");
	}
}

$safeValues = array_map(
	static function (string $value): string {
		return str_replace(["|", "\r", "\n"], " ", $value);
	},
	[makeID(), $name, $email, $phone, $institution, $date]
);

$record = implode(" | ", $safeValues) . PHP_EOL;
if (file_put_contents(DATA_FILE, $record, FILE_APPEND | LOCK_EX) === false) {
	showMessage("Pendaftaran gagal", "Data peserta tidak dapat disimpan.");
}

showMessage("Pendaftaran berhasil", "Data Anda telah berhasil disimpan.", true);
