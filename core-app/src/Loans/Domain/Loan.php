<?php

namespace Core\Loans\Domain;

use Core\Common\Domain\AggregateRoot;
use Core\Common\Domain\DomainException;
use Core\Loans\Domain\Events\LoanCreatedEvent;

class Loan extends AggregateRoot
{
    private LoanStatus $status;

    protected function __construct(
        private readonly ClientName $name,
        private readonly LoanAmount $amount,
        private readonly LoanTermInterval $interval,
        private readonly LoanId $id,
        private Passport | null $passport = null,
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
     * @return Passport|null
     */
    public function getPassport(): ?Passport
    {
        return $this->passport;
    }

    public static function createLoan(
        ClientName $name,
        LoanAmount $amount,
        LoanTermInterval $interval,
        LoanId $id,
    ): Loan
    {
        $loan = new self(
            $name,
            $amount,
            $interval,
            $id,
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

    }

    /**
     * @param array $data
     * @return object
     * @throws DomainException
     */
    public static function fromArray(array $data): object
    {
        return new self(
            new ClientName(collect([
                    'firstName' => $data['firstName'],
                    'lastName' => $data['lastName'],
                    'middleName' => $data['middleName']
                ])
            ),
            new LoanAmount($data['amount']),
            LoanTermInterval::fromMonthCount($data['interval']),
            new LoanId($data['id'])
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
        ];
    }
}
