<?php
namespace App\Controllers;

class TestLogin extends BaseController
{
    public function test()
    {
        $ionAuth = new \App\Libraries\IonAuth();
        
        // Try logging in with the default credentials
        $identity = 'administrator';
        $password = 'password';
        
        echo "Attempting login with:\n";
        echo "Identity: " . $identity . "\n";
        echo "Password: " . $password . "\n\n";
        
        $result = $ionAuth->login($identity, $password);
        
        if ($result) {
            echo "✓ Login successful!\n";
            echo "User: " . $ionAuth->user()->row()->username . "\n";
        } else {
            echo "✗ Login failed\n";
            echo "Errors:\n";
            foreach ($ionAuth->errors() as $error) {
                echo "  - " . $error . "\n";
            }
        }
    }
    
    public function create_test_user()
    {
        $ionAuth = new \App\Libraries\IonAuth();
        
        $testPassword = 'testpass123';
        
        $userData = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => $testPassword,
            'first_name' => 'Test',
            'last_name' => 'User',
        ];
        
        $result = $ionAuth->register($userData['username'], $userData['password'], $userData['email'], [
            'first_name' => $userData['first_name'],
            'last_name' => $userData['last_name'],
        ]);
        
        if ($result) {
            echo "✓ Test user created successfully!\n";
            echo "Username: testuser\n";
            echo "Password: " . $testPassword . "\n";
            echo "Email: test@example.com\n";
        } else {
            echo "✗ Failed to create test user\n";
            echo "Errors:\n";
            foreach ($ionAuth->errors() as $error) {
                echo "  - " . $error . "\n";
            }
        }
    }
}
