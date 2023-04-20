<?php

namespace Cora\Domain\Petrinet\Marking;

use Cora\Utils\Printer;
use Cora\Domain\Petrinet\Marking\MarkingInterface as IMarking;
use Cora\Domain\Petrinet\Marking\Tokens\TokenCountInterface as Tokens;
use Cora\Domain\Petrinet\PetrinetInterface as Petrinet;
use Cora\Domain\Petrinet\Place\Place;

use Ds\Map;
use Exception;

class MarkingBuilder implements MarkingBuilderInterface {
    protected $map;

    public function __construct() {
        $this->map = new Map();
        $this->printer = new Printer;
    }

    public function assign(Place $p, Tokens $t): void {
        $this->map->put($p, $t);
        $properties = get_object_vars($p);
        foreach ($properties as $id => $value){
            // $this->printer->terminalLog($id);
            // $this->printer->terminalLog($value);
        }
    }

    public function getMarking(Petrinet $net): IMarking {
        $places = $net->getPlaces();
        // foreach ($places as $singular)
        //     $this->printer->terminalLog($singular);
        $assignedPlaces = $this->map->keys();
        // foreach ($assignedPlaces as $singular)
        //     $this->printer->terminalLog($singular);
        foreach($assignedPlaces as $place) {
            if (!$places->contains($place))
                throw new Exception("Tokens assigned to invalid place");
        }
        $marking = new Marking($this->map);
        return $marking;
    }
}
