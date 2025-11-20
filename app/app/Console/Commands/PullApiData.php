<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Company;
use App\Services\ApiServiceRunner;

class PullApiData extends Command
{
    protected $signature = 'pull:api-data {--company=}';
    protected $description = 'Выгрузка данных из API сервисов';

    public function handle()
    {
        $companyId = $this->option('company');

        if ($companyId) {
            $company = Company::findOrFail($companyId);
            $this->runForCompany($company);
            return;
        }

        Company::chunk(50, function ($companies) {
            foreach ($companies as $company) {
                $this->runForCompany($company);
            }
        });
    }

    private function runForCompany($company)
    {
        $this->info("Компания: {$company->name}");

        $runner = new ApiServiceRunner(function ($m) {
            $this->info($m);
        });

        $runner->runForCompany($company);
    }
}
