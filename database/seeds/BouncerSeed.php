<?php

use Illuminate\Database\Seeder;
use Silber\Bouncer\Database\Role;
use Silber\Bouncer\Database\Ability;
use App\{BranchOffice, Product, Provider, Purchase, Transaction, User};

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
        $this->userAbilities();
        $this->transactionAbilities();
        $this->othersAbilities();
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
            'title' => 'Crear producto'
        ]);

        Bouncer::ability()->createForModel(Product::class, [
            'name' => 'update',
            'title' => 'Actualizar producto'
        ]);

        // Tenant Abilities

        Bouncer::ability()->createForModel(Product::class, [
            'name' => 'tenant-view',
            'title' => 'Ver productos en sucursal'
        ]);

        Bouncer::ability()->createForModel(Product::class, [
            'name' => 'tenant-create',
            'title' => 'Crear producto en sucursal'
        ]);

        Bouncer::ability()->createForModel(Product::class, [
            'name' => 'tenant-update',
            'title' => 'Actualizar producto en sucursal'
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
            'title' => 'Crear proveedor'
        ]);

        Bouncer::ability()->createForModel(Provider::class, [
            'name' => 'update',
            'title' => 'Actualizar proveedor'
        ]);

        //Tenant Abilities

        Bouncer::ability()->createForModel(Provider::class, [
            'name' => 'tenant-view',
            'title' => 'Ver proveedores en sucursal'
        ]);

        Bouncer::ability()->createForModel(Provider::class, [
            'name' => 'tenant-create',
            'title' => 'Crear proveedor en sucursal'
        ]);

        Bouncer::ability()->createForModel(Provider::class, [
            'name' => 'tenant-update',
            'title' => 'Actualizar proveedor en sucursal'
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
            'title' => 'Crear compra'
        ]);

        // Tenant Abilities

        Bouncer::ability()->createForModel(Purchase::class, [
            'name' => 'tenant-view',
            'title' => 'Ver compras en sucursal'
        ]);

        Bouncer::ability()->createForModel(Purchase::class, [
            'name' => 'tenant-create',
            'title' => 'Crear compra en sucursal'
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
            'title' => 'Ver sucursales'
        ]);

        Bouncer::ability()->createForModel(BranchOffice::class, [
            'name' => 'create',
            'title' => 'Crear sucursal'
        ]);

        Bouncer::ability()->createForModel(BranchOffice::class, [
            'name' => 'update',
            'title' => 'Actualizar sucursal'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Usuarios Habilidades
    |--------------------------------------------------------------------------
    |
    | Todas la habilidades para la gestion del crud de usuarios
    */
    protected function userAbilities(): void
    {
        Bouncer::ability()->createForModel(User::class, [
            'name' => 'view',
            'title' => 'Ver usuarios'
        ]);

        Bouncer::ability()->createForModel(User::class, [
            'name' => 'create',
            'title' => 'Crear usuario'
        ]);

        Bouncer::ability()->createForModel(User::class, [
            'name' => 'update',
            'title' => 'Actualizar usuario'
        ]);
    }

    protected function transactionAbilities(): void
    {
        Bouncer::ability()->createForModel(Transaction::class, [
            'name' => 'view',
            'title' => 'ver transacciónes'
        ]);

        Bouncer::ability()->createForModel(Transaction::class, [
            'name' => 'create',
            'title' => 'Crear transacción'
        ]);

        Bouncer::ability()->createForModel(Transaction::class, [
            'name' => 'move-product',
            'title' => 'Mover productos a otras sucursales'
        ]);

        // Tenant Abilities
        Bouncer::ability()->createForModel(Transaction::class, [
            'name' => 'tenant-view',
            'title' => 'ver transacciónes en sucursal'
        ]);

        Bouncer::ability()->createForModel(Transaction::class, [
            'name' => 'tenant-create',
            'title' => 'Crear transacción en sucursal'
        ]);
    }

    protected function othersAbilities(): void
    {
        Bouncer::ability()->create([
            'name' => ' view-dashboard',
            'title' => 'Ver dashboard'
        ]);

        // Tenant Abilities

        Bouncer::ability()->create([
            'name' => ' tenant-view-dashboard',
            'title' => 'Ver dashboard en sucursal'
        ]);
    }

}
