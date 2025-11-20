<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Account;

class CreateAccount extends Command
{
    protected $signature = 'create:account {company_id} {name}';

    protected $description = 'Создать новый аккаунт';

    public function handle()
    {
        $company_id = $this->argument('company_id');
        $name = $this->argument('name');

        $account = Account::create([
            'company_id' => $company_id,
            'name' => $name,
        ]);

        $this->info("Аккаунт '{$account->name}' успешно создан с ID: {$account->id}");
    }
}
