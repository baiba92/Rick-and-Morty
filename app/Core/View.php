<?php declare(strict_types=1);

namespace App\Core;

class View
{
    private string $template;
    private array $content;

    public function __construct(string $template, array $content)
    {
        $this->template = $template;
        $this->content = $content;
    }

    public function template(): string
    {
        return $this->template;
    }

    public function content(): array
    {
        return $this->content;
    }
}