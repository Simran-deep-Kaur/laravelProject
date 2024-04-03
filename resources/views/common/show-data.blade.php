<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex justify-center">
            <div
                class="p-6 m-6 border rounded-md bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 ">
                <div class="flex justify-center">
                    @if($data->profile_image)
                    <img title="{{ $data->profile_image }}" style="border-radius: 50%; max-width:100px"
                        src="{{asset('storage/uploads/'.$data->profile_image)}}" alt="">
                    @else
                    <img title="No image uploaded" style="border-radius: 50%; max-width:100px"
                        src="{{asset('storage/uploads/image2.png'.$data->profile_image)}}" alt="">
                    @endif
                </div>
                <div class="my-6">
                    <p class="my-2">
                        <strong>Name:</strong> {{ $data->name }}
                    </p>
                    <p class="my-2">
                        <strong>Email:</strong> {{ $data->email }}
                    </p>
                    @if($data->gender)
                    <p class="my-2">
                        <strong>Gender:</strong> {{ $data->gender }}
                    </p>
                    @endif
                    @if ($data->age)
                    <p class="my-2">
                        <strong>Age:</strong> {{ $data->age }}
                    </p>
                    @endif
                    @if( $data->creator)
                    <p class='my-2'>
                        <strong>Creator:</strong> {{ $data->creator }}
                    </p>
                    @endif
                    @if( $data->role)
                    <p class='my-2'>
                        <strong>Role:</strong> 
                        @foreach (explode(",", $data->role) as $role )
                            <li>{{ $role }}</li>                            
                        @endforeach
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>