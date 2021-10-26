<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class ChangeSuperAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sa:modify-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to change website system administrator\'s password';

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
     * @return int
     */
    public function handle()
    {
        try {
            $sa = User::withCount(['roles' => function ($query) {
                return $query->where('name', 'SuperAdmin');
            }])->having('roles_count', '>', 0)->first();

            if (empty($sa)) {
                $this->error("The system has no super admin user. Did you run the seeder? Please make sure to run the seeder first.");
                return 0;
            }

            $old_password = $this->secret('Current password');
            if (Auth::attempt(['email' => $sa->email, 'password' => $old_password, 'account_disabled' => 0])) {
                $password_validator = new Password(8);
                $rules = ['new_password' => Password::min(8), $password_validator->letters(), $password_validator->symbols()];
                $new_password = $this->secret('New password');
                $validation = Validator::make(['new_password' => $new_password], $rules);
                if ($validation->passes()) {
                    $password_confirmation = $this->secret('Confirmation password');
                    if (strcasecmp($new_password, $password_confirmation) == 0) {
                        if ($this->confirm("Are you sure you want to continue? [yes|no]")) {
                            $sa->password = Hash::make($new_password);
                            $sa->save();
                            $this->info("You have modified sa's password successfully.");
                        }
                    } else {
                        $this->warn("Your password confirmation doesn't match.");
                    }
                } else {
                    $this->warn("Your new password does not conform with configured password strength policy. The password should have minimum of 8 characters and it should contain a letter and symbol.");
                }
            } else {
                $this->error("You have provided invalid password.");
            }
            return 0;
        } catch (\Exception $ex) {
            $this->error($ex->getMessage());
        }
    }
}
