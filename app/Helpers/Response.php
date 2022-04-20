<?php

namespace App\Helpers;

use App\Helpers\Util;

class Response
{

    const CODE = [
        // Success
        'OK' => [true, 200],
        'CREATED' => [true, 201],
		'RESET' => [true, 200],
        // Failure
        'ERROR' => [false, 500],
        'INTERNAL' => [false, 500],
        'INPUT' => [false, 400],
        'EXIST' => [false, 400],
        'ACCEPT' => [false, 406],
        'AUTH' => [false, 401],
        'ACCESS' => [false, 403],
        'PROGRESS' => [false, 422],
        'EXPIRED' => [false, 422],
        // Thanos
        'PEACE' => [true, 200]
    ];

    private string $method;
    private string $code = 'ERROR';
    private bool $success = false;
    private int $status = 500;
    private $data = null;
    private $option = null;
    private $message = null;

    public function __construct(string $method)
    {
        $this->method = $method;
    }

    public function set(string $code, $data = null, $option = null): void
    {
        $this->code = $code;
        $this->success = self::CODE[$this->code][0];
        $this->status = self::CODE[$this->code][1];
        $this->data = $data;
        $this->option = $option;
    }

    public function get(): array
    {
        // Default
        $response = [
            'status' => $this->status,
            'content' => [
                'code' => $this->code,
                'success' => $this->success
            ]
        ];
        // Mode
        if ($this->success) {
            $response['content']['data'] = $this->data;
        } else {
            $response['content']['error'] = $this->data;
        }
        // Option
        if (!empty($this->option)) {
            $response['content']['option'] = $this->option;
        }
        return $response;
    }

    public function log(string $message): void
    {
        $this->message = Util::trim($message);
        if (env('LOG_DEBUG')) {

            var_dump($this->method);
            var_dump($this->code);
            var_dump($this->status);
            var_dump($this->message);
            die();

        }
    }

}
