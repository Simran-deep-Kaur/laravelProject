<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admins') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-between bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 ">
                <a href="{{ route('admin.store') }}" class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded  ">
                    Add Admin
                </a>
            </div>
        </div>
    </div>
    @include('common.index')
    </div>

</x-app-layout>