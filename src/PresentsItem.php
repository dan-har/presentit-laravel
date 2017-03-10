<?php

namespace Presentit\Laravel;

use Presentit\Present;

trait PresentsItem
{
    /**
     * Get the present object for the entity.
     *
     * @return \Presentit\Present
     */
    public function present()
    {
        return Present::item($this);
    }

    /**
     * Transform the entity to a new presentation.
     *
     * @param mixed $transformer
     * @return \Presentit\Presentation
     */
    public function transform($transformer)
    {
        return $this->present()->with($transformer);
    }
}
