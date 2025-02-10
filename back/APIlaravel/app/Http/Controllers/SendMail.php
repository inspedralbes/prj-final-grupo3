<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SendMail extends Controller
{
//     public function sendEmail(Request $request)
//     {
//         // Validar les dades rebudes
//         $validatedData = $request->validate([
//             'subject' => 'required|string',
//             'message' => 'required|string',
//             'to' => 'required|array',
//             'to.*' => 'required|email', // Cada element hi ha que se valid 
//         ]);
 
//         // Configurar PHPMailer
//         $mail = new PHPMailer(true);
 
//         try {
//             // Configuració del servidor SMTP
//             $mail->isSMTP();
//             $mail->CharSet = 'UTF-8';
//             $mail->Host = env("MAIL_HOST");
//             $mail->SMTPAuth = true;
//             $mail->Username = env("MAIL_USERNAME");
//             $mail->Password = env("MAIL_PASSWORD");
//             $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//             $mail->Port = 587;
 
//             $mail->SMTPOptions = [
//                 'ssl' => [
//                     'verify_peer' => false,
//                     'verify_peer_name' => false,
//                     'allow_self_signed' => true
//                 ]
//             ];
 
//             // Remitent
//             $mail->setFrom('triplan25@gmail.com', 'TriPlan');
 
//             // Afegir el destinatari principal (es pot deixar buit si no hi ha principal)
//             $mail->addAddress('triplan25@gmail.com'); // Este puede ser tu dirección de control
 
//             // Afegir cada destinatari com BCC (còpia oculta)
//             foreach ($validatedData['to'] as $recipient) {
//                 $mail->addBCC($recipient);
//             }
 
//             // En cas de tindre una vista (blade) la renderitzarem perquè l'usuari el vegi la informació
//             // en el correu
 
//             $htmlContent = View::make('email', [
//                 'subject' => $validatedData['subject'],
//                 'message' => $validatedData['message'],
//             ])->render();
 
//             // Contingut del correu
//             $mail->isHTML(true);
//             $mail->Subject = $validatedData['subject'];
//             $mail->Body = $htmlContent;
 
//             // Enviar el correu
//             $mail->send();
 
//             return response()->json([
//                 'message' => 'Email sent successfully'
//             ]);
 
//         } catch (Exception $e) {
//             return response()->json([
//                 'error' => "Error sending email: {$mail->ErrorInfo}"
//             ], 500);
//         }
//     }
// }
public function sendEmail(Request $request)
{
    // Validar los datos recibidos
    $validatedData = $request->validate([
        'subject' => 'required|string',
        'message' => 'required|string',
        'to' => 'required|array',
        'to.*' => 'required|email', // Cada elemento debe ser una dirección de correo válida
        'user' => 'nullable|array', // Opcional: Datos del usuario
        'user.name' => 'nullable|string',
        'user.surname' => 'nullable|string',
    ]);

    // Configurar PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = env("MAIL_HOST");
        $mail->SMTPAuth = true;
        $mail->Username = env("MAIL_USERNAME");
        $mail->Password = env("MAIL_PASSWORD");
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];

        // Remitente
        $mail->setFrom('triplan25@gmail.com', 'TriPlan');

        // Agregar el destinatario principal (puede dejarse vacío si no hay principal)
        $mail->addAddress('triplan25@gmail.com'); // Puede ser tu dirección de control

        // Agregar cada destinatario como BCC (copia oculta)
        foreach ($validatedData['to'] as $recipient) {
            $mail->addBCC($recipient);
        }

        // Renderizar la vista del correo con los datos del usuario
        $htmlContent = View::make('email', [
            'subject' => $validatedData['subject'],
            'message' => $validatedData['message'],
            'user' => $validatedData['user'] ?? null, // Pasar los datos del usuario
        ])->render();

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $validatedData['subject'];
        $mail->Body = $htmlContent;

        // Enviar el correo
        $mail->send();

        return response()->json([
            'message' => 'Email sent successfully'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => "Error sending email: {$mail->ErrorInfo}"
        ], 500);
    }
}
}