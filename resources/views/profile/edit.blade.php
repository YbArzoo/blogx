<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-zinc-800 dark:text-zinc-100 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">

            <div class="card p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form', [
                        'inputClass' => 'input',
                        'labelClass' => 'form-label',
                        'buttonClass' => 'btn-primary'
                    ])
                </div>
            </div>

            <div class="card p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form', [
                        'inputClass' => 'input',
                        'labelClass' => 'form-label',
                        'buttonClass' => 'btn-primary'
                    ])
                </div>
            </div>

            <div class="card p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form', [
                        'buttonClass' => 'btn-primary'
                    ])
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
