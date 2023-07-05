@extends('layouts.app')

@section('title')
    Create User
@endsection

@section('theme')
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Update User</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('user.update',$user->id) }}" method="POST" id="updateForm">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label>User Name*</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name',$user->name) }}"
                                placeholder="Eg@Mg Mg">
                        </div>

                        <div class="mb-3">
                            <label>Email*</label>
                            <input type="text" class="form-control" name="email" value="{{ old('email',$user->email) }}"
                                placeholder="Eg@mgmg@gmail.com">
                        </div>

                        <div class="mb-3">
                            <label>Password*</label>
                            <input type="password" class="form-control" name="password" value="{{ old('password',$user->password) }}"
                                placeholder="Please type password">
                        </div>

                        <div class="mb-3">
                            <label>User Role</label>
                            <select class="form-select select2" name="role">
                                <option value="1" @if ($user->role == 1) selected @endif>Admin</option>
                                <option value="2" @if ($user->role == 2) selected @endif>User</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Gender</label>
                            <select class="form-select select2" name="gender">
                                <option value="male" @if ($user->gender == 'male') selected @endif>Male</option>
                                <option value="female" @if ($user->gender == 'female') selected @endif>Female</option>
                                <option value="other" @if ($user->gender == 'other') selected @endif>Other</option>
                            </select>
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="is_ban" {{ $user->is_ban ? 'checked' : '' }}>
                            <label class="form-check-label" for="exampleCheck1">Is Ban the user?</label>
                        </div>

                        <button class="btn btn-primary px-3 mt-4">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\UpdateUserRequest', '#updateForm') !!}
@endsection
