<?php
// Demo account credentials
$accounts = [
    [
        'email' => 'admin@hiking.com',
        'password' => 'admin123',
        'username' => 'Admin',
        'role' => 'admin'
    ],
    [
        'email' => 'user@hiking.com',
        'password' => 'user123',
        'username' => 'user',
        'role' => 'author'
    ]
];

foreach ($accounts as $account) {
    // Generate hash using bcrypt algorithm (PASSWORD_DEFAULT)
    $hashed_password = password_hash($account['password'], PASSWORD_DEFAULT);
    
    echo "Account: {$account['username']} ({$account['role']})\n\n";
    echo "  Email: {$account['email']}\n\n";
    echo "  Plain Password: {$account['password']}\n\n";
    echo "  Hashed Password: {$hashed_password}\n\n";
    echo "\n\n";
    echo "------------------------------------------\n\n\n";
}

echo "==========================================\n\n";
echo "VERIFICATION TEST\n\n";
echo "==========================================\n\n\n";

// Verify that password_verify() works with generated hashes
foreach ($accounts as $account) {
    $hashed_password = password_hash($account['password'], PASSWORD_DEFAULT);
    $verification_result = password_verify($account['password'], $hashed_password);
    
    echo "Testing {$account['username']}: ";
    echo $verification_result ? "PASS - password_verify() successful\n\n" : "FAIL\n\n";
}

echo "\n==========================================\n\n";
echo "NOTES\n\n";
echo "==========================================\n\n";
echo "• Each hash is unique even for the same password (due to random salt)\n\n";
echo "• Hashes start with \$2y\$10\$ indicating bcrypt algorithm and cost factor\n\n";
echo "• The hashes in schema.sql were generated using this script\n\n";
echo "==========================================\n\n";
?>
