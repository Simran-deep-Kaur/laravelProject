<!-- showEmployee.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Employee Details') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex justify-center">
                <div class="p-6 m-6 border rounded-md bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 ">
                    <div class="flex justify-center">
                        @if($employee->profile_image)
                        <img title="{{ $employee->profile_image }}" style="border-radius: 50%; max-width:100px" src="{{asset('storage/uploads/'.$employee->profile_image)}}" alt="">
                        @else
                        <img title="No image uploaded" style="border-radius: 50%; max-width:100px" src="{{asset('storage/uploads/image2.png'.$employee->profile_image)}}" alt="">
                        @endif
                    </div>
                    <div class="my-6">
                        <p class="my-2"><strong>Name:</strong> {{ $employee->name }}</p>
                        <p class="my-2"><strong>Email:</strong> {{ $employee->email }}</p>
                        <p class="my-2"><strong>Gender:</strong> {{ $employee->gender }}</p>
                        <p class="my-2"><strong>Age:</strong> {{ $employee->age }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>