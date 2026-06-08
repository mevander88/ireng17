<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class ApiGame
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // $url = Crypt::decryptString('eyJpdiI6ImlDMzRwdjlTWDBiVWF2YW5Da0sxK0E9PSIsInZhbHVlIjoiWklsRDR5VVJSbzJ5WlBZRkNiSGF4N3k0MHE0b2FPNWRlUHFSa01jTFNnUT0iLCJtYWMiOiIxM2MxMTUxNDlhMTljMDQ0Y2I4MzMwYjdlNzAzZTY3NTIyYWMyOTA2ZDM5ZTY2ODdkNjY0YjU2NzY4MjFhYWI4IiwidGFnIjoiIn0=');
        // $serverIp = gethostbyname(gethostname());
        
        // $validasi = Http::get($url.'api/lic?ip='.$serverIp);
        // $validasiData = $validasi->json();
        
        // if($validasiData['status'] !== 'active'){
        //     $domain = $request->getHost();
        //     $encryptedIp = Crypt::encryptString($serverIp);
        //     $encryptedDomain = Crypt::encryptString($domain);

        //     return redirect($url.'?ip=' . urlencode($encryptedIp) . '&domain=' . urlencode($encryptedDomain));
        // }
        
        return $next($request);
    }
}
