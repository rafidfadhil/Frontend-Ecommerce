<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::create([
            'title' => 'Cara Membuat Akun di Mitra.id',
            'slug' => 'cara-membuat-akun-di-mitra-id',
            'topic_id' => 1,
            'body' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas pretium libero ut commodo pulvinar. Sed mattis leo quis lectus interdum pharetra. Morbi et porta libero, eu ornare nulla. Etiam dapibus est vitae velit luctus, eget semper lectus tincidunt. Etiam ut massa tristique turpis vestibulum rutrum ac ut justo. Aliquam erat volutpat. In id metus ut dolor venenatis ornare. Etiam pharetra scelerisque magna. Vestibulum maximus cursus turpis, eget pulvinar orci dignissim at. Aenean imperdiet, lorem at aliquam tempus, ligula erat faucibus erat, venenatis lacinia libero orci at ante. Integer rutrum nulla enim.</p><p>Vestibulum gravida elit sit amet nulla aliquam, a sodales tortor vestibulum. Quisque nec maximus nibh. Sed pulvinar porta hendrerit. Nam et scelerisque ex, sit amet condimentum ex. Aliquam velit metus, convallis ut nunc ac, volutpat consequat velit. Suspendisse pulvinar urna at dapibus fringilla. Morbi quis elit massa.</p><p>In fringilla egestas erat, nec accumsan sapien imperdiet sed. Nam malesuada efficitur porta. Sed commodo malesuada nunc et fringilla. Morbi rutrum nisi id finibus dictum. Aenean sagittis libero a enim dignissim aliquam. Duis vitae congue nisi. Cras vitae dictum nibh. Aenean gravida tellus ut feugiat consequat. Phasellus a nibh augue. Nulla in mollis justo. Quisque hendrerit hendrerit risus eu convallis. Integer faucibus mi pharetra purus varius, quis scelerisque ante bibendum. Aenean in ipsum sed massa fermentum sagittis. Maecenas et libero a risus imperdiet pulvinar eu non magna. Cras ullamcorper nisi vitae odio elementum, a aliquam sapien maximus. Suspendisse sed nisl consequat, rhoncus velit ut, ullamcorper tellus.</p>'
        ]);

        Article::create([
            'title' => 'Cara Melakukan Pembayaran',
            'slug' => 'cara-melakukan-pembayaran',
            'topic_id' => 3,
            'body' => '<p>Cara melakukan pembayaran lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas pretium libero ut commodo pulvinar. Sed mattis leo quis lectus interdum pharetra. Morbi et porta libero, eu ornare nulla. Etiam dapibus est vitae velit luctus, eget semper lectus tincidunt. Etiam ut massa tristique turpis vestibulum rutrum ac ut justo. Aliquam erat volutpat. In id metus ut dolor venenatis ornare. Etiam pharetra scelerisque magna. Vestibulum maximus cursus turpis, eget pulvinar orci dignissim at. Aenean imperdiet, lorem at aliquam tempus, ligula erat faucibus erat, venenatis lacinia libero orci at ante. Integer rutrum nulla enim.</p><p>Vestibulum gravida elit sit amet nulla aliquam, a sodales tortor vestibulum. Quisque nec maximus nibh. Sed pulvinar porta hendrerit. Nam et scelerisque ex, sit amet condimentum ex. Aliquam velit metus, convallis ut nunc ac, volutpat consequat velit. Suspendisse pulvinar urna at dapibus fringilla. Morbi quis elit massa.</p><p>In fringilla egestas erat, nec accumsan sapien imperdiet sed. Nam malesuada efficitur porta. Sed commodo malesuada nunc et fringilla. Morbi rutrum nisi id finibus dictum. Aenean sagittis libero a enim dignissim aliquam. Duis vitae congue nisi. Cras vitae dictum nibh. Aenean gravida tellus ut feugiat consequat. Phasellus a nibh augue. Nulla in mollis justo. Quisque hendrerit hendrerit risus eu convallis. Integer faucibus mi pharetra purus varius, quis scelerisque ante bibendum. Aenean in ipsum sed massa fermentum sagittis. Maecenas et libero a risus imperdiet pulvinar eu non magna. Cras ullamcorper nisi vitae odio elementum, a aliquam sapien maximus. Suspendisse sed nisl consequat, rhoncus velit ut, ullamcorper tellus.</p>'
        ]);
    }
}
