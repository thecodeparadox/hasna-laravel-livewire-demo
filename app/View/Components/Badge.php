<?php

namespace App\View\Components;

use Illuminate\Support\Arr;
use Illuminate\View\Component;

class Badge extends Component
{
    /**
     * Content to show in badge
     *
     * @var mixed
     */
    public $content;

    /**
     * Bage Type
     * @var string
     */
    public $type = 'secodary';

    /**
     * Default Badge coloring class
     *
     * @var string
     */
    public $bgClass = 'bg-secondary';

    /**
     *
     * Badge Class for coloring
     * @var string[]
     */
    private $types = [
        'primary',
        'secondary',
        'info',
        'danger',
        'warning',
        'success'
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(mixed $content, string $type)
    {
        $type = strtolower(trim($type));
        $this->content = $content;
        $this->type = in_array($type, $this->types) ? $type : $this->type;
        $this->bgClass = 'bg-' . $this->type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.badge');
    }
}
