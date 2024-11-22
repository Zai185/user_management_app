<?php

function dd(...$var)
{
    echo "<pre>";
    var_dump(...$var);
    die();
}

/**
 * Give our the view file path
 * @param mixed $filepath file are defie with "."
 * @param mixed $data
 * @return void
 */
function view($filepath, $data = []): array
{
    $filepath = str_replace('.', '/', $filepath);
    return [$filepath, $data];
}

function redirect(string $uri)
{
    // return [null, $uri];
    header("location: $uri");
    exit;
}

function view_path($filename)
{
    return "view/$filename.php";
}


function verify_session_token($uid): bool
{

    $session = Session::where('user_id', $uid)->get();
    dd($session);
    return true;
}

function config($config_file)
{
    return require "config/$config_file.php";
}


function back()
{
    redirect(Session::getProps('prev_url') ?? '/');
}

// & models

function request()
{
    return new Request();
}
