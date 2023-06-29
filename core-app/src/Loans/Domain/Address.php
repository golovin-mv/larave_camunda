<?php

namespace Core\Loans\Domain;

use Core\Common\Domain\DomainException;
use Core\Common\Domain\Entity;

class Address implements Entity
{
    public function __construct(
        private readonly AddressId $id,
        private readonly PostalCode $postalCode,
        private readonly AddressString $addressString,
    )
    {}

    /**
     * @return AddressId
     */
    public function getId(): AddressId
    {
        return $this->id;
    }


    /**
     * @param array $data
     * @return self
     * @throws DomainException
     */
    public static function fromArray(array $data): object
    {
        return new self(
            new AddressId($data['id']),
            new PostalCode($data['postalCode']),
            $data['address'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->valueOf(),
            'postalCode' => $this->postalCode->valueOf(),
            'address' => $this->addressString->valueOf(),
        ];
    }

}
