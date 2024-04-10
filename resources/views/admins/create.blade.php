<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Admin') }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-6 sm:px-6 lg:px-8">
        <form enctype="multipart/form-data" action="{{ route('admin.store') }}" method="POST"
            class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @include ('common.form', ['url' => route('admins.validateEmail')])
        </form>
    </div>
</x-app-layout>
