@extends('layouts.main')

@section('content')
<div class="memo_page"> 
<div class="container-fluid"> 
    <div class="row">
        <!-- <div class="col-xs-12">
            <h3 class="memo_page_title statement_heading">MEMO</h3>
        </div> -->
        <div class="col-xs-12 memo_tab">
            <button type="button" class="btn btn-secondary btn_top_memo" style="display: none;">Tulis Memo</button>
            
            <div class="mdc-tab-bar" role="tablist">
                <div class="mdc-tab-scroller">
                  <div class="mdc-tab-scroller__scroll-area mdc-tab-scroller__scroll-area--scroll mdc-tab-scroller__scroll-x" style="margin-bottom: 0px;">
                    <div class="mdc-tab-scroller__scroll-content nav nav-tabs">
                      <!---->
                        <a role="tab" mode="1" data-toggle="tab" href="#kotak" class="mdc-tab mdc-tab--active" aria-selected="false">
                            <span class="mdc-tab__content">
    
                                <span class="mdc-tab__text-label"><!---->KOTAK MASUK<!----> (<span class="hot">0</span>)</span>
                                
    
                            </span> 
                            
                            <span class="mdc-tab-indicator mdc-tab-indicator--active">
                            <span class="mdc-tab-indicator__content
                                mdc-tab-indicator__content--underline" style=""></span>
                            </span>
    
                            <span class="mdc-tab__ripple mdc-ripple-upgraded" style="--mdc-ripple-fg-size:91px; --mdc-ripple-fg-scale:1.8648; --mdc-ripple-fg-translate-start:76px, -10.5px; --mdc-ripple-fg-translate-end:30.6563px, -21.5px;"></span>
                        </a>
                        <!---->
                        <a mode="2" role="tab" data-toggle="tab" href="#terkirim" class="mdc-tab" style="display:none;" aria-selected="false">
                            <span class="mdc-tab__content">
    
                                <span class="mdc-tab__text-label"><!---->KIRIM<!----></span>
    
                            </span>
    
                            <span class="mdc-tab-indicator">
                            <span class="mdc-tab-indicator__content
                                mdc-tab-indicator__content--underline" style=""></span>
                            </span>
    
                            <span class="mdc-tab__ripple mdc-ripple-upgraded" style="--mdc-ripple-fg-size:93px; --mdc-ripple-fg-scale:1.85613; --mdc-ripple-fg-translate-start:48.6875px, -6.5px; --mdc-ripple-fg-translate-end:31.1875px, -22.5px;"></span>
                        </a>
                        <!---->
                            <a mode="0" role="tab" data-toggle="tab" href="#memo" class="mdc-tab" aria-selected="false">
                            <span class="mdc-tab__content">
    
                                <span class="mdc-tab__text-label"><!---->PENGUMUMAN<!----> (<span class="announce_msg_count hot">0</span>)</span>
                                
                            
                            </span>
                            
                            <span class="mdc-tab-indicator">
                            <span class="mdc-tab-indicator__content
                                mdc-tab-indicator__content--underline" style=""></span>
                            </span>
    
                            <span class="mdc-tab__ripple mdc-ripple-upgraded" style="--mdc-ripple-fg-size:102px; --mdc-ripple-fg-scale:1.83267; --mdc-ripple-fg-translate-start:-44.1875px, -35px; --mdc-ripple-fg-translate-end:34.1484px, -27px;"></span>
                        </a> 
                    </div>
                  </div>
                </div>
              </div>
    
            <div class="tab-content">
                <div id="kotak" class="tab-pane fade active in">
                
                    <div id="kotak_table_wrapper" class="dataTables_wrapper no-footer"><div id="kotak_table_filter" class="dataTables_filter"><label>Cari Pesan Disini<input type="search" class="" placeholder="Cari Pesan Disini" aria-controls="kotak_table"></label><i class="icon icon-search"></i><i class="icon icon-search"></i></div><table id="kotak_table" class="display dataTable no-footer" role="grid" style="width: 100%;" width="100%" cellspacing="0">
                        <colgroup><col width="3%">
                        </colgroup><thead>
                            <tr role="row"><th class="sorting_disabled selectall-checkbox" rowspan="1" colspan="1" style="width: 25px;">
                                    <div class="form-check">
                                        <label class="check_container con_chckbox">
                                            <input type="checkbox">
                                            <span class="checkmark checkmarking"></span>
                                        </label>
                                    </div> 
                                    <!-- <input type="checkbox"> -->
                                </th><th class="sorting_disabled control" rowspan="1" colspan="1" style="width: 367px;"><span class="memo_select"> Pilih Semua </span>
                                    <button type="button" style="margin-left:8px;" class="btn btn-primary btn_memo" onclick="check_status('delete')"><i class="icon-bin"></i>HAPUS</button>
                                    <button type="button" class="btn btn-secondary btn_memo" onclick="check_status('read')"><i class="icon-checkmark"></i>TANDA BACA</button>
                                </th></tr>
                        </thead>
                        <tbody>
                                                       
                            
                        <tr class="odd"><td colspan="2" class="dataTables_empty" valign="top">No records available</td></tr></tbody>
                    </table><div class="dataTables_paginate paging_full_numbers" id="kotak_table_paginate"><a class="paginate_button first disabled" aria-controls="kotak_table" data-dt-idx="0" tabindex="0" id="kotak_table_first">Pertama</a><a class="paginate_button previous disabled" aria-controls="kotak_table" data-dt-idx="1" tabindex="0" id="kotak_table_previous">Sebelumnya</a><span></span><a class="paginate_button next disabled" aria-controls="kotak_table" data-dt-idx="2" tabindex="0" id="kotak_table_next">Lanjut</a><a class="paginate_button last disabled" aria-controls="kotak_table" data-dt-idx="3" tabindex="0" id="kotak_table_last">Terakhir</a></div></div>
                </div>
                <div id="terkirim" class="tab-pane fade">
                    <div class="button_table">                    
                        <button type="button" class="btn btn-primary btn_memo" onclick="check_status('delete')"><i class="icon-bin"></i>HAPUS</button>
                        <button type="button" class="btn btn-secondary btn_memo" onclick="check_status('read')"><i class="icon-checkmark"></i>TANDA BACA</button>
                    </div>
                    <div id="terkirim_table_wrapper" class="dataTables_wrapper no-footer"><div id="terkirim_table_filter" class="dataTables_filter"><label>Cari Pesan Disini<input type="search" class="" placeholder="Cari Pesan Disini" aria-controls="terkirim_table"></label><i class="icon icon-search"></i></div><table id="terkirim_table" class="display dataTable no-footer" role="grid" style="width: 100%;" width="100%" cellspacing="0">
                      <colgroup><col width="3%">
                        </colgroup><thead>
                            <tr role="row"><th class="sorting_disabled selectall-checkbox" rowspan="1" colspan="1" style="width: 0px;">
                                    <div class="form-check">
                                        <label class="check_container con_chckbox">
                                            <input type="checkbox">
                                            <span class="checkmark checkmarking"></span>
                                        </label>
                                    </div>
                                    <!-- <input type="checkbox"> -->
                                </th><th class="sorting_disabled control" rowspan="1" colspan="1" style="width: 0px;"><h5 class="memo_select"> Pilih Semua </h5></th></tr>
                        </thead>
                        <tbody>
                                                      
                        <tr class="odd"><td colspan="2" class="dataTables_empty" valign="top">No records available</td></tr></tbody>
                    </table><div class="dataTables_paginate paging_full_numbers" id="terkirim_table_paginate"><a class="paginate_button first disabled" aria-controls="terkirim_table" data-dt-idx="0" tabindex="0" id="terkirim_table_first">Pertama</a><a class="paginate_button previous disabled" aria-controls="terkirim_table" data-dt-idx="1" tabindex="0" id="terkirim_table_previous">Sebelumnya</a><span></span><a class="paginate_button next disabled" aria-controls="terkirim_table" data-dt-idx="2" tabindex="0" id="terkirim_table_next">Lanjut</a><a class="paginate_button last disabled" aria-controls="terkirim_table" data-dt-idx="3" tabindex="0" id="terkirim_table_last">Terakhir</a></div></div>
                </div>
                <div id="memo" class="tab-pane fade">
                    
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="accordion">
                                                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- TULIS MEMO BARU  on click to show -->
        <div class="col-sm-12 tulis_memo">
            <div class="tulis_memo_bg">
                <h3 class="memo_content_title">TULIS MEMO BARU</h3> 
                <form method="post" id="new_memo" enctype="multipart/form-data" action="#" novalidate="novalidate">
                <input type="hidden" name="_token" value="OT0E5A26B6jr3BzCsEU1vFqDQoSXBIJndGTDLA6s">                    <div class="container-fluid">           
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>KIRIM KE ADMIN</label>
                                    <select class="form-control" name="topic">
                                        <option value="" selected="">Pilih Topik</option>
                                        <option value="general problem">Masalah Umum</option>
                                        <option value="general problem">Masalah Umum</option>
                                    </select>
                                </div>                            
                            </div>
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <label>JUDUL</label>
                                    <input type="text" class="form-control" placeholder="JUDUL" autofocus="" name="subject">
                                </div>                            
                            </div>                            
                            <div class="col-xs-12">
                                <div class="wrapper">
                                    <label>PESAN</label>
                                    <div class="options">
                                        <input class="editor_font" type="number" onchange="return transform('fontSize', this.value)" value="3" max="7" min="1">
                                        <button onclick="return transform('bold', null)">
                                            <svg class="svg-inline--fa fa-bold fa-w-12" aria-hidden="true" data-prefix="fas" data-icon="bold" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg=""><path fill="currentColor" d="M304.793 243.891c33.639-18.537 53.657-54.16 53.657-95.693 0-48.236-26.25-87.626-68.626-104.179C265.138 34.01 240.849 32 209.661 32H24c-8.837 0-16 7.163-16 16v33.049c0 8.837 7.163 16 16 16h33.113v318.53H24c-8.837 0-16 7.163-16 16V464c0 8.837 7.163 16 16 16h195.69c24.203 0 44.834-1.289 66.866-7.584C337.52 457.193 376 410.647 376 350.014c0-52.168-26.573-91.684-71.207-106.123zM142.217 100.809h67.444c16.294 0 27.536 2.019 37.525 6.717 15.828 8.479 24.906 26.502 24.906 49.446 0 35.029-20.32 56.79-53.029 56.79h-76.846V100.809zm112.642 305.475c-10.14 4.056-22.677 4.907-31.409 4.907h-81.233V281.943h84.367c39.645 0 63.057 25.38 63.057 63.057.001 28.425-13.66 52.483-34.782 61.284z"></path></svg><!-- <i class="fas fa-bold"></i> -->
                                        </button>  
                                        <button onclick="return transform('italic', null)">
                                            <svg class="svg-inline--fa fa-italic fa-w-10" aria-hidden="true" data-prefix="fas" data-icon="italic" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M204.758 416h-33.849l62.092-320h40.725a16 16 0 0 0 15.704-12.937l6.242-32C297.599 41.184 290.034 32 279.968 32H120.235a16 16 0 0 0-15.704 12.937l-6.242 32C96.362 86.816 103.927 96 113.993 96h33.846l-62.09 320H46.278a16 16 0 0 0-15.704 12.935l-6.245 32C22.402 470.815 29.967 480 40.034 480h158.479a16 16 0 0 0 15.704-12.935l6.245-32c1.927-9.88-5.638-19.065-15.704-19.065z"></path></svg><!-- <i class="fas fa-italic"></i> -->
                                        </button>
                                        <button onclick="return transform('underline', null)">
                                            <svg class="svg-inline--fa fa-underline fa-w-14" aria-hidden="true" data-prefix="fas" data-icon="underline" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M224.264 388.24c-91.669 0-156.603-51.165-156.603-151.392V64H39.37c-8.837 0-16-7.163-16-16V16c0-8.837 7.163-16 16-16h137.39c8.837 0 16 7.163 16 16v32c0 8.837-7.163 16-16 16h-28.813v172.848c0 53.699 28.314 79.444 76.317 79.444 46.966 0 75.796-25.434 75.796-79.965V64h-28.291c-8.837 0-16-7.163-16-16V16c0-8.837 7.163-16 16-16h136.868c8.837 0 16 7.163 16 16v32c0 8.837-7.163 16-16 16h-28.291v172.848c0 99.405-64.881 151.392-156.082 151.392zM16 448h416c8.837 0 16 7.163 16 16v32c0 8.837-7.163 16-16 16H16c-8.837 0-16-7.163-16-16v-32c0-8.837 7.163-16 16-16z"></path></svg><!-- <i class="fas fa-underline"></i> -->
                                        </button>
                                        <button onclick="return transform('justifyLeft', null)">
                                            <svg class="svg-inline--fa fa-align-left fa-w-14" aria-hidden="true" data-prefix="fas" data-icon="align-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M288 44v40c0 8.837-7.163 16-16 16H16c-8.837 0-16-7.163-16-16V44c0-8.837 7.163-16 16-16h256c8.837 0 16 7.163 16 16zM0 172v40c0 8.837 7.163 16 16 16h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16zm16 312h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm256-200H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16h256c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16z"></path></svg><!-- <i class="fas fa-align-left"></i> -->
                                        </button>
                                        <button onclick="return transform('justifyCenter', null)">
                                            <svg class="svg-inline--fa fa-align-center fa-w-14" aria-hidden="true" data-prefix="fas" data-icon="align-center" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M352 44v40c0 8.837-7.163 16-16 16H112c-8.837 0-16-7.163-16-16V44c0-8.837 7.163-16 16-16h224c8.837 0 16 7.163 16 16zM16 228h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 256h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm320-200H112c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16h224c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16z"></path></svg><!-- <i class="fas fa-align-center"></i> -->
                                        </button>
                                        <button onclick="return transform('justifyRight', null)">
                                            <svg class="svg-inline--fa fa-align-right fa-w-14" aria-hidden="true" data-prefix="fas" data-icon="align-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M160 84V44c0-8.837 7.163-16 16-16h256c8.837 0 16 7.163 16 16v40c0 8.837-7.163 16-16 16H176c-8.837 0-16-7.163-16-16zM16 228h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 256h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm160-128h256c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H176c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"></path></svg><!-- <i class="fas fa-align-right"></i> -->
                                        </button>
                                        <button onclick="return transform('insertOrderedList', null)">
                                            <svg class="svg-inline--fa fa-list-ol fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="list-ol" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M3.263 139.527c0-7.477 3.917-11.572 11.573-11.572h15.131V88.078c0-5.163.534-10.503.534-10.503h-.356s-1.779 2.67-2.848 3.738c-4.451 4.273-10.504 4.451-15.666-1.068l-5.518-6.231c-5.342-5.341-4.984-11.216.534-16.379l21.72-19.938C32.815 33.602 36.732 32 42.785 32H54.89c7.656 0 11.749 3.916 11.749 11.572v84.384h15.488c7.655 0 11.572 4.094 11.572 11.572v8.901c0 7.477-3.917 11.572-11.572 11.572H14.836c-7.656 0-11.573-4.095-11.573-11.572v-8.902zM2.211 304.591c0-47.278 50.955-56.383 50.955-69.165 0-7.18-5.954-8.755-9.28-8.755-3.153 0-6.479 1.051-9.455 3.852-5.079 4.903-10.507 7.004-16.111 2.451l-8.579-6.829c-5.779-4.553-7.18-9.805-2.803-15.409C13.592 201.981 26.025 192 47.387 192c19.437 0 44.476 10.506 44.476 39.573 0 38.347-46.753 46.402-48.679 56.909h39.049c7.529 0 11.557 4.027 11.557 11.382v8.755c0 7.354-4.028 11.382-11.557 11.382h-67.94c-7.005 0-12.083-4.028-12.083-11.382v-4.028zM5.654 454.61l5.603-9.28c3.853-6.654 9.105-7.004 15.584-3.152 4.903 2.101 9.63 3.152 14.359 3.152 10.155 0 14.358-3.502 14.358-8.23 0-6.654-5.604-9.106-15.934-9.106h-4.728c-5.954 0-9.28-2.101-12.258-7.88l-1.05-1.926c-2.451-4.728-1.226-9.806 2.801-14.884l5.604-7.004c6.829-8.405 12.257-13.483 12.257-13.483v-.35s-4.203 1.051-12.608 1.051H16.685c-7.53 0-11.383-4.028-11.383-11.382v-8.755c0-7.53 3.853-11.382 11.383-11.382h58.484c7.529 0 11.382 4.027 11.382 11.382v3.327c0 5.778-1.401 9.806-5.079 14.183l-17.509 20.137c19.611 5.078 28.716 20.487 28.716 34.845 0 21.363-14.358 44.126-48.503 44.126-16.636 0-28.192-4.728-35.896-9.455-5.779-4.202-6.304-9.805-2.626-15.934zM144 132h352c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H144c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h352c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H144c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h352c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H144c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"></path></svg><!-- <i class="fas fa-list-ol"></i> -->
                                        </button>
                                        <button onclick="return transform('insertUnorderedList', null)">
                                            <svg class="svg-inline--fa fa-list-ul fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="list-ul" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M96 96c0 26.51-21.49 48-48 48S0 122.51 0 96s21.49-48 48-48 48 21.49 48 48zM48 208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm0 160c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm96-236h352c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H144c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h352c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H144c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h352c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H144c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"></path></svg><!-- <i class="fas fa-list-ul"></i> -->
                                        </button>                                    
                                    </div>
                                    <iframe name="editor" id="editor"></iframe>
                                    
                                    <input type="hidden" id="content_body" name="content[body]">
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <label for="myfile">LAMPIRKAN FILE</label>
                                <div class="fileUpload"> 
                                        <label for="file-upload">PILIH FILE<input type="file" multiple="" id="file-upload" name="attachments[]"></label>
                                        <span id="filename">TIDAK ADA FILE TERPILIH</span>
                                   
                                </div>
                            </div>
                            <div class="col-xs-12 form_button">
                                <button type="button" class="btn btn-primary">BATAL</button>
                                <button type="submit" class="btn btn-secondary">KIRIM</button>                                
                            </div>
                        </div>
                    </div>
                </form>  
            </div>          
        </div>
    </div>
</div>
</div>


@endsection