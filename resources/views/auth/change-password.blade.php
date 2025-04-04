@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="{{ route('password.update') }}">
    @csrf
    @method('PUT') <!-- Ensure the method is PUT -->

    <label for="current_password">Current Password</label>
    <input type="password" name="current_password" required>

    <label for="new_password">New Password</label>
    <input type="password" name="new_password" required>

    <label for="new_password_confirmation">Confirm Password</label>
    <input type="password" name="new_password_confirmation" required>

    <button type="submit">Change Password</button>
</form>
