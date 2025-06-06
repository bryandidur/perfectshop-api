<?php

namespace App\Dtos;

abstract class BaseDto
{
    /**
     * Create a new DTO instance.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    /**
     * Fill the DTO with data.
     *
     * @param array $data
     */
    final public function fill(array $data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}
