<?php

namespace Core\Loans\Domain;

use Core\Common\Domain\AggregateRoot;
use Core\Common\Domain\DomainException;
use Core\Loans\Domain\Events\LoadAddressRemoved;
use Core\Loans\Domain\Events\LoadFinished;
use Core\Loans\Domain\Events\LoanAddressAdded;
use Core\Loans\Domain\Events\LoanCreatedEvent;
use Core\Loans\Domain\Events\LoanPassportEdited;
use Illuminate\Support\Arr;
use function Symfony\Component\Translation\t;

class Loan extends AggregateRoot
{
    protected function __construct(
        private readonly LoanId $id,
        private readonly ClientName $name,
        private readonly LoanAmount $amount,
        private readonly LoanTermInterval $interval,
        private LoanStatus $status,
        private Passport | null $passport = null,
        private Address | null $address = null,
    )
    {
        parent::__construct();
    }

    /**
     * @return LoanId
     */
    public function getId(): LoanId
    {
        return $this->id;
    }

    /**
     * @return ClientName
     */
    public function getName(): ClientName
    {
        return $this->name;
    }

    /**
     * @return LoanAmount
     */
    public function getAmount(): LoanAmount
    {
        return $this->amount;
    }

    /**
     * @return Passport|null
     */
    public function getPassport(): ?Passport
    {
        return $this->passport;
    }

    /**
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public static function createLoan(
        ClientName $name,
        LoanAmount $amount,
        LoanTermInterval $interval,
        LoanId $id,
    ): Loan
    {
        $loan = new self(
            $id,
            $name,
            $amount,
            $interval,
            new LoanStatus(LoanStatusEnum::IN_WORK),
        );

        $loan->status = new LoanStatus(LoanStatusEnum::IN_WORK);
        $loan->applyEvent(new LoanCreatedEvent($loan));

        return $loan;
    }

    public function editPassport(Passport | null $passport): void
    {
        if (!$this->status->equals(new LoanStatus(LoanStatusEnum::IN_WORK)))
        {
            throw new DomainException('The passport information in the application cannot be changed while it is in the status of "submitted."');
        }

        if ($this->passport && $this->passport->equals($passport))
        {
            return;
        }

        $this->passport = $passport;
        $this->applyEvent(new LoanPassportEdited($this));
    }

    public function addAddress(Address $address)
    {
        $this->address = $address;

        $this->applyEvent(new LoanAddressAdded(
            $this,
            $address->getId(),
        ));
    }

    public function removeAddress(AddressId $id)
    {
        if(!$this->address)
        {
            return;
        }

        if (!$this->address->getId()->equals($id))
        {
            throw new DomainException('There is no such address in the loan');
        }

        $this->address = null;

        $this->applyEvent(new LoadAddressRemoved($this));
    }

    public function finishLoan(): void
    {
        if (
            !$this->address || !$this->passport
        )
        {
           throw new DomainException('Can not finish load without passport or address');
        }

        $this->status = new LoanStatus(LoanStatusEnum::SCORING);
        $this->applyEvent(new LoadFinished($this));
    }

    public function rejectLoan(): void
    {
        $this->status = new LoanStatus(LoanStatusEnum::REJECTED);
        //TODO events
    }

    public function getMoney(): void
    {
        $this->status = new LoanStatus(LoanStatusEnum::FINISH);
        //TODO events
    }

    /**
     * @param array $data
     * @return object
     * @throws DomainException
     */
    public static function fromArray(array $data): object
    {
        return new self(
            new LoanId($data['id']),
            new ClientName(collect([
                    'firstName' => $data['firstName'],
                    'lastName' => $data['lastName'],
                    'middleName' => $data['middleName']
                ])
            ),
            new LoanAmount($data['amount']),
            LoanTermInterval::fromMonthCount($data['interval']),
            new LoanStatus(LoanStatusEnum::from($data['status'])),
            $data['passport']
                ? new Passport(
                    Arr::get($data, 'passport.series'),
                    Arr::get($data, 'passport.number')
                )
                : null,
            $data['address']
                ? new Address(
                    new AddressId(Arr::get($data, 'address.id')),
                    new PostalCode(Arr::get($data, 'address.postalCode')),
                    new AddressString(Arr::get($data, 'address.address'))
                )
                : null,
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id->valueOf(),
            'firstName' => $this->name->getFirstName(),
            'lastName' => $this->name->getLastName(),
            'middleName' => $this->name->getMiddleName(),
            'status' => $this->status->valueOf(),
            'amount' => $this->amount->valueOf(),
            'interval' => $this->interval->getMonthCount(),
            'passport' => $this->passport
                ? [
                    'series' => $this->passport->getSeries(),
                    'number' => $this->passport->getNumber(),
                ]
                : null,
            'address' => $this->address
                ? [
                    'address',
                    'postalCode',
                ]
                : null,
        ];
    }
}
