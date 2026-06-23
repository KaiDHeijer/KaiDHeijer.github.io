<?php
require_once 'db.php';

$check = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
if ($check > 0) {
    die('Database is al gevuld. Verwijder eerst de bestaande data.');
}

$hash = password_hash('geheim', PASSWORD_DEFAULT);

$pdo->prepare('INSERT INTO users (name, email, password, bio) VALUES (?, ?, ?, ?)')->execute(['Jan de Vries', 'jan@example.com', $hash, 'Ik verzamel alles wat glinstert.']);
$pdo->prepare('INSERT INTO users (name, email, password, bio) VALUES (?, ?, ?, ?)')->execute(['Sara Bakker', 'sara@example.com', $hash, 'Postzegels en vinyl.']);
$pdo->prepare('INSERT INTO users (name, email, password, bio) VALUES (?, ?, ?, ?)')->execute(['Mo El Amrani', 'mo@example.com', $hash, 'Sneakerhead sinds 2019.']);

$pdo->exec("
INSERT INTO collections (user_id, name, description) VALUES
  (1, 'Zeldzame Munten',       'Munten uit de Romeinse tijd en middeleeuwen'),
  (1, 'Pokémon Kaarten',       'Eerste generatie holografische kaarten'),
  (2, 'Vinyl Collectie',       'Jazz en soul platen uit de jaren 60-70'),
  (2, 'Postzegels Europa',     'Europese postzegels vanaf 1950'),
  (3, 'Nike Dunks',            'Limited edition Nike Dunk lows'),
  (3, 'Retro Games',           'Cartridges voor SNES en N64')
");

$pdo->exec("
INSERT INTO items (collection_id, name, description, category) VALUES
  (1, 'Denarius Augustus',     'Zilveren munt, ca. 27 v.Chr.',          'Romeins'),
  (1, 'Gouden Florijn',        'Florence, 1252',                         'Middeleeuws'),
  (1, 'Duit VOC',              'Koperen duit, 1746',                     'Koloniaal'),
  (2, 'Charizard Holo',        'Base Set 1st Edition',                   'Holo Rare'),
  (2, 'Pikachu Red Cheeks',    'Base Set, drukfout variant',             'Error Card'),
  (3, 'Kind of Blue',          'Miles Davis, 1959, eerste persing',      'Jazz'),
  (3, 'What\\'s Going On',     'Marvin Gaye, 1971',                      'Soul'),
  (4, 'Beatrix Zegel 1980',    'Eerste Beatrix-serie',                   'Nederland'),
  (4, 'Europa CEPT 1960',      'Eerste gezamenlijke Europa-uitgave',     'Internationaal'),
  (5, 'Dunk Low Panda',        'Black/White, 2021',                      'Low'),
  (5, 'Dunk Low Coast',        'UCLA kleuren, 2021',                     'Low'),
  (6, 'Super Mario World',     'SNES, compleet in doos',                 'SNES'),
  (6, 'GoldenEye 007',         'N64, losse cartridge',                   'N64')
");

echo 'Seed data succesvol ingevoegd! <a href="inlog.php">Ga naar home</a>';
