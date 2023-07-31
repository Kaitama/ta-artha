<?php

namespace App\Http\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Roster extends Component
{
    public function render()
    {
        $rosters = Auth::user()->rosters()->orderBy('day')->get();
        $days = (new \App\Models\Roster)->days;
        return view('livewire.components.roster', compact('rosters', 'days'));
    }
}
