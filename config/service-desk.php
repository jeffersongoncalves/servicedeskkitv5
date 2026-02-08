<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | Define the models used by the service desk system. The user model is the
    | model that creates tickets, while the operator model is the model
    | that handles and manages tickets.
    |
    */

    'models' => [
        'user' => \App\Models\User::class,
        'operator' => \App\Models\Operator::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Ticket Settings
    |--------------------------------------------------------------------------
    */

    'ticket' => [
        'reference_prefix' => 'SD',
        'default_status' => 'open',
        'default_priority' => 'medium',
        'allowed_extensions' => [
            'jpg', 'jpeg', 'png', 'gif', 'pdf',
            'doc', 'docx', 'xls', 'xlsx', 'csv',
            'txt', 'zip',
        ],
        'max_file_size' => 10240, // KB
        'max_attachments_per_comment' => 5,
        'attachment_disk' => env('SERVICE_DESK_ATTACHMENT_DISK', 'local'),
        'attachment_path' => 'service-desk/attachments',
        'auto_close_days' => null,
        'allow_reopen' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | SLA Settings
    |--------------------------------------------------------------------------
    */

    'sla' => [
        'enabled' => true,
        'auto_apply' => true,
        'near_breach_minutes' => 30,
        'pause_on_statuses' => ['on_hold'],
        'default_business_hours_schedule' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Knowledge Base Settings
    |--------------------------------------------------------------------------
    */

    'knowledge_base' => [
        'enabled' => true,
        'default_visibility' => 'public',
        'versioning_enabled' => true,
        'feedback_enabled' => true,
        'track_views' => true,
        'search_engine' => 'database',
    ],

    /*
    |--------------------------------------------------------------------------
    | Service Catalog Settings
    |--------------------------------------------------------------------------
    */

    'service_catalog' => [
        'enabled' => true,
        'default_visibility' => 'public',
        'auto_create_ticket' => true,
        'approval_enabled' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Settings
    |--------------------------------------------------------------------------
    */

    'email' => [
        'enabled' => env('SERVICE_DESK_EMAIL_ENABLED', true),

        'from' => [
            'address' => env('SERVICE_DESK_FROM_ADDRESS', env('MAIL_FROM_ADDRESS')),
            'name' => env('SERVICE_DESK_FROM_NAME', env('MAIL_FROM_NAME')),
        ],

        'subject_prefix' => '[Service Desk #:reference]',
        'threading_enabled' => true,

        'inbound' => [
            'driver' => env('SERVICE_DESK_INBOUND_DRIVER', null),

            'imap' => [
                'host' => env('SERVICE_DESK_IMAP_HOST'),
                'port' => env('SERVICE_DESK_IMAP_PORT', 993),
                'encryption' => env('SERVICE_DESK_IMAP_ENCRYPTION', 'ssl'),
                'validate_cert' => env('SERVICE_DESK_IMAP_VALIDATE_CERT', true),
                'username' => env('SERVICE_DESK_IMAP_USERNAME'),
                'password' => env('SERVICE_DESK_IMAP_PASSWORD'),
                'folder' => env('SERVICE_DESK_IMAP_FOLDER', 'INBOX'),
                'mark_as_read' => true,
                'move_processed_to' => null,
                'poll_interval' => 5,
            ],

            'mailgun' => [
                'signing_key' => env('SERVICE_DESK_MAILGUN_SIGNING_KEY'),
            ],

            'sendgrid' => [
                'webhook_username' => env('SERVICE_DESK_SENDGRID_WEBHOOK_USERNAME'),
                'webhook_password' => env('SERVICE_DESK_SENDGRID_WEBHOOK_PASSWORD'),
            ],

            'resend' => [
                'api_key' => env('SERVICE_DESK_RESEND_API_KEY', env('RESEND_API_KEY')),
                'webhook_secret' => env('SERVICE_DESK_RESEND_WEBHOOK_SECRET'),
            ],

            'postmark' => [
                'webhook_username' => env('SERVICE_DESK_POSTMARK_WEBHOOK_USERNAME'),
                'webhook_password' => env('SERVICE_DESK_POSTMARK_WEBHOOK_PASSWORD'),
            ],

            'store_raw_payload' => env('SERVICE_DESK_STORE_RAW_PAYLOAD', false),
            'retention_days' => 30,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Webhook Settings
    |--------------------------------------------------------------------------
    */

    'webhooks' => [
        'prefix' => 'service-desk/webhooks',
        'middleware' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    */

    'notifications' => [
        'channels' => ['mail'],

        'notify_on' => [
            'ticket_created' => true,
            'ticket_assigned' => true,
            'ticket_status_changed' => true,
            'comment_added' => true,
            'ticket_closed' => true,
            'sla_breached' => true,
            'sla_near_breach' => true,
            'escalation' => true,
            'approval_requested' => true,
            'approval_decision' => true,
        ],

        'queue' => env('SERVICE_DESK_NOTIFICATION_QUEUE', 'default'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Register Default Listeners
    |--------------------------------------------------------------------------
    |
    | When enabled, the package will automatically register its default
    | event listeners for notifications and history logging.
    |
    */

    'register_default_listeners' => true,

];
