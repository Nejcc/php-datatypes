<?php

declare(strict_types=1);

include_once __DIR__ . '/../vendor/autoload.php';

use Nejcc\PhpDatatypes\Enums\Http\HttpStatusCode;

$response = HttpStatusCode::OK->buildResponse(
    data: ['user' => 'Lord Nejc'],
    headers: ['Content-Type' => 'application/json']
);
echo "<pre>";
print_r($response);
echo "</pre>";
/* Output:
Array
(
    [status] => 200
    [message] => OK
    [data] => Array
        (
            [user] => Lord Nejc
        )
    [headers] => Array
        (
            [Content-Type] => application/json
        )
)
*/

echo "<pre>";
$successCodes = HttpStatusCode::getSuccessCodes();
foreach ($successCodes as $code) {
    echo "{$code->value} - {$code->getMessage()}\n";
}
echo "</pre>";



$status = HttpStatusCode::NOT_FOUND;
echo $status->getSuggestion(); // Output: "Verify the URL or resource identifier."
