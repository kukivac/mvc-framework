<?php

declare(strict_types=1);

namespace system\core\api;

class ApiResponse
{
    public const HTTP_200_OK = 200;
    public const HTTP_400_BAD_REQUEST = 400;
    public const HTTP_401_UNAUTHORIZED = 401;
    public const HTTP_404_NOT_FOUND = 404;
    public const HTTP_500_SERVER_ERROR = 500;


    /** @var array */
    private $reponse_body;

    /** @var int */
    private $response_code;

    /**
     * @param array $reponse_body
     * @param int $response_code
     */
    public function __construct(array $reponse_body, int $response_code = self::HTTP_200_OK)
    {
        $this->reponse_body = $reponse_body;
        $this->response_code = $response_code;
    }

    public function render()
    {
        echo json_encode($this->reponse_body);
        http_response_code($this->response_code);
    }
}