<?php


namespace App\Module\User\Application\Command\User\SendNotification;


use App\Core\Message\Command\Command;
use App\Module\Email\Domain\SharedKernel\ValueObject\Email;
use App\Module\Email\Domain\SharedKernel\ValueObject\TemplatedEmailContent;
use App\Module\User\Domain\SharedKernel\ValueObject\UserId;

class SendEmailNotificationCommand extends Command
{
    private Email $from;
    private UserId $to;
    private TemplatedEmailContent $content;

    public function __construct(Email $from, UserId $to, TemplatedEmailContent $content)
    {
        $this->from = $from;
        $this->to = $to;
        $this->content = $content;
    }

    public function getFrom(): Email
    {
        return $this->from;
    }

    public function getTo(): UserId
    {
        return $this->to;
    }

    public function getContent(): TemplatedEmailContent
    {
        return $this->content;
    }
}
