<?php
declare(strict_types=1);

require('Card.php');
require('Player.php');
require('Dealer.php');
require('Blackjack.php');
require('Deck.php');
require('Suit.php');

session_start();
if(!isset($_SESSION['blackjack']))
{
    $_SESSION['blackjack'] = new Blackjack();
}

$blackjack = $_SESSION['blackjack'];
$player = $blackjack->getPlayer();
$dealer = $blackjack->getDealer();
$deck = $blackjack->getDeck();
$score = 0;
$palyerScore = $player->getScore();
$dealerScore = $dealer->getScore();


if(!isset($_POST['button'])){
    echo "Start the game!";
}else if($_POST['button'] === 'hit'){
        $player->hit($deck);
        
        if($player->hasLost())
        {
            echo "You loss!";
        }else if($palyerScore == 21){
            echo "You nature win!";
        }else if($palyerScore < 21 && $palyerScore < $dealerScore){
            echo "You loss!";
        }else if($palyerScore == $dealerScore){
            echo "It is Draw! You win!";
        }else{
            echo "You win!";
        }
        

    } else if($_POST['button'] === 'stand'){
        $dealer->hit($deck);

        if($dealer->hasLost())
        {
            echo "You win!";
        }else if($dealerScore == 21){
            echo "Dealer nature wins! You loss!";
        }else if($dealerScore < 21 && $dealerScore < $palyerScore){
            echo "You win!";
        }else if($dealerScore == $palyerScore){
            echo "It is Draw! You win!";
        }else{
            echo "You loss!";
        }
        
    }else if($_POST['button'] === 'surrender'){
        $player->hasLost();
        echo "You loss!";
        
    }else if($_POST['button'] === 'new'){
    session_unset();
    $_SESSION['blackjack'] = new Blackjack();
    $blackjack = $_SESSION['blackjack'];
    $player = $blackjack->getPlayer();
    $dealer = $blackjack->getDealer();
    $deck = $blackjack->getDeck();
    $score = 0;    
    $palyerScore = $player->getScore();
    $dealerScore = $dealer->getScore();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackjack-php</title>
</head>
<body>
    <div class="container">
        <h1>Blackjack</h1>
        <form method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <h2>Player: 
                        <?php
                             foreach($player->getCards() as $card){
                                echo $card->getUnicodeCharacter(true);
                            }
                        ?>
                    </h2>
                    <p class="float-right" style="font-size: 30px;"><strong>Score: <?php echo $palyerScore; ?></strong></p>
                </div>
                <div class="form-group col-md-6">
                    <h2>Dealer: 
                        <?php 
                            foreach($dealer->getCards() as $card){
                                echo $card->getUnicodeCharacter(true);
                            } 
                        ?>
                    </h2>
                    <p class="float-left" style="font-size: 30px;"><strong>Score: <?php echo $dealerScore; ?></strong></p>
                </div>
            </div>
                    <button type="submit" name="button" value="hit" class="btn btn-primary">Hit</button>
                    <button type="submit" name="button" value="stand" class="btn btn-primary">Stand</button>
                    <button type="submit" name="button" value="surrender" class="btn btn-primary">surrender</button>
                    <button type="submit" name="button" value="new" class="btn btn-primary">New Game</button>
        </form>
    </div>
</body>
</html>