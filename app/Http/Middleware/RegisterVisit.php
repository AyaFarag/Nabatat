<?php

namespace App\Http\Middleware;

use App\Models\Visitor;

use Closure;

class RegisterVisit
{
    public function handle($request, Closure $next)
    {

        $ip = $request -> ip();
        try {
            $visitor = Visitor::where("ip", $ip) -> first();
            if ($visitor) {
                $visitor -> count += 1;
                $visitor -> save();
            } else {
                $geoip = geoip() -> getLocation($ip);
                Visitor::create([
                    "ip"      => $ip,
                    "country" => $geoip -> country,
                    "city"    => $geoip -> city,
                    "count"   => 1
                ]);
            }
        } catch (Exception $e) {

        }

        return $next($request);
    }
}
