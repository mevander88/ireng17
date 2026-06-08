<?php
use App\Models\Setting;

$setting = Setting::first();
// settings main template

$template_folder = $setting->template ?? 'main';

if (empty($template_folder) || !view()->exists('layouts.' . $template_folder . '.main')) {
    $template_folder = 'main';
}
?>
@desktop
@include('layouts.main.master')
@elsedesktop
@include('layouts.'.$template_folder.'.main')
@enddesktop
