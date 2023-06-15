@extends('layouts.app')

@section('title')
    Job Lists
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    Job Lists
                </div>

                <div class="card-body">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Salary</th>
                                <th>Requirement</th>
                                <th>Category</th>
                                <th>Owner</th>
                                <th>Action</th>
                                <th>Created At</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                ajax: '{{ route('post.queryTable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'salary',
                        name: 'salary'
                    },
                    {
                        data: 'requirements',
                        name: 'requirements'
                    },
                    {
                        data: 'category_id',
                        name: 'category_id'
                    },
                    {
                        data: 'user_id',
                        name: 'user_id'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                    {
                        data: 'created',
                        name: 'created'
                    },
                ]
            })

            $(document).on('click', '.del-btn', function(e, id) {
                e.preventDefault()
                var id = $(this).data(id).id;
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Deleted!',
                            'Your post has been deleted.',
                            'success'
                        )
                        $.ajax({
                            method: "DELETE",
                            url: `/post/${id}`
                        }).done(function(res) {
                            table.ajax.reload();
                        })
                    }
                })
            })

        })
    </script>
@endsection
