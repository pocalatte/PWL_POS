<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        //kita ambil data user lalu simpan pada variabel $user
        $user = Auth::user();

        //kondisi jika user nya ada
        if ($user) {
            //jika user nya memiliki level admin
            if ($user->level == '1') {
                return redirect()->intended('admin');
            }
            //jika usernya memiliki level manager
            else if ($user->level == '2') {
                return redirect()->intended('manager');
            }
        }
        return view('login');
    }

    public function proses_login(Request $request)
    {
        //kita buat validasi pada saat tombol login di klik
        //validasi nya username & password wajib di isi
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        //ambil data request username & password
        $kredensil = $request->only('username', 'password');
        // cek jika data username dan password valid (sesuai) dengan data
        if (Auth::attempt($kredensil)) {
            //kalau berhasim simpan data usernya di variabel $user
            $user = Auth::user();

            //cek lagi jika level user admin maka arahkan ke halaman admin
            if ($user->level == '1') {
                return redirect()->intended('admin');
            }
            //tapi jika level user manager maka arahkan ke halaman user
            else if ($user->level == '2') {
                return redirect()->intended('manager');
            }
            //jika belum ada role maka ke halaman /
            return redirect()->intended('/');
        }
        //jika tidak ada data user yang valid maka kembalikan lagi ke halaman login
        //pastikan kirim pesan error juga kalau login gagal ya
        return redirect('login')
            ->withInput()
            ->withErrors(['login_gagal' => 'Patikan kembali username dan password yang dimasukkan sudah benar']);
    }

    public function register()
    {
        //tampilkan view register
        return view('register');
    }

    //aksi form register
    public function proses_register(Request $request)
    {
        //kita buat validasi untuk formnya
        //validasinya yaitu semua field wajib di isi
        //validasi username itu harus unique atau tidak boleh duplicater username
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'username' => 'required|unique:UserModel',
            'password' => 'required',
        ]);

        //kalau berhasil isi level * hash password ya biar semua
        $request['level_id'] = '2';
        $request['password'] = Hash::make($request['password']);

        //masukan semua data pada request ke table user
        UserModel::create($request->all());

        //kalo berhasil arahkan ke halaman login
        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        //logout itu harus menghapus sessionnnya
        $request->session()->flush();
        //jalan kan juga fungsi logout pada auth
        Auth::logout();
        //kembalikan ke halaman login
        return redirect('login');
    }
}
