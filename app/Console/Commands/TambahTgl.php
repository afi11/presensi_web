<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\DateRecords;
use Carbon\Carbon;

class TambahTgl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:tambahtanggal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $record = new DateRecords();
        $record->tgl_record = Carbon::now()->format('Y-m-d');
        $record->save();
    }
}
