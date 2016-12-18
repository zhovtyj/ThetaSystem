<?php

use Illuminate\Database\Seeder;
use App\Entry;
use App\User;
use App\Status;

class EntriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entry1 = new Entry();
        $entry1->name = 'Name 1';
        $entry1->phone = '+380987654321';
        $user_admin = User::where('name', 'Admin')->first();
        $entry1->user_id = $user_admin->id;
        $entry1->link = 'link1';
        $status_md = Status::where('name', 'MD')->first();
        $entry1->status_id = $status_md->id;
        $entry1->save();

        $entry2 = new Entry();
        $entry2->name = 'Name 2';
        $entry2->phone = '+380987654321';
        $user_admin = User::where('name', 'Agent')->first();
        $entry2->user_id = $user_admin->id;
        $entry2->link = 'link2';
        $status_md = Status::where('name', 'NA')->first();
        $entry2->status_id = $status_md->id;
        $entry2->save();

        $entry3 = new Entry();
        $entry3->name = 'Name 3';
        $entry3->phone = '+380987654321';
        $user_admin = User::where('name', 'Agent')->first();
        $entry3->user_id = $user_admin->id;
        $entry3->link = 'link3';
        $status_md = Status::where('name', 'VM')->first();
        $entry3->status_id = $status_md->id;
        $entry3->save();

        $entry4 = new Entry();
        $entry4->name = 'Name 4';
        $entry4->phone = '+380987654321';
        $user_admin = User::where('name', 'Agent')->first();
        $entry4->user_id = $user_admin->id;
        $entry4->link = 'link4';
        $status_md = Status::where('name', 'BN')->first();
        $entry4->status_id = $status_md->id;
        $entry4->save();

        $entry5 = new Entry();
        $entry5->name = 'Name 5';
        $entry5->phone = '+380987654321';
        $user_admin = User::where('name', 'Agent')->first();
        $entry5->user_id = $user_admin->id;
        $entry5->link = 'link5';
        $status_md = Status::where('name', 'DONE')->first();
        $entry5->status_id = $status_md->id;
        $entry5->save();
    }
}
