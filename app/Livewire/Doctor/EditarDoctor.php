<?php

namespace App\Livewire\Doctor;

use App\Livewire\Forms\DoctorForm;
use App\Models\Doctor;
use Livewire\Component;
use Livewire\WithFileUploads;


class EditarDoctor extends Component
{
    use WithFileUploads;
    public DoctorForm $form;
    public Doctor $doctor;


    public function mount(Doctor $doctor)
    {
        $this->doctor = $doctor;
        $this->form->setDoctor($doctor);
    }

    public function save()
    {
        $this->form->update();
        session()->flash('success', 'Doctor editado correctamente!.');
        $this->redirectRoute('doctor.index-doctor', navigate: true);
    }

    public function render()
    {
        return view('livewire.doctor.crear-doctor',
    [
        'editando' => true,
        'doctor' => $this->doctor
    ]);
    }
}
