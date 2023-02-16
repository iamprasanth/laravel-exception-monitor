<?php

return [
    /**
     * Configure the ErrorEmail service
     *
     * - enable_email (true/false) - If true then mail will sent when an exception occures
     *
     * - toEmailAddress (string|array) - The email address(es) to send these error emails to,
     *   typically
     * 
     * - toBccEmailAddress (string|array) - The email address(es) to send bcc of error emails
     *
     * - fromEmailAddress (string) - The email address these emails should be sent from
     *
     * - emailSubject (string) - The subject of email
     *
     */
    'ErrorEmail' => [
        'enable_email' => false,
        'toEmailAddress' => ['error@mailinator.com'],
        'toBccEmailAddress' => [],
        'fromEmailAddress' => "report@mailinator.com",
        'emailSubject' => 'Exception occured in - '.config('app.name')
    ],

    /**
    *
    * use mydomain.com/log_dashboard_url to view logs
    *
    */

    'log_dashboard_url' => 'exception-monitor'
];
