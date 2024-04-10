<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Employee Details') }}
        </h2>
    </x-slot>

    @include('common.show-data', ['data' => $employee])
</x-app-layout>
