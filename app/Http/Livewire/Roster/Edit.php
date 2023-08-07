<?php

namespace App\Http\Livewire\Roster;

use App\Models\Roster;
use App\Models\User;
use Livewire\Component;

class Edit extends Component
{
    public $user;

    public $tahun_ajaran;

    public $semester;

    public $teaching_hours = [];

    public $sum_hours = 0;

    public $rosters = [];

    public $schedule;

    protected function rules(): array
    {
        return [
            'rosters' => 'required|array|min:1',
            'rosters.*.day' => 'required',
            'rosters.*.start_hour' => 'required',
            'rosters.*.end_hour' => 'required',
            'rosters.*.subject' => 'required',
        ];
    }

    protected $validationAttributes = [
        'rosters'   => 'roster',
        'rosters.*.day' => 'hari',
        'rosters.*.start_hour'    => 'jam mulai',
        'rosters.*.end_hour'    => 'jam selesai',
        'rosters.*.subject'    => 'mata pelajaran',
    ];

    public function mount(User $user, $years, $semester)
    {
        if (!$user->hasRole('guru-honor')) return abort(404);

        $this->user = $user;

        $this->tahun_ajaran = str_replace('-', '/', $years);

        $this->semester = $semester;

        $this->rosters = $user->rosters()
            ->where('years', str_replace('-', '/', $years))
            ->where('semester', $semester)
            ->get(['day', 'start_hour', 'end_hour', 'subject'])
            ->toArray();

        $this->schedule = count($this->rosters);
    }

    public function update()
    {
        $this->validate();

        $summary = [];
        foreach ($this->rosters as $key => $roster) {
            $this->rosters[$key]['years'] = $this->tahun_ajaran;
            $this->rosters[$key]['semester'] = $this->semester;
            if(isset($summary[$roster['day']])) {
                $summary[$roster['day']] += 1;
            } else {
                $summary[$roster['day']] = 1;
            }
        }
        $teaching_hours = [];
        foreach ($summary as $key => $sum) {
            $teaching_hours[] = [
                'day'   => $key,
                'hours' => $sum,
            ];
        }
        $this->user->teachinghours()->delete();
        $this->user->teachinghours()->createMany($teaching_hours);
        $this->user->rosters()->where('years', $this->tahun_ajaran)->where('semester', $this->semester)->delete();
        $this->user->rosters()->createMany($this->rosters);


        return to_route('rosters.index')->with('success', 'Roster berhasil diubah.');
    }

    public function addSchedule()
    {
        $this->schedule += 1;
    }

    public function removeSchedule($index)
    {
        unset($this->rosters[$index]);
        $this->schedule -= 1;

    }

    public function render()
    {
        return view('livewire.roster.edit');
    }
}
