<?php

namespace App\Jobs;

use App\Models\Image;
use Google\Cloud\Vision\V1\Client\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\AnnotateImageRequest;
use Google\Cloud\Vision\V1\BatchAnnotateImagesRequest;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Feature\Type;
use Google\Cloud\Vision\V1\Image as GImage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GoogleVisionSafeSearch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Image $image
    ) {}

    public function handle(): void
    {
        $path = storage_path('app/public/' . $this->image->path);

        // Inizializza il client con le credenziali
        $client = new ImageAnnotatorClient([
            'credentials' => base_path('google_credential.json'),
        ]);

        // Prepara l'immagine
        $gImage = (new GImage())->setContent(file_get_contents($path));

        // Prepara la feature safe search
        $feature = (new Feature())->setType(Type::SAFE_SEARCH_DETECTION);

        // Prepara la request
        $request = (new AnnotateImageRequest())
            ->setImage($gImage)
            ->setFeatures([$feature]);

        // Esegue la chiamata API
        $batchRequest = (new BatchAnnotateImagesRequest())->setRequests([$request]);
        $response = $client->batchAnnotateImages($batchRequest);
        $annotation = $response->getResponses()[0]->getSafeSearchAnnotation();

        if ($annotation) {
            $this->image->update([
                'safe_search' => [
                    'adult'    => $annotation->getAdult(),
                    'violence' => $annotation->getViolence(),
                    'racy'     => $annotation->getRacy(),
                ],
            ]);
        }

        $client->close();
    }
}
