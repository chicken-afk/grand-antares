<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $row['users'] = DB::table('users')->join('roles', 'roles.id', 'users.role_id')
            ->leftJoin('outlets', 'outlets.id', 'users.outlet_id')
            ->select('users.*', 'roles.role_name', 'outlets.outlet_name')
            // ->where('users.deleted_at', null)
            ->where('users.company_id', Auth::user()->company_id)->get();
        $row['roles'] = DB::table('roles')->get();
        $row['outlets'] = DB::table('outlets')->where('company_id', Auth::user()->company_id)->get();
        return view('main.user-management', compact('row'));
    }

    public function store(Request $request)
    {
        /**Validation Here */

        $eCount = DB::table('users')->where('email', $request->email)->count();
        if ($eCount != 0) {
            alert('error', 'Email Sudah Digunakan', 'error');
            return redirect()->back();
        }

        DB::table('users')->insert([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'is_superadmin' => $request->role_id == 1 ? 1 : 0,
            'outlet_id' => $request->outlet_id == 'false' ? null : $request->outlet_id,
            'created_at' => now(),
            'company_id' => Auth::user()->company_id,
            'email' => $request->email
        ]);
        alert('success', 'berhasil menambah user', 'success');
        return redirect()->back();
    }

    public function deleteUser($uuid)
    {
        DB::table('users')->where('id', $uuid)->update([
            'is_active' => 0,
            'deleted_at' => now()
        ]);
        alert('success', 'berhasil menghapus user', 'success');
        return redirect()->back();
    }

    public function updateUser(Request $request)
    {
        // dd($request);
        DB::table('users')->where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'updated_at' => now()
        ]);
        alert('success', 'berhasil mengubah data user', 'success');
        return redirect()->back();
    }
}
