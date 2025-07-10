<?php
use Illuminate\Support\Facades\Storage;


if (! function_exists('splitFullName')) {
    function splitFullName(string $fullName): array
    {
        // Remove extra spaces and split by space
        $parts = preg_split('/\s+/', trim($fullName));

        // If no name is entered
        if (empty($parts)) {
            return ['surname' => '', 'othernames' => ''];
        }

        // If only one name is entered, treat it as surname
        if (count($parts) === 1) {
            return ['surname' => $parts[0], 'othernames' => ''];
        }

        // First word as surname, rest as othernames
        $surname = $parts[0];
        $othernames = implode(' ', array_slice($parts, 1));

        return [
            'surname' => $surname,
            'othernames' => $othernames
        ];
    }
}

if (!function_exists('formatPhoneNumber')) {
    /**
     * @param string $number
     * @param string|null $country
     * @param bool $strip_plus
     * @return string
     */
    function formatPhoneNumber(string $number, ?string $country = null, bool $strip_plus = true): string
    {
        $number = preg_replace('/\s+/', '', $number);
        $replace = static function ($needle, $replacement) use (&$number) {
            if (Str::startsWith($number, $needle)) {
                $pos = strpos($number, $needle);
                $length = strlen($needle);
                $number = substr_replace($number, $replacement, $pos, $length);
            }
        };

        //07 sanitizer
        $replace('2547', '+2547');
        $replace('07', '+2547');
        $replace('7', '+2547');

        //01 sanitizer
        $replace('2541', '+2541');
        $replace('01', '+2541');

        if (!is_null($country)) {
            if ($country == 'KE' || $country == 'ke') {
                $replace('1', '+2541');
            }
        }

        if ($strip_plus) {
            $replace('+254', '254');
        }

        return $number;
    }
}

if (!function_exists('uploadToOBS')) {
    function uploadToOBS($file, $dir = 'images'): ?string
    {
        $extension = $file->getClientOriginalExtension();

        $obs_upload_image = $file;
        $obs_upload_image = file_get_contents($obs_upload_image);

        $name = time() . "_" . uniqid() ."_". $dir.'.' . $extension;
        $filePath = 'skyworld' . $name;

        Storage::disk('obs')->put($filePath, $obs_upload_image);

        return Storage::disk('obs')->url($filePath);
    }

}

if (!function_exists('getImage')) {
    function getImage($file_name = ''): string
    {
        if (!empty($file_name)) {
            $return_file =  'skyworld' . $file_name;
        } else {
            $return_file = 'static-images/no-image.png';
        }
        return Storage::disk('obs')->url($return_file);
    }
}

if (!function_exists('uploadMultipleImages')) {
    function uploadMultipleImages($input ,$model = null): array
    {
        $images = [];
        $obs_base = 'https://weego-cms-files.obs.af-south-1.myhuaweicloud.com/'.
            $model_id = '';
        if(!is_null($model))
            $model_id = $model->id;

        if(request()->hasFile($input))
        {
            foreach(request()->file($input) as $file) {
                $name = $model_id.'_'.uniqid() . '_' . $file->getClientOriginalName();
                $obs_upload_image = $file;
                $obs_upload_image = file_get_contents($obs_upload_image);

                $filePath = 'skyworld' . $name;

                Storage::disk('obs')->put($filePath, $obs_upload_image);

                $file_url = $obs_base.$filePath;

                $images[] = $file_url;
            }
        }

        return $images;
    }
}

if (!function_exists('deleteImage')) {
    function deleteImage($image): bool
    {
        $filePath =  'skyworld' . $image;

        return Storage::disk('obs')->delete($filePath);
    }

}





