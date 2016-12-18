<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status_md = new Status();
        $status_md->name = 'MD';
        $status_md->save();

        $status_na = new Status();
        $status_na->name = 'NA';
        $status_na->save();

        $status_vm = new Status();
        $status_vm->name = 'VM';
        $status_vm->save();

        $status_bn = new Status();
        $status_bn->name = 'BN';
        $status_bn->save();

        $status_done = new Status();
        $status_done->name = 'DONE';
        $status_done->save();
    }
}
