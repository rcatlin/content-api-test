<?php

namespace RCatlin\ContentApi;

abstract class EntityClassName
{
    public static function renderFromParts(array $parts)
    {
        $partialPath = implode('\\', array_map(function ($part) {
            return ucfirst($part);
        }, $parts));

        return 'RCatlin\\ContentApi\\Entity\\' . $partialPath;
    }
}
