<?php

namespace Spt\ExceptionHandling\Exceptions;

use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\DB;
use Mail;
use Exception;

class EmailHandler extends ExceptionHandler
{
    public function report(Exception $exception)
    {
        // Check whether the exception is not excluded from reporting
        if ($this->shouldReport($exception)) {
            // check if we should mail this exception
            if (config('sptexception.ErrorEmail.enable_email') == true) {
                // if we passed our validation lets mail the exception
                $this->mailException($exception);
            }
            // run the parent report (logs exception and all that good stuff)
            $this->callParentReport($exception);
        }
    }

    protected function callParentReport(Exception $exception)
    {
        parent::report($exception);
    }

    /**
    * For sending the exception via email
    *
    * @param Exception $exception
    *
    */
    public function mailException(Exception $exception)
    {
        $data = [
            'exception' => $exception,
            'toEmail' => config('sptexception.ErrorEmail.toEmailAddress'),
            'fromEmail' => config('sptexception.ErrorEmail.fromEmailAddress'),
            'subject' => config('sptexception.ErrorEmail.emailSubject')
        ];

        Mail::send('exceptions::email', ['input' => $data], function ($message) {
            $message->from(config('sptexception.ErrorEmail.fromEmailAddress'))
                ->to(config('sptexception.ErrorEmail.toEmailAddress'))
                ->bcc(config('sptexception.ErrorEmail.toBccEmailAddress'), '')
                ->subject(config('sptexception.ErrorEmail.emailSubject'));
        });
    }
}
