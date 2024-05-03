<?php

function getBody()
{
    return json_decode(file_get_contents("php://input"));
}

function sanitizeString($value)
{
    return filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
}

function sanitizeInput($data, $property, $filterType, $isObject = true)
{
    if ($isObject) {
        return isset($data->$property) ? filter_var($data->$property, $filterType) : null;
    } else {
        return isset($data[$property]) ? filter_var($data[$property], $filterType) : null;
    }
}

function response($response, $status)
{
    http_response_code($status);
    echo json_encode($response);
    exit;
}

function responseError($message, $status)
{
    http_response_code($status);
    echo json_encode(['error' => $message]);
    exit;
}

function debug($content)
{
    echo '<pre>';
    echo var_dump($content);
    echo '</pre>';
    exit;
}
