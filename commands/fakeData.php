<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

$db = new PDO(
    'mysql:host=localhost;port=3308;dbname=blog_pro;charset=utf8',
    'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
);

$db->exec('SET FOREIGN_KEY_CHECKS = 0');
$db->exec('TRUNCATE TABLE comment');
$db->exec('TRUNCATE TABLE post');
//$db->exec('TRUNCATE TABLE user');
$db->exec('SET FOREIGN_KEY_CHECKS = 1');

/*for ($i=0; $i<15; $i++) {

    
    $req = $db->prepare(
        'INSERT INTO user 
        (userName, password, profilPicture, authorName, userType_id)
        VALUES (:userName, :password, :profilPicture, :authorName, :userType_id)'
    );
    $req -> execute(
        array(
            'userName' => $faker->firstName,
            'password' => $faker->password,
            'profilPicture' => $faker->image($dir = '../tmp', $width = 640, $height = 480)  ,
            'authorName' => $faker->name,
            'userType_id' => rand(4, 6)
        )
    );

}*/

for ($i=0; $i<25; $i++) {

    $ray = array(4, 5);
    $req = $db->prepare(
        'INSERT INTO post 
        (title, chapo, content, lastDateModif, user_id)
        VALUES (:title, :chapo, :content, :lastDateModif, :user_id)'
    );
    $req -> execute(
        array(
            'title' => $faker->catchPhrase,
            'chapo' => $faker->realText($maxNbChars = 90, $indexSize = 2),
            'content' => $faker->text($maxNbChars = 800),
            'lastDateModif' => $faker->date($format = 'Y-m-d', $max = 'now') . $faker->time($format = 'H:i:s', $max = 'now'),
            'user_id' => $ray[array_rand($ray, 1)]
        )
    );

}