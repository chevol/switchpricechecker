<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\US_Game;

class USGameController extends Controller
{
    public function getGames()
    {
      $games = US_Game::orderBy('title')->paginate(20);
      return view('allGames')->with('games',$games);
    }
}
