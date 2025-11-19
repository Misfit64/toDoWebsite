<x-base-layout>
     @push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
    @endpush
<div class="container d-flex align-items-center flex-column mt-5">
        <div class="d-flex h1 align-items-center gap-2">
            <x-logo :height="30" :width="30"/>
            <div>
                ToDoWebsite
            </div>
        </div>
        <form method="POST" action="/signup" class="mt-4 w-75">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Enter your Username">
                <div class="invalid-feedback"></div>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Email</label>
                <input type="text" class="form-control" name="email" id="email" placeholder="Enter your Email">
                <div class="invalid-feedback"></div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password">
                <div class="invalid-feedback"></div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="confirm-password" id="confirm-password" placeholder="Confirm your password">
                <div class="invalid-feedback"></div>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-dark w-100">Register</button>
            </div>
            <div class="mb-3">
                <a class="btn btn-dark w-100" href="{{route('login')}}">Already a User? Click here to Login</a>
            </div>
        </form>
    </div>
    <script>
        const form = $('form');
        form.submit((e)=>{
            e.preventDefault();

            axios.post('/signup',{
                username: $('#username').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                'confirm-password': $('#confirm-password').val()
            },{
                headers: {
                    'Accept': 'application/json'
                }
            }
        )
            .then(response=>{
                if (response.data && response.data.redirect) {
                    window.location.href = response.data.redirect;
                } else {
                    alert(response.data.message || 'Registration successful!');
                }
            })
            .catch(error=>{
                console.log(error)
                var error_list = error.response.data.errors;
                function is_invalid(selection){
                    $('#'+ selection).removeClass('is-valid').addClass('is-invalid').next().text(error_list[selection][0]);
                }

                function is_valid(selection){
                    $('#'+ selection).removeClass('is-invalid').addClass('is-valid').next().empty();
                }

                if(error_list.email){
                    is_invalid('email');
                } else {
                    is_valid('email');
                }

                if(error_list.username){
                    is_invalid('username')
                }else {
                    is_valid('username');
                }

                if(error_list.password){
                    is_invalid('password');
                }else {
                    is_valid('password');
                }

                if(error_list['confirm-password']){
                    is_invalid('confirm-password');
                } else {
                    is_valid('confirm-password')
                }

                console.log(error_list)
            });
        })
    </script>
</x-base-layout>
