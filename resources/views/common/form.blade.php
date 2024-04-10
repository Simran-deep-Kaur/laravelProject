<input type="hidden" id="csrf_token" value="{{ csrf_token() }}">

<div class="mb-4">
    <label for="name" class="inline-block text-gray-700 text-sm font-bold mb-2">Name</label><span class="text-red-500">
        *</span>
    <input type="text" name="name" id="name" value="{{ old('name') ?? ($data->name ?? '') }}"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">

    @error('name')
        <p class="text-red-500">{{ $message }}</p>
    @enderror
</div>
<div class="mb-4">
    <label for="email" class="inline-block text-gray-700 text-sm font-bold mb-2">Email</label><span
        class="text-red-500"> *</span>
    <input onkeyup="validateEmail()" type="text" name="email" id="email"
        value="{{ old('email') ?? ($data->email ?? '') }}"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    @error('email')
        <p class="text-red-500">{{ $message }}</p>
    @enderror
    <div id="email-error" class="text-red-500"></div>
</div>
<div class="mb-4">
    <label class="inline-block text-gray-700 text-sm font-bold mb-2">Gender</label><span class="text-red-500"> *</span>
    <div>
        <input type="radio" name="gender" id="male" value="male" class="mr-1"
            {{ isset($data) && $data->gender === 'male' ? 'checked' : '' }}>
        <label for="male" class="text-gray-700">Male</label>
    </div>
    <div>
        <input type="radio" name="gender" id="female" value="female" class="mr-1"
            {{ isset($data) && $data->gender === 'female' ? 'checked' : '' }}>
        <label for="female" class="text-gray-700">Female</label>
    </div>
    <div>
        <input type="radio" name="gender" id="other" value="other" class="mr-1"
            {{ isset($data) && $data->gender === 'other' ? 'checked' : '' }}>
        <label for="other" class="text-gray-700">Other</label>
    </div>
    @error('gender')
        <p class="text-red-500">{{ $message }}</p>
    @enderror
</div>
<div class="mb-4">
    <label for="age" class="block text-gray-700 text-sm font-bold mb-2">Age</label>
    <input type="number" name="age" value="{{ old('age') ?? ($data->age ?? '') }}" id="age"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    @error('age')
        <p class="text-red-500">{{ $message }}</p>
    @enderror
</div>
<div class="mb-4">
    <label for="profile_image" class="block text-gray-700 text-sm font-bold mb-2">Profile Image</label>
    <input type="file" value="{{ old('profile_image') ?? ($data->profile_image ?? '') }}" name="profile_image"
        accept="image/*" id="profile_image"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight ">
</div>
<div class="inline-block items-center justify-between">
    <button type="submit"
        class="button-click bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save</button>
</div>

<script>
    function validateEmail() {
        $.ajax({
            url: "{{ $url }}",
            method: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                'email': document.getElementById("email").value,
                'Id': "{{ $data->id ?? '' }}",
            },
            success: function(response) {
                document.getElementById("email-error").innerText = response.message ?? '';
            }
        })
    }
</script>
