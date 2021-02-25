<?php

declare(strict_types=1);

namespace Hyperdrive\Panels;

use Hyperdrive\Contracts\PanelContract;
use Hyperdrive\Player\Player;
use Symfony\Component\Config\Definition\Exception\Exception;

class MapPanel extends BasePanel implements PanelContract
{
    public function __construct(protected Player $player)
    {
        parent::__construct();
    }

    public function showMap(): void
    {
        try {
            $this->cli->columns($this->player->getMap(), 6);
        } catch (Exception $exception) {
            $this->showException($exception);
            $this->selectionSection();
            $this->cli->columns($this->player->getMap(), 6);
        }
    }

    /**
     * @throws Exception
     */
    public function selectionSection(): void
    {
        $this->cli->info("Do you want to buy access to the map?");
        $result = $this->cli->radio("Select option", ["Yes", "No"])->prompt();

        if ($result === "No") {
            throw new Exception("The map purchase has been canceled");
        }

        $this->player->buyAccessToTheMap();
    }
}
