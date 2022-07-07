<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Statuspage\UptimeRobot;


class UptimeRobot
{
    private string $apiKey;
    private string $apiVersion;

    public function __construct(string $apiKey, string $apiVersion = '2')
    {
        $this->apiKey = $apiKey;
        $this->apiVersion = $apiVersion;
    }

    public function getMonitors()
    {
        return Http::asForm()->withHeaders($this->getDefaultHeaders())->post($this->getUrl('getMonitors'), $this->mergeData([]))->json();
    }

    public function getMonitorsData()
    {
        return Http::asForm()->withHeaders($this->getDefaultHeaders())->post($this->getUrl('getMonitors'), $this->mergeData([
            'response_times' => 1,
            'mwindows' => 1,
            'timezone' => 1,
            'response_times_limit' => 5,
        ]))->json();
    }

    private function mergeData(array $data){
        return array_merge([
            'api_key' => $this->apiKey,
            'format' => 'json'
        ], $data);
    }

    private function getDefaultHeaders(){
        return [
            'Cache-Control' => 'no-cache',
        ];
    }

    private function getUrl(string $path): string
    {
        return 'https://api.uptimerobot.com/v'.$this->apiVersion.'/'.$path;
    }

    private function getFullUrl(string $path, array $args = []): string
    {
        return 'https://api.uptimerobot.com/v'.$this->apiVersion.'/'.$path.'?api_key='.$this->apiKey.(count($args) > 0 ? ('&'.$this->mapped_implode('&', $args)) : '').'&format=json';
    }

    private function mapped_implode($glue, $array, $symbol = '='): string
    {
        return implode($glue, array_map(
                function($k, $v) use($symbol) {
                    return $k . $symbol . $v;
                },
                array_keys($array),
                array_values($array)
            )
        );
    }
}
