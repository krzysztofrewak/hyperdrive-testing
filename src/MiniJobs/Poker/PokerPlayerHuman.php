<?php


namespace Hyperdrive\MiniJobs\Poker;


use Hyperdrive\Handlers\TextHandler;
use Illuminate\Support\Collection;
use League\CLImate\CLImate;
use Hyperdrive\MiniJobs\Poker\Helpers\CardHandler;

class PokerPlayerHuman extends PokerPlayer
{
    use TextHandler;
    use CardHandler;

    public function selectCardsToRemove(): array
    {
        $cli = new CLImate();
        $cardsToSelect = [];
        $cardsIdToRemove = [];
        $options = [];

        foreach ($this->cards as $cardInfo) {
            $id = $this->cards->search($cardInfo);
            $card = $cardInfo[0] . " " . $cardInfo[1];
            $cardTranslated = $this->translateCard($cardInfo);
            $cardsToSelect[$id] = "$cardTranslated[0] $cardTranslated[1]";
            array_push($options, [$id, $card]);
        }

        $cardsToRemove = $cli->checkboxes("Select cards you wish to change.", $cardsToSelect)->prompt();

        $cardToRemoveTr = collect();
        foreach ($cardsToRemove as $card) {
            $cardToRemoveTr->add(explode(" ", $card));
        }

        $cardsToRemove = collect();
        foreach ($cardToRemoveTr as $card) {
            $cardsToRemove->add($this->translateCard($card));
        }

        foreach ($options as $option) {
            foreach ($cardsToRemove as $cardToRemove) {
                $card = "$cardToRemove[0] $cardToRemove[1]";
                if ($card === $option[1]) {
                    array_push($cardsIdToRemove, $option[0]);
                    break;
                }
            }
        }
        return $cardsIdToRemove;
    }

    public function giveCards(Collection $cards): void
    {
        $this->typewriterEffect("You received: ");
        $this->displayCards($cards);

        $this->cards = $this->cards->merge($cards);
    }
}