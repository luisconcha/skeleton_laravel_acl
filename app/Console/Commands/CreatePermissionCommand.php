<?php

namespace App\Console\Commands;

use App\Annotations\PermissionReader;
use App\Models\Permission;
use Illuminate\Console\Command;

class CreatePermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lacc:make-permissions';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Criação de permissões baseado em Controllers e actions';
    /**
     * @var PermissionReader
     */
    private $permissionReader;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct( PermissionReader $permissionReader )
    {
        parent::__construct();
        $this->permissionReader = $permissionReader;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $permissions = $this->permissionReader->getPermissions();

        foreach ( $permissions as $permission ):
            if ( !$this->existPermission( $permission ) ) {
                Permission::create( $permission );
            }
        endforeach;

        $this->info( "<info>Permissões carregadas com sucesso!</info>" );
    }

    private function existPermission( $permission )
    {
        $permission = Permission::where( [
            'name'          => $permission[ 'name' ],
            'resource_name' => $permission[ 'resource_name' ],
        ] )->first();

        return $permission != null;
    }
}
