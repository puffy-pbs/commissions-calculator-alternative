<?php

namespace Services;

class ServiceProducer
{
    /**
     * Service producer
     * @param $bin
     * @return Service
     */
    public static function create($bin = null): Service
    {
        switch (true) {
            case null !== $bin:
                $url = AvailableServices::BIN_LOOKUP_URL . $bin;
                break;
            default:
                $url = AvailableServices::LATEST_EXCHANGE_RATES_API_URL;
                break;
        }

        return new DefaultService($url);
    }
}
