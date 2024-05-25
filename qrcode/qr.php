<?php
require '../vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

// Data to be encoded in the QR code
$data = 'https://www.google.com';

// Set QR code options
$options = new QROptions([
    'eccLevel' => QRCode::ECC_L,    // Error correction level
    'outputType' => QRCode::OUTPUT_IMAGE_PNG, // Output type
    'imageBase64' => false,         // Output as base64
]);

// Create a new QRCode instance
$qrcode = new QRCode($options);

// Generate the QR code image
$image = $qrcode->render($data);

// Save the image to a file
file_put_contents('qrcode.png', $image);

// Output the image directly to the browser
header('Content-Type: image/png');
echo $image;
