<x-base-layout>
    @push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @endpush
<div class="container d-flex align-items-center flex-column mt-5">
        <div class="d-flex h1 align-items-center gap-2">
            <x-logo :height="30" :width="30"/>
            <div>
                ToDoWebsite
            </div>
        </div>
        <form method="POST" action="/login" class="mt-4 w-75">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control @error('username')is-invalid @enderror" name="username" id="username" placeholder="Enter your Username" value="{{ old('username') }}">
                @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password')is-invalid @enderror" name="password" id="password" placeholder="Enter your password">
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-dark w-100">Login</button>
            </div>
            <div class="mb-3">
                <a class="btn btn-dark w-100" href="{{route('signup')}}">Click here to Register</a>
            </div>
        </form>
</div>

</x-base-layout>
