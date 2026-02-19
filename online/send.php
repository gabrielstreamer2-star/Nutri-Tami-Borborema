<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // PHPMailer via Composer

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = strip_tags(trim($_POST['nome']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $mensagem = trim($_POST['mensagem']);

    if (empty($nome) || empty($mensagem) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Preencha todos os campos corretamente!";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Config SMTP usando SEU Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'gabrielstreamer2@gmail.com';       // seu Gmail
        $mail->Password = 'qesm uxjm udro ihen';         // senha de app
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Configurações do e-mail
        $mail->setFrom('gabrielstreamer2@gmail.com', 'Site Nutri Tamiris'); // quem envia
        $mail->addReplyTo($email, $nome);                             // e-mail do cliente
        $mail->addAddress('tamiinascimento@hotmail.com');             // e-mail da sua mãe

        $mail->Subject = "Mensagem de $nome ($email)";
        $mail->Body    = "Nome: $nome\nE-mail: $email\n\nMensagem:\n$mensagem";

        $mail->send();
        http_response_code(200);
        echo "Mensagem enviada com sucesso para tamiris!";
    } catch (Exception $e) {
        http_response_code(500);
        echo "Erro ao enviar: " . $mail->ErrorInfo;
    }
} else {
    http_response_code(403);
    echo "Método inválido.";
}
