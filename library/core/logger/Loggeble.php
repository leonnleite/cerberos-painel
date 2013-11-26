<?php

namespace br\com\cf\library\core\logger;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
interface Loggeble
{

    public function LogInfo ($line);

    public function LogDebug ($line);

    public function LogWarn ($line);

    public function LogError ($line);

    public function LogFatal ($line);

    public function Log ($line, $priority);
}