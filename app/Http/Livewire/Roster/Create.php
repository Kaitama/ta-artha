<?php

namespace App\Http\Livewire\Roster;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Create extends Component
{
    public User $user;

    public $teaching_hours = [];

    public $sum_hours = 0;

    public $schedule = 1;

    public $rosters = [];

    public $tahun_ajaran;

    public $semester;

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

    public function mount($years, $semester)
    {
        if (!$this->user->hasRole('guru-honor')) return abort(404);
        $this->tahun_ajaran = str_replace('-', '/', $years);
        $this->semester = $semester;
    }

    public function store()
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

        $latest = $this->user->rosters()->orderBy('years')->first();
        if ($latest) {
            $num_years = str_replace('/', '', $latest->years);
            $now_years = str_replace('/', '', $this->tahun_ajaran);
            if ($now_years >= $num_years){
                $this->user->teachinghours()->delete();
                $this->user->teachinghours()->createMany($teaching_hours);
            }
        } else {
            $this->user->teachinghours()->createMany($teaching_hours);
        }

        $this->user->rosters()->createMany($this->rosters);
        return to_route('rosters.index')->with('success', 'Roster berhasil disimpan.');
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
        return view('livewire.roster.create');
    }
}
