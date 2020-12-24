<?php


namespace App\Http\Traits;

use Illuminate\Support\Facades\Validator;

trait ErorApiResponse
{
    public function abortSchema(array $validator, $code)
    {
        return [
            'errors' => [
                'code' => $code,
                'message' => $validator
            ]
        ];
    }

    public function forbiddenSchema()
    {

        return [
            'errors' => [
                'code' => 403,
                'message' => 'Forbidden: Something went wrong, Task not created'
            ]
        ];
    }

    public function okSchema(array $data, $code)
    {
        return [
            'code' => $code,
            'data' => $data,
        ];
    }
}