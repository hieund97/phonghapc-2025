<?php

namespace App\Services;

use App\Models\Appearance;
use App\Models\Design;
use Intervention\Image\Facades\Image;
use Storage;

class ImageService
{
    public static function getUrl($customizeId, $appearanceId, $viewId)
    {
        return route('customizes.image', [
            'customize' => $customizeId,
            'appearance' => $appearanceId,
            'view' => $viewId,
        ]);
    }

    public static function getDesignUrl($designId, $appearanceId, $colors)
    {
        $colors = base64_encode(
            collect($colors)->map(fn ($color) => $color['layer'] . ':' . $color['color'])->implode(',')
        );

        return route('designs.image', [
            'design' => $designId,
            'appearance' => $appearanceId,
            'colors' => $colors,
        ]);
    }

    public function generateDesign(Design $design, Appearance $appearance, $colors = [])
    {
        $colors = collect($colors);

        $image = Image::canvas(300, 300);
        $image->fill($appearance->colors[0]['value']);

        foreach ($design->medias as $media) {
            $color = $colors->where('layer', $media->pivot->layer)->first();
            $color = $color['color'] ?? $media->pivot->default;

            $layer = Image::make(Storage::disk('public')->get($media->path));
            $layer->colorize(100, 100, 100);
            $layer->colorize(...$this->hexToGd($color));
            $layer->resize($design->size['width'], $design->size['height']);

            $image->insert($layer, 'center');
        }

        return $image;
    }

    protected function hexToGd($hex)
    {
        return array_map(fn ($value) => $value / 1.275 - 100, sscanf($hex, '#%02x%02x%02x'));
    }

    public function generate($productImage, $view, $configurations)
    {
        $printArea = Image::canvas(
            $view->printArea->boundary['size']['width'],
            $view->printArea->boundary['size']['height']
        );

        if (config('app.debug')) {
            $printArea->rectangle(0, 0, $printArea->width() - 1, $printArea->height() - 1, function ($draw) {
                $draw->border(1, '#000');
            });
        }

        foreach ($configurations as $configuration) {
            $this->design($printArea, $configuration->design, $configuration);
        }

        return Image::make($productImage)
            ->resize($view->width, $view->height)
            ->insert(
                $printArea,
                'top-left',
                ceil($view->printArea->offset['x']),
                ceil($view->printArea->offset['y'])
            );
    }

    public function design($printArea, $design, $options)
    {
        foreach ($design->medias as $media) {
            $image = Image::make(Storage::disk('public')->get($media->path));

            $image->resize(
                $design->size['width'] * $options->scale,
                $design->size['height'] * $options->scale
            );

            $image->rotate($options->rotate);
            $image->colorize(100, 100, 100);

            $color = $options->colors->where('layer', $media->pivot->layer)->first();
            $color = $color['color'] ?? $media->pivot->default;

            if ($color) {
                $image->colorize(...$this->hexToGd($color));
            }

            $printArea->insert(
                $image,
                'top-left',
                ceil($options->offset['x']),
                ceil($options->offset['y'])
            );
        }
    }

    public function text($text, $options)
    {
        return null;
    }
}
