<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VideoCaption;
use App\Models\VideoImage;
use Illuminate\Support\Facades\Storage;
use Exception;
use FFMpeg;
use Illuminate\Support\Str;
define('SRT_STATE_SUBNUMBER', 0);
define('SRT_STATE_TIME',      1);
define('SRT_STATE_TEXT',      2);
define('SRT_STATE_BLANK',     3);
ini_set('max_execution_time', 300);

class ImageController extends Controller {

    public function create_images_from_video_file(Request $request) {
        $imagePath = storage_path('images');
        $captionsPath = storage_path('app/captions');

        // Get filename with the extension
        $filenameWithExt = $request->file('file')->getClientOriginalName();
        // need just file name, try to get season and episode numbers
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // save to storage and get path
        $path = $request->file('file')->storeAs('captions',$filenameWithExt);
        // get saved file for use


        $titleParts = explode('-', $filename);

        [$season, $episode] = str_split(trim($titleParts[1]), 3);

        $season = preg_replace("/[^0-9]/", "", $season );
        $season = ltrim($season, "0");

        $episode = preg_replace("/[^0-9]/", "", $episode );

        // get saved file for use
        $video  = file($captionsPath.'/'.$filenameWithExt);

        $captions = VideoCaption::where('episodeNumber', 'like', $episode)->where('episodeSeason', 'like', $season)->get();

        $imagePaths = [];

        foreach($captions as $caption) {
            $elapsed = intval($caption->startTime) - intval($caption->endTime);
            $a = 0;
            $counter = [];
            // 6 frames after start time
            if ($elapsed > 6) {
                while($a < 3){
                    $a++;
                    array_push($counter, ($caption->startTime + $a));
                }
            } else {
                while($a < $elapsed){
                    $a++;
                    array_push($counter, ($caption->startTime + $a));
                }
            }

            // loop over frames to grab from the video and save them to local dir
            foreach ($counter as $key => $seconds) {
                FFMpeg::fromDisk('captions')
                    ->open($filenameWithExt)
                    ->addFilter("select='gt(scene\,0.4)'", 1)
                    ->getFrameFromSeconds($seconds)
                    ->export()
                    ->withVisibility('public')
                    ->toDisk('spaces')
                    ->save(trim(explode('.', $titleParts[2])[0]). '-' . $episode . '-' . $caption->number.'-'.$seconds. Str::uuid()->toString() .'.png');
            }

            // get all images and match them to the current captions and save that to db
            foreach(Storage::disk('spaces')->files() as $file) {
                $fileName = explode('-', $file)[2];
                if ($fileName == $caption->number) {

                    try{
                        $imageData = new VideoImage;
                        $imageData->text = $caption->text;
                        $imageData->episodeSeason = $season;
                        $imageData->episodeTitle = trim(explode('.', $titleParts[2])[0]);
                        $imageData->episodeNumber = $episode;
                        $imageData->number = $caption->number;
                        $imageData->startTime = $caption->startTime;
                        $imageData->stopTime = $caption->stopTime;
                        $imageData->url = Storage::disk('spaces')->url($file);
                        $imageData->save();
                    }
                    catch(Throwable $e) {
                        report($e);
                    }
                    $object = array(
                        'text' => $caption->text,
                        'episodeSeason' => $caption->episodeSeason,
                        'episodeTitle' => $caption->episodeTitle,
                        'episodeNumber' => $caption->episodeNumber,
                        'startTime' => $caption->startTime,
                        'stopTime' => $caption->stopTime,
                        'url' => Storage::disk('spaces')->url($file),
                    );
                    array_push($imagePaths, $object);
                }
            }

            FFMpeg::cleanupTemporaryFiles();
        }
        return response()->json($imagePaths);
    }


    public function get_single_image(Request $request) {
       // get single record from table
       $results = VideoImage::findOrFail($request->id);
       return response()->json($results);
    }

    public function get_random_image(Request $request) {
        // get random image record from table
        $result = VideoImage::inRandomOrder()->limit(1)->get();
        return response()->json($result);
    }

    public function get_near_images(Request $request) {
        // get previous 5 records from current image
        $before = VideoImage::where('id', '<', $request->id)->latest('id')->limit(3)->get();
        // get 5 records after from current image
        $after = VideoImage::where('id', '>', $request->id)->oldest('id')->limit(2)->get();
        // get current record cause we lazy
        $current = VideoImage::findOrFail($request->id);
        // put into array
        $results = [$before, $current, $after];
        // return that shit
        return response()->json($results);
    }

}
