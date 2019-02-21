<?php

namespace Infinety\TemplyResourcesSelector;

use Laravel\Nova\Card;

class TemplyResourcesSelector extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = '1/3';

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'temply-resources-selector';
    }

    /**
     * Indicates that the analytics should show current visitors.
     *
     * @return $this
     */
    public function type(string $type)
    {
        return $this->withMeta(['type' => $type]);
    }

    /**
     * Prepare the element for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge([
            'name'  => str_random(16),
            'width' => $this->width,
        ], parent::jsonSerialize());
    }
}
