<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\User;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin {name} {mail} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea un usuario administrador dado su correo y contraseña';

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
        $nombre = $this->argument('name');
        $correo = $this->argument('mail');
        $pwd = $this->argument('password');
        User::create([
            'name' => $nombre,
            'email' => $correo,
            'admin' => true,
            'password' => Hash::make($pwd),
        ]);
        $this->info('Administrador creado correctamente');
    }
}
