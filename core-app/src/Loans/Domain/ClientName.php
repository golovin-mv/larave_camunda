<?php

namespace Core\Loans\Domain;

use Core\Common\Domain\DomainException;
use Core\Common\Domain\ValueObject\ValueObject;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ClientName extends ValueObject
{
    private string $firstName;
    private string $lastName;
    private string $middleName;

    public function __construct(Collection $value)
    {
        parent::__construct($value);
        //TODO check empty string
        if (!$value->has(['firstName', 'lastName'])) {
            throw new DomainException(
                'The client name should consist of a first name and a last name'
            );
        }

        $this->firstName = $value->get('firstName');
        $this->lastName = $value->get('lastName');
        $this->middleName = $value->get('middleName', null);

    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getMiddleName(): string
    {
        return $this->middleName;
    }
}
