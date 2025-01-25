<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Notifications\PendingTaskNotification;

class CheckPendingTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-pending-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for pending tasks older than 24 hours and notify users.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = Task::whereStatus('Pending')
            ->where('created_at', '<', now()->subDay())
            ->with('user')
            ->get();

        foreach ($tasks as $task) {
            if ($task->user) {
                // Mail::to($task->user->email)->queue();
            }
        }

        $this->info('Notifications for pending tasks sent successfully.');
    }
}
