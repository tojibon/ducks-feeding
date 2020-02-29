<?php

namespace App\Console\Commands;

use App\Feeding;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RecurringFeeding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recurring:feeding';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Will create entry for recurring feeding.';

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
     * @return mixed
     */
    public function handle()
    {
        $records = Feeding::recurring()->get();

        foreach ($records as $record) {
            $properties['food_type_id'] = $record->food_type_id;
            $properties['food_id'] = $record->food_id;
            $properties['location_id'] = $record->location_id;
            $properties['total_ducks'] = $record->total_ducks;
            $properties['amount_foods'] = $record->amount_foods;
            $properties['daily_recurring'] = 0;
            $properties['feeding_time'] = date('Y-m-d') . ' ' . date('H:i:s', strtotime($record->feeding_time));

            if (Feeding::where($properties)->count() <= 0) {
                Feeding::create($properties);
                Log::info('Recurring item created for: ' . json_encode($properties));
            } else {
                Log::info('Recurring item already created!');
            }
        }
    }
}
