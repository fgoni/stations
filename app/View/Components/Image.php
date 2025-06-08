<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Image extends Component
{
    public string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function render()
    {
        return view('components.image');
    }
}
