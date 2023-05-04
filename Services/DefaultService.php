<?php

namespace Services;

use Base\Requester;

class DefaultService implements Service
{
    /** @var string $url */
    private string $url;

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Get data
     * @return false|mixed
     */
    public function getData()
    {
        return (new Requester())
            ->getData($this->url);
    }
}
