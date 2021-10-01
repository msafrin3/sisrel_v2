<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Yajra\DataTables\Facades\DataTables;
use App\User;

class UserController extends Controller
{
    
    public function index() {
        $data['title'] = 'User Management';
        $data['datatable_route'] = route('admin.users.list');
        $data['breadcrumbs'] = [
            [
                'label' => 'Home',
                'link' => '/',
            ],
            [
                'label' => 'User Management',
                'link' => '/admin/users',
                'active' => true
            ]
        ];

        $data['columns'] = array(
            array(
                'dt' => '',
                'label' => '',
                'width' => '1%'
            ),
            array(
                'dt' => 'name',
                'label' => 'Name'
            ),
            array(
                'dt' => 'email',
                'label' => 'Email'
            ),
            array(
                'dt' => 'created_at',
                'label' => 'Created At'
            )
        );

        $data['buttons'] = array(
            array(
                'id' => 'createuser',
                'class' => 'btn-primary',
                'label' => 'Add new User',
                'link' => route('admin.users.create'),
                'modal' => true
            )
        );

        return view('layouts.table', $data);
    }

    public function getsearchlist(Request $request) {
        $users = DB::table('users')->get();

        return DataTables::of($users)->make(true);
    }

}
