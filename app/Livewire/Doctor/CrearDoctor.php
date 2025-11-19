<?php

namespace App\Livewire\Doctor;

use App\Livewire\Forms\DoctorForm;
use Livewire\Component;
use Livewire\WithFileUploads;

class CrearDoctor extends Component
{
    use WithFileUploads;
    public DoctorForm $form;
    
    public function save()
    {
        $this->form->store();
        session()->flash('success', 'El doctor se registró correctamente.');
        return redirect()->route('doctor.index-doctor');
    }

    public function render()
    {
        return view('livewire.doctor.crear-doctor',
    [
        'editando' => false
    ]);
    }
}
