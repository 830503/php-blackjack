<?php 
declare(strict_types=1);

class Player 
{
    private $cards = [];
    private bool $lost = false;

    public function __construct(Deck $deck)
    {
        array_push($this->cards, $deck->drawCard());
        array_push($this->cards, $deck->drawCard());
    }

    public function hit(Deck $deck)
    {
        if($this->getScore() > 21){
            $this->hasLost();
        }
    }

    public function surrender()
    {
        $this->hasLost();
    }

    public function getScore()
    {
        $score = 0;
        foreach($this->cards as $card){
            $score += $card->getValue();
        }
        return $score;
    }

    public function hasLost()
    {
         $this->lost = true;
    }
    
    public function setLost($lost)
    {
        return $this->lost;
    }

    public function getCards()
    {
        return $this->cards;
    }
}

?>
