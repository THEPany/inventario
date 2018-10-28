<?php

use Illuminate\Database\Seeder;
use Silber\Bouncer\Database\Role;
use Silber\Bouncer\Database\Ability;
use App\{BranchOffice, Product, Provider, Purchase};

class BouncerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAbilities();
        $this->createRoles();
    }

    protected function createAbilities()
    {
        $this->allAbility();
        $this->productAbilities();
        $this->proveedorAbilities();
        $this->purchaseAbilities();
        $this->branchOfficeAbilities();
    }

    protected function createRoles()
    {
        /*
        |--------------------------------------------------------------------------
        | Rol de administrador
        |--------------------------------------------------------------------------
        */
        $admin = Bouncer::role()->create([
            'name' => 'admin',
            'title' => 'Administrador',
        ]);
        Bouncer::allow($admin)->everything();
    }

    /*
    |--------------------------------------------------------------------------
    | Todas las habilidades
    |--------------------------------------------------------------------------
    |
    | Estas habilidades solo las puede tener un rol de administrador, ya que tienen autorizacion total sobre
    | los distintos modulos del sistema.
    */
    protected function allAbility(): void
    {
        Bouncer::ability()->create([
            'name' => '*',
            'title' => 'Todas las habilidades',
            'entity_type' => '*',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Productos Habilidades
    |--------------------------------------------------------------------------
    |
    | Todas la habilidades para la gestion del crud de productos
    */
    protected function productAbilities(): void
    {
        Bouncer::ability()->createForModel(Product::class, [
            'name' => 'view',
            'title' => 'Ver productos'
        ]);

        Bouncer::ability()->createForModel(Product::class, [
            'name' => 'create',
            'title' => 'Crear productos'
        ]);

        Bouncer::ability()->createForModel(Product::class, [
            'name' => 'update',
            'title' => 'Actualizar productos'
        ]);
    }

    /*
      |--------------------------------------------------------------------------
      | Proveedor Habilidades
      |--------------------------------------------------------------------------
      |
      | Todas la habilidades para la gestion del crud de proveedores
      */
    protected function proveedorAbilities(): void
    {
        Bouncer::ability()->createForModel(Provider::class, [
            'name' => 'view',
            'title' => 'Ver proveedores'
        ]);

        Bouncer::ability()->createForModel(Provider::class, [
            'name' => 'create',
            'title' => 'Crear proveedores'
        ]);

        Bouncer::ability()->createForModel(Provider::class, [
            'name' => 'update',
            'title' => 'Actualizar proveedores'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Compras Habilidades
    |--------------------------------------------------------------------------
    |
    | Todas la habilidades para la gestion del crud de compras
    */
    protected function purchaseAbilities(): void
    {
        Bouncer::ability()->createForModel(Purchase::class, [
            'name' => 'view',
            'title' => 'Ver compras'
        ]);

        Bouncer::ability()->createForModel(Purchase::class, [
            'name' => 'create',
            'title' => 'Crear compras'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Sucursales Habilidades
    |--------------------------------------------------------------------------
    |
    | Todas la habilidades para la gestion del crud de sucursales
    */
    protected function branchOfficeAbilities(): void
    {
        Bouncer::ability()->createForModel(BranchOffice::class, [
            'name' => 'view',
            'title' => 'Ver compras'
        ]);

        Bouncer::ability()->createForModel(BranchOffice::class, [
            'name' => 'create',
            'title' => 'Crear compras'
        ]);

        Bouncer::ability()->createForModel(BranchOffice::class, [
            'name' => 'update',
            'title' => 'Actualizar compras'
        ]);
    }

}
