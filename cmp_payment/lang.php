<?php

$language = "spanish"; // Change this according to the desired language ("spanish" or "english")

$email = "contacto@example.com"; // Change this with your contact email

if ($language == "spanish") {
    #Spanish
    $consentText = "Aceptar consentimientos y no pagar nada.";
    $notCompletedPaymentText = "No has completado el pago, por lo que necesitarás aceptar el consentimiento o volver a intentarlo.";
    $successfulPurchaseText = "Compra realizada con éxito";
    $completedPurchaseText = "Has completado con éxito la compra.";
    $validCodeText = "Tu código válido por 1 año es: ";
    $importantSaveCodeText = "Es importante que guardes el código ya que si navegas desde otro ordenador o pierdes tus datos podrás recuperar la compra.";
    $payWithText = "Paga 50€ y navega sin aceptar el consentimiento en este sitio durante 1 año.";
    $tokenInputPlaceholder = "Introduce tu token aquí";
    $submitTokenButtonText = "Enviar token";
    $tokenValidation = "Validación de token";
    $codeValidated = "Tu código se ha validado.";
    $canNavigate = "Puedes navegar sin aceptar el consentimiento.";
    $codeNotValid = "Tu código no es válido.";
    $waitCode = "Si acabas de comprar tu código refresca la página en 1 minuto y vuelve a introducirlo.";
    $needAccept = "Para navegar por este sitio necesitas aceptar el consentimiento o pagar un módico precio. Si has pagado y crees que es un error contáctanos en ".$email;
    $browseFree = "Navega gratis";
    $browseWithoutAccept = "Navega sin aceptar.";
    $oneYear = "Quitar consentimientos 1 año";
    $haveCode = "Si ya tienes un código introducelo a continuación para validarlo.";
} else {
    #English
    $consentText = "Accept consents and pay nothing.";
    $notCompletedPaymentText = "You have not completed the payment, so you will need to accept the consent or try again.";
    $successfulPurchaseText = "Purchase successful";
    $completedPurchaseText = "You have successfully completed the purchase.";
    $validCodeText = "Your valid code for 1 year is: ";
    $importantSaveCodeText = "It is important that you save the code as if you browse from another computer or lose your data, you will be able to recover the purchase.";
    $payWithText = "Pay €50 and browse without accepting consent on this site for 1 year.";
    $tokenInputPlaceholder = "Enter your token here";
    $submitTokenButtonText = "Submit token";
    $tokenValidation = "Token validation";
    $codeValidated = "Your code has been validated.";
    $canNavigate = "You can navigate without accepting the consent.";
    $codeNotValid = "Your code is not valid.";
    $waitCode = "If you've just purchased your code, refresh the page in 1 minute and enter it again.";
    $needAccept = "To browse this site, you need to accept the consent or pay a small fee. If you have paid and believe it's an error, contact us at ".$email;
    $browseFree = "Browse for free";
    $browseWithoutAccept = "Browse without accepting.";
    $oneYear = "Remove consents 1 year";
    $haveCode = "If you already have a code, enter it below to validate.";
}