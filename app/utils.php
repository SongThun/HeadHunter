<?php

function formatDate($dateString)
{
    $date = new DateTime($dateString);
    return $date->format('d/m/Y');
}
function slugify($string)
{
    $string = strtolower($string);
    $string = preg_replace('/[^a-z0-9\s-]/', '', $string);
    $string = preg_replace('/[\s-]+/', '-', $string);
    return trim($string, '-');
}

?>