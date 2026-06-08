<?php

namespace App\Http\Controllers;

use App\Models\Api;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::first();
        $api = Api::first();
        // return $api;
        return view('backoffice.setting.setting', compact('setting', 'api'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    public function updateWebsite(Request $request)
    {
        $web = Setting::first();
        $web->nama_web = $request->nama_web;
        $web->telp = $request->telp;
        $web->seo_meta_keywords = $request->metaKeyword;
        $web->seo_description = $request->metaDescription;
        $web->seo_social_description = $request->metaSocial;
        $web->maintenance_mode = $request->maintenance_mode;
        $web->save();

        return redirect()->back()->with('success', 'Pengaturan website berhasil diperbarui.');
        
    }

    public function updateContact(Request $request)
    {
        $contact = Setting::first();
        $contact->wa = $request->input('wa');
        $contact->tele = $request->input('tele');
        $contact->live_chat = $request->input('live_chat');
        $contact->save();

        return redirect()->back()->with('success', 'Kontak berhasil diperbarui.');
    }

    public function updateAppearance(Request $request)
    {
        $appearance = Setting::first();
        $appearance->themes = $request->theme;
        $appearance->template = $request->template;
        $appearance->running_text = $request->running_text;
        

        if ($request->hasFile('logo')) {

            $appearance->logo = $request->file('logo')->store('logo');
        }

        if ($request->hasFile('favicon')) {

            $appearance->favicon = $request->file('favicon')->store('post-images');
        }
        $appearance->save();
        return redirect()->back()->with('success', 'Tampilan berhasil diperbarui.');
    }

    public function updatePopup (Request $request)
    {
        $popup = Setting::first();
        $popup->msg_popup = $request->msg_popup;
        $popup->popup_bg = $request->popup_bg;
        if ($request->hasFile('popup')) {

            $popup->popup = $request->file('popup')->store('post-images');
        }
        $popup->save();

        return redirect()->back()->with('success', 'Popup berhasil diperbarui.');
    }

    public function updateGateway(Request $request)
    {
        $gateway = Setting::first();
        $gateway->url_gateway = $request->urlAgregator;
        $gateway->apikey_gateway = $request->apiKey;
        $gateway->callback_url = $request->callback;
        $gateway->qris_status = $request->statusGateway;
        $gateway->save();

        return redirect()->back()->with('success', 'Payment gateway berhasil diperbarui.');
    }

    public function updateWDDEPO(Request $request)
    {
        $dpwd = Setting::first();
        $dpwd->minimal_depo = $request->minim_depo;
        $dpwd->minimal_wd = $request->minim_wd;
        $dpwd->maksimal_wd = $request->maks_wd;
        $dpwd->save();

        return redirect()->back()->with('success', 'Pengaturan deposit dan withdraw berhasil diperbarui.');
    }

    public function apiSG(Request $request)
    {
        $SG = Api::first();
        $SG->sg_agent_code = $request->input('sgAgentCode');
        $SG->sg_sign = $request->input('sgSignature');
        $SG->sg_endpoint = $request->input('sgEndpoint');
        $SG->sg_status = $request->input('sgStatus');
        $SG->save();

        return redirect()->back()->with('success', 'Softgaming API berhasil diperbarui.');
    }

    public function apiNX(Request $request)
    {
        $NX = Api::first();
        $NX->nx_agent_code = $request->input('nxAgentCode');
        $NX->nx_token = $request->input('nxToken');
        $NX->nx_endpoint = $request->input('nxEndpoint');
        $NX->nx_status = $request->input('nxStatus');
        $NX->save();

        return redirect()->back()->with('success', 'Nexus API berhasil diperbarui.');
    }

    public function apiWSG(Request $request)
    {
        $WSG = Api::first();
        $WSG->wsg_agent_code = $request->input('wsgAgentCode');
        $WSG->wsg_token = $request->input('wsgToken');
        $WSG->wsg_endpoint  = $request->input('wsgEndpoint');
        $WSG->wsg_status = $request->input('wsgStatus');
        $WSG->save();

        return redirect()->back()->with('success', 'World Slot Game API berhasil diperbarui.');
    }

    public function apiNG(Request $request)
    {
        $NG = Api::first();
        $NG->ng_agent_code = $request->input('ngAgentCode');
        $NG->ng_signature = $request->input('ngSignature');
        $NG->ng_endpoint  = $request->input('ngEndpoint');
        $NG->ng_status = $request->input('ngStatus');
        $NG->save();

        return redirect()->back()->with('success', 'N-Gaming API berhasil diperbarui.');
    }

    public function destroy(Setting $setting)
    {
        //
    }
}
