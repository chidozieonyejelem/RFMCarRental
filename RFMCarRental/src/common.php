<?php
function escape($data)
{
    return htmlspecialchars(trim(stripslashes($data)), ENT_QUOTES, 'UTF-8');
}