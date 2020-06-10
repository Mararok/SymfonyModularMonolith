<?php


namespace App\Module\Email\Application\Command\SendTemplatedEmail;


use App\Core\Message\Command\CommandHandler;
use App\Core\Template\TemplateService;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email as SymfonyEmail;

class SendTemplatedEmailCommandHandler implements CommandHandler
{
    private MailerInterface $mailer;
    private TemplateService $templateService;

    public function __construct(MailerInterface $mailer, TemplateService $templateService)
    {
        $this->mailer = $mailer;
        $this->templateService = $templateService;
    }

    public function __invoke(SendTemplatedEmailCommand $command)
    {
        $email = $this->buildEmail($command);
        $this->mailer->send($email);
    }

    private function buildEmail(SendTemplatedEmailCommand $command): SymfonyEmail
    {
        $content = $command->getContent();
        $renderedContent = $this->templateService->renderBlocks(
            $content->getTemplateId(),
            ["subject", "text", "html"],
            $content->getContext()
        );

        return (new SymfonyEmail())
            ->from($command->getFrom()->getRaw())
            ->to($command->getTo()->getRaw())
            ->subject($renderedContent["subject"])
            ->text($renderedContent["text"])
            ->html($renderedContent["html"]);
    }
}
