<?php

declare(strict_types=1);

namespace Hyperdrive\Story;

use Hyperdrive\Output\OutputContract;

class Story
{

    protected OutputContract $output;

    /**
     * Story constructor.
     * @param OutputContract $output
     */
    public function __construct(OutputContract $output)
    {
        $this->output = $output;
        $this->intro();
    }

    private function intro(): void
    {
        $this->output->info("");
        $this->output->info("You were on your way to deliver the two remaining cargos across the galaxy.");
        $this->output->info("You were about to leave the spaceport and travel to your next destination.");
        $this->output->info("But as you were about to leave you've been contacted over the comms by a calm yet somehow familiar voice.");
        $this->output->info("The voice asked you to deliver something. You've run into many people like that in your life as a space courier.");
        $this->output->info("You understand that there are always some packages to deliver but you were tired and the last thing you wanted was another job.");
        $this->output->info("You wanted to decline but... you couldn't.");
        $this->output->info("Something told you to get out of your ship and agree to deliver the package. Was it your curiosity? Or some tricks of an unknown nature?");
        $this->output->info("A few moments later you found yourself agreeing to the contract. A young man gave you a small and mysterious box that fit in the palm of your hand.");
        $this->output->info("He told you to deliver it to a Jedi Master named 'Corran Horn' for 10000 credits.");
        $this->output->info("The promise of an unusually high payment was almost too good to be true. But why was that box so important?");
        $this->output->info("The last thing you heard from the mysterious man was to 'Watch out for Yuuzhan Vongs.'");
        $this->output->info("You had a lot of questions. But the young man vanished as soon as you received the box.");
        $this->output->info("You were asking yourself all kinds of questions. But the most important thing was: 'Why is this box worth 10000 credits?'");
        $this->output->info("Could it be a trap? Does this 'Jedi Master' even exist?");
        $this->output->info("");
    }

    public function mainQuests($mainQuestsCompleted): void
    {
        if($mainQuestsCompleted==1)
        {

        }
        if($mainQuestsCompleted==2)
        {

        }
        if($mainQuestsCompleted==3)
        {
            $this->ending();
        }
    }

    private function ending(): void
    {
        $this->output->info("You finished your last quest and finished the game!");
        $this->output->info("Thank you for playing!");
        exit(0);
    }

}