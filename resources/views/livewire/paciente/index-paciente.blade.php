<div class="space-y-5">

    <!-- Notifications -->
    <div x-data="{
        notifications: [],
        displayDuration: 6000,
        soundEffect: true,

        addNotification({ variant = 'info', sender = null, title = null, message = null }) {
            const id = Date.now()
            const notification = { id, variant, sender, title, message }

            // Keep only the most recent 20 notifications
            if (this.notifications.length >= 20) {
                this.notifications.splice(0, this.notifications.length - 19)
            }

            // Add the new notification to the notifications stack
            this.notifications.push(notification)

            if (this.soundEffect) {
                // Play the notification sound
                const notificationSound = new Audio('https://res.cloudinary.com/ds8pgw1pf/video/upload/v1728571480/penguinui/component-assets/sounds/ding.mp3')
                notificationSound.play().catch((error) => {
                    console.error('Error playing the sound:', error)
                })
            }
        },
        removeNotification(id) {
            setTimeout(() => {
                this.notifications = this.notifications.filter(
                    (notification) => notification.id !== id,
                )
            }, 400);
        },
        init() {
            // mensajes tipo Livewire/Laravel
            const sessionSuccess = '{{ session('success') }}'
            const sessionInfo = '{{ session('info') }}'
            const sessionError = '{{ session('error') }}'
            const sessionWarning = '{{ session('warning') }}'

            if (sessionSuccess) {
                this.addNotification({
                    variant: 'success',
                    title: 'Éxito',
                    message: sessionSuccess
                })
            }

            if (sessionInfo) {
                this.addNotification({
                    variant: 'info',
                    title: 'Información',
                    message: sessionInfo
                })
            }

            if (sessionError) {
                this.addNotification({
                    variant: 'error',
                    title: 'Error',
                    message: sessionError
                })
            }

            if (sessionWarning) {
                this.addNotification({
                    variant: 'warning',
                    title: 'Advertencia',
                    message: sessionWarning
                })
            }
        }
    }" x-on:notify.window="addNotification($event.detail)">

        <div x-on:mouseenter="$dispatch('pause-auto-dismiss')" x-on:mouseleave="$dispatch('resume-auto-dismiss')"
            class="group pointer-events-none fixed inset-x-8 top-0 z-99 flex max-w-full flex-col gap-2 bg-transparent px-6 py-6 md:bottom-0 md:left-[unset] md:right-0 md:top-[unset] md:max-w-sm">
            <template x-for="(notification, index) in notifications" x-bind:key="notification.id">
                <!-- root div holds all of the notifications  -->
                <div>
                    <!-- Info Notification  -->
                    <template x-if="notification.variant === 'info'">
                        <div x-data="{ isVisible: false, timeout: null }" x-cloak x-show="isVisible"
                            class="pointer-events-auto relative rounded-radius border border-info bg-surface text-on-surface dark:bg-surface-dark dark:text-on-surface-dark"
                            role="alert" x-on:pause-auto-dismiss.window="clearTimeout(timeout)"
                            x-on:resume-auto-dismiss.window=" timeout = setTimeout(() => {(isVisible = false), removeNotification(notification.id) }, displayDuration)"
                            x-init="$nextTick(() => { isVisible = true }), (timeout = setTimeout(() => { isVisible = false, removeNotification(notification.id) }, displayDuration))" x-transition:enter="transition duration-300 ease-out"
                            x-transition:enter-end="translate-y-0" x-transition:enter-start="translate-y-8"
                            x-transition:leave="transition duration-300 ease-in"
                            x-transition:leave-end="-translate-x-24 opacity-0 md:translate-x-24"
                            x-transition:leave-start="translate-x-0 opacity-100">
                            <div
                                class="flex w-full items-center gap-2.5 bg-info/10 rounded-radius p-4 transition-all duration-300">

                                <!-- Icon -->
                                <div class="rounded-full bg-info/15 p-0.5 text-info" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="size-5" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>

                                <!-- Title & Message -->
                                <div class="flex flex-col gap-2">
                                    <h3 x-cloak x-show="notification.title" class="text-sm font-semibold text-info"
                                        x-text="notification.title"></h3>
                                    <p x-cloak x-show="notification.message" class="text-pretty text-sm"
                                        x-text="notification.message"></p>
                                </div>

                                <!--Dismiss Button -->
                                <button type="button" class="ml-auto" aria-label="dismiss notification"
                                    x-on:click="(isVisible = false), removeNotification(notification.id)">
                                    <svg xmlns="http://www.w3.org/2000/svg viewBox="0 0 24 24 stroke="currentColor"
                                        fill="none" stroke-width="2" class="size-5 shrink-0" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </template>

                    <!-- Success Notification  -->
                    <template x-if="notification.variant === 'success'">
                        <div x-data="{ isVisible: false, timeout: null }" x-cloak x-show="isVisible"
                            class="pointer-events-auto relative rounded-radius border border-success bg-surface text-on-surface dark:bg-surface-dark dark:text-on-surface-dark"
                            role="alert" x-on:pause-auto-dismiss.window="clearTimeout(timeout)"
                            x-on:resume-auto-dismiss.window=" timeout = setTimeout(() => {(isVisible = false), removeNotification(notification.id) }, displayDuration)"
                            x-init="$nextTick(() => { isVisible = true }), (timeout = setTimeout(() => { isVisible = false, removeNotification(notification.id) }, displayDuration))" x-transition:enter="transition duration-300 ease-out"
                            x-transition:enter-end="translate-y-0" x-transition:enter-start="translate-y-8"
                            x-transition:leave="transition duration-300 ease-in"
                            x-transition:leave-end="-translate-x-24 opacity-0 md:translate-x-24"
                            x-transition:leave-start="translate-x-0 opacity-100">
                            <div
                                class="flex w-full items-center gap-2.5 bg-success/10 rounded-radius p-4 transition-all duration-300">

                                <!-- Icon -->
                                <div class="rounded-full bg-success/15 p-0.5 text-success" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="size-5" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>

                                <!-- Title & Message -->
                                <div class="flex flex-col gap-2">
                                    <h3 x-cloak x-show="notification.title" class="text-sm font-semibold text-success"
                                        x-text="notification.title"></h3>
                                    <p x-cloak x-show="notification.message" class="text-pretty text-sm"
                                        x-text="notification.message"></p>
                                </div>

                                <!--Dismiss Button -->
                                <button type="button" class="ml-auto" aria-label="dismiss notification"
                                    x-on:click="(isVisible = false), removeNotification(notification.id)">
                                    <svg xmlns="http://www.w3.org/2000/svg viewBox="0 0 24 24 stroke="currentColor"
                                        fill="none" stroke-width="2" class="size-5 shrink-0" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-on-surface dark:text-on-surface-dark">Pacientes</h1>
            <p class="mt-2 text-on-surface/70 dark:text-on-surface-dark/70">Gestiona todos tus Pacientes</p>
        </div>
    </div>

    <!-- primary Floating Button -->
