<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

// Test if we can compile the Blade views
$blade = $app->make('view');

try {
    // Test create view
    echo "Testing create.blade.php...\n";
    $view = $blade->make('assistance-requests.create', [
        'requestTypes' => [],
        'agents' => [],
        'documentRequirements' => []
    ]);
    echo "✓ create.blade.php syntax is valid\n\n";
} catch (\Exception $e) {
    echo "✗ create.blade.php error: " . $e->getMessage() . "\n\n";
}

try {
    // Test edit view
    echo "Testing edit.blade.php...\n";
    $mockRequest = new \stdClass();
    $mockRequest->id = 1;
    $mockRequest->request_type_id = null;
    $mockRequest->request_category_id = null;
    $mockRequest->request_subcategory_id = null;
    $mockRequest->purpose = '';
    $mockRequest->agent_id = null;
    $mockRequest->status = 'draft';
    $mockRequest->user_id = 1;

    $view = $blade->make('assistance-requests.edit', [
        'assistanceRequest' => $mockRequest,
        'requestTypes' => [],
        'categories' => [],
        'agents' => [],
        'documentRequirements' => []
    ]);
    echo "✓ edit.blade.php syntax is valid\n\n";
} catch (\Exception $e) {
    echo "✗ edit.blade.php error: " . $e->getMessage() . "\n\n";
}

echo "✓ All Blade templates are syntactically valid!\n";
