<?php

namespace App\Traits;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

trait OptimizesImagesToWebp
{
    public static function bootOptimizesImagesToWebp()
    {
        static::saving(function ($model) {
            if (!method_exists($model, 'getImageFieldsToOptimize')) {
                return;
            }

            $imageFields = $model->getImageFieldsToOptimize();

            foreach ($imageFields as $field) {
                if ($model->isDirty($field)) {
                    $paths = $model->getAttribute($field);
                    if (empty($paths)) continue;

                    $isArray = is_array($paths);
                    $pathsArray = $isArray ? $paths : [$paths];
                    
                    $newPathsArray = [];

                    $manager = new ImageManager(new Driver());

                    foreach ($pathsArray as $path) {
                        if (Str::endsWith(strtolower($path), '.webp')) {
                            $newPathsArray[] = $path;
                            continue;
                        }

                        $absolutePath = public_path($path);
                        
                        if (file_exists($absolutePath) && @is_array(getimagesize($absolutePath))) {
                            try {
                                $image = $manager->decodePath($absolutePath);
                                $image->scaleDown(width: 1920);
                                
                                $newPath = (string) Str::of($path)->beforeLast('.') . '.webp';
                                $newAbsolutePath = public_path($newPath);
                                
                                $image->save($newAbsolutePath, quality: 80);
                                
                                if ($newAbsolutePath !== $absolutePath) {
                                    @unlink($absolutePath);
                                }
                                $newPathsArray[] = $newPath;
                            } catch (\Exception $e) {
                                \Illuminate\Support\Facades\Log::error('Image optimization failed: ' . $e->getMessage());
                                $newPathsArray[] = $path;
                            }
                        } else {
                            $newPathsArray[] = $path;
                        }
                    }

                    $model->setAttribute($field, $isArray ? array_values(array_filter($newPathsArray)) : $newPathsArray[0]);
                }
            }
        });
    }
}
