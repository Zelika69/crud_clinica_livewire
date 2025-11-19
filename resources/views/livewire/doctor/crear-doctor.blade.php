<div>
    <div class="mb-6">
        <h2 class="text-lg font-medium text-on-surface dark:text-on-surface-dark">
            {{ $editando ? 'Editar doctor' : 'Crear doctor' }}
        </h2>
        <p class="mt-1 text-sm text-on-surface/70 dark:text-on-surface-dark/70">
            {{ $editando ? 'Modifica la información del doctor.' : 'Llena el formulario para registrar un nuevo doctor.' }}
        </p>
    </div>
    <form wire:submit="save" class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Nombre --}}
        <x-form.input label="Nombre" name="form.nombre" type="text" wire:model="form.nombre" />
        {{-- Apellido --}}
        <x-form.input label="Apellido" name="form.apellido" type="text" wire:model="form.apellido" />
        {{-- Especialidad --}}
        <x-form.input label="Especialidad" name="form.especialidad" type="text" wire:model="form.especialidad" />
        {{-- Email --}}
        <x-form.input label="Email" name="form.email" type="email" wire:model="form.email" />
        {{-- Teléfono --}}
        <x-form.input label="Teléfono" name="form.telefono" type="text" wire:model="form.telefono" />
        {{-- Foto de Perfil --}}
        <div class="relative flex w-full max-w-sm flex-col gap-2 text-on-surface dark:text-on-surface-dark">

            <label for="fileInput" class="w-fit pl-0.5 text-sm">Foto de Perfil</label>

            {{-- Input --}}
            <input id="fileInput" type="file" wire:model="form.foto_perfil"
                class="w-full max-w-md overflow-clip rounded-radius border border-outline bg-surface-alt/50 text-sm
        file:mr-4 file:border-none file:bg-surface-alt file:px-4 file:py-2 file:font-medium
        file:text-on-surface-strong focus-visible:outline-2 focus-visible:outline-offset-2
        focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75
        dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:file:bg-surface-dark-alt
        dark:file:text-on-surface-dark-strong dark:focus-visible:outline-primary-dark" />

            <small class="pl-0.5">PNG, JPG, WebP - Max 5MB</small>

            {{-- PREVIEW DE IMAGEN --}}
            @if ($form->foto_perfil)
                {{-- NUEVA imagen seleccionada (temporal) --}}
                <div class="mt-2 w-32 h-32 rounded-lg overflow-hidden border border-outline dark:border-outline-dark">
                    <img src="{{ $form->foto_perfil->temporaryUrl() }}" class="w-full h-full object-cover" />
                </div>
            @elseif($editando && $doctor->foto_perfil)
                {{-- Imagen YA GUARDADA en edición --}}
                <div class="mt-2 w-32 h-32 rounded-lg overflow-hidden border border-outline dark:border-outline-dark">
                    <img src="{{ Storage::url($doctor->foto_perfil) }}" class="w-full h-full object-cover" />
                </div>
            @endif

            @error('form.foto_perfil')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>



        <div class="space-x-4 md:col-span-2 flex items-center">

            {{-- Botón Guardar --}}
            <button type="submit"
                class="mt-2 rounded-radius bg-primary px-4 py-2 h-10 text-sm font-medium text-on-primary
        flex items-center hover:opacity-75 transition">
                <span wire:loading.remove>
                    {{ $editando ? 'Actualizar doctor' : 'Crear doctor' }}
                </span>
                <span wire:loading>
                    Procesando...
                </span>
            </button>

            {{-- Botón Cancelar --}}
            <a href="{{ route('doctor.index-doctor') }}"
                class="mt-2 rounded-radius bg-secondary px-4 py-2 h-10 text-sm font-medium text-on-secondary
        flex items-center hover:opacity-75 transition">
                Cancelar
            </a>

        </div>

    </form>
</div>
