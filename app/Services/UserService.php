<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class UserService {


    public function createUser($request) {
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password,
            "role" => $request->role,
            "gender" => $request->gender,
            "is_ban" => $request->is_ban ? 1 : 0
        ]);
        return redirect()->route('user.index')->with('created', 'Successfully Created');
    }

    public function updateUser($request,$user) {
        $user->update([
            'name' => $request->name,
            "email" => $request->email,
            "password" => $request->password,
            "role" => $request->role,
            'gender' => $request->gender,
            "is_ban" => $request->is_ban ? 1 : 0
        ]);
        return redirect()->route('user.index')->with('success', 'Successfully Updated');
    }

    public function dataTable() {
        $lists = User::latest()->get();
        return DataTables::of($lists)
            ->addColumn('action', function ($value) {
                $edit = '<a href="' . route('user.edit', $value->id) . '" class="btn btn-secondary btn-sm">Edit</a>';
                $del = '<a href="#" class="btn btn-danger text-white btn-sm del-btn ms-2" data-id="' . $value->id . '">Delete</a>';
                return '<span>' . $edit . $del . '</span>';
            })
            ->editColumn('banInfo', function ($value) {
                if ($value->is_ban) {
                    $ui = '<span class="badge badge-danger">Yes</span>';
                } else {
                    $ui = '<span class="badge badge-success">No</span>';
                }
                return $ui;
            })
            ->editColumn('userRole', fn ($value) => $value->role == 1 ? 'Admin' : 'User')
            ->editColumn('created', fn ($value) => Carbon::parse($value->created_at)->format('d M Y'))
            ->editColumn('gender', fn ($value) => $value->capital_gender)
            ->editColumn('name', fn ($value) =>  $value->capital_name)
            ->rawColumns(['banInfo', 'action'])
            ->make(true);
    }

}



?>
