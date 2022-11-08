<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use Michelf\Markdown;

class PostsEntity extends Entity
{
    private function to_markdown($content) // (1)
    {
        $content = str_replace(PHP_EOL, "  " . PHP_EOL, $content);
        return Markdown::defaultTransform($content);
    }

    public function setContent($content) // (2)
    {
        $this->attributes['content'] = $content; // (3)
        $this->attributes['html_content'] = $this->to_markdown($content); // (4)
    }

}
