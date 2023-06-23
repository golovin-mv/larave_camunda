<?php

namespace Core\Loans\Domain;

interface LoanRepository
{
    public function getNextId(): LoanId;
    public function save(Loan $loan): Loan;
    public function getById(LoanId $id): Loan;
}
