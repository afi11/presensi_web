<?php

use Illuminate\Support\Str;

function generateRandom($length)
{
    return Str::random($length);
}