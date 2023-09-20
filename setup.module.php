<?php


$module_name = "kiadmin.lodging";
$module_url = "packages/kodeingatan/lodging";
$module_provider_class = "Kodeingatan\\Lodging\\Provider\\LodgingServiceProvider::class";
$project_path =  __DIR__ . "/../../../";
$project_composer_json_path = $project_path . "composer.json";
$project_app_config = $project_path . "/config/app.php";

$composer_json = json_decode(file_get_contents($project_composer_json_path), true);
$config_app = file_get_contents($project_app_config);

if (!isset($composer_json['autoload']['psr-4'])) $composer_json['autoload']['psr-4'] = [];
$composer_json['autoload']['psr-4']["Kodeingtan\\Lodging\\"] = "packages/kodeingatan/lodging/src/";


if (!isset($composer_json['repositories'])) $composer_json['repositories'] = [];
$i_repository = -1;
foreach ($composer_json['repositories'] ?? [] as $index => $value) if ($value['url'] == $module_url) $i_repository = $index;


$composer_json['repositories'][$i_repository != -1 ? $i_repository : count($composer_json['repositories'])] = [
    'type' => 'path',
    'url' => $module_url,
];

$default_provider_regex = '/ \'providers\' => ServiceProvider::defaultProviders\\(\\)->merge\\([^)]*\\)->toArray\\(\\),/i';
preg_match($default_provider_regex, $config_app, $default_provider);

if (!strpos($default_provider[0], $module_provider_class)) {
    $default_provider = str_replace("])->toArray(),", "\t$module_provider_class\n\t])->toArray(),", $default_provider[0] ?? '');
    file_put_contents($project_app_config, preg_replace($default_provider_regex, $default_provider, $config_app));
}

file_put_contents($project_composer_json_path, json_encode($composer_json));

system(<<<CMD
    cd ../../../ && 
    composer update && 
    php artisan {$module_name}:install && 
    php artisan {$module_name}:about
CMD);
