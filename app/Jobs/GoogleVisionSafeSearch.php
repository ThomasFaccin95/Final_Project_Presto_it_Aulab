<?php

namespace App\Jobs;

use App\Models\Image;
use Google\Cloud\Vision\V1\Client\ImageAnnotatorClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GoogleVisionSafeSearch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Image $image
    ) {}

    public function handle(): void
    {
        // Costruiamo il percorso completo dell'immagine
        $path = storage_path('app/public/' . $this->image->path);

        // Inizializziamo il client
        $imageAnnotator = new ImageAnnotatorClient([
            'credentials' => base_path('google_credential.json'),
        ]);

        try {
            // Leggiamo il contenuto del file
            $imageContent = file_get_contents($path);

            // Eseguiamo la scansione SafeSearch in modo diretto
            $response = $imageAnnotator->safeSearchDetection($imageContent);
            $annotation = $response->getSafeSearchAnnotation();

            if ($annotation) {
                // Likelihood ritorna degli interi (1-5), li mappiamo per comodità o li salviamo così
                $this->image->update([
                    'safe_search' => [
                        'adult'    => $annotation->getAdult(),
                        'medical'  => $annotation->getMedical(),
                        'spoof'    => $annotation->getSpoof(),
                        'violence' => $annotation->getViolence(),
                        'racy'     => $annotation->getRacy(),
                    ],
                ]);
            }
        } catch (\Exception $e) {
            // È buona norma loggare l'errore se qualcosa va storto nell'analisi
            Log::error("Google Vision Error: " . $e->getMessage());
        } finally {
            $imageAnnotator->close();
        }
    }
}
