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
        $data['title'] = 'Pengurusan pengguna';
        $data['url'] = 'admin/users';
        $data['datatable_route'] = route('admin.users.list');
        $data['breadcrumbs'] = [
            [
                'label' => 'Laman Utama',
                'link' => '/',
            ],
            [
                'label' => 'Pengurusan pengguna',
                'link' => '/admin/users',
                'active' => true
            ]
        ];

        $user_list = User::select(['id', 'name'])->get()->toArray();
        array_unshift($user_list, array('id' => '', 'name' => '- Semua Pengguna -'));

        $data['columns'] = array(
            array(
                'dt' => 'id',
                'label' => 'id',
                'width' => '1%'
            ),
            array(
                'dt' => 'name',
                'label' => 'Name',
                'filter' => [
                    'class' => 'col-md-2',
                    'value' => $user_list
                ]
            ),
            array(
                'dt' => 'email',
                'label' => 'Email'
            ),
            array(
                'dt' => 'ic',
                'label' => 'IC'
            ),
            array(
                'dt' => 'roles',
                'label' => 'Roles',
                'searchable' => false,
                'orderable' => false
            ),
            array(
                'dt' => 'created_at',
                'label' => 'Created At',
                'searchable' => false
            )
        );

        $data['buttons'] = array(
            array(
                'id' => 'createuser',
                'class' => 'btn-primary',
                'label' => 'Tambah Baru',
                'link' => route('admin.users.create'),
                'modal' => true,
                'icon' => 'fa-plus-circle'
            )
        );

        $data['actions'] = array(
            array(
                'id' => 'delete',
                'name' => 'Padam pengguna',
                'msg' => 'Adakah anda pasti untuk padam pengguna?'
            )
        );

        return view('layouts.table', $data);
    }

    public function getsearchlist(Request $request) {
        $users = DB::table('users');

        if($request['name']) {
            $users->where('users.id', $request['name']);
        }

        return DataTables::of($users)
            ->editColumn('roles', function($query) {
                $user = User::find($query->id);
                $html = '';
                foreach($user->roles as $role) {
                    $html .= '<span class="cl cl-primary">'. $role->display_name .'</span>';
                }
                return $html;
            })
            ->filterColumn('name', function($query, $keyword) {
                $query->where('users.name', 'like', '%'.$keyword.'%');
            })
            ->filterColumn('email', function($query, $keyword) {
                $query->where('users.email', 'like', '%'.$keyword.'%');
            })
            ->rawColumns(['roles'])
            ->make(true);
    }

    public function create() {
        return view('sisrel.admin.users.add');
    }

}
