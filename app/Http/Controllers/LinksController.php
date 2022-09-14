<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Links;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;

use \Exception;
use App\Models\History;

use Carbon\Carbon;

class LinksController extends Controller
{
    public function index($link)
    {
        $link = Links::where('link', $link)
            ->first();
        if (Carbon::parse($link->updated_at)->diffInDays(Carbon::now()) >= 7) {
            $link->active = false;
            $link->save();
        }
        if ($link->active == 1) {
            return view('rand.dashboard', [
                'url' => url('rand/' . $link->id),
                'link' => $link->link
            ]);
        } else  throw new Exception('Посилання не дійсне');
    }

    public function render($id)
    {
        $link = Links::find($id);
        do {
            $new_link = rand(1000, 10000);
        } while (Links::where('link', '=', $new_link)->count() != 0);
        $link->link = $new_link;
        $link->save();
        return redirect('rand/' . $link->link);
    }

    public function disable($id)
    {
        $link = Links::find($id);
        $link->active = false;
        $link->save();
        return redirect('rand/' . $link->link);
    }
    public function lucky($id)
    {
        $rand = rand(1, 1000);
        if (($rand % 2) == 0) {
            if ($rand > 900) {
                $massege = 'Win rand > 900 and rand = ' . $rand;
                $percent = 70;
            } elseif ($rand > 600) {
                $massege = 'Win rand > 600 and rand = ' . $rand;
                $percent = 50;
            } elseif ($rand > 300) {
                $massege = 'Win rand > 300 and rand = ' . $rand;
                $percent = 30;
            } elseif ($rand < 300) {
                $massege = 'Win rand > 300 and rand = ' . $rand;
                $percent = 10;
            }
            //$massege = 'Win';
            $result = $rand * ($percent / 100);
            $massege .= ' result persent = ' . $result;
        } else  $massege = 'Lose rand = ' . $rand;
        History::create([
            'link_id' => $id,
            'result' => $massege
        ]);
        return [
            'massege' => $massege
        ];
    }

    public function history($id)
    {
        //dd($id);
      //  dd(History::where('link_id', $id)->get());
      return History::where('link_id', $id)
      ->latest('updated_at')
      ->limit(3)
      ->get()
      ->toJson();
    }
}