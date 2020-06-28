<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\WordType;

class WordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('words')->insert([
            'word_category_id' => '1',
            'word' => 'breakfast',
            'word_type' => '[0]',
            'ipa' => "/ˈbrekfəst/",
            'definition' => 'bữa sáng'
        ]);

        DB::table('words')->insert([
            'word_category_id' => '1',
            'word' => 'lunch',
            'word_type' => '[0]',
            'ipa' => "/lʌntʃ/",
            'definition' => 'bữa trưa'
        ]);

        DB::table('words')->insert([
            'word_category_id' => '1',
            'word' => 'dinner',
            'word_type' => '[0]',
            'ipa' => "/ˈdɪnɚ/",
            'definition' => 'bữa tối'
        ]);

        DB::table('words')->insert([
            'word_category_id' => '2',
            'word' => 'computer',
            'word_type' => '[0]',
            'ipa' => "/kəmˈpjuːt̬ɚ/",
            'definition' => 'máy tính'
        ]);

        DB::table('words')->insert([
            'word_category_id' => '2',
            'word' => 'print',
            'word_type' => '[0, 1]',
            'ipa' => "/prɪnt/",
            'definition' => 'in'
        ]);

        DB::table('words')->insert([
            'word_category_id' => '2',
            'word' => 'procedure',
            'word_type' => '[0]',
            'ipa' => "/prəˈsiːdʒɚ/",
            'definition' => 'quy trình, hành chính'
        ]);

        DB::table('words')->insert([
            'word_category_id' => '3',
            'word' => 'grocery',
            'word_type' => '[0]',
            'ipa' => "/ˈɡroʊsɚi/",
            'definition' => 'nông sản'
        ]);

        DB::table('words')->insert([
            'word_category_id' => '3',
            'word' => 'stock',
            'word_type' => '[0]',
            'ipa' => "/stɑːk/",
            'definition' => 'hàng trên kệ/ chứng khoán/ nước dùng'
        ]);

        DB::table('words')->insert([
            'word_category_id' => '3',
            'word' => 'sell',
            'word_type' => '[1]',
            'ipa' => "/sel/",
            'definition' => 'bán'
        ]);

        DB::table('words')->insert([
            'word_category_id' => '4',
            'word' => 'cash',
            'word_type' => '[0, 1]',
            'ipa' => "/kæʃ/",
            'definition' => 'tiền mặt, đổi ra tiền mặt'
        ]);

        DB::table('words')->insert([
            'word_category_id' => '4',
            'word' => 'inflationary',
            'word_type' => '[1]',
            'ipa' => "/ɪnˈfleɪʃəneri/",
            'definition' => 'lạm phát, sự phì đại'
        ]);

        DB::table('words')->insert([
            'word_category_id' => '4',
            'word' => 'bankrupt',
            'word_type' => '[2]',
            'ipa' => "/ˈbæŋkrʌpt/",
            'definition' => 'bị vỡ nợ'
        ]);

        DB::table('words')->insert([
            'word_category_id' => '5',
            'word' => 'recess',
            'word_type' => '[0]',
            'ipa' => "/rɪˈses/",
            'definition' => 'giờ nghỉ'
        ]);

        DB::table('words')->insert([
            'word_category_id' => '5',
            'word' => 'kindergarten',
            'word_type' => '[0]',
            'ipa' => "/ˈkɪndɚˌɡɑːrtən/",
            'definition' => 'nhà trẻ, trường mẫu giáo'
        ]);

        DB::table('words')->insert([
            'word_category_id' => '5',
            'word' => 'test',
            'word_type' => '[0, 1]',
            'ipa' => "/test/",
            'definition' => 'bài kiểm tra, hành động kiểm tra'
        ]);
    }
}
