<?php
namespace App\Traits;

trait ResponseJsonTrait
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function responseSuccess($result, $message = null, $code = 200)
    {
        $response = [
            'success'   => true,
            'result'    => $result,
        ];

        if (!empty($message)) {
            $response['message'] = $message;
        }

        return response()->json($response, $code);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function responseError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['result'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
