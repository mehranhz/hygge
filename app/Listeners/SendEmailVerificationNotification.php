<?php

namespace App\Listeners;

use App\Events\UserSelfRegistered;
use App\Exceptions\ServiceCallException;
use App\Mail\EmailVerificationRequestMail;
use App\Services\Contracts\EmailVerificationInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailVerificationNotification implements ShouldQueue
{
    protected EmailVerificationInterface $emailVerificationService;

    /**
     * Create the event listener.
     */
    public function __construct(EmailVerificationInterface $emailVerificationService)
    {
        $this->emailVerificationService = $emailVerificationService;
    }

    /**
     * Handle the event.
     */
    public function handle(UserSelfRegistered $event): void
    {
        try {

            $user = $event->user;
            $token = $this->emailVerificationService->generateTokenFromEmailAddress($user->getEmail());
            $this->emailVerificationService->persistToken($user->getEmail(), $token);
            $this->sendEmail($user, $token);
        } catch (\Exception $exception) {
            throw new ServiceCallException('there was a problem while sending email', code: $exception->getCode());
        }
    }

    /**
     * @param mixed $user
     * @param string $token
     * @return bool
     */
    protected function sendEmail(mixed $user, string $token): bool
    {
        Mail::to($user)->send(
            new EmailVerificationRequestMail(
                $user->getName(),
                env('APP_NAME'),
                $this->emailVerificationService->getEmailVerificationPath($token)
            ));

        return true;
    }
}
