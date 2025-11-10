<?php

namespace App\Livewire;

use Livewire\Component;

class EditorDemo extends Component
{
    public ?array $content = null;

    public function mount(): void
    {
        $this->content = [
            'type' => 'doc',
            'content' => [
                [
                    'type' => 'heading',
                    'attrs' => ['level' => 1],
                    'content' => [
                        ['type' => 'text', 'text' => 'Welcome to Strata Editor'],
                    ],
                ],
                [
                    'type' => 'paragraph',
                    'content' => [
                        ['type' => 'text', 'text' => 'This is a rich text editor powered by '],
                        ['type' => 'text', 'text' => 'Tiptap', 'marks' => [['type' => 'bold']]],
                        ['type' => 'text', 'text' => '. Try editing this content!'],
                    ],
                ],
            ],
        ];
    }

    public function save(): void
    {
        session()->flash('message', 'Content saved successfully!');
    }

    public function render()
    {
        return view('livewire.editor-demo');
    }
}
