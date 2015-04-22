<?php namespace Sequoyah\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Request;
use Response;
use Sequoyah\Models\SyllabaryColumnHeader;
use Sequoyah\Models\SyllabaryRowHeader;

class AudioController extends Controller
{
    /* @arguments:
            Format: clip.extension
        @output:
            matches the output file extension.
        @requirements:
            Requires sox to be installed onto server
    */
    public function GenerateSyllableAudio($syllabaryId, $clip1, $clip2, $output)
    {
        if(Storage::exists('audioSample/' . $clip1))
        {
            if(Storage::exists('audioSample/' . $clip2))
            {
                $command = 'sox -m audioSample/' . $clip1 . ' audioSample/' . $clip2 . ' audioSample/' . $outputName;
                exec($command);
            }
            else
            {
                echo "Could not find audioSample/" . $clip2;
            }
        }
        else
        {
            echo "Could not find audioSample" . $clip1;
        }

    }

    public function GetRowAudioSample($syllabaryId, $rowId)
    {
       $row = SyllabaryRowHeader::where('syllabary_id', '=', $syllabaryId)->
                                  where('id', '=', $rowId)->first();
       
       if ($row == NULL || $row->audio_sample == NULL)
         return '';

       return response()->make(Storage::get($row->audio_sample));
    }

    public function GetColumnAudioSample($syllabaryId, $columnId)
    {
       $column = SyllabaryColumnHeader::where('syllabary_id', '=', $syllabaryId)->
                                        where('id', '=', $columnId)->first();
       
       if ($column == NULL || $column->audio_sample == NULL)
         return '';

       return response()->make(Storage::get($column->audio_sample));
    }

    public function UploadRowHeaderSample($syllabaryId, $rowId)
    {
      $row = SyllabaryRowHeader::where('syllabary_id', '=', $syllabaryId)->
                                 where('id', '=', $rowId)->first();

      if ($row == NULL)
        return response()->json(['success' => false]);

      $uploadStatus = $this->_UploadAudioSample();
      if ($uploadStatus['success'] == false)
        return redirect()->back();

      $row->audio_sample = $uploadStatus['file_path'];
      $row->save();

      return redirect()->back();
    }

    public function UploadColumnHeaderSample($syllabaryId, $columnId)
    {
      $column = SyllabaryColumnHeader::where('syllabary_id', '=', $syllabaryId)->
                                       where('id', '=', $columnId)->first();

      if ($column == NULL)
        return response()->json(['success' => false]);

      $uploadStatus = $this->_UploadAudioSample();
      if ($uploadStatus['success'] == false)
        return redirect()->back();

      $column->audio_sample = $uploadStatus['file_path'];
      $column->save();

      return redirect()->back();
    }

    public function UploadSyllableSample($syllabaryId, $syllableCellId)
    {
    }

    private function _UploadAudioSample()
    {
        $audioFileType = pathinfo(basename($_FILES['audioSample']['name']), PATHINFO_EXTENSION);
        $targetDir = "audioSample/";
        $targetFile = $targetDir . uniqid() . '.' .  $audioFileType;
        $uploadOk = true;

        // Check if file name is already in use.

        if (Storage::exists($targetFile))
        {
             $statusArray = [
               'success' => false,
               'error' => 'File already exists.',
             ];
             return $statusArray;
        }

        // Audio format check.

        if (($audioFileType != "wav") && ($audioFileType != "mp3") &&
              ($audioFileType != "ogg"))
        {
             $statusArray = [
               'success' => false,
               'error' => 'Unsupported audio format. Use wav, mp3, or ogg.', 
             ];
             return $statusArray;
        }

        // Audio file size check.

        if($_FILES['audioSample']['size'] > 5242880) // Max size is 5MB.
        {
             $statusArray = [
               'success' => false,
               'error' => 'File size too large.',
             ];
             return $statusArray;
        }
        elseif($_FILES['audioSample']['size'] == 0)
        {
             $statusArray = [
               'success' => false,
               'error' => 'File size too small.',
             ];
             return $statusArray;
        }

        if ($uploadOk == false)
        {
              $statusArray = [
               'success' => false,
               'error' => 'File was not uploaded. ' . $targetFile,
             ];
        }
        elseif(Storage::put($targetFile, File::get(Request::file('audioSample'))))
        {
             $statusArray = [
               'success' => true,
               'file_path' => $targetFile
             ];
        }

        return $statusArray;
    }
}
