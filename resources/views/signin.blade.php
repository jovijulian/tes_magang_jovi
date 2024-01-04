@extends('layouts/main')

@section('title')
    <title>Signin</title>
@endsection

@section('main')
    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper">
                <div class="login-content">
                    <div class="login-userset">
                        <div class="login-userheading">
                            <h3>Sign In</h3>
                            <h4>Silahkan masuk ke akun anda</h4>
                        </div>
                        <form id="signin-form">
                            <div class="form-login">
                                <label for="username">Username</label>
                                <div class="form-addons">
                                    <input type="text" id="username" placeholder="Masukan username anda" required>
                                    <img src="assets/img/icons/mail.svg" alt="img">
                                </div>
                            </div>
                            <div class="form-login">
                                <label for="password">Password</label>
                                <div class="pass-group">
                                    <input type="password" id="password" class="pass-input"
                                        placeholder="Masukan password anda" required>
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                            </div>

                            <div class="form-login">
                                <button type="submit" class="btn btn-login">Masuk</button>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="login-img">
                    <img src="assets/img/login.jpg" alt="img">
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            const token = localStorage.getItem('access_token')
            const expirationTime = localStorage.getItem('expires_at')

            if (token && expirationTime && Date.now() < parseInt(expirationTime)) {
                window.location.href = "{{ url('/dashboard') }}"
            }

            $('#signin-form').on('submit', function() {
                event.preventDefault()
                $('#global-loader').show()

                const data = {
                    username: $('#username').val(),
                    password: $('#password').val()
                }

                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                let config = {
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                }


                axios.post("{{ url('api/v1/auth/login') }}", data, config)
                    .then(function(res) {
                        const data = res.data.data.item

                        const expiresIn = data.expires_in
                        const expirationTime = Date.now() + (expiresIn * 1000)


                        localStorage.setItem('token_type', data.token_type)
                        localStorage.setItem('access_token', data.access_token)
                        localStorage.setItem('expires_at', expirationTime)

                        window.location.href = "{{ url('/dashboard') }}"
                    })
                    .catch(function(err) {
                        $('#global-loader').hide()

                        if (err.response.data.meta.code === 400) {
                            const errorMessage = err.response.data.meta.errors[0]
                            if (errorMessage.errors) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: errorMessage.errors
                                })
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Internal server error'
                            })
                        }
                    })



            })
        })
    </script>
@endsection
