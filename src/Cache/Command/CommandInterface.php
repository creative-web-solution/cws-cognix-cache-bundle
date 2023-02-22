<?php

namespace Cws\Bundle\CognixCacheBundle\Cache\Command;

interface CommandInterface
{
    // see https://tldp.org/LDP/abs/html/exitcodes.html
    public const COMMAND_SUCCESS = 0;
    public const COMMAND_FAILURE = 1;
    public const COMMAND_INVALID = 2;
}
