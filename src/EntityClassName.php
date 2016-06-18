<?php

namespace RCatlin\ContentApi;

abstract class EntityClassName
{
    public function renderFcqnFromParts(array $parts)
    {
        $partialPath = implode('\\', array_map(function ($part) {
            return ucfirst($part);
        }, $parts));

        return 'RCatlin\\ContentApi\\Entity\\' . $partialPath;
    }
}
