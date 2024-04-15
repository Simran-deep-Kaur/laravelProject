
<div class="py-10 ">
    <div class=" max-w-8xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div style="  overflow-x:scroll"
                class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                Profile Image
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                Gender
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                Age
                            </th>
                            @if (isset($data[0]['creator']))
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                    Creator
                                </th>
                            @endif
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                Date
                            </th>
                            @if (isset($data[0]['role']))
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                    Role
                                </th>
                            @endif
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody id="employeeTableBody" class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($data as $row)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img style="max-width:50px; border-radius: 50%" src="{{ $row['profile_url'] }}"
                                        alt="profile image" />
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
                                            @foreach ($row['role'] as $role)
                                                <li class="list-disc">{{ $role['name'] }}</li>
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
                    {{ $employees->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</div>