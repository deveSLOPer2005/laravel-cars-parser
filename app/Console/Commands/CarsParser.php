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
        $url = 'https://api.encar.com/search/car/list/general?count=true&q=(And.(And.Hidden.N._.CarType.Y.)_.(Or.ServiceMark.EncarDiagnosisP0._.ServiceMark.EncarDiagnosisP1._.ServiceMark.EncarDiagnosisP2.))&sr=%7CExtendWarranty%7C0%7C4';

        $response = \Illuminate\Support\Facades\Http::withoutVerifying()
        ->withHeaders([
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        'Accept' => 'application/json, text/javascript, */*; q=0.01',
        'Accept-Language' => 'ko-KR,ko;q=0.9,en-US;q=0.8',
    ])
    ->timeout(15)
    ->get($url);

    if ($response->successful()) {
        $data = $response->json();
        Storage::disk('local')->put(
            'cars.json', 
            json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
        $this->info("done! check 'storage/app/cars.json' to see the result.");
        return Command::SUCCESS;
        } else {
            $this->error("oops! you're blocked. error: " . $response->status());
            return Command::FAILURE;
        }
    }
}