@extends('layouts/content')

@section('title')
    <title>Tambah User</title>
@endsection

@section('content')
    <div class="cardhead">
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Tambah Data User</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/user') }}">User</a></li>
                            <li class="breadcrumb-item active">Tambah User</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-xl-11 d-flex">
                    <div class="card flex-fill">
                        {{-- <div class="card-header">
              <h5 class="card-title">Basic Form</h5>
            </div> --}}
                        <div class="card-body p-4">
                            <form id="insert-user-form">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Nama *</label>
                                    <div class="col-lg-10">
                                        <input type="text" id="name" class="form-control"
                                            placeholder="Masukan nama lengkap" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Email</label>
                                    <div class="col-lg-10">
                                        <input type="email" id="email" class="form-control"
                                            placeholder="Masukan email ">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Username</label>
                                    <div class="col-lg-10">
                                        <input type="text" id="username" class="form-control"
                                            placeholder="Masukan username ">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Password</label>
                                    <div class="col-lg-10">
                                        <input type="password" id="password" class="form-control"
                                            placeholder="Masukan password ">
                                    </div>
                                </div>


                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            const tokenType = localStorage.getItem('token_type')
            const accessToken = localStorage.getItem('access_token')

            // REDIRECT IF NOT ADMIN
            // if (!currentUser.isAdmin) {
            //   window.location.href = "{{ url('/dashboard') }}"
            // }

            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            let config = {
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'multipart/form-data',
                    'Accept': 'application/json',
                    'Authorization': `${tokenType} ${accessToken}`
                }
            }





            $('#insert-user-form').on('submit', () => {
                event.preventDefault()
                $('#global-loader').show()

                const data = {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    username: $('#username').val(),
                    password: $('#password').val(),
                }




                axios.post("{{ url('api/v1/user/') }}", data, config)
                    .then(res => {
                        // const shelf = res.data.data.item
                        sessionStorage.setItem("success", `User berhasil ditambahkan`)
                        window.location.href = "{{ url('/user') }}"
                    })
                    .catch(err => {
                        $('#global-loader').hide()

                        let errorMessage = ''

                        if (err.response.status == 422) {
                            const errors = err.response.data.errors[0]
                            for (const key in errors) {
                                errorMessage += `${errors[key]} \n`
                            }
                        } else if (err.response.status == 500) {
                            errorMessage = 'Internal server error'
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'User gagal ditambahkan',
                            text: errorMessage
                        })
                    })

            })

        })
    </script>
@endsection
