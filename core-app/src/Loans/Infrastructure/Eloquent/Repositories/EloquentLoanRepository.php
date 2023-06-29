<?php

namespace Core\Loans\Infrastructure\Eloquent\Repositories;

use Core\Loans\Domain\AddressId;
use Core\Loans\Domain\Loan;
use Core\Loans\Domain\LoanId;
use Core\Loans\Domain\LoanRepository;
use Core\Loans\Infrastructure\Eloquent\Models\LoanModel;
use Illuminate\Support\Arr;
use Ramsey\Uuid\Uuid;

class EloquentLoanRepository implements LoanRepository
{
    public function getNextId(): LoanId
    {
        return new LoanId(Uuid::uuid4());
    }

    public function nextAddressId(): AddressId
    {
        return new AddressId(Uuid::uuid4());
    }

    public function save(Loan $loan): Loan
    {
        $loanModel = LoanModel::where('id', $loan->getId()->valueOf())
            ->firstOr(function () use ($loan) {
                return LoanModel::create($loan->toArray());
            });

        $this->saveLoanPassport(
            $loan,
            $loanModel,
        );

        $this->saveLoanAddress(
            $loan,
            $loanModel,
        );

        $loanModel->update(Arr::except($loan->toArray(), ['passport', 'address']));
        $loanModel->save();

        return Loan::fromArray(
            $this->arrayFromModel(
                $loanModel,
            ),
        );
    }

    public function getById(LoanId $id): Loan
    {
        return Loan::fromArray(
            $this->arrayFromModel(
                LoanModel::where('id', $id->valueOf())->firstOrFail()
            ),
        );
    }

    private function saveLoanPassport(Loan $loan, LoanModel $model): LoanModel
    {
        $loan->getPassport()
            ? $model->passport()->updateOrCreate(
                [
                    'loanId' => $loan->getId()->valueOf(),
                ],
                [
                    'series' => $loan->getPassport()->getSeries(),
                    'number' => $loan->getPassport()->getNumber(),
                ]
            )
            : $model->passport()->delete();

        return $model;
    }

    private function saveLoanAddress(Loan $loan, LoanModel $loanModel): LoanModel
    {
        $loan->getAddress()
            ? $loanModel->address()->updateOrCreate(
                [
                    'loanId' => $loan->getId()->valueOf(),
                ],
                $loan->getAddress()->toArray(),
            )
            : $loanModel->address()->delete();

        return $loanModel;
    }

    private function arrayFromModel(LoanModel $model): array
    {
        return [
            'passport' => $model->passport ? $model->passport->toArray() : null,
            'address' => $model->address ? $model->address->toArray() : null,
            ...$model->toArray()
        ];
    }
}
