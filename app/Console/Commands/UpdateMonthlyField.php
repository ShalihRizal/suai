<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use Modules\Carline\Repositories\CarlineRepository;

class UpdateMonthlyField extends Command
{
    protected $signature = 'update:monthly-field';
    protected $description = 'Update a field in the database at the end of each month';

    protected $repository;

    public function __construct(CarlineRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    public function handle()
    {
        $this->repository->updateMonthlyField();

        $this->info('Monthly field update completed.');
    }
}
