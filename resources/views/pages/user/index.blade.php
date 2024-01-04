@extends('layouts/content')

@section('title')
    <title>User</title>
@endsection

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>User</h4>
                <h6>Manajemen Data User</h6>
            </div>
            <div class="page-btn">
                <a href="/user/insert" class="btn btn-added remove-role"><img src="{{ url('assets/img/icons/plus.svg') }}"
                        alt="img" class="me-1">Tambah User
                    Baru</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-input">
                            <a class="btn btn-searchset"><img src="{{ url('assets/img/icons/search-white.svg') }}"
                                    alt="img"></a>
                        </div>
                    </div>
                    <div class="wordset">
                        <ul>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                        src="{{ url('assets/img/icons/excel.svg') }}" alt="img"></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="table-responsive pb-4">
                    <table id="user-table" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama </th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Dibuat Pada</th>
                                <th>Diubah Pada</th>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>

    <script>
        const tokenType = localStorage.getItem('token_type')
        const accessToken = localStorage.getItem('access_token')

        let hiddenRole = false



        hiddenRole && $('.remove-role').remove()

        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        let config = {
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `${tokenType} ${accessToken}`
            }
        }

        let dataProgress = []

        $(document).ready(function() {
            // NOTIF VERIFY USER
            const success = sessionStorage.getItem("success")
            if (success) {
                Swal.fire(success, '', 'success')
                sessionStorage.removeItem("success")
            }



            // GET DATA
            const table = $('#user-table').DataTable()

            getData()

            // GET SHELF
            function getData() {
                axios.get("{{ url('api/v1/user/') }}", config)
                    .then(function(res) {
                        const users = res.data.data.items
                        users.map((user, i) => {
                            const formattedCreatedAt = new Date(user.created_at).toISOString()
                                .split('T')[0];
                            const formattedUpdatedAt = new Date(user.updated_at).toISOString()
                                .split('T')[0];
                            table.row.add([
                                i + 1,
                                user.name,
                                user.email,
                                user.username,
                                formattedCreatedAt,
                                formattedUpdatedAt,
                            ]).draw(false)
                        })
                    })
                    .catch(function(err) {
                        console.log(err)
                    })
            }
        })
    </script>
@endsection
