<?php


namespace App\Module\Email\Application\Command\SendTemplatedEmail;



use App\Core\Message\Command\Command;
use App\Module\Email\Domain\SharedKernel\ValueObject\Email;
use App\Module\Email\Domain\SharedKernel\ValueObject\TemplatedEmailContent;

class SendTemplatedEmailCommand extends Command
{
    private Email $from;
    private Email $to;
    private TemplatedEmailContent $content;

    public function __construct(Email $from, Email $to, TemplatedEmailContent $content)
    {
        $this->from = $from;
        $this->to = $to;
        $this->content = $content;
    }

    public function getFrom(): Email
    {
        return $this->from;
    }

    public function getTo(): Email
    {
        return $this->to;
    }

    public function getContent(): TemplatedEmailContent
    {
        return $this->content;
    }
}
