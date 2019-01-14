<?php

namespace App\Http\Controllers;

use App\User;
use App\Account;
use Illuminate\Http\Request;

class AdminController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin');
    }

    public function uploadFile(Request $request){
       $path =  $request->file->path();

        if ($fh = fopen($path, 'r')) {
            while (!feof($fh)) {
                $line = explode( '/', fgets($fh));
                if(count($line) > 2 ){
                    $user = User::firstOrCreate(['cedula' => $this->clearCedula($line[0])]);

                    $account = Account::where('name', $line[1])->where('user_id', $user->id)->first();
                    
                    if(!$account){
                        $account = Account::create([
                            'name'=> $line[1],
                            'user_id' => $user->id
                        ]);
                    }

                    $account->balance = ($line[1] == 'GOMAS' ? $line[3] : $line[2]);
                    $account->save();

                    $user->accounts()->save($account);
                }

            }
            fclose($fh);
        }

    }

    public function clearCedula($cedula){
       $cedulaArry = explode('-', $cedula);
       return implode('', $cedulaArry);
    }

}