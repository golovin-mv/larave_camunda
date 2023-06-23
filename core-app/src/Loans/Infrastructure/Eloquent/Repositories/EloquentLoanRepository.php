<?php

namespace Core\Loans\Infrastructure\Eloquent\Repositories;

use Core\Loans\Domain\Loan;
use Core\Loans\Domain\LoanId;
use Core\Loans\Domain\LoanRepository;
use Core\Loans\Infrastructure\Eloquent\Models\LoanModel;
use Ramsey\Uuid\Uuid;

class EloquentLoanRepository implements LoanRepository
{
    public function getNextId(): LoanId
    {
        return  new LoanId(Uuid::uuid4());
    }

    public function save(Loan $loan): Loan
    {
        $savedLoan = LoanModel::firstOrNew($loan->toArray());

        $loan->getPassport()
            ? $savedLoan->passport()->delete()
            : $savedLoan->passport()->save([
                'series' => $loan->getPassport()->getSeries(),
                'number' => $loan->getPassport()->getNumber(),
        ]   );

        return Loan::fromArray($savedLoan->toArray());
    }

    public function getById(LoanId $id): Loan
    {
        $loanModel = LoanModel::find('id', $id->valueOf());

        return Loan::fromArray($loanModel);
    }
}
