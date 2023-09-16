<?php

namespace App\Http\Controllers;

use App\Models\Csnumber;
use App\Models\Ipaddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function loginPage()
    {
        return view('main.login');
    }

    public function login(Request $request)
    {
        // dd($request);

        // Check if user aktif
        $user = DB::table('users')->where('email', $request->email)->first();
        if ($user) {
            if ($user->is_active == 0) {
                alert('Gagal', 'Email Tidak Ditemukan', 'error');
                return redirect()->back();
            }
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                if (Auth::user()->role_id == 1) {
                    return redirect()->route('dashboard');
                } elseif (Auth::user()->role_id == 2) {
                    return redirect()->route('getOrders');
                } elseif (Auth::user()->role_id == 3) {
                    return redirect()->route('getOrders');
                } elseif (Auth::user()->role_id == 4) {
                    return redirect()->route('userPage');
                }
            } else {
                alert('Gagal', 'Kombinasi Email Dan Password Salah', 'error');
                return redirect()->back();
            }
        } else {
            alert('Gagal', 'Email Tidak Ditemukan', 'error');
            return redirect()->back();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect()->route('loginPageAdmin');
    }

    public function setting()
    {
        $row['users'] = DB::table('users')->where('users.id', Auth::id())
            ->join('roles', 'roles.id', 'users.role_id')
            ->select('users.*', 'roles.role_name')
            ->first();
        $row['customer_services'] = Csnumber::get();
        $row['ip_address'] = Ipaddress::get();
        return view('main.setting', compact('row'));
    }

    public function saveSetting(Request $request)
    {
        if ($request->new_password == null) {
            DB::table('users')->where('id', Auth::id())->update([
                'name' => $request->name,
                'email' => $request->email,
                'updated_at' => now()
            ]);
        } else {
            // Check if new password == confirmation
            if ($request->new_password != $request->password_confirmation) {
                alert('error', 'Password Confirmation Tidak Sama', 'error');
                return redirect()->back();
            }
            DB::table('users')->where('id', Auth::id())->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->new_pasword),
                'updated_at' => now()
            ]);
        }
        alert('success', 'Berhasil Menyimpan Profile', 'success');
        return redirect()->back();
    }

    public function saveWhatsapp(Request $request)
    {
        $nomorHp = $this->formatNomorHP($request->whatsapp);
        Csnumber::create(['name' => $request->name, 'whatsapp' => $nomorHp]);

        alert('success', 'Berhasil Menyimpan Whatsapp', 'success');
        return redirect()->back();
    }

    public function whatsappChangeStatus($id)
    {
        $whatsapp = Csnumber::findOrFail($id);
        $whatsapp->is_active = $whatsapp->is_active == 1 ? 0 : 1;
        $whatsapp->save();
        alert('success', 'Berhasil Merubah Status', 'success');
        return redirect()->back();
    }

    function formatNomorHP($nomorHP)
    {
        // Menghilangkan semua karakter selain angka
        $nomorHP = preg_replace("/[^0-9]/", "", $nomorHP);

        // Jika nomorHP dimulai dengan '0', maka ubah menjadi '62'
        if (substr($nomorHP, 0, 1) === '0') {
            $nomorHP = '62' . substr($nomorHP, 1);
        }

        return $nomorHP;
    }

    public function postIpAddress(Request $request)
    {
        Ipaddress::create([
            'wifi_name' => $request->wifi_name,
            'ip_address' => $request->ip_address
        ]);
        alert('success', 'Berhasil Menambah Data', 'success');
        return redirect()->back();
    }

    public function wifiChangeStatus($id)
    {
        $wifi = Ipaddress::findOrFail($id);
        $wifi->is_active = $wifi->is_active == 1 ? 0 : 1;
        $wifi->save();
        alert('success', 'Berhasil Merubah Status', 'success');
        return redirect()->back();
    }
}
