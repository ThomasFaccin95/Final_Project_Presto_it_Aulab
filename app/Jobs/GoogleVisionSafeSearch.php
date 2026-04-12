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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GoogleVisionSafeSearch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Image $image) {}

    public function handle(): void
    {
        $path = storage_path('app/public/' . $this->image->path);

        Log::info("[SafeSearch] Avvio job per immagine ID: {$this->image->id}");

        if (!file_exists($path)) {
            Log::warning("[SafeSearch] File NON trovato, job interrotto.");
            return;
        }

        $imageAnnotator = new ImageAnnotatorClient([
            'credentials' => base_path('google_credential.json'),
        ]);

        try {
            $imageContent = file_get_contents($path);

            $gImage = (new GImage())->setContent($imageContent);
            $feature = (new Feature())->setType(Type::SAFE_SEARCH_DETECTION);

            $request = (new AnnotateImageRequest())
                ->setImage($gImage)
                ->setFeatures([$feature]);

            $batchRequest = (new BatchAnnotateImagesRequest())
                ->setRequests([$request]);

            $response = $imageAnnotator->batchAnnotateImages($batchRequest);
            $annotation = $response->getResponses()[0]->getSafeSearchAnnotation();

            if ($annotation) {
                $adult    = $annotation->getAdult();
                $violence = $annotation->getViolence();
                $racy     = $annotation->getRacy();

                Log::info("[SafeSearch] Risultati — adult: {$adult}, violence: {$violence}, racy: {$racy}");

                $this->image->update([
                    'safe_search' => [
                        'adult'    => $adult,
                        'medical'  => $annotation->getMedical(),
                        'spoof'    => $annotation->getSpoof(),
                        'violence' => $violence,
                        'racy'     => $racy,
                    ],
                ]);

                // Likelihood: 1=UNKNOWN, 2=VERY_UNLIKELY, 3=UNLIKELY, 4=POSSIBLE, 5=LIKELY, 6=VERY_LIKELY
                if ($adult >= 4 || $violence >= 4 || $racy >= 4) {
                    Log::warning("[SafeSearch] CONTENUTO ESPLICITO rilevato — eliminazione articolo.");

                    $article = $this->image->article;

                    if (!$article) {
                        Log::error("[SafeSearch] Articolo non trovato!");
                        return;
                    }

                    foreach ($article->images as $img) {
                        Storage::disk('public')->delete($img->path);
                        $img->delete();
                        Log::warning("[SafeSearch] Immagine eliminata: {$img->id}");
                    }

                    $article->delete();
                    Log::warning("[SafeSearch] Articolo ID {$article->id} eliminato automaticamente.");

                    return;
                }

                Log::info("[SafeSearch] Contenuto OK per immagine ID: {$this->image->id}");
            }
        } catch (\Exception $e) {
            Log::error("[SafeSearch] Errore: " . $e->getMessage());
        } finally {
            $imageAnnotator->close();
        }
    }
}