<div class="flex items-center justify-left gap-2">
<span class="">Crear</span>
        <button onclick="window.location='{{ route('paciente.crear-paciente') }}'" aria-label="create something epic" type="button"
        class="inline-flex justify-center items-center aspect-square whitespace-nowrap rounded-full border border-primary bg-primary p-2 text-base font-medium tracking-wide text-on-primary transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:border-primary-dark dark:bg-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
            class="size-7 fill-on-primary dark:fill-on-primary-dark" fill="currentColor">
            <path fill-rule="evenodd"
                d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
                clip-rule="evenodd" />
        </svg>
    </button>
</div>
    <div class="overflow-hidden w-full overflow-x-auto rounded-radius border border-outline dark:border-outline-dark">
        <table class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
            <thead
                class="border-b border-outline bg-surface-alt text-sm text-on-surface-strong dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark-strong">
                <tr>
                    <th scope="col" class="p-4">Nombre</th>
                    <th scope="col" class="p-4">Apellido</th>
                    <th scope="col" class="p-4">Email</th>
                    <th scope="col" class="p-4">Telefono</th>
                    <th scope="col" class="p-4">Fecha de Nacimiento</th>
                    <th scope="col" class="p-4">Direccion</th>
                    <th scope="col" class="p-4">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline dark:divide-outline-dark">
                @forelse ($pacientes as $paciente)
                    <tr>
                        <td class="p-4">{{ $paciente->nombre }}</td>
                        <td class="p-4">{{ $paciente->apellido }}</td>
                        <td class="p-4">{{ $paciente->email }}</td>
                        <td class="p-4">{{ $paciente->telefono }}</td>
                        <td class="p-4">{{ $paciente->fecha_nacimiento }}</td>
                        <td class="p-4">{{ $paciente->direccion }}</td>
                        <td class="p-4">
                            <button wire:navigate
                                onclick="window.location='{{ route('paciente.editar-paciente', $paciente) }}'"
                                type="button"
                                class="inline-flex justify-center items-center gap-2 whitespace-nowrap rounded-radius bg-primary border border-primary dark:border-primary-dark px-4 py-2 text-base font-medium tracking-wide text-on-primary transition hover:opacity-75 text-center focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">
                                Edit
                            </button>

                            <div x-data="{ modalIsOpen: false }">
                                <button x-on:click="modalIsOpen = true" type="button"
                                    class="inline-flex justify-center items-center gap-2 whitespace-nowrap rounded-radius bg-danger border border-danger dark:border-danger px-4 py-2 text-sm font-medium tracking-wide text-on-danger transition hover:opacity-75 text-center focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-danger active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-danger dark:text-on-danger dark:focus-visible:outline-danger">Eliminar</button>
                                <div x-cloak x-show="modalIsOpen" x-transition.opacity.duration.200ms
                                    x-trap.inert.noscroll="modalIsOpen" x-on:keydown.esc.window="modalIsOpen = false"
                                    x-on:click.self="modalIsOpen = false"
                                    class="fixed inset-0 z-30 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8"
                                    role="dialog" aria-modal="true" aria-labelledby="defaultModalTitle">
                                    <!-- Modal Dialog -->
                                    <div x-show="modalIsOpen"
                                        x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
                                        x-transition:enter-start="opacity-0 scale-y-0"
                                        x-transition:enter-end="opacity-100 scale-y-100"
                                        class="flex max-w-lg flex-col gap-4 overflow-hidden rounded-lg border border-neutral-300 bg-white text-neutral-600 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300">
                                        <!-- Dialog Header -->
                                        <div
                                            class="flex items-center justify-between border-b border-neutral-300 bg-neutral-50/60 p-4 dark:border-neutral-700 dark:bg-neutral-950/20">
                                            <h3 id="defaultModalTitle"
                                                class="font-semibold tracking-wide text-neutral-900 dark:text-white">
                                                Advertencia</h3>
                                            <button x-on:click="modalIsOpen = false" aria-label="close modal">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    aria-hidden="true" stroke="currentColor" fill="none"
                                                    stroke-width="1.4" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <!-- Dialog Body -->
                                        <div class="px-4 py-8">
                                            <p>Estas seguro que quieres <strong>ELIMINAR</strong> a este Paciente?</p>
                                        </div>
                                        <!-- Dialog Footer -->
                                        <div
                                            class="flex flex-col-reverse justify-between gap-2 border-t border-neutral-300 bg-neutral-50/60 p-4 dark:border-neutral-700 dark:bg-neutral-950/20 sm:flex-row sm:items-center md:justify-end">
                                            <button x-on:click="modalIsOpen = false" type="button"
                                                class="whitespace-nowrap rounded-lg px-4 py-2 text-center text-sm font-medium tracking-wide text-neutral-600 transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0 dark:text-neutral-300 dark:focus-visible:outline-white">Cancelar</button>
                                            <button x-on:click="modalIsOpen = false" type="button"
                                                class="whitespace-nowrap rounded-lg bg-black border border-black dark:border-white px-4 py-2 text-center text-sm font-medium tracking-wide text-neutral-100 transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0 dark:bg-white dark:text-black dark:focus-visible:outline-white" wire:click="delete({{ $paciente }})">Aceptar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center">No hay pacientes registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">
            {{ $pacientes->links() }}
        </div>
    </div>
</div>
