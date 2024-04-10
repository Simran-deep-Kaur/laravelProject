<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex justify-center">
            <div
                class="p-6 m-6 border rounded-md bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 ">
                <div class="flex justify-center">
                    <img title="{{ $data['profile_url'] }}" style="border-radius: 50%; max-width:100px"
                        src="{{ $data['profile_url'] }}" alt="">
                </div>
                <div class="my-6">
                    @if (isset($data['unique_id']))
                        <p class="my-2">
                            <strong>Unique ID:</strong> {{ $data['unique_id'] }}
                        </p>
                    @endif
                    <p class="my-2">
                        <strong>Name:</strong> {{ $data['name'] }}
                    </p>
                    <p class="my-2">
                        <strong>Email:</strong> {{ $data['email'] }}
                    </p>
                    @if ($data['gender'])
                        <p class="my-2">
                            <strong>Gender:</strong> {{ $data['gender'] }}
                        </p>
                    @endif
                    @if ($data['age'])
                        <p class="my-2">
                            <strong>Age:</strong> {{ $data['age'] }}
                        </p>
                    @endif
                    @if (isset($data['creator']))
                        <p class='my-2'>
                            <strong>Creator:</strong> {{ $data['creator'] }}
                        </p>
                    @endif
                    @if (isset($data['role']))
                        <p class='my-2'>
                            <strong>Role:</strong>
                            @foreach ($data['role'] as $role)
                                <li>{{ $role['name'] }}</li>
                            @endforeach
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
