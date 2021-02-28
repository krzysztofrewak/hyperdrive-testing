<?php

declare(strict_types=1);

namespace Hyperdrive\Story;

use Hyperdrive\Output\OutputContract;
use JetBrains\PhpStorm\NoReturn;

class Story
{

    protected OutputContract $output;

    public function __construct(OutputContract $output)
    {
        $this->output = $output;
    }

    public function intro(): void
    {
        $this->output->write("");
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
        $this->output->write("");

    }

    public function mainQuests($mainQuestsCompleted): void
    {
        if ($mainQuestsCompleted == 1) {
            $this->output->write("");
            $this->output->info("You arrived at your destination.");
            $this->output->info("Unsure of who to look for, you were walking around looking for anything or anyone that can point you to Master Horn.");
            $this->output->info("After founding nothing you decided it was time to leave. You entered your ship and to your surprise you saw a young man waiting for you in your own ship.");
            $this->output->info("You felt that he was the one you were looking for.");
            $this->output->info("'I believe you got something for me.'");
            $this->output->info("You handed over the box and the man has begun to examine it from every possible angle.");
            $this->output->info("After a while you reluctantly asked for your payment.");
            $this->output->info("'Yes, yes, of course. Here you go.'");
            $this->output->info("He gave you the payment and he continued the study of his box.");
            $this->output->info("You were curious and did not want to disturb the man. After a while you wanted to ask him to get off your ship but you were interupted by a flash of light coming from the box.");
            $this->output->info("The man kept staring at the blinding light and you could see fear on his face. After a few minutes the light faded away as he turned to you and said:");
            $this->output->info("'Listen, I need your help. I need you to get me somewhere. I'll pay you double the amount for your previous delivery. But I need to get there quick.'");
            $this->output->info("You again felt that weird feeling that didn't want you to decline.");
            $this->output->info("You agreed to his offer.");
            $this->output->info("'Thank you' - he said.");
            $this->output->info("He gave you a hand and said 'Corran Horn, nice to meet you.'");
        }
        if ($mainQuestsCompleted == 2) {
            $this->output->write("");
            $this->output->info("You arrived at your destination.");
            $this->output->info("You were about to exit your cockpit and talk to Master Horn but when you went to meet him you realized he was gone.");
            $this->output->info("All that was left of him was your payment and the mystery of not only him, but his box as well.");
            $this->output->info("For hours you wondered what was inside that box, what did he saw and why he wanted you to get him here.");
            $this->output->info("What was so important?");
            $this->output->info("Who knows. Maybe you'll find out one day...");
            $this->ending();
        }
    }

    #[NoReturn] private function ending(): void
    {
        $this->output->info("You finished the last main quest and finished the game!");
        $this->output->info("Thank you for playing!");
        exit(0);
    }

}