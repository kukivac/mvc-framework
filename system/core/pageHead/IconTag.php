<?php

namespace system\core\pageHead;

class IconTag
{
    /** @var string */
    protected $rel;

    /** @var string|null */
    protected $type;

    /** @var string */
    protected $href;

    /**
     * IconTag constructor.
     *
     * @param string $rel
     * @param string|null $type
     * @param string $href
     */
    public function __construct(string $rel, ?string $type, string $href)
    {
        $this->href = $href;
        $this->type = $type;
        $this->rel = $rel;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return "<link rel=\"" . $this->rel . "\" type=\"" . $this->type . "\" href=\"" . $this->href . "\">\n";
    }
}