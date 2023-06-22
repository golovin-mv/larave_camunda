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
    )
    {
        parent::__construct();
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

    /**
     * @param array $data
     * @return object
     * @throws DomainException
     */
    public static function fromArray(array $data): object
    {
        return new self(
            new ClientName(collect(
                    $data['firsName'],
                    $data['lastName'],
                    $data['middleName']
                )
            ),
            new LoanAmount($data['amount']),
            LoanTermInterval::fromMonthCount($data['interval']),
            new LoanId($data['id'])
        );
    }

    /**
     * @param object $object
     * @return array
     */
    public function toArray(object $object): array
    {
        return [
            'id' => $this->id->valueOf(),
            'firsName' => $this->name->getFirstName(),
            'lastName' => $this->name->getLastName(),
            'middleName' => $this->name->getMiddleName(),
            'status' => $this->status->valueOf(),
            'amount' => $this->amount->valueOf(),
            'interval' => $this->interval->getMonthCount(),
        ];
    }
}
