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

class GoogleVisionLabelImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Image $image
    ) {}

    public function handle(): void
    {
        $path = storage_path('app/public/' . $this->image->path);

        $client = new ImageAnnotatorClient([
            'credentials' => base_path('google_credential.json'),
        ]);

        $gImage = (new GImage())->setContent(file_get_contents($path));

        // Prepara la feature label detection
        $feature = (new Feature())->setType(Type::LABEL_DETECTION);

        $request = (new AnnotateImageRequest())
            ->setImage($gImage)
            ->setFeatures([$feature]);

        $batchRequest = (new BatchAnnotateImagesRequest())
            ->setRequests([$request]);

        $response = $client->batchAnnotateImages($batchRequest);
        $labels = $response->getResponses()[0]->getLabelAnnotations();

        if ($labels) {
            $result = [];
            foreach ($labels as $label) {
                $result[] = $label->getDescription();
            }
            $this->image->update(['labels' => $result]);
        }

        $client->close();
    }
}
