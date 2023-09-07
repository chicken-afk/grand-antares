<?php

namespace App\Http\Middleware;

use App\Models\Ipaddress;
use Closure;
use Illuminate\Http\Request;

class LimitedIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $ipAddress = Ipaddress::where('is_active', 1)->pluck('ip_address')->toArray();
        $userIP = $request->ip();

        if (in_array($userIP, $ipAddress)) {
            return $next($request);
            // $userIP terdapat dalam koleksi $ipAddress
            // Lakukan tindakan yang sesuai di sini
            // Contoh: return response()->json(['message' => 'IP valid'], 200);
        } else {
            $uri = $request->getRequestUri();
            $arr = explode("/", $uri);
            $data = $arr[2];
            // $userIP tidak terdapat dalam koleksi $ipAddress
            return redirect()->route('wifiList', ['code' => $data]);
        }
    }
}
