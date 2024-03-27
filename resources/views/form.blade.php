<div class="mb-4">
    <label for="name" class="inline-block text-gray-700 text-sm font-bold mb-2">Name</label><span class="text-red-500"> *</span>
    <input  type="text" name="name" id="name" value="{{ old('name') ?? ($employee->name ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    @error('name')
    <p id="name-error" class="text-red-500">{{$message}}</p>
    @enderror
</div>
<div class="mb-4">
    <label for="email" class="inline-block text-gray-700 text-sm font-bold mb-2">Email</label><span class="text-red-500"> *</span>
    <input onkeyup="checkEmail()" type="text" name="email" id="email" value="{{ old('email') ?? ($employee->email ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    @error('email')
    <p id="email-error-message" class="text-red-500">{{$message}}</p>
    @enderror
    <div id="email-error" class="text-red-500"></div>
</div>
<div class="mb-4">
    <label class="inline-block text-gray-700 text-sm font-bold mb-2">Gender</label><span class="text-red-500"> *</span>
    <div>
        <input type="radio" name="gender" id="male" value="male" class="mr-1" {{isset($employee) && $employee->gender === 'male' ? 'checked' : '' }}>
        <label for="male" class="text-gray-700">Male</label>
    </div>
    <div>
        <input type="radio" name="gender" id="female" value="female" class="mr-1" {{ isset($employee) && $employee->gender === 'female' ? 'checked' : '' }}>
        <label for="female" class="text-gray-700">Female</label>
    </div>
    <div>
        <input type="radio" name="gender" id="other" value="other" class="mr-1" {{ isset($employee) && $employee->gender === 'other' ? 'checked' : '' }}>
        <label for="other" class="text-gray-700">Other</label>
    </div>
    @error('gender')
    <p class="text-red-500">{{$message}}</p>
    @enderror
</div>
<div class="mb-4">
    <label for="age" class="block text-gray-700 text-sm font-bold mb-2">Age</label>
    <input  type="number" name="age" value="{{ old('age') ?? ($employee->age ?? '') }}" id="age" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    @error('age')
    <p id="age-error" class="text-red-500">{{$message}}</p>
    @enderror
</div>
<div class="mb-4">
    <label for="profile_image" class="block text-gray-700 text-sm font-bold mb-2">Profile Image</label>
    <input type="file" value="{{ old('profile_image') ?? ($employee->profile_image ?? '') }}" name="profile_image" accept="image/*" id="profile_image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight ">
</div>
<div class="inline-block items-center justify-between">
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save</button>
</div>


<script>
    function checkEmail() {
        let currentEmail = document.getElementById("email").value;
        let previousEmail = "{{ $employee->email ?? '' }}";
        $.ajax({
            url: "{{ route('employee.checkEmail') }}",
            method: "POST",
            data: {
                "_token": "{{csrf_token()}}",
                'email': currentEmail,
                'previousEmail': previousEmail,
            },
            success: function(response) {
                if (response.status === "error") {
                    document.getElementById("email-error").innerText = response.message;
                } else {
                    document.getElementById("email-error").innerText = "";
                }
            }
        })
        if (currentEmail !== "") {
            document.getElementById("email-error-message").innerText = "";
        }
    }

    // function checkName() {
    //     let name = document.getElementById("name").value;
    //     if (name !== "") {
    //         let nameError = document.getElementById("name-error").value;
    //         if (nameError !== "") {
    //             document.getElementById('name-error').innerHTML = "";
    //         }
    //     }
    // }

    // function checkAge() {
    //     let age = document.getElementById("age").value;
    //     if (age < 18) {
    //         document.getElementById('age-error').innerText = "The age field must be at least 18.";
    //     }
    // }
</script>