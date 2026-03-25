<?php

namespace App\Core;

use Firebase\JWT\JWT as FirebaseJWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\Key;

class JWT {
    private string $key;

    public function __construct()
    {
        $this->key = $_ENV['JWT_SECRET'];
    }

    public function encode(array $payload, string $alg = 'HS256', ?string $kid = null, ?array $headers = null): string
    {
        return FirebaseJWT::encode($payload, $this->key, $alg, $kid, $headers);
    }
    public function decode(string $jwt, string $alg = 'HS256', ?\stdClass &$headers = null): array
    {
        try {
            $decoded = FirebaseJWT::decode($jwt, new Key($this->key, $alg, $headers));
            return (array) $decoded;
        } catch (ExpiredException $e) {
            throw new \Exception('Token has expired', 401);
        } catch (BeforeValidException $e) {
            throw new \Exception('Token is not valid yet', 401);
        } catch (SignatureInvalidException $e) {
            throw new \Exception('Invalid token signature', 401);
        } catch (\Exception $e) {
            throw new \Exception('Invalid token: ' . $e->getMessage(), 401);
        }
    }
}