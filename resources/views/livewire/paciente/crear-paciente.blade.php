<div>
    <div class="mb-6">
        <h2 class="text-lg font-medium text-on-surface dark:text-on-surface-dark">
            {{ $editando ? 'Editar Paciente' : 'Crear Paciente' }}
        </h2>
        <p class="mt-1 text-sm text-on-surface/70 dark:text-on-surface-dark/70">
            {{ $editando ? 'Modifica la información del paciente.' : 'Llena el formulario para registrar un nuevo paciente.' }}
        </p>
    </div>
    <form wire:submit="save" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-form.input wire:model="form.nombre" name="form.nombre" label="Nombre" type="text"
            placeholder="Introduce tu nombre" />
        <x-form.input wire:model="form.apellido" name="form.apellido" label="Apellido" type="text"
            placeholder="Introduce tu apellido" />
        <x-form.input wire:model="form.email" name="form.email" label="Email" type="email"
            placeholder="correo@example.com" />
        <x-form.input wire:model="form.telefono" name="form.telefono" label="Teléfono" type="text"
            placeholder="Ej: 55 1234 5678" />
        <x-form.input wire:model="form.fecha_nacimiento" name="form.fecha_nacimiento" label="Fecha de Nacimiento"
            type="date" />
        <x-form.input wire:model="form.direccion" name="form.direccion" label="Dirección" type="text"
            placeholder="Calle #123, Ciudad" />
      <div class="space-x-4 md:col-span-2 flex items-center">

    {{-- Botón Guardar --}}
    <button type="submit"
        class="mt-2 rounded-radius bg-primary px-4 py-2 h-10 text-sm font-medium text-on-primary
        flex items-center hover:opacity-75 transition">
        <span wire:loading.remove>
            {{ $editando ? 'Actualizar Paciente' : 'Crear Paciente' }}
        </span>
        <span wire:loading>
            Procesando...
        </span>
    </button>

    {{-- Botón Cancelar --}}
    <a href="{{ route('paciente.index-paciente') }}"
        class="mt-2 rounded-radius bg-secondary px-4 py-2 h-10 text-sm font-medium text-on-secondary
        flex items-center hover:opacity-75 transition">
        Cancelar
    </a>

</div>


    </form>
</div>
