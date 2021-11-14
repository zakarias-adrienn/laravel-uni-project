<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderedItem;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // Törölje a bejegyzéseket az összes táblából -> ne legyenek korábbiak benne
        DB::table('users')->truncate();
        DB::table('categories')->truncate();
        DB::table('items')->truncate();
        DB::table('orders')->truncate();
        DB::table('ordered_items')->truncate();


        // Törölje a korábbi bejegyzésekhez tartozó képeket -> törölje le a tárhelyből
        Storage::delete(Storage::files('public/images/item_images'));

        // Egy alap user készítése - admin
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@szerveroldali.hu',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_admin' => true,
        ]);
        $user1 = User::create([
            'name' => 'user1',
            'email' => 'user1@szerveroldali.hu',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_admin' => false,
        ]);
        // "Gyártson le" 5 bejegyzést, a create() pedig berakja az adatbázisba
        Category::factory(9)->create();
        Item::factory(9)->create();

        // összekötések
        Item::all()->each(function ($item) {
            $ids = Category::all()->random(rand(1, 4))->pluck('id')->toArray();
            $item->categories()->attach($ids);
        });

        // első rendelés
        $ordereditem1 = new OrderedItem();
        $ordereditem1->quantity = 2; // random

        $ordereditem2 = new OrderedItem();
        $ordereditem2->quantity = 3;


        $item2 = Item::find(2);
        $item1 = Item::find(1);
        $ordereditem2->item()->associate($item2);
        $ordereditem1->item()->associate($item1);
        Order::factory(1)->create(['user_id' => $user1]);
        $order = Order::find(1);
        $order->received_on = date_create('now');
        $order->processed_on = date_create('now');
        $ordereditem1->order()->associate($order);
        $ordereditem2->order()->associate($order);
        $ordereditem1->save();
        $ordereditem2->save();
        $order->ordered_items()->save($ordereditem1);
        $order->ordered_items()->save($ordereditem2);
        $item1->ordered_items()->save($ordereditem1);
        $item1->save();
        $item2->ordered_items()->save($ordereditem2);
        $item2->save();
        $order->save();



        // második rendelés
        $ordereditem3 = new OrderedItem();
        $ordereditem3->quantity = 2; // random

        $ordereditem4 = new OrderedItem();
        $ordereditem4->quantity = 3;

        $item3 = Item::find(3);
        $item4 = Item::find(4);
        $ordereditem3->item()->associate($item3);
        $ordereditem4->item()->associate($item4);
        Order::factory(1)->create(['user_id' => $user1]);
        $order = Order::find(2);
        $order->received_on = date_create('now');
        $order->processed_on = date_create('now');
        $ordereditem3->order()->associate($order);
        $ordereditem4->order()->associate($order);
        $ordereditem3->save();
        $ordereditem4->save();
        $order->ordered_items()->save($ordereditem3);
        $order->ordered_items()->save($ordereditem4);
        $item3->ordered_items()->save($ordereditem3);
        $item3->save();
        $item4->ordered_items()->save($ordereditem4);
        $item4->save();
        $order->save();


        // harmadik rendelés
        $ordereditem5 = new OrderedItem();
        $ordereditem5->quantity = 1; // random

        $ordereditem6 = new OrderedItem();
        $ordereditem6->quantity = 1;

        $item5 = Item::find(3);
        $item6 = Item::find(4);
        $ordereditem5->item()->associate($item5);
        $ordereditem6->item()->associate($item6);
        Order::factory(1)->create(['user_id' => $user1]);
        $order = Order::find(3);
        $order->received_on = date_create('now');
        $order->processed_on = date_create('now');
        $ordereditem5->order()->associate($order);
        $ordereditem6->order()->associate($order);
        $ordereditem5->save();
        $ordereditem6->save();
        $order->ordered_items()->save($ordereditem5);
        $order->ordered_items()->save($ordereditem6);
        $item5->ordered_items()->save($ordereditem5);
        $item5->save();
        $item6->ordered_items()->save($ordereditem6);
        $item6->save();
        $order->save();


    }
}
