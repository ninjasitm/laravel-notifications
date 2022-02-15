<?php

namespace Database\Seeders;

use Illuminate\Support\Arr;
use Illuminate\Http\UploadedFile;
use Nitm\Content\Repositories\FileRepository;

trait SeederCommon
{
    /**
     * Get Media for the given model based on the type sent
     *
     * @param  mixed $model
     * @param  mixed $type
     * @return void`
     */
    public function getMedia($model, $type, $save = true)
    {
        $result = null;
        $method = $save === true ? 'saveMedia' : 'getUploadedFile';
        switch ($type) {
            case 'image':
                return $this->$method($model, function () {
                    // $result = json_decode(file_get_contents('https://api.unsplash.com/photos/random?client_id=' . env('UNSPLASH_API_KEY')), true);
                    $result = Arr::random([
                        'https://archive.org/download/SPD-SLRSY-683/Ham_Flight.jpg',
                        'https://archive.org/download/SPD-SLRSY-4743/160148main_pia08813-516-annot.jpg',
                        'https://archive.org/download/SPD-SLRSY-19/kids-Comets005.jpg',
                        'https://archive.org/download/518084main_filament-break-orig/518084main_filament-break-orig_full.jpg',
                        'https://archive.org/download/SPD-SLRSY-166/gas_interiors.jpg'
                    ]);
                    // return [$result['urls']['regular'], $result['id'] . '.jpg'];
                    return [$result, pathinfo($result, PATHINFO_BASENAME)];
                });
                break;

            case 'video':
                return $this->$method($model, function () {
                    $result = Arr::random([
                        'http://www.digitalhistory.uh.edu/multimedia/digital_stories/before1492.wmv',
                        'https://archive.org/download/PegLegPe1938/PegLegPe1938.ogv',
                        'https://archive.org/download/0586_How_the_Eye_Functions_E00456_04_22_16_00/0586_How_the_Eye_Functions_E00456_04_22_16_00.mp4',
                        'https://archive.org/download/Frontier1937/Frontier1937.mp4',
                        'https://archive.org/download/TexasFar1952/TexasFar1952_512kb.mp4'
                    ]);
                    return [$result, pathinfo($result, PATHINFO_BASENAME)];
                });
                break;

            case 'audio':
                return $this->$method($model, function () {
                    $result = Arr::random([
                        'http://www.digitalhistory.uh.edu/music/aint_we_got_fun_billy_jones1921.mp3',
                        'http://www.digitalhistory.uh.edu/music/wabash_blues.mp3',
                        'http://www.digitalhistory.uh.edu/music/yankee_doodle_vess_ossman1897.mp3',
                        'http://www.digitalhistory.uh.edu/music/beulah_land_harry_macdonough.mp3',
                        'http://www.digitalhistory.uh.edu/music/band_of_gideon_fisk.mp3'
                    ]);
                    return [$result, pathinfo($result, PATHINFO_BASENAME)];
                });
                break;
        }
        return $result;
    }

    /**
     * Save Media
     *
     * @param  mixed $model
     * @param  mixed $getter
     * @return void
     */
    protected function saveMedia($model, $getter)
    {
        return app(FileRepository::class)->store($this->getUploadedFile($model, $getter), 'files', 'media', true, $model);
    }

    /**
     * Get Uploaded File instance
     *
     * @param  mixed $model
     * @param  mixed $getter
     * @return void
     */
    protected function getUploadedFile($model, $getter)
    {
        $path = tempnam('/tmp', uniqid());
        list($url, $filename) = $getter();
        file_put_contents($path, file_get_contents($url));
        return new UploadedFile($path, $filename);
    }
}