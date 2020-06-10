<?php


namespace App\Module\Email\Domain\SharedKernel\ValueObject;


class TemplatedEmailContent
{
    private string $templateId;
    private array $context;

    public function __construct(string $templateId, array $context)
    {
        $this->templateId = $templateId;
        $this->context = $context;
    }

    public static function create(string $templateId, array $context): self
    {
        return new self($templateId, $context);
    }

    public function extendContextWith(array $context): self
    {
        return self::create($this->templateId, array_merge($this->context, $context));
    }

    public function getTemplateId(): string
    {
        return $this->templateId;
    }

    public function getContext(): array
    {
        return $this->context;
    }
}
