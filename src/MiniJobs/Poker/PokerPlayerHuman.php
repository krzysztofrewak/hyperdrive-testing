<?php


namespace Hyperdrive\MiniJobs\Poker;


use Hyperdrive\Traits\TextHandler;
use Illuminate\Support\Collection;
use League\CLImate\CLImate;

class PokerPlayerHuman extends PokerPlayer
{
    use TextHandler;

    public function selectCardsToRemove(): array
    {
        $cli = new CLImate();
        $cardsToSelect = [];
        $cardsIdToRemove = [];
        $options = [];

        foreach ($this->cards as $cardInfo) {
            $id = $this->cards->search($cardInfo);
            $card = $cardInfo[0] . " " . $cardInfo[1];
            $cardsToSelect[$id] = $card;
            array_push($options, [$id, $card]);
        }
        $cardsToRemove =  $cli->checkboxes("Select cards you wish to change.", $cardsToSelect)->prompt();

        foreach ($options as $option) {
            foreach ($cardsToRemove as $cardToRemove) {
                if (array_search($cardToRemove, $option)) {
                    array_push($cardsIdToRemove, $option[0]);
                }
            }
        }
        return $cardsIdToRemove;
    }

    public function giveCards(Collection $cards): void
    {
        $this->typewriterEffect("You received: ");
        print_r($cards);

        $this->cards = $this->cards->merge($cards);
        print_r($this->cards);
    }
}