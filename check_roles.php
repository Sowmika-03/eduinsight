<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Check roles
$roles = \App\Models\Role::all();
echo "=== Available Roles ===\n";
foreach($roles as $role) {
    echo "ID: {$role->id}, Name: {$role->name}\n";
}
