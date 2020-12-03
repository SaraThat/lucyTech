<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator; 
use App\Rules\ValidAmount;
use App\Models\Player;
use App\Models\BalanceTranscation;
use App\Models\Bet;
use App\Models\BetSelection;

class ApisController extends Controller
{
    

    public function store(Request $request)
    {

        $errors = [];

        // I tried normal validation language file, but i couldn't get the result as you format

        // $validator = Validator::make($request->all(), [
        //     'stake_amount' =>  "numeric|max:10000|min:0.3",
        //     'selections' => ["array","min:1","max:20"],
        //     'selections.*.id' => "distinct",
        //     'selections.*.odds' => "numeric|min:1|max:10000",
        // ]);


        // if ($validator->fails()) {

        //    return $validator->errors();

        // }

        if($request->input('stake_amount') > 10000)
        {
            $error = new \StdClass();
            $error->code = 3;
            $error->message = 'Maximum stake amount is 10000';

            array_push($errors,$error);
        }


        if($request->input('stake_amount') < 0.3)
        {
            $error = new \StdClass();
            $error->code = 2;
            $error->message = 'Minimum stake amount is 0.3';
            array_push($errors,$error);
        }


        if(count($request->input('selections')) < 0)
        {
            $error = new \StdClass();
            $error->code = 4;
            $error->message = 'Minimum number of selections is 1';
            array_push($errors,$error);

        }


        if(count($request->input('selections')) > 20)
        {
            $error = new \StdClass();
            $error->code = 5;
            $error->message = 'Maximum number of selections is 20';
            array_push($errors,$error);

        }


        $selection_erros = [];
        if($request->input('selections'))
        {
            $selections = $request->input('selections');

            foreach($selections  as $selection)
            {
                $errorObj = new \StdClass();
                $error = new \StdClass();

                if($selection["odds"]< 0.3)
                {

                    $error->code = 2;
                    $error->message = 'Minimum stake amount is 0.3';
                    $errorObj->id = $selection["id"];
                    $errorObj->errors = $error;
                     array_push($selection_erros,$errorObj);
                }



            }
        }



        $selectionsCollection = collect($request->input('selections'));
        $sum = $request->input('stake_amount') * $selectionsCollection->pluck('odds')->sum();


        if($sum > 20000)
        {
            array_push($errors, ["code" => 9, "message" => "Maximum win amount is 20000"]);
        }



       if(empty($errors))
       {
           $player = Player::find($request->input('player_id'));


           if($player->balance < $sum)
           {
                $error = new \StdClass();
                $error->code = 11;
                $error->message = 'Insufficient balance';
                array_push($errors,$error);
           }

           if(!$player)
           {
               Player::create([]);             
           }else{

            $balanceTranscation = new BalanceTranscation;
            $balanceTranscation->amount = $sum;
            $balanceTranscation->amount_before = $player->balance;

            $player->balance -= $sum;
            $player->balanceTranscation()->save($balanceTranscation);

            $player->save();
           }


           $bet = Bet::create([
            'stake_amount' => $request->input('stake_amount')
            ]);

           foreach($selections as $selection)
           {

                $betSelection = new BetSelection;

                $betSelection->selection_id	= $selection["id"]	;
                $betSelection->odds	 = $selection["odds"];

                $bet->betSelection()->save($betSelection);
           }
            return $player;
       }else{
        return  json_encode(["errors"=>$errors,"selections" =>  $selection_erros]);
       }
    }


}
