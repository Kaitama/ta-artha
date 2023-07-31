<?php

namespace App\Http\Livewire\Roster;

use App\Models\Roster;
use App\Models\User;
use Livewire\Component;

class Edit extends Component
{
    public User $user;

    public $teaching_hours = [];

    public $sum_hours = 0;

    public $rosters = [];

    protected function rules(): array
    {
        return [
            'rosters.*.*.day' => 'required',
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
        $rosters = $this->user->rosters()->get()->groupBy('day');

        foreach ($rosters as $day => $roster){
            foreach ($roster as $k => $schedule){
                $this->rosters[$day][$k] = [
                    'id'            => $schedule->id,
                    'day'           => $schedule->day,
                    'start_hour'    => $schedule->start_hour,
                    'end_hour'      => $schedule->end_hour,
                    'subject'       => $schedule->subject,
                ];
            }
        }

    }

    public function update()
    {
        $this->validate();
    dd($this->rosters);
        foreach ($this->rosters as $schedules) {
            foreach ($schedules as $k => $schedule){
                Roster::find($schedule['id'])->update([
                    'day'   => $schedule['day'],
                    'start_hour' => $schedule['start_hour'],
                    'end_hour'  => $schedule['end_hour'],
                    'subject'   => $schedule['subject'],
                ]);
            }
        }

        return to_route('rosters.index')->with('success', 'Roster berhasil diubah.');
    }

    public function render()
    {
        return view('livewire.roster.edit');
    }
}
