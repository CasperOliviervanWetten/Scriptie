<?php

namespace Cora\Converter;

use Cora\Domain\Petrinet\PetrinetInterface as Petrinet;
use Cora\Domain\Petrinet\Marking\MarkingInterface as Marking;
use Cora\Domain\Petrinet\Marking\Tokens\IntegerTokenCount;

class PetrinetToDot extends Converter {
    protected $petrinet;
    protected $marking;

    public function __construct(Petrinet $net, ?Marking $marking=NULL) {
        $this->petrinet = $net;
        $this->marking  = $marking;
    }

    public function convert() {
        $placeStrings   = $this->placesToArray();
        $transStrings   = $this->transitionsToArray();
        $flowStrings    = $this->flowsToArray();
        $markingStrings = $this->markingToArray();
        $options = [
            'graph [fontname="monospace", fontsize="14"]',
            'node [fontname="monospace", fontsize="14"]',
            'edge [fontname="monospace", fontsize="10"]'
        ];
        $s = "digraph G {";
        $s .= "\n\t";
        $s .= implode("\n\t", $options);
        $s .= "\n\t";
        $s .= implode("\n\t", $placeStrings);
        $s .= "\n\t";
        $s .= implode("\n\t", $transStrings);
        $s .= "\n\t";
        $s .= implode("\n\t", $flowStrings);
        if (!is_null($this->marking)) {
            $s .= "\n\t";
            $s .= implode("\n\t", $markingStrings);
        }
        $s .= "\n";
        $s .= "}";
        return $s;
    }

    protected function placesToArray() {
        $places = $this->petrinet->getPlaces();
        $ids = [];
        $names = [];
        foreach ($places as $place) {
            $id = $place->getID();
            $ids[] = $id;
            $name = $place->getLabel() ?? $id;
            $id .= ' [xlabel="' . $name . '"]';
            $names[] = $id;
        }
        //Transform $ids into a string with ', ' in between the array values, and add the format options of the places 
        $ids = implode(", ", $ids);
        $ids .= '[shape="ellipse", width=0.75, height=0.75, label=""]';
        return array_merge([$ids],$names);
    }

    protected function transitionsToArray() {
        $transitions = $this->petrinet->getTransitions();
        $names = [];
        foreach ($transitions as $transition) { 
            $name = $transition->getLabel() ?? $transition->getID();
            $names[] = $name;
        }
        $optionsStr = '[shape="box", style="filled", fillcolor="#2ECC71", width=0.75, height=0.75]';
        $t = sprintf("%s %s;", implode(", ", $names), $optionsStr);
        return [$t];
    }

    protected function flowsToArray() {
        $flows = $this->petrinet->getFlows();
        $res = [];
        foreach($flows as $flow => $weight) {
            $row = sprintf("%s -> %s", $flow->getFrom(), $flow->getTo());
            if ($weight > 1)
                $row .= sprintf("[label=%d]", $weight);
            $row .= ";";
            array_push($res, $row);
        }
        return $res;
    }

    protected function markingToArray() {
        $result = [];
        if (is_null($this->marking))
            return $result;
        foreach($this->marking as $place => $tokens) {
            if ($tokens instanceof IntegerTokenCount &&
                $tokens->getValue() <= 0)
                continue;
            $l = sprintf('%s [label="%s"];', $place, $tokens);
            array_push($result, $l);
        }
        return $result;
    }
}
