<?php

namespace App\Http\Livewire\Roster;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Create extends Component
{
    public User $user;

    public $teaching_hours = [];

    public $sum_hours = 0;

    public $rosters = [];

    protected function rules(): array
    {
        return [
            'rosters.*.*.start_hour' => 'required',
            'rosters.*.*.end_hour' => 'required',
            'rosters.*.*.subject' => 'required',
        ];
    }

    protected $validationAttributes = [
        'rosters.*.*.start_hour'    => 'jam mulai',
        'rosters.*.*.end_hour'    => 'jam selesai',
        'rosters.*.*.subject'    => 'mata pelajaran',
    ];

    public function mount()
    {
        if (!$this->user->hasRole('guru-honor')) return abort(404);

        $this->teaching_hours = $this->user->teachinghours()->orderBy('day')->get(['day', 'hours'])->toArray();
        $this->sum_hours = $this->user->teachinghours()->sum('hours');
        foreach ($this->user->teachinghours as $key => $th){
            for ($i = 0; $i < $th->hours; $i++){
                $this->rosters[$th->day][$i] = [
                    'start_hour'    => null,
                    'end_hour'      => null,
                    'subject'       => null,
                ];
            }
        }
    }

    public function store()
    {
        $this->validate();
        $data = array();
        foreach ($this->rosters as $day => $roster) {
            foreach ($roster as $i => $ros) {
                $data[] = [
                    'start_hour'=> $ros['start_hour'],
                    'end_hour'  => $ros['end_hour'],
                    'subject'   => $ros['subject'],
                    'day'       => $day,
                ];
            }
        }
        $this->user->rosters()->createMany($data);
        return to_route('rosters.index')->with('success', 'Roster berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.roster.create');
    }
}
