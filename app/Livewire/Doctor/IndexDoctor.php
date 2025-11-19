<?php

namespace App\Livewire\Doctor;
use App\Models\Doctor;

use Livewire\Component;

class IndexDoctor extends Component
{
    public function delete(Doctor $doctor)
    {
        $doctor->delete();
        session()->flash('success', 'Doctor eliminado correctamente.');
        $this->redirectRoute('doctor.index-doctor', navigate: true);

    }

    public function render()
    {
        return view('livewire.doctor.index-doctor',
    [
        'doctores' => Doctor::latest()->paginate(10),

    ]);
    }
}
