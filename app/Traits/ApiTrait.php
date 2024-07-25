<?php

namespace App\Traits;

trait ApiTrait
{
    public function response($status, $message, $data, $errors, $meta = [], $info = [])
    {
        return is_array($errors) ?
            response()->json([
                'status'   => $status,
                'message'  => __($message),
                'data'     => $data,
                'meta'     => $meta,
                'errors'    => $errors,
                'info'     => $info,
            ], $status) :

            response()->json([
                'status'   => $status,
                'message'  => __($message),
                'data'     => $data,
                'meta'     => $meta,
                'errors'    => [
                    [
                        "field" => "genric",
                        "errors" => [$errors]
                    ],
                ],
                'info' => $info,
            ], $status);
    }
}
