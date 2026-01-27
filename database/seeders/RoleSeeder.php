<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Models\Module;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'Users' => [
                'actions' => [
                    'Index'   => 'user.index',
                    'Create'  => 'user.create',
                    'Edit'    => 'user.edit',
                    'Trash'   => 'user.destroy',
                ],
                'roles' => [
                    RoleEnum::SUPER_ADMIN => ['Index', 'Create', 'Edit', 'Trash'],
                ]
            ],
            'Roles' => [
                'actions' => [
                    'Index'   => 'role.index',
                    'Create'  => 'role.create',
                    'Edit'    => 'role.edit',
                    'Trash'   => 'role.destroy',
                ],
                'roles' => [
                    RoleEnum::SUPER_ADMIN => ['Index', 'Create', 'Edit', 'Trash'],
                ],
            ],
            'Electric' => [
                'actions' => [
                    'Index'   => 'electric.index',
                    'Create'  => 'electric.create',
                    'Edit'    => 'electric.edit',
                    'Trash'   => 'electric.destroy',
                ],
                'roles' => [
                    RoleEnum::SUPER_ADMIN => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Electric => ['Index', 'Create', 'Edit', 'Trash'],
                ],
            ],
            'Anti-Encroachment' => [
                'actions' => [
                    'Index'   => 'encroachment.index',
                    'Create'  => 'encroachment.create',
                    'Edit'    => 'encroachment.edit',
                    'Trash'   => 'encroachment.destroy',
                ],
                'roles' => [
                    RoleEnum::SUPER_ADMIN => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Encroachment => ['Index', 'Create', 'Edit', 'Trash'],
                ],
            ],
            'Record' => [
                'actions' => [
                    'Index'   => 'record.index',
                    'Create'  => 'record.create',
                    'Edit'    => 'record.edit',
                    'Trash'   => 'record.destroy',
                ],
                'roles' => [
                    RoleEnum::SUPER_ADMIN => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Record => ['Index', 'Create', 'Edit', 'Trash'],
                ],
            ],
            'Fire' => [
                'actions' => [
                    'Index'   => 'fire.index',
                    'Create'  => 'fire.create',
                    'Edit'    => 'fire.edit',
                    'Trash'   => 'fire.destroy',
                ],
                'roles' => [
                    RoleEnum::SUPER_ADMIN => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Fire => ['Index', 'Create', 'Edit', 'Trash'],
                ],
            ],
            'Building' => [
                'actions' => [
                    'Index'   => 'building.index',
                    'Create'  => 'building.create',
                    'Edit'    => 'building.edit',
                    'Trash'   => 'building.destroy',
                ],
                'roles' => [
                    RoleEnum::SUPER_ADMIN => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Building => ['Index', 'Create', 'Edit', 'Trash'],
                ],
            ],
            'Transport' => [
                'actions' => [
                    'Index'   => 'transport.index',
                    'Create'  => 'transport.create',
                    'Edit'    => 'transport.edit',
                    'Trash'   => 'transport.destroy',
                ],
                'roles' => [
                    RoleEnum::SUPER_ADMIN => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Transport => ['Index', 'Create', 'Edit', 'Trash'],
                ],
            ],
            'Sanitation' => [
                'actions' => [
                    'Index'   => 'sanitation.index',
                    'Create'  => 'sanitation.create',
                    'Edit'    => 'sanitation.edit',
                    'Trash'   => 'sanitation.destroy',
                ],
                'roles' => [
                    RoleEnum::SUPER_ADMIN => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Sanitation => ['Index', 'Create', 'Edit', 'Trash'],
                ],
            ],
            'Taxation' => [
                'actions' => [
                    'Index'   => 'taxation.index',
                    'Create'  => 'taxation.create',
                    'Edit'    => 'taxation.edit',
                    'Trash'   => 'taxation.destroy',
                ],
                'roles' => [
                    RoleEnum::SUPER_ADMIN => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Taxation => ['Index', 'Create', 'Edit', 'Trash'],
                ],
            ],
            'Health' => [
                'actions' => [
                    'Index'   => 'health.index',
                    'Create'  => 'health.create',
                    'Edit'    => 'health.edit',
                    'Trash'   => 'health.destroy',
                ],
                'roles' => [
                    RoleEnum::SUPER_ADMIN => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Health => ['Index', 'Create', 'Edit', 'Trash'],
                ],
            ],
            'Schools' => [
                'actions' => [
                    'Index'   => 'schools.index',
                    'Create'  => 'schools.create',
                    'Edit'    => 'schools.edit',
                    'Trash'   => 'schools.destroy',
                ],
                'roles' => [
                    RoleEnum::SUPER_ADMIN => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Health => ['Index', 'Create', 'Edit', 'Trash'],
                ],
            ],
            'Admin' => [
                'actions' => [
                    'Index'   => 'admin.index',
                    'Create'  => 'admin.create',
                    'Edit'    => 'admin.edit',
                    'Trash'   => 'admin.destroy',
                ],
                'roles' => [
                    RoleEnum::SUPER_ADMIN => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::AdminBranch => ['Index', 'Create', 'Edit', 'Trash'],
                ],
            ],
            'MT' => [
                'actions' => [
                    'Index'   => 'mt.index',
                    'Create'  => 'mt.create',
                    'Edit'    => 'mt.edit',
                    'Trash'   => 'mt.destroy',
                ],
                'roles' => [
                    RoleEnum::SUPER_ADMIN => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Mt => ['Index', 'Create', 'Edit', 'Trash'],
                ],
            ],
            'Account' => [
                'actions' => [
                    'Index'   => 'account.index',
                    'Create'  => 'account.create',
                    'Edit'    => 'account.edit',
                    'Trash'   => 'account.destroy',
                ],
                'roles' => [
                    RoleEnum::SUPER_ADMIN => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Account => ['Index', 'Create', 'Edit', 'Trash'],
                ],
            ],
            'Engineering' => [
                'actions' => [
                    'Index'   => 'engineering.index',
                    'Create'  => 'engineering.create',
                    'Edit'    => 'engineering.edit',
                    'Trash'   => 'engineering.destroy',
                ],
                'roles' => [
                    RoleEnum::SUPER_ADMIN => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Engineering => ['Index', 'Create', 'Edit', 'Trash'],
                ],
            ],
            'Veterinary' => [
                'actions' => [
                    'Index'   => 'veterinary.index',
                    'Create'  => 'veterinary.create',
                    'Edit'    => 'veterinary.edit',
                    'Trash'   => 'veterinary.destroy',
                ],
                'roles' => [
                    RoleEnum::SUPER_ADMIN => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Veterinary => ['Index', 'Create', 'Edit', 'Trash'],
                ],
            ],
            'Library' => [
                'actions' => [
                    'Index'   => 'library.index',
                    'Create'  => 'library.create',
                    'Edit'    => 'library.edit',
                    'Trash'   => 'library.destroy',
                ],
                'roles' => [
                    RoleEnum::SUPER_ADMIN => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Library => ['Index', 'Create', 'Edit', 'Trash'],
                ],

            ],
            'Law' => [
                'actions' => [
                    'Index'   => 'law.index',
                    'Create'  => 'law.create',
                    'Edit'    => 'law.edit',
                    'Trash'   => 'law.destroy',
                ],
                'roles' => [
                    RoleEnum::SUPER_ADMIN => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Law => ['Index', 'Create', 'Edit', 'Trash'],
                ],

            ],

            'Dashboard' => [
                'actions' => [
                    'Index'   => 'dashboard.index',
                ],
                'roles' => [
                    RoleEnum::SUPER_ADMIN => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Encroachment => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Electric => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Fire => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Building => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Transport => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Sanitation => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Taxation => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Health => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::AdminBranch => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Mt => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Account => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Engineering => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Veterinary => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Library => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Schools => ['Index', 'Create', 'Edit', 'Trash'],
                    RoleEnum::Law => ['Index', 'Create', 'Edit', 'Trash'],
                ],
            ],
        ];

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $superAdminPermissions = [];
        $electricBranchPermissions = [];
        $recordBranchPermissions = [];
        $fireBranchPermissions = [];
        $encroachmentPermissions = [];
        $buildingBranchPermissions = [];
        $transportBranchPermissions = [];
        $sanitationBranchPermissions = [];
        $taxationBranchPermissions = [];
        $healthBranchPermissions = [];
        $adminBranchPermissions = [];
        $mtBranchPermissions = [];
        $accountBranchPermissions = [];
        $engineeringBranchPermissions = [];
        $veterinaryBranchPermissions = [];
        $libraryBranchPermissions = [];
        $lawBranchPermissions = [];
        $schoolsPermissions = [];
        foreach ($modules as $key => $value) {
            Module::updateOrCreate(['name' => $key], ['name' => $key, 'actions' => $value['actions']]);
            foreach ($value['actions'] as $key => $permission) {
                if (!Permission::where('name', $permission)->first()) {
                    $permission = Permission::create(['name' => $permission]);
                }
                if (isset($value['roles'])) {
                    foreach ($value['roles'] as $role => $allowed_actions) {
                        if ($role == RoleEnum::SUPER_ADMIN) {
                            if (in_array($key, $allowed_actions)) {
                                $superAdminPermissions[] = $permission;
                            }
                        }
                        if ($role == RoleEnum::Electric) {
                            if (in_array($key, $allowed_actions)) {
                                $electricBranchPermissions[] = $permission;
                            }
                        }
                        if ($role == RoleEnum::Record) {
                            if (in_array($key, $allowed_actions)) {
                                $recordBranchPermissions[] = $permission;
                            }
                        }
                        if ($role == RoleEnum::Fire) {
                            if (in_array($key, $allowed_actions)) {
                                $fireBranchPermissions[] = $permission;
                            }
                        }
                        if ($role == RoleEnum::Encroachment) {
                            if (in_array($key, $allowed_actions)) {
                                $encroachmentPermissions = $permission;
                            }
                        }
                        if ($role == RoleEnum::Building) {
                            if (in_array($key, $allowed_actions)) {
                                $buildingBranchPermissions[] = $permission;
                            }
                        }
                        if ($role == RoleEnum::Transport) {
                            if (in_array($key, $allowed_actions)) {
                                $transportBranchPermissions[] = $permission;
                            }
                        }
                        if ($role == RoleEnum::Sanitation) {
                            if (in_array($key, $allowed_actions)) {
                                $sanitationBranchPermissions[] = $permission;
                            }
                        }
                        if ($role == RoleEnum::Taxation) {
                            if (in_array($key, $allowed_actions)) {
                                $taxationBranchPermissions[] = $permission;
                            }
                        }
                        if ($role == RoleEnum::Health) {
                            if (in_array($key, $allowed_actions)) {
                                $healthBranchPermissions[] = $permission;
                            }
                        }
                        if ($role == RoleEnum::Schools) {
                            if (in_array($key, $allowed_actions)) {
                                $schoolsPermissions[] = $permission;
                            }
                        }
                        if ($role == RoleEnum::AdminBranch) {
                            if (in_array($key, $allowed_actions)) {
                                $adminBranchPermissions[] = $permission;
                            }
                        }
                        if ($role == RoleEnum::Mt) {
                            if (in_array($key, $allowed_actions)) {
                                $mtBranchPermissions[] = $permission;
                            }
                        }
                        if ($role == RoleEnum::Account) {
                            if (in_array($key, $allowed_actions)) {
                                $accountBranchPermissions[] = $permission;
                            }
                        }
                        if ($role == RoleEnum::Engineering) {
                            if (in_array($key, $allowed_actions)) {
                                $engineeringBranchPermissions[] = $permission;
                            }
                        }
                        if ($role == RoleEnum::Veterinary) {
                            if (in_array($key, $allowed_actions)) {
                                $veterinaryBranchPermissions[] = $permission;
                            }
                        }
                        if ($role == RoleEnum::Library) {
                            if (in_array($key, $allowed_actions)) {
                                $libraryBranchPermissions[] = $permission;
                            }
                        }
                        if ($role == RoleEnum::Law) {
                            if (in_array($key, $allowed_actions)) {
                                $lawBranchPermissions[] = $permission;
                            }
                        }
                    }
                }
            }

        }

        //Admin Role
        $superAdmin = Role::create([
            'name' => RoleEnum::SUPER_ADMIN,
            'system_reserve' => true

        ]);
        $superAdmin->givePermissionTo(Permission::all());
        $user = User::factory()->create([
            'name' => 'Administrator',
            'email' => 'administrator@mcq.gob.pk',
            'password' => Hash::make('admin@123'),
            'system_reserve' => true

        ]);
        $user->assignRole($superAdmin);

        //Electric Branch
        $electricBranchRole = Role::create([
            'name' => RoleEnum::Electric,
            'system_reserve' => false

        ]);

        $electricBranchRole->givePermissionTo($electricBranchPermissions);
        $electricBranch = User::factory()->create([
            'name' => 'Electric Branch',
            'email' => 'electric_branch@mcq.gob.pk',
            'password' => Hash::make('electric@123'),
            'branchID' => 1,
            'system_reserve' => false


        ]);
        $electricBranch->assignRole($electricBranchRole);

        //Record Branch
        $recordBranchRole = Role::create([
            'name' => RoleEnum::Record,
            'system_reserve' => false

        ]);

        $recordBranchRole->givePermissionTo($recordBranchPermissions);
        $recordBranch = User::factory()->create([
            'name' => 'Record Branch',
            'email' => 'record_branch@mcq.gob.pk',
            'password' => Hash::make('record@123'),
            'branchID' => 2,
            'system_reserve' => false

        ]);
        $recordBranch->assignRole($recordBranchRole);

        //Fire Brigade Branch
        $fireBrigadeRole = Role::create([
            'name' => RoleEnum::Fire,
            'system_reserve' => false

        ]);

        $fireBrigadeRole->givePermissionTo($fireBranchPermissions);
        $fireBrigade = User::factory()->create([
            'name' => 'Fire Brigade Branch',
            'email' => 'fire_branch@mcq.gob.pk',
            'password' => Hash::make('fire@123'),
            'branchID' => 3,
            'system_reserve' => false

        ]);
        $fireBrigade->assignRole($fireBrigadeRole);

        //Anti-Encroachment Branch (Zone 1)
        $encroachmentRole = Role::create([
            'name' => RoleEnum::Encroachment,
            'system_reserve' => false

        ]);

        $encroachmentRole->givePermissionTo($encroachmentPermissions);
        $encroachment = User::factory()->create([
            'name' => 'Anti-Encroachment Branch',
            'email' => 'encroachment@mcq.gob.pk',
            'password' => Hash::make('encroachment@123'),
            'branchID' => 4,
            'system_reserve' => false

        ]);
        $encroachment->assignRole($encroachmentRole);

        //Building Branch
        $buildingBranchRole = Role::create([
            'name' => RoleEnum::Building,
            'system_reserve' => false

        ]);

        $buildingBranchRole->givePermissionTo($buildingBranchPermissions);
        $buildingBranch = User::factory()->create([
            'name' => 'Building Branch',
            'email' => 'building_branch@mcq.gob.pk',
            'password' => Hash::make('building@123'),
            'branchID' => 5,
            'system_reserve' => false

        ]);
        $buildingBranch->assignRole($buildingBranchRole);

        //Transport Branch
        $transportBranchRole = Role::create([
            'name' => RoleEnum::Transport,
            'system_reserve' => false

        ]);

        $transportBranchRole->givePermissionTo($transportBranchPermissions);
        $transportBranch = User::factory()->create([
            'name' => 'Transport Branch',
            'email' => 'transport_branch@mcq.gob.pk',
            'password' => Hash::make('transport@123'),
            'branchID' => 6,
            'system_reserve' => false

        ]);
        $transportBranch->assignRole($transportBranchRole);

        //Sanitation Branch
        $sanitationBranchRole = Role::create([
            'name' => RoleEnum::Sanitation,
            'system_reserve' => false

        ]);

        $sanitationBranchRole->givePermissionTo($sanitationBranchPermissions);
        $sanitationBranch = User::factory()->create([
            'name' => 'Sanitation Branch',
            'email' => 'sanitation_branch@mcq.gob.pk',
            'password' => Hash::make('sanitation@123'),
            'branchID' => 7,
            'system_reserve' => false

        ]);
        $sanitationBranch->assignRole($sanitationBranchRole);

        //Taxation Branch
        $taxationBranchRole = Role::create([
            'name' => RoleEnum::Taxation,
            'system_reserve' => false

        ]);

        $taxationBranchRole->givePermissionTo($taxationBranchPermissions);
        $taxationBranch = User::factory()->create([
            'name' => 'Taxation Branch',
            'email' => 'taxation_branch@mcq.gob.pk',
            'password' => Hash::make('taxation@123'),
            'branchID' => 8,
            'system_reserve' => false

        ]);
        $taxationBranch->assignRole($taxationBranchRole);

        //Health Branch
        $healthBranchRole = Role::create([
            'name' => RoleEnum::Health,
            'system_reserve' => false

        ]);

        $healthBranchRole->givePermissionTo($healthBranchPermissions);
        $healthBranch = User::factory()->create([
            'name' => 'Health Branch',
            'email' => 'health_branch@mcq.gob.pk',
            'password' => Hash::make('health@123'),
            'branchID' => 9,
            'system_reserve' => false

        ]);
        $healthBranch->assignRole($healthBranchRole);

        //Admin Branch
        $adminBranch = Role::create([
            'name' => RoleEnum::AdminBranch,
            'system_reserve' => false

        ]);

        $adminBranch->givePermissionTo($adminBranchPermissions);
        $healthBranch = User::factory()->create([
            'name' => 'Admin Branch',
            'email' => 'admin_branch@mcq.gob.pk',
            'password' => Hash::make('admin@123'),
            'branchID' => 10,
            'system_reserve' => false

        ]);
        $healthBranch->assignRole($adminBranch);

        //MT Branch
        $mtBranchRole = Role::create([
            'name' => RoleEnum::Mt,
        ]);

        $mtBranchRole->givePermissionTo($mtBranchPermissions);
        $mtBranch = User::factory()->create([
            'name' => 'MT Branch',
            'email' => 'mt_branch@mcq.gob.pk',
            'password' => Hash::make('mt@123'),
            'branchID' => 11,
            'system_reserve' => false

        ]);
        $mtBranch->assignRole($mtBranchRole);

        //Account Branch
        $accountBranchRole = Role::create([
            'name' => RoleEnum::Account,
            'system_reserve' => false

        ]);

        $accountBranchRole->givePermissionTo($accountBranchPermissions);
        $accountBranch = User::factory()->create([
            'name' => 'Account Branch',
            'email' => 'account_branch@mcq.gob.pk',
            'password' => Hash::make('account@123'),
            'branchID' => 12,
            'system_reserve' => false

        ]);
        $accountBranch->assignRole($accountBranchRole);

        //Engineering Branch
        $engineeringBranchRole = Role::create([
            'name' => RoleEnum::Engineering,
            'system_reserve' => false

        ]);

        $engineeringBranchRole->givePermissionTo($engineeringBranchPermissions);
        $engineeringBranch = User::factory()->create([
            'name' => 'Engineering Branch',
            'email' => 'engineering_branch@mcq.gob.pk',
            'password' => Hash::make('engineering@123'),
            'branchID' => 13,
            'system_reserve' => false

        ]);
        $engineeringBranch->assignRole($engineeringBranchRole);

        //Veterinary Branch
        $veterinaryBranchRole = Role::create([
            'name' => RoleEnum::Veterinary,
            'system_reserve' => false

        ]);

        $veterinaryBranchRole->givePermissionTo($veterinaryBranchPermissions);
        $veterinaryBranch = User::factory()->create([
            'name' => 'Veterinary Branch',
            'email' => 'veterinary_branch@mcq.gob.pk',
            'password' => Hash::make('veterinary@123'),
            'branchID' => 14,
            'system_reserve' => false

        ]);
        $veterinaryBranch->assignRole($veterinaryBranchRole);

        //Library
        $libraryBranchRole = Role::create([
            'name' => RoleEnum::Library,
            'system_reserve' => false

        ]);

        $libraryBranchRole->givePermissionTo($libraryBranchPermissions);
        $libraryBranch = User::factory()->create([
            'name' => 'Library Branch',
            'email' => 'library_branch@mcq.gob.pk',
            'password' => Hash::make('library@123'),
            'branchID' => 15,
            'system_reserve' => false

        ]);
        $libraryBranch->assignRole($libraryBranchRole);

        //Schools
        $schoolsRole = Role::create([
            'name' => RoleEnum::Schools,
            'system_reserve' => false

        ]);

        $schoolsRole->givePermissionTo($schoolsPermissions);
        $schoolBranch = User::factory()->create([
            'name' => 'MCQ Schools',
            'email' => 'schools_mcq@mcq.gob.pk',
            'password' => Hash::make('school@123'),
            'branchID' => 16,
            'system_reserve' => false

        ]);
        $schoolBranch->assignRole($schoolsRole);

        //Law
        $lawBranchRole = Role::create([
            'name' => RoleEnum::Law,
            'system_reserve' => false

        ]);

        $lawBranchRole->givePermissionTo($lawBranchPermissions);
        $schoolBranch = User::factory()->create([
            'name' => 'Law Branch',
            'email' => 'law_branch@mcq.gob.pk',
            'password' => Hash::make('law@123'),
            'branchID' => 18,
            'system_reserve' => false

        ]);
        $schoolBranch->assignRole($schoolsRole);

    }
}
