<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Company;

class CreateCompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:company {name} {--description=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создать новую компанию с описанием';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = trim($this->argument('name'));

        if (empty($name)) {
            $this->error('Имя компании не может быть пустым. Создание отменено.');
            return 1;
        }
        $description = $this->option('description') ?? '';

        $company = Company::create([
            'name' => $name,
            'description' => $description,
        ]);

        $this->info("Компания '{$company->name}' успешно создана с ID: {$company->id}");
    }
}
