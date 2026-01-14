<?php

namespace App\Domain\Exceptions;

use Exception;
use Throwable;

//* Extendemos la clase de EXCEPTION de PHP para crear nuestras exceptions de dominio
//* La extensión permitirá utilizar metodos de la clase Exception y agregar nuevos metodos como getCode, getMessage etc.
abstract class BaseDomainException extends Exception 
{
    private array $metadata;

    public function __construct(
        string $message = "", 
        int $code = 400, 
        array $metadata = [], 
        Throwable $previous = null
    ) {
        $this->metadata = $metadata;
        parent::__construct($message, $code, $previous);
    }


    //* Este metodo retorna los metadatos asociados a la exception DEBE SER MANUAL CREADO porque no lo hereda de la clase Exception
    public function getMetadata(): array 
    {
        return $this->metadata;
    }
}