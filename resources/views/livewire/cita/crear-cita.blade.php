<div>

    <div class="mb-6">
        <h2 class="text-lg font-medium text-on-surface dark:text-on-surface-dark">
            {{ $editando ? 'Editar Cita' : 'Crear Cita' }}
        </h2>
        <p class="mt-1 text-sm text-on-surface/70 dark:text-on-surface-dark/70">
            {{ $editando ? 'Modifica la información de la cita.' : 'Llena el formulario para registrar una nueva cita.' }}
        </p>
    </div>
    <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Fecha y Hora --}}
        <x-form.input wire:model="form.fecha_hora" name="form.fecha_hora" label="Fecha y Hora" type="datetime-local" />

        {{-- Paciente --}}
        <div x-data="{
            options: [
                @foreach ($pacientes as $p)
                {
                    value: '{{ $p->id }}',
                    label: '{{ $p->nombre }} {{ $p->apellido }} ',
                }, @endforeach
            ],
            isOpen: false,
            openedWithKeyboard: false,
            selectedOption: null,

            setSelectedOption(option) {
                this.selectedOption = option
                this.isOpen = false
                this.openedWithKeyboard = false

                this.$refs.hiddenTextField.value = option.value
                this.$refs.hiddenTextField.dispatchEvent(new Event('input')) // ← NECESARIO
            },

            highlightFirstMatchingOption(pressedKey) {
                const option = this.options.find((item) =>
                    item.label.toLowerCase().startsWith(pressedKey.toLowerCase()),
                )
                if (option) {
                    const index = this.options.indexOf(option)
                    const allOptions = document.querySelectorAll('.combobox-option')
                    if (allOptions[index]) {
                        allOptions[index].focus()
                    }
                }
            }
        }" x-init="@if($form->paciente_id)
        let opt = options.find(o => o.value == '{{ $form->paciente_id }}');
        if (opt) {
            selectedOption = opt;
            $refs.hiddenTextField.value = opt.value;
        }
        @endif" class="w-full max-w-xs flex flex-col gap-1"
            x-on:keydown="highlightFirstMatchingOption($event.key)"
            x-on:keydown.esc.window="isOpen = false; openedWithKeyboard = false">

            <label class="w-fit pl-0.5 text-sm text-on-surface dark:text-on-surface-dark">
                Paciente
            </label>

            <div class="relative">

                <!-- trigger button -->
                <button type="button" role="combobox"
                    class="inline-flex w-full items-center justify-between gap-2 whitespace-nowrap border-outline bg-surface-alt px-4 py-2 text-sm font-medium capitalize tracking-wide text-on-surface transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:text-on-surface-dark dark:focus-visible:outline-primary-dark rounded-radius border"
                    aria-haspopup="listbox" aria-controls="patientsList" x-on:click="isOpen = !isOpen"
                    x-on:keydown.down.prevent="openedWithKeyboard = true"
                    x-on:keydown.enter.prevent="openedWithKeyboard = true"
                    x-on:keydown.space.prevent="openedWithKeyboard = true"
                    x-bind:aria-expanded="isOpen || openedWithKeyboard">
                    <span class="text-sm font-normal"
                        x-text="selectedOption ? selectedOption.label : 'Seleccione un paciente'">
                    </span>

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path fill-rule="evenodd"
                            d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- hidden livewire binding -->
                <input type="text" name="form.paciente_id" x-ref="hiddenTextField" wire:model="form.paciente_id"
                    hidden />

                <!-- dropdown list -->
                <ul x-cloak x-show="isOpen || openedWithKeyboard" id="patientsList"
                    class="absolute z-10 left-0 top-11 flex max-h-44 w-full flex-col overflow-y-auto border-outline bg-surface-alt py-1.5 dark:border-outline-dark dark:bg-surface-dark-alt rounded-radius border"
                    role="listbox" x-on:click.outside="isOpen = false; openedWithKeyboard = false"
                    x-on:keydown.down.prevent="$focus.wrap().next()" x-on:keydown.up.prevent="$focus.wrap().previous()"
                    x-transition x-trap="openedWithKeyboard">
                    <template x-for="(item, index) in options" :key="item.value">
                        <li class="combobox-option inline-flex justify-between items-center gap-3
           bg-surface-alt px-4 py-2 text-sm text-on-surface hover:bg-surface-dark-alt/5
           hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/5
           focus-visible:text-on-surface-strong dark:bg-surface-dark-alt
           dark:text-on-surface-dark dark:hover:bg-surface-alt/5
           dark:hover:text-on-surface-dark-strong dark:focus-visible:bg-surface-alt/10
           dark:focus-visible:text-on-surface-dark-strong"
                            role="option" @click="setSelectedOption(item)" @keydown.enter="setSelectedOption(item)"
                            :id="'option-' + index" tabindex="0">
                            <!-- Label -->
                            <span :class="selectedOption == item ? 'font-bold' : ''" x-text="item.label"></span>

                            <!-- Checkmark (tamaño fijo) -->
                            <svg x-cloak x-show="selectedOption == item" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                class="w-4 h-4 flex-shrink-0" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </li>

                    </template>
                </ul>

            </div>
        </div>

        {{-- Doctor --}}
        <div x-data="{
            options: [
                @foreach ($doctores as $doctor)
                {
                    value: '{{ $doctor->id }}',
                    label: '{{ $doctor->nombre }} {{ $doctor->apellido }}',
                    email: '{{ $doctor->email }}',
                    img: '{{ asset('storage/' . $doctor->foto_perfil) }}',
                }, @endforeach
            ],
            isOpen: false,
            openedWithKeyboard: false,
            selectedOption: null,
            setSelectedOption(option) {
                this.selectedOption = option
                this.isOpen = false
                this.openedWithKeyboard = false

                this.$refs.hiddenTextField.value = option.value
                this.$refs.hiddenTextField.dispatchEvent(new Event('input')) // ← NECESARIO
            },
            highlightFirstMatchingOption(pressedKey) {
                const option = this.options.find((item) =>
                    item.label.toLowerCase().startsWith(pressedKey.toLowerCase())
                )
                if (option) {
                    const index = this.options.indexOf(option)
                    const allOptions = document.querySelectorAll('.combobox-option')
                    if (allOptions[index]) {
                        allOptions[index].focus()
                    }
                }
            },
        }" x-init="if ('{{ $form->doctor_id }}') {
            let opt = options.find(o => o.value == '{{ $form->doctor_id }}');
            if (opt) {
                selectedOption = opt;
                $refs.hiddenTextField.value = opt.value;
            }
        }" class="w-full max-w-xs flex flex-col gap-1"
            x-on:keydown="highlightFirstMatchingOption($event.key)"
            x-on:keydown.esc.window="isOpen = false; openedWithKeyboard = false">
            <label for="doctor" class="w-fit pl-0.5 text-sm text-on-surface dark:text-on-surface-dark">
                Doctor
            </label>

            <div class="relative">
                <!-- Botón que abre la lista -->
                <button type="button" role="combobox"
                    class="inline-flex w-full items-center justify-between gap-2 whitespace-nowrap border-outline bg-surface-alt px-4 py-2 text-sm font-medium capitalize tracking-wide text-on-surface dark:text-on-surface-dark rounded-radius border dark:border-outline-dark dark:bg-surface-dark-alt/50"
                    aria-haspopup="listbox" aria-controls="doctorList" x-on:click="isOpen = !isOpen"
                    x-on:keydown.down.prevent="openedWithKeyboard = true"
                    x-on:keydown.enter.prevent="openedWithKeyboard = true"
                    x-on:keydown.space.prevent="openedWithKeyboard = true"
                    x-bind:aria-label="selectedOption ? selectedOption.label : 'Seleccione un doctor'"
                    x-bind:aria-expanded="isOpen || openedWithKeyboard">
                    <span class="text-sm font-normal"
                        x-text="selectedOption ? selectedOption.label : 'Seleccione un doctor'"></span>

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path fill-rule="evenodd"
                            d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Campo REAL enviado al formulario -->
                <input id="doctor" name="form.doctor_id" type="text" x-ref="hiddenTextField"
                    wire:model="form.doctor_id" hidden>
                <!-- Lista desplegable -->
                <ul x-cloak x-show="isOpen || openedWithKeyboard" id="doctorList"
                    class="absolute z-10 left-0 top-11 flex max-h-44 w-full flex-col overflow-y-auto border-outline bg-surface-alt py-1.5 dark:border-outline-dark dark:bg-surface-dark-alt rounded-radius border"
                    role="listbox" x-on:click.outside="isOpen = false; openedWithKeyboard = false"
                    x-on:keydown.down.prevent="$focus.wrap().next()" x-on:keydown.up.prevent="$focus.wrap().previous()"
                    x-transition x-trap="openedWithKeyboard">
                    <template x-for="(item, index) in options" :key="item.value">
                        <li class="combobox-option inline-flex justify-between items-center gap-6 bg-surface-alt px-4 py-2 text-sm text-on-surface hover:bg-surface-dark-alt/5 hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/5 focus-visible:text-on-surface-strong focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-on-surface-dark dark:hover:bg-surface-alt/5 dark:hover:text-on-surface-dark-strong dark:focus-visible:bg-surface-alt/10 dark:focus-visible:text-on-surface-dark-strong"
                            role="option" @click="setSelectedOption(item)" @keydown.enter="setSelectedOption(item)"
                            :id="'option-' + index" tabindex="0">
                            <div class="flex items-center gap-2">
                                <img class="size-8 rounded-full object-cover" :src="item.img">
                                <div class="flex flex-col">
                                    <span :class="selectedOption == item ? 'font-bold' : ''"
                                        x-text="item.label"></span>
                                    <span class="text-xs opacity-70" x-text="item.email"></span>
                                </div>
                            </div>

                            <!-- Check -->
                            <svg x-cloak x-show="selectedOption == item" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2"
                                class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </li>
                    </template>
                </ul>
            </div>
        </div>

        {{-- Motivo --}}
        <x-form.input wire:model="form.motivo" name="form.motivo" label="Motivo" type="text" />

        {{-- Estado --}}
        {{-- Estado --}}
        <div x-data="{
            options: [
                { value: 'programada', label: 'Programada' },
                { value: 'confirmada', label: 'Confirmada' },
                { value: 'cancelada', label: 'Cancelada' },
                { value: 'atendida', label: 'Atendida' },
            ],
            isOpen: false,
            openedWithKeyboard: false,
            selectedOption: null,

            setSelectedOption(option) {
                this.selectedOption = option
                this.isOpen = false
                this.openedWithKeyboard = false

                this.$refs.hiddenTextField.value = option.value
                this.$refs.hiddenTextField.dispatchEvent(new Event('input')) // ← NECESARIO
            },

            highlightFirstMatchingOption(pressedKey) {
                const option = this.options.find((item) =>
                    item.label.toLowerCase().startsWith(pressedKey.toLowerCase()),
                )
                if (option) {
                    const index = this.options.indexOf(option)
                    const allOptions = document.querySelectorAll('.estado-option')
                    if (allOptions[index]) {
                        allOptions[index].focus()
                    }
                }
            }
        }" x-init="@if($form->estado)
        let opt = options.find(o => o.value == '{{ $form->estado }}');
        if (opt) {
            selectedOption = opt;
            $refs.hiddenTextField.value = opt.value;
        }
        @endif" class="w-full max-w-xs flex flex-col gap-1"
            x-on:keydown="highlightFirstMatchingOption($event.key)"
            x-on:keydown.esc.window="isOpen = false; openedWithKeyboard = false">

            <label class="w-fit pl-0.5 text-sm text-on-surface dark:text-on-surface-dark">
                Estado
            </label>

            <div class="relative">

                <!-- Botón principal -->
                <button type="button" role="combobox"
                    class="inline-flex w-full items-center justify-between gap-2 whitespace-nowrap border-outline bg-surface-alt px-4 py-2 text-sm font-medium capitalize tracking-wide text-on-surface transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:text-on-surface-dark dark:focus-visible:outline-primary-dark rounded-radius border"
                    aria-haspopup="listbox" aria-controls="estadoList" x-on:click="isOpen = !isOpen"
                    x-on:keydown.down.prevent="openedWithKeyboard = true"
                    x-on:keydown.enter.prevent="openedWithKeyboard = true"
                    x-on:keydown.space.prevent="openedWithKeyboard = true"
                    x-bind:aria-expanded="isOpen || openedWithKeyboard">
                    <span class="text-sm font-normal"
                        x-text="selectedOption ? selectedOption.label : 'Seleccione estado'">
                    </span>

                    <!-- Flecha -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path fill-rule="evenodd"
                            d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Hidden field real (Livewire) -->
                <input type="text" x-ref="hiddenTextField" wire:model="form.estado" name="form.estado" hidden />

                <!-- Lista desplegable -->
                <ul x-cloak x-show="isOpen || openedWithKeyboard" id="estadoList"
                    class="absolute z-10 left-0 top-11 flex max-h-44 w-full flex-col overflow-y-auto border-outline bg-surface-alt py-1.5 dark:border-outline-dark dark:bg-surface-dark-alt rounded-radius border"
                    role="listbox" x-on:click.outside="isOpen = false; openedWithKeyboard = false"
                    x-on:keydown.down.prevent="$focus.wrap().next()"
                    x-on:keydown.up.prevent="$focus.wrap().previous()" x-transition x-trap="openedWithKeyboard">

                    <template x-for="(item, index) in options" :key="item.value">
                        <li class="estado-option inline-flex justify-between items-center gap-3
                    bg-surface-alt px-4 py-2 text-sm text-on-surface hover:bg-surface-dark-alt/5
                    hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/5
                    focus-visible:text-on-surface-strong dark:bg-surface-dark-alt
                    dark:text-on-surface-dark dark:hover:bg-surface-alt/5
                    dark:hover:text-on-surface-dark-strong dark:focus-visible:bg-surface-alt/10
                    dark:focus-visible:text-on-surface-dark-strong"
                            role="option" @click="setSelectedOption(item)" @keydown.enter="setSelectedOption(item)"
                            :id="'estado-' + index" tabindex="0">
                            <!-- Label -->
                            <span :class="selectedOption == item ? 'font-bold' : ''" x-text="item.label"></span>

                            <!-- Palomita -->
                            <svg x-cloak x-show="selectedOption == item" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                class="w-4 h-4 flex-shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </li>
                    </template>

                </ul>

            </div>

            @error('form.estado')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror

        </div>


        {{-- Estado --}}


        {{-- Botones --}}
        <div class="space-x-4 md:col-span-2 flex items-center">
            <button type="submit"
                class="mt-2 rounded-radius bg-primary px-4 py-2 h-10 text-sm font-medium text-on-primary
                flex items-center hover:opacity-75 transition">
                <span wire:loading.remove>
                    {{ $editando ? 'Actualizar Cita' : 'Crear Cita' }}
                </span>
                <span wire:loading>
                    Procesando...
                </span>
            </button>

            <a href="{{ route('cita.index-cita') }}"
                class="mt-2 rounded-radius bg-secondary px-4 py-2 h-10 text-sm font-medium text-on-secondary
                flex items-center hover:opacity-75 transition">
                Cancelar
            </a>
        </div>
    </form>
</div>
