<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\User;
use App\Models\ExamCenter;
use App\Models\Region;
use App\Models\Division;
use App\Models\SubDivision;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $examCenter = ExamCenter::first();
        $region = Region::first();
        $division = Division::first();
        $subDivision = SubDivision::first();

        Application::create([
            'user_id' => $user->id,
            'exam_center_id' => $examCenter->id,
            'region_id' => $region?->id,
            'division_id' => $division?->id,
            'sub_division_id' => $subDivision?->id,
            'name' => 'John Doe',
            'dob' => '1995-05-15',
            'pob' => 'Douala',
            'primary_language' => 'English',
            'email' => 'john.doe@example.com',
            'telephone' => '+237123456789',
            'idc_number' => '123456789012',
            'gender' => 'male',
            'bankref' => 'BANK123456',
            'marital_status' => 'single',
            'is_civil_servant' => false,
            'option1' => 'Computer Science',
            'option2' => 'Information Technology',
            'option3' => 'Software Engineering',
            'country' => 'Cameroon',
            'mother_name' => 'Jane Doe',
            'mother_address' => 'Douala, Cameroon',
            'mother_contact' => '+237987654321',
            'father_name' => 'James Doe',
            'father_address' => 'Douala, Cameroon',
            'father_contact' => '+237987654322',
            'guardian_name' => 'Jane Doe',
            'guardian_address' => 'Douala, Cameroon',
            'guardian_contact' => '+237987654321',
            'passport' => 'passport.jpg',
            'birthcert' => 'birth_certificate.jpg',
            'bankrecipt' => 'bank_receipt.jpg',
            'has_math' => 'yes',
            'has_english' => 'yes',
        ]);
    }
}
