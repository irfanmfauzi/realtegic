<?php

if (!function_exists('sendResponse')) {
    function sendResponse($results, $message)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'results' => $results
        ], 200);
    }
}

if (!function_exists('sendError')) {
    function sendError($error, $code = 404)
    {
        return response()->json([
            'success' => false,
            'message' => $error
        ], $code);
    }
}

if (!function_exists('sendSuccess')) {
    function sendSuccess($message)
    {
        return response()->json([
            'success' => true,
            'message' => $message
        ], 200);
    }
}
