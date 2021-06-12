<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VideoCaption;
use Illuminate\Support\Facades\Storage;
use Exception;
define('SRT_STATE_SUBNUMBER', 0);
define('SRT_STATE_TIME',      1);
define('SRT_STATE_TEXT',      2);
define('SRT_STATE_BLANK',     3);
class VideoCaptionController extends Controller {

    public function action_list_caption(Request $request) {
        $captionsPath = storage_path('app/captions/');
        // Get filename with the extension
        $filenameWithExt = $request->file('file')->getClientOriginalName();
        // need just file name, try to get season and episode numbers
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // save to storage and get path
        $path = $request->file('file')->storeAs('captions',$filenameWithExt);
        // get saved file for use
        $lines   = file($captionsPath.$filenameWithExt);
        // create array to hold all data
        $subs    = array();
        $state   = SRT_STATE_SUBNUMBER;
        $subNum  = 0;
        $subText = '';
        $subTime = '';
        // start loop to gather data into object
        foreach($lines as $line) {
            switch($state) {
                case SRT_STATE_SUBNUMBER:
                    $subNum = trim($line);
                    $state  = SRT_STATE_TIME;
                    break;

                case SRT_STATE_TIME:
                    $subTime = trim($line);
                    $state   = SRT_STATE_TEXT;
                    break;

                case SRT_STATE_TEXT:
                    if (trim($line) == '') {
                        $sub = new \stdClass();
                        $sub->number = $subNum;
                        list($sub->startTime, $sub->stopTime) = explode(' --> ', $subTime);
                        $sub->startTime = str_replace(',', '.', $sub->startTime); // replace , with .
                        $sub->stopTime = str_replace(',', '.', $sub->stopTime); // replace , with .
                        $sub->text   = utf8_decode($subText);
                        $subText     = '';
                        $state       = SRT_STATE_SUBNUMBER;

                        $subs[]      = $sub;
                    } else {
                        $subText .= $line;
                    }
                    break;
            }
        }

        if ($state == SRT_STATE_TEXT) {
            // if file was missing the trailing newlines, we'll be in this
            // state here.  Append the last read text and add the last sub.
            $sub->text = $subText;
            $subs[] = $sub;
        }

        //save it to table now
        $nameParts = explode('-', $filename);
        $seasonParts = explode('x', $nameParts[1]);
        $epName = explode('.', $nameParts[2]);
        foreach($subs as $sub) {
            try{
                $caption = new VideoCaption;
                $caption->text = $sub->text;
                $caption->episodeSeason = trim($seasonParts[0]);
                $caption->episodeTitle = trim($epName[0]);
                $caption->episodeNumber = trim($seasonParts[1]);
                $caption->number = $sub->number;
                $caption->startTime = $sub->startTime;
                $caption->stopTime = $sub->stopTime;
                $caption->save();
            }
            catch(Throwable $e) {
                report($e);
            }
        }
        unlink($captionsPath.$filenameWithExt); // clean up file we dont want it laying around
        return response()->json($subs);
    }

    public function search(Request $request) {
        $captions = VideoCaption::where('text', 'like', '%' . $request->search . '%')->get();
        return response()->json($captions);
    }
}
