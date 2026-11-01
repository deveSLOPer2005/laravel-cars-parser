<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

#[Signature('app:cars-parser')]
#[Description('Command description')]
class CarsParser extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = 'https://encar.com';

        $response = \Illuminate\Support\Facades\Http::withoutVerifying()
        ->withHeaders([
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
        'Accept-Language' => 'ko-KR,ko;q=0.9,en-US;q=0.8',
    ])
    ->timeout(15)
    ->get($url);

    if ($response->successful()) {
        $htmlContent = mb_convert_encoding($response->body(), 'UTF-8', 'EUC-KR');
        $filename = 'encar_page.html';
        Storage::disk('local')->put($filename, $htmlContent);
        return Command::SUCCESS;
        } else {
            $this->error("oops! you're blocked. error: " . $response->status());
            return Command::FAILURE;
        }
    }
}