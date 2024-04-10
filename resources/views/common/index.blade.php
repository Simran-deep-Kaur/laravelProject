<div class="py-10">
    <div class=" max-w-8xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                    <input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                            role="alert">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Profile Image
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Name
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Email
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Gender
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Age
                            </th>
                            @if (isset($data[0]['creator']))
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Creator
                                </th>
                            @endif
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Date
                            </th>
                            @if (isset($data[0]['role']))
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Role
                                </th>
                            @endif
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($data as $row)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($row['profile_url'] && Str::contains($row['profile_url'], '/show-image/'))
                                        <img style="max-width:50px; border-radius: 50%" src="{{ $row['profile_url'] }}"
                                            alt="profile image" />
                                    @else
                                        <img style="max-width:50px; border-radius: 50%"
                                            src="{{ asset('storage/uploads/image2.png') }}" alt="default profile image"
                                            title="No image uploaded" />
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $row['name'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $row['email'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $row['gender'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $row['age'] }}
                                </td>
                                @if (isset($row['creator']))
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $row['creator'] }}
                                    </td>
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $row['created_at'] }}
                                </td>
                                @if (isset($row['role']))
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <ul>

                                            @foreach (explode(',', $row['role']) as $role)
                                                <li class="list-disc">{{ $role }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a class="button-click inline-block bg-yellow-400 hover:bg-yellow-600 text-dark font-bold py-2 px-4 rounded"
                                        href="{{ $row['show_url'] }}">View</a>
                                    <a href="{{ $row['edit_url'] }}"
                                        class="button-click inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                    <form id="delete" class="inline-block" action="{{ $row['delete_url'] }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="button-click delete-button inline-block bg-red-400 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
