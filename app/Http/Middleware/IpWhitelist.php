<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IpWhitelist
{
    protected $subnets = [
        ['subnet' => '10.55.3.0', 'mask' => 24], // lantai 1
        ['subnet' => '10.55.4.0', 'mask' => 24], // lantai 2
        // bisa tambah subnet lain di sini
    ];
    
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();

        // Jika di localhost (dev), biarkan
        if ($ip === '127.0.0.1' || $ip === '::1') {
            return $next($request);
        }

        // Cek subnet kantor
        if (!$this->ipInSubnet($ip, $this->subnet, $this->mask)) {
            abort(403, 'Access denied: IP not allowed.');
        }

        return $next($request);
    }

    private function ipInSubnet($ip, $subnet, $mask)
    {
        $ipLong = ip2long($ip);
        $subnetLong = ip2long($subnet);
        $maskLong = ~((1 << (32 - $mask)) - 1);

        return ($ipLong & $maskLong) === ($subnetLong & $maskLong);
    }
}
