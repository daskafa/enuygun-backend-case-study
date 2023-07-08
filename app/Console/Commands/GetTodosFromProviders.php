<?php

namespace App\Console\Commands;

use App\Adapters\TodoListAdapter;
use App\Constants\ProviderConstants;
use App\ProviderApiRequests\FirstProviderApiRequest;
use App\ProviderApiRequests\SecondProviderApiRequest;
use App\Repositories\DeveloperTodoRepository;
use App\Services\DeveloperTodoService;
use Illuminate\Console\Command;

class GetTodosFromProviders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get-todos-from-providers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get todos from providers and save to database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $firstProviderApiRequest = new FirstProviderApiRequest(ProviderConstants::FIRST_PROVIDER_URL);
        $secondProviderApiRequest = new SecondProviderApiRequest(ProviderConstants::SECOND_PROVIDER_URL);
        $todoListAdapter = new TodoListAdapter($firstProviderApiRequest, $secondProviderApiRequest);

        $developerTodoRepository = new DeveloperTodoRepository();
        (new DeveloperTodoService($developerTodoRepository))
            ->saveTodos($todoListAdapter->getMergedFormattedTodos());

        $this->info('Developer todos saved successfully');
    }
}
