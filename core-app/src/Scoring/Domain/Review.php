<?php

namespace Core\Scoring\Domain;

use Core\Common\Domain\AggregateRoot;
use Core\Loans\Domain\LoanId;
use Core\Scoring\Domain\Events\PrescoringStarted;
use Core\Scoring\Domain\Events\PrescoringReviewRejected;
use Core\Scoring\Domain\Events\PrescoringReviewSuccess;
use Core\Scoring\Domain\Events\ScoringSuccess;
use Illuminate\Support\Facades\Log;

class Review extends AggregateRoot
{
    private ScoringResult | null $result;
    protected function __construct(
        private readonly ReviewId $id,
        private readonly LoanId $loanId,
        private readonly ReviewType $type,
    )
    {
        parent::__construct();
    }

    /**
     * @return ReviewId
     */
    public function getId(): ReviewId
    {
        return $this->id;
    }

    /**
     * @return LoanId
     */
    public function getLoanId(): LoanId
    {
        return $this->loanId;
    }

    /**
     * @return ReviewType
     */
    public function getType(): ReviewType
    {
        return $this->type;
    }

    /**
     * @return ScoringResult|null
     */
    public function getResult(): ?ScoringResult
    {
        return $this->result;
    }


    static public function prescoreLoan(
        ReviewId $id,
        LoanId $loanId,
        string $firstName,
    ): Review
    {
        Log::channel('develop')->info('start prescoring to: '. $firstName);

        $review = new self(
            $id,
            $loanId,
            new ReviewType(ReviewTypeEnum::PRESCORING)
        );

        if ($firstName === 'Nikita')
        {
            $review->reject();
        } else {
            $review->success();
        }

        $review->applyEvent(new PrescoringStarted($review));

        return $review;
    }

    public static function scoreLoan(
        ReviewId $id,
        LoanId $loanId,
        string $firstName,
        int $sum,
    ): Review
    {
        $review = new self(
            $id,
            $loanId,
            new ReviewType(ReviewTypeEnum::PRESCORING)
        );

        Log::channel('develop')->info('start prescoring to: '. $firstName.' with sum: '.$sum);
        sleep(10);

        $review->result = new ScoringResult(ScoringResultEnum::SUCCESS);

        Log::channel('develop')->info('scoring finished with result: '. $review->result->valueOf());

        $review->applyEvent(new ScoringSuccess(
            $review,
            $review->loanId,
        ));

        return $review;
    }

    public function reject(): void
    {
        $this->result = new ScoringResult(ScoringResultEnum::REJECT);
        $this->applyEvent(new PrescoringReviewRejected($this));
    }

    public function success(): void
    {
        $this->result = new ScoringResult(ScoringResultEnum::SUCCESS);
        $this->applyEvent(new PrescoringReviewSuccess($this));
    }

    public static function fromArray(array $data): Review
    {
        $review = new self(
            new ReviewId($data['id']),
            new LoanId($data['loanId']),
            new ReviewType($data['type'])
        );

        if ($data['result'])
        {
            $review->result = new ScoringResult($data['result']);
        }

        return $review;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->valueOf(),
            'loanId' => $this->loanId->valueOf(),
            'type' => $this->type->valueOf(),
            'result' => $this->result?->valueOf(),
        ];
    }

}
