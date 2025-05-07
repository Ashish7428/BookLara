<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AuthorSeeder extends Seeder
{
    public function run()
    {
        $authors = [
            [
                'username' => 'rknarayan',
                'full_name' => 'R.K. Narayan',
                'email' => 'rk.narayan@gmail.com',
                'phone' => '9876543210',
                'password' => Hash::make('Test@1234'),
                'bio' => 'One of India\'s most renowned and widely read authors, known for his Malgudi Days series.',
            ],
            [
                'username' => 'ruskinbond',
                'full_name' => 'Ruskin Bond',
                'email' => 'ruskin.bond@gmail.com',
                'phone' => '9876543211',
                'password' => Hash::make('Test@1234'),
                'bio' => 'An Indian author of British descent, famous for his books on children and nature.',
            ],
            [
                'username' => 'arundhati',
                'full_name' => 'Arundhati Roy',
                'email' => 'arundhati.roy@gmail.com',
                'phone' => '9876543212',
                'password' => Hash::make('Test@1234'),
                'bio' => 'Renowned for her novel "The God of Small Things," which won the Man Booker Prize.',
            ],
            [
                'username' => 'cbhagat',
                'full_name' => 'Chetan Bhagat',
                'email' => 'chetan.bhagat@gmail.com',
                'phone' => '9876543213',
                'password' => Hash::make('Test@1234'),
                'bio' => 'A best-selling Indian author known for contemporary novels that have been adapted into films.',
            ],
            [
                'username' => 'amishtripathi',
                'full_name' => 'Amish Tripathi',
                'email' => 'amish.tripathi@gmail.com',
                'phone' => '9876543214',
                'password' => Hash::make('Test@1234'),
                'bio' => 'Author of the Shiva Trilogy, known for blending mythology with history.',
            ],
            [
                'username' => 'khuswantsingh',
                'full_name' => 'Khushwant Singh',
                'email' => 'khuswant.singh@gmail.com',
                'phone' => '9876543215',
                'password' => Hash::make('Test@1234'),
                'bio' => 'Khushwant Singh is India’s best-known writer and columnist. He has been founder-editor of Yojana, and editor of the Illustrated Weekly of India, the National Herald and the Hindustan Times. He is also the author of several books which include the novels I Shall Not Hear the Nightingale, Delhi, The Company of Women and Burial at Sea; the classic two-volume A History of the Sikhs; and a number of translations and non-fiction books on Sikh religion and culture, Delhi, nature, current affairs and Urdu poetry. His autobiography, Truth, Love and a Little Malice, was published in 2002.',
            ],
            [
                'username' => 'jhumpalahiri',
                'full_name' => 'Jhumpa Lahiri',
                'email' => 'jhumpa.lahiri@gmail.com',
                'phone' => '9876543216',
                'password' => Hash::make('Test@1234'),
                'bio' => 'Pulitzer Prize-winning author known for "The Namesake" and "Interpreter of Maladies."',
            ],
            [
                'username' => 'vikramseth',
                'full_name' => 'Vikram Seth',
                'email' => 'vikram.seth@gmail.com',
                'phone' => '9876543217',
                'password' => Hash::make('Test@1234'),
                'bio' => 'Renowned for his novel "A Suitable Boy," one of the longest English novels published in a single volume.',
            ],
            [
                'username' => 'shobha_de',
                'full_name' => 'Shobhaa De',
                'email' => 'shobha.de@gmail.com',
                'phone' => '9876543218',
                'password' => Hash::make('Test@1234'),
                'bio' => 'A writer and columnist known for her socialite novels and bold themes.',
            ],
            [
                'username' => 'anitalakshmi',
                'full_name' => 'Anita Desai',
                'email' => 'anita.desai@gmail.com',
                'phone' => '9876543219',
                'password' => Hash::make('Test@1234'),
                'bio' => 'Three-time Booker Prize nominee and author of "Clear Light of Day" and "Fasting, Feasting."',
            ],
            [
                'username' => 'kiran_nagarkar',
                'full_name' => 'Kiran Nagarkar',
                'email' => 'kiran.nagarkar@gmail.com',
                'phone' => '9876543220',
                'password' => Hash::make('Test@1234'),
                'bio' => 'An acclaimed Indian novelist, playwright, and screenwriter known for "Cuckold."',
            ],
        ];

        foreach ($authors as $author) {
            // Author::create($author);
            Author::firstOrCreate(
                ['email' => $author['email']], // Unique constraint (email)
                $author // Data to insert if not exists
            );
        }
    }
}