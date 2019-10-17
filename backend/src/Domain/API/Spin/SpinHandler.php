<?php

declare(strict_types=1);

namespace App\Domain\API\Spin;

use App\Domain\API\Spin\Exception\UnableToSpin;
use App\Domain\Model\BonusWallet\BonusWallet;
use App\Domain\Model\BonusWallet\BonusWalletRepositoryInterface;
use App\Domain\Model\Player\Player;
use App\Domain\Model\Wallet\Wallet;
use App\Domain\Model\Wallet\WalletRepositoryInterface;
use App\Domain\Service\Player\TotalBalanceCalculator;
use App\Domain\Service\Spin\LooseAction;
use App\Domain\Service\Spin\RandomGenerator;
use App\Domain\Service\Spin\WageringRequirementsCalculator;
use App\Domain\Service\Spin\WinAction;
use App\Domain\Shared\Model\CommonWallet\ValueObject\CurrentValue;
use App\Domain\Shared\Model\CommonWallet\ValueObject\Status;
use App\Domain\Shared\ValueObject\Amount;

final class SpinHandler
{
    /** @var TotalBalanceCalculator */
    private $totalBalanceCalculator;

    /** @var WageringRequirementsCalculator */
    private $wageringRequirementsCalculator;

    /** @var WinAction */
    private $winAction;

    /** @var LooseAction */
    private $looseAction;

    /** @var RandomGenerator */
    private $randomGenerator;

    public function __construct(
        TotalBalanceCalculator $totalBalanceCalculator,
        WageringRequirementsCalculator $wageringRequirementsCalculator,
        WinAction $winAction,
        LooseAction $looseAction,
        RandomGenerator $randomGenerator
    )
    {
        $this->totalBalanceCalculator = $totalBalanceCalculator;
        $this->wageringRequirementsCalculator = $wageringRequirementsCalculator;
        $this->winAction = $winAction;
        $this->looseAction = $looseAction;
        $this->randomGenerator = $randomGenerator;
    }

    public function handle(SpinCommand $command)
    {
        $fullAmount = $this->totalBalanceCalculator->calculate($command->getPlayer());
        if ($fullAmount->getValue() < $command->getBetAmount()->getValue()) {
            throw UnableToSpin::betAmountIsTooHigh($fullAmount);
        }

        if ($this->randomGenerator->rollACoin()) {
            $this->winAction->win($command->getBetAmount(), $command->getPlayer());
        } else {
            $this->looseAction->loose($command->getBetAmount(), $command->getPlayer());
        }

        $this->wageringRequirementsCalculator->calculate($command->getBetAmount(), $command->getPlayer());
    }
}