<?php


namespace App\Core\Template;


use Twig\Environment;
use Twig\TemplateWrapper;

class TemplateService
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function render(string $templateId, array $context): string
    {
        $template = $this->loadTemplate($templateId);
        return $template->render($context);
    }

    public function renderBlocks(string $templateId, array $blocksToRender, array $context): array
    {
        $template = $this->loadTemplate($templateId);
        $renderedBlocks = [];
        foreach ($blocksToRender as $blockName) {
            $renderedBlocks[$blockName] = $template->renderBlock($blockName, $context);
        }

        return $renderedBlocks;
    }

    private function loadTemplate(string $templateId): TemplateWrapper
    {
        return $this->twig->load($templateId);
    }
}
