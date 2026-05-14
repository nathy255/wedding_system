<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Contribution;
use App\Models\Gift;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ──────────────────────────────────────────────
        $admin = User::create([
            'full_name' => 'Admin Mmari',
            'phone'     => '+255712000001',
            'email'     => 'admin@weddingis.co.tz',
            'password'  => Hash::make('admin123'),
            'role'      => 'admin',
        ]);

        $committee1 = User::create([
            'full_name' => 'Fatuma Ally',
            'phone'     => '+255712345678',
            'email'     => 'fatuma@weddingis.co.tz',
            'password'  => Hash::make('admin123'),
            'role'      => 'committee',
        ]);

        $committee2 = User::create([
            'full_name' => 'Joseph Mwangi',
            'phone'     => '+255754221093',
            'email'     => 'joseph@weddingis.co.tz',
            'password'  => Hash::make('admin123'),
            'role'      => 'committee',
        ]);

        User::create([
            'full_name' => 'Amina Juma',
            'phone'     => '+255769887341',
            'email'     => 'amina@weddingis.co.tz',
            'password'  => Hash::make('admin123'),
            'role'      => 'couple',
        ]);

        // ── Event ──────────────────────────────────────────────
        $event = Event::create([
            'couple_name'   => 'Amina & Daniel',
            'bride_name'    => 'Amina Juma',
            'groom_name'    => 'Daniel Kimaro',
            'wedding_date'  => '2026-06-14',
            'venue'         => 'Arusha, Tanzania',
            'target_budget' => 7200000,
            'created_by'    => $admin->id,
            'is_active'     => true,
        ]);

        // ── Contributions ──────────────────────────────────────
        $contributions = [
            ['Fatuma Ally',    '+255712345678', 150000, 'mpesa',        'MP2026A001', 'confirmed'],
            ['Rose Njau',      '+255769887341', 200000, 'airtel_money', 'AM2026B002', 'confirmed'],
            ['Baraka Kimaro',  '+255743002156',  50000, 'cash',          null,        'pending'],
            ['Sophia Laizer',  '+255787541220', 100000, 'mpesa',        'MP2026C004', 'confirmed'],
            ['Hassan Msuya',   '+255711222333',  75000, 'tigopesa',     'TP2026D005', 'confirmed'],
            ['Grace Mollel',   '+255711333444', 250000, 'bank_transfer','BT2026E006', 'confirmed'],
            ['Peter Lema',     '+255711444555',  30000, 'cash',          null,        'pending'],
            ['Amina Hassan',   '+255711555666', 120000, 'mpesa',        'MP2026F008', 'confirmed'],
        ];

        foreach ($contributions as [$name, $phone, $amount, $method, $ref, $status]) {
            Contribution::create([
                'event_id'           => $event->id,
                'contributor_name'   => $name,
                'contributor_phone'  => $phone,
                'type'               => 'cash',
                'amount'             => $amount,
                'payment_method'     => $method,
                'payment_reference'  => $ref,
                'status'             => $status,
                'recorded_by'        => $admin->id,
                'confirmed_by'       => $status === 'confirmed' ? $admin->id : null,
                'confirmed_at'       => $status === 'confirmed' ? now() : null,
            ]);
        }

        // ── Gifts ──────────────────────────────────────────────
        $gifts = [
            ['Mama Grace',    '+255711000001', 'Dining Set (12 pcs)',  'kitchen_dining', 350000, 'received'],
            ['Uncle Hassan',  '+255711000002', 'Bed Linen Set',        'bedroom_linen',  120000, 'pledged'],
            ['Mwanaidi Juma', '+255711000003', 'Blender & Kettle',     'electronics',    180000, 'received'],
            ['Zawadi Msafiri','+255711000004', 'Wall Mirror',          'furniture',       85000, 'pledged'],
            ['Neema Tarimo',  '+255711000005', 'Cutlery Set',          'kitchen_dining',  60000, 'received'],
        ];

        foreach ($gifts as [$name, $phone, $item, $cat, $value, $status]) {
            Gift::create([
                'event_id'        => $event->id,
                'donor_name'      => $name,
                'donor_phone'     => $phone,
                'item_name'       => $item,
                'category'        => $cat,
                'estimated_value' => $value,
                'status'          => $status,
                'received_by'     => $status === 'received' ? $admin->id : null,
                'received_at'     => $status === 'received' ? now() : null,
            ]);
        }
    }
}
