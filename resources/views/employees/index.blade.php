<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Employees') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="py-5">
            <div
                class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-between bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 ">
                    <a href="{{ route('employee.store') }}"
                        class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded  ">
                        Add User
                    </a>
                </div>
                @if($users)
                <div
                    class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 flex items-center">
                    <form action="{{ route('employees') }}" method="GET" class="flex">
                        <select name="filter" id="filter" onchange="this.form.submit()"
                            class="inline-block w-full focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:focus:ring-gray-600 dark:focus:border-gray-600 rounded-md mr-2">
                            <option value="all">All Employees</option>
                            @foreach($users as $user)
                            <option type="submit" value="{{ $user->id }}" {{ request('filter')==$user->id ? 'selected' :
                                '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                @endif
            </div>

        </div>
        @include('common.index')
    </div>

</x-app-layout>

