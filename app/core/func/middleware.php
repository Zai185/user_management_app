<?php
function require_data($key)
{
    if (!isset(request()->data[$key])) {
        Session::flash('error', "$key is required");
        Session::flash($key, "$key is required");
        back();
    }
}

function unique($key, $data)
{
    [$table, $column] = $data;
    $class = rtrim($table,'s');
    $value = request()->data[$key];
    $result = $class::find($value, $column);
    Session::flash('error', "$key '$value' already exists");
    Session::flash($key, "$key '$value' already exists");
    if (!$result) back();
}