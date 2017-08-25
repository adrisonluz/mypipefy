<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\ApiPipefy;
use App\PipefyUser as PipefyUsersDB;
use Illuminate\Support\Facades\Storage;

class PipefyUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pipefy:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza a tabela de usuários do Pipefy';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->ask('Informe o seu Email');
        $token = User::getUserToken($email);

        if(is_null($token)){
            $this->error('Token do usuário não encontrado');
        }

        $apiPipefy = new ApiPipefy;
        $apiPipefy->key = $token;
        $users = $apiPipefy->getUsers();

        $bar = $this->output->createProgressBar(count($users));
        
        if(!is_null($users)){
            foreach($users as $user){
                $pipefyUser = PipefyUsersDB::firstOrNew([
                    'pipefy_id'  => $user->user->id,
                    'email'      => $user->user->email,
                ]);

                $pipefyUser->username   = $user->user->username;
                $pipefyUser->name       = $user->user->name;

                //Save a image
                $extension = pathinfo($user->user->avatarUrl, PATHINFO_EXTENSION);
                $extension = substr($extension, 0, 4);
                $extension = rtrim($extension, '?');

                $filename = $user->user->id.'_'.str_slug($user->user->username).'.'.$extension;

                $image = file_get_contents($user->user->avatarUrl);

                if(Storage::disk('local')->put('pipefy_avatar/'.$filename, $image)){
                    $pipefyUser->avatar_url = $filename;
                }
                
                $pipefyUser->save();

                $bar->advance();
            }
        }else{
           $this->error('Houve um problema na comunicação com a Api do Pipefy'); 
        }
        $bar->finish();
        $this->info("\nUsuários importados com sucesso!");
    }
}
