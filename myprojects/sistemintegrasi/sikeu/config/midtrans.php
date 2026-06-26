<?php
return [
// Server Key dari Dashboard Midtrans
'serverKey' => env('MIDTRANS_SERVER_KEY'),
// Client Key dari Dashboard Midtrans
'clientKey' => env('MIDTRANS_CLIENT_KEY'),
// Set ke true jika sudah Production, false jika masih Sandbox/Testing
'isProduction' => env('MIDTRANS_IS_PRODUCTION',
false),
// Sanitization otomatis dari Midtrans (Sangat disarankan true)
'isSanitized' => env('MIDTRANS_IS_SANITIZED', true),
// Fitur 3DS untuk keamanan kartu kredit (Sangat disarankan true)
'is3ds' => env('MIDTRANS_IS_3DS', true),
];