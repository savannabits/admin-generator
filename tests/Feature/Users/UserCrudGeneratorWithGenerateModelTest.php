<?php

namespace Savannabits\AdminGenerator\Tests\Feature\Users;

use Savannabits\AdminGenerator\Tests\UserTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\File;

class UserCrudGeneratorWithGenerateModelTest extends UserTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_model_name_should_auto_generate_from_table_name_if_required(): void
    {
        $filePath = base_path('app/Models/User.php');

        $this->assertFileNotExists($filePath);

        $this->artisan('admin:generate:user', [
            '--generate-model' => true
        ]);

        $this->assertFileExists($filePath);
        $this->assertStringStartsWith('<?php

namespace App\Models;

use Savannabits\AdminAuth\Activation\Contracts\CanActivate as CanActivateContract;
use Savannabits\AdminAuth\Activation\Traits\CanActivate;
use Savannabits\AdminAuth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements CanActivateContract
{', File::get($filePath));
    }

    /** @test */
    public function user_model_name_should_use_custom_name_if_required(): void
    {
        $filePath = base_path('app/Models/Auth/User.php');

        $this->assertFileNotExists($filePath);

        $this->artisan('admin:generate:user', [
            '--model-name' => 'Auth\\User',
            '--generate-model' => true
        ]);

        $this->assertFileExists($filePath);
        $this->assertStringStartsWith('<?php

namespace App\Models\Auth;

use Savannabits\AdminAuth\Activation\Contracts\CanActivate as CanActivateContract;
use Savannabits\AdminAuth\Activation\Traits\CanActivate;
use Savannabits\AdminAuth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements CanActivateContract
{', File::get($filePath));
    }

    /** @test */
    public function user_model_name_should_use_custom_name_outside_default_folder_if_required(): void
    {
        $filePath = base_path('app/Auth/User.php');

        $this->assertFileNotExists($filePath);

        $this->artisan('admin:generate:user', [
            '--model-name' => 'App\\Auth\\User',
            '--generate-model' => true
        ]);

        $this->assertFileExists($filePath);
        $this->assertStringStartsWith('<?php

namespace App\Auth;

use Savannabits\AdminAuth\Activation\Contracts\CanActivate as CanActivateContract;
use Savannabits\AdminAuth\Activation\Traits\CanActivate;
use Savannabits\AdminAuth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements CanActivateContract
{', File::get($filePath));
    }

}
