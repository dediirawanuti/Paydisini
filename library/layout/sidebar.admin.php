<?php
li('Back','feather icon-home warning','/');
li('Home','feather icon-umbrella warning','/admin/');
ul([
    'name' => 'Users',
    'icon' => 'feather icon-user',
    'content' => [
        ['name' => 'Manage Users','page' => '/admin/users/manage'],
        ['name' => 'Locked Users','page' => '/admin/users/locked'],
        ['name' => 'Activity Logs','page' => '/admin/users/activity'],
        ['name' => 'Balance Mutation','page' => '/admin/users/mutation'],
        ['name' => 'Transfer History','page' => '/admin/users/transfer'],
    ]
]);
ulhead('');
li('Provider','feather icon-cpu','/admin/provider/');
ul([
    'name' => 'Social Media',
    'icon' => 'feather icon-cloud',
    'content' => [
        ['name' => 'Transaction','page' => '/admin/social-media/transaction'],
        ['name' => 'Category','page' => '/admin/social-media/category'],
        ['name' => 'Service','page' => '/admin/social-media/service'],
        ['name' => 'Report','page' => '/admin/social-media/report'],
        ['name' => 'Point','page' => '/admin/social-media/point'],
    ]
]);
ul([
    'name' => 'Reports',
    'icon' => 'feather icon-file-text',
    'content' => [
        ['name' => 'Sales','page' => '/admin/report/sales'],
        ['name' => 'Profit','page' => '/admin/report/profit'],
        ['name' => 'Deposit','page' => '/admin/report/deposit'],
        ['name' => 'Summary','page' => '/admin/report/summary'],
    ]
]);
ulhead('');
ul([
    'name' => 'Deposit',
    'icon' => 'feather icon-credit-card',
    'content' => [
        ['name' => 'Manage','page' => '/admin/deposit/manage'],
        ['name' => 'Voucher','page' => '/admin/deposit/voucher'],
        ['name' => 'Method','page' => '/admin/deposit/method'],
    ]
]);
ul([
    'name' => 'Configuration',
    'icon' => 'feather icon-settings',
    'content' => [
        ['name' => 'Website','page' => '/admin/config/website'],
        ['name' => 'SMTP Mailer','page' => '/admin/config/smtp'],
        ['name' => 'Social Media','page' => '/admin/config/social'],
        ['name' => 'Hold Balance','page' => '/admin/config/hold'],
        ['name' => 'Web Pages','page' => '/admin/config/pages'],
        ['name' => 'Others','page' => '/admin/config/others'],
    ]
]);
ul([
    'name' => 'Server',
    'icon' => 'feather icon-box',
    'content' => [
        ['name' => 'Error Log','page' => '/admin/server/error-log'],
    ]
]);
ul([
    'name' => 'Others',
    'icon' => 'feather icon-list',
    'content' => [
        ['name' => 'News & Info','page' => '/admin/others/news/'],
        ['name' => 'General Quest','page' => '/admin/others/faq/'],
    ]
]);
?>