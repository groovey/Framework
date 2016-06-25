<?php

namespace Groovey\Framework\Traits;

trait Translation
{
    public function trans($message)
    {
        return $this['trans']->get($message);
    }

    public function setLocale($locale)
    {
        $locale = $locale ?: 'en';

        return $this['trans']->setLocale($locale);
    }
}
