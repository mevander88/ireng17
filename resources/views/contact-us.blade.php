<?php
use App\Models\Setting;
$setting = Setting::first();
?>
@extends('layouts.main')

@section('content')
<div class="container contact-us">
    <div class="row">
      <div class="col-xs-12">
        <h1 class="mt-4">Hubungi kami</h1>
        <p class="fs-lg">Spesialis Dukungan Pelanggan tersedia setiap hari selama 24 jam.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="bg-1 fs-lg">
                                                                                                                                                               
              <a class="btn dis_flex" href="https://api.whatsapp.com/send/?phone=<?= $setting->wa ?>&text&type=phone_number&app_absent=0">
                <span class="icon-txt fs-xxl">
                  <i class="icon-whatsapp"></i>
                </span>
               
                <span>{{ $setting->wa}}</span>
              </a>
           
                                                                                                                                                                                                                             
              <a class="btn dis_flex" href="#">
                <span class="icon-txt fs-xxl">
                  <i class="icon-telegram"></i>
                </span>
                
                <span>{{ $setting->tele}}</span>
              </a>
           
                                              
              <a class="btn dis_flex" href="#">
                <span class="icon-txt fs-xxl">
                  <i class="icon-telegram"></i>
                </span>
               
                <span>{{ $setting->nama_web }}</span>
              </a>
           
                                           
                                    </div>
    </div>
  </div>
</div>


@endsection