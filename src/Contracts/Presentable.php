<?php

namespace Presentit\Laravel\Contracts;

interface Presentable
{
    /**
     * Get the present object for the entity.
     *
     * @return \Presentit\Present
     */
    public function present();

    /**
     * Transform the entity to a new presentation.
     *
     * @param mixed $transformer
     * @return \Presentit\Presentation
     */
    public function transform($transformer);
}
