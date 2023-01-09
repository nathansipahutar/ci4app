<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function __construct()
    {
        //membuat user model untuk konek ke database 
        $this->userModel = new UserModel();

        //meload validation
        $this->validation = \Config\Services::validation();

        //meload session
        $this->session = \Config\Services::session();
        $this->email = \Config\Services::email();

        //query builder
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('user');
    }

    public function login()
    {
        //menampilkan halaman login

        return view('auths/login', [
            'title' => 'Login | Bunch of Gifts',
            'statusNav' => 'login'
        ]);
    }

    public function register()
    {
        //menampilkan halaman register
        return view('auths/register', [
            'title' => 'Register | Bunch of Gifts',
            'statusNav' => 'login'
        ]);
    }

    public function valid_register()
    {
        //tangkap data dari form 
        $data = $this->request->getPost();

        //jalankan validasi
        $this->validation->run($data, 'register');

        //cek errornya
        $errors = $this->validation->getErrors();

        //jika ada error kembalikan ke halaman register
        if ($errors) {
            session()->setFlashdata('error', $errors);
            return redirect()->to('/register');
        }

        //jika tdk ada error 

        //buat salt
        $salt = uniqid('', true);

        //hash password digabung dengan salt
        $password = md5($data['password']) . $salt;

        //GENERATE ID
        $this->builder->selectMax("id");
        $id_tangkap = $this->builder->countAll();
        $id_tangkap++;
        // dd($id_tangkap);

        //masukan data ke database
        $this->userModel->insert([
            'id' => "PLG-" . $id_tangkap,
            'username' => $data['username'],
            'email' => $data['email'],
            'no_hp' => $data['no_hp'],
            'password' => $password,
            'salt' => $salt,
            'role' => 2
        ]);

        //EMAIL INVOICE
        // private function sendEmail($attachment, $to, $title, $message)
        // {
        $this->email->setFrom('bunchofgift.id@gmail.com', 'Bunch of Gifts');
        //EMAIL INVOICE manual
        // $this->email->setTo('captaintsubasa1611@gmail.com');
        $this->email->setTo($data['email']);

        // $this->email->attach($attachment);
        $this->email->SetSubject('Konfirmasi akun email');

        // $this->email->setMessage('Terima kasih sudah membuat akun!'); // Our message above including the link
        // $this->email->setMessage('Berikut adalah informasi seputar akun yang anda buat.'); // Our message above including the link
        // $this->email->setMessage(' ------------------------'); // Our message above including the link
        // $this->email->setMessage('Username: ' . $data['username'] . ''); // Our message above including the link
        // $this->email->setMessage('Nomor HP: ' . $data['no_hp'] . ''); // Our message above including the link
        // $this->email->setMessage('------------------------'); // Our message above including the link
        // $this->email->setMessage('Silahkan klik link berikut untuk mengaktivasi akun anda.'); // Our message above including the link
        $this->email->setMessage('Silahkan klik link berikut untuk mengaktivasi akun anda. http://localhost:8080/emailValidation/' . $data['username'] . ''); // Our message above including the link

        if (!$this->email->send()) {
            return redirect()->to('/register');
        } else {
            session()->setFlashdata('login', 'Anda berhasil mendaftar, silahkan aktivasi akun terlebih dahulu');
            // session()->setFlashdata('login', 'Anda berhasil mendaftar, silahkan login');
            return redirect()->to('/login');
        }
        // }

        //arahkan ke halaman login
    }
    public function emailValidation($username)
    {
        //menampilkan halaman register

        $user = $this->userModel->getUsernameDetail($username);

        $this->userModel->save([
            'id' => $user['id'],
            'active' => '1',
        ]);

        return redirect()->to('/login');
        // return view('auths/register', ['title' => 'Register | Bunch of Gifts',]);
    }

    public function valid_login()
    {
        //ambil data dari form
        $data = $this->request->getPost();

        //ambil data user di database yang usernamenya sama 
        $user = $this->userModel->where('username', $data['username'])->first();

        //cek apakah username ditemukan
        if ($user) {
            //cek password
            //jika salah arahkan lagi ke halaman login
            if ($user['password'] != md5($data['password']) . $user['salt']) {
                session()->setFlashdata('password', 'Password salah');
                return redirect()->to('/login');
            } else if ($user['active'] != 1) {
                session()->setFlashdata('active', 'Anda belum mengaktivasi akun ini, silahkan cek email anda');
                return redirect()->to('/login');
            } else {
                //jika benar, arahkan user masuk ke aplikasi 
                $sessLogin = [
                    'isLogin' => true,
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'email' => $user['email'],
                    'no_hp' => $user['no_hp'],
                ];
                $this->session->set($sessLogin);
                return redirect()->to('/admin');
            }
        } else {
            //jika username tidak ditemukan, balikkan ke halaman login
            session()->setFlashdata('username', 'Username tidak ditemukan');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        //hancurkan session 
        //balikan ke halaman login
        $this->session->destroy();
        return redirect()->to('/');
    }
}
