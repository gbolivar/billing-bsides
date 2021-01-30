<?php 
namespace App\Http\Domains;

use Illuminate\Http\Request;

class LoggerEventsDomains
{
    public function __invoke($inpact, Request $request):void
    {
        \Log::info($inpact, ['request' => $request->all(), 'headers' => $request->headers->all()]);
    }
}
