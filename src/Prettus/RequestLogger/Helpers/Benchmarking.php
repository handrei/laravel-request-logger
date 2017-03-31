<?php namespace Prettus\RequestLogger\Helpers;

/**
 * Class Benchmarking
 * @package Prettus\RequestLogger\Helpers
 */
class Benchmarking
{

    /**
     * @var array
     */
    protected static $timers = [];

    /**
     * @param $name
     * @return mixed
     */
    public static function start($name, $startTime = null)
    {
        $start = $startTime ?? microtime(true);

        static::$timers[$name] = [
            'start' => $start
        ];

        return $start;
    }

    /**
     * @param $name
     * @return float
     * @throws \Exception
     */
    public static function end($name, $endTime = null)
    {

        $end = $endTime ?? microtime(true);

        if (isset(static::$timers[$name]) && isset(static::$timers[$name]['start'])) {

            if (isset(static::$timers[$name]['duration'])) {
                return static::$timers[$name]['duration'];
            }

            $start = static::$timers[$name]['start'];
            static::$timers[$name]['end'] = $end;
            static::$timers[$name]['duration'] = sprintf("%d", ($end - $start) * 1000);

            return static::$timers[$name]['duration'];
        }

        throw new \Exception("Benchmarking '{$name}' not started");
    }

    /**
     * @param $name
     * @return float
     * @throws \Exception
     */
    public static function duration($name)
    {
        return static::end($name);
    }
}
