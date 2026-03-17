<?php

namespace App\Core;
class Request {
    public function getBody(): array {
        $method = $_SERVER['REQUEST_METHOD'];
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

        if (strpos($contentType, 'application/json') !== false) {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            return is_array($data) ? $data : [];
        }

        if ($method === 'POST') {
            return $_POST;
        }

        if (in_array($method, ['PUT', 'PATCH'])) {
            $input = file_get_contents('php://input');
            parse_str($input, $data);
            return $data;
        }

        return [];
    }
    public function getQueryParams(): array {
        return $_GET;
    }
    public function getHeaders(): array {
        $headers = [];

        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) === 'HTTP_') {
                $headerName = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
                $headers[$headerName] = $value;
            }
        }
        return $headers;
    }
    public function getHeader(string $name): ?string {
        $headers = $this->getHeaders();
        $formattedName = str_replace(' ', '-', ucwords(str_replace('-', ' ', strtolower($name))));

        return $headers[$formattedName] ?? null;
    }
    public function getBearerToken(): ?string {
        $authHeader = $this->getHeader('Authorization');

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return $matches[1];
        }

        return null;
    }
}