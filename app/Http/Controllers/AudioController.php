<?php namespace Sequoyah\Http\Controllers;

class AudioController extends Controller
{
    /* @arguments:
            Format: clip.extension
        @output:
            matches the output file extension.
        @requirements:
            Requires sox to be installed onto server
    */
    public function MergeAudio($syllabaryId, $clip1, $clip2, $output)
    {
        if(Storage::exists('audioSample/' . $clip1))
        {
            if(Storage::exists('audioSample/' . $clip2))
            {
                $command = 'sox -m audioSample/' . $clip1Path . ' audioSample/' . $clip2Path . ' audioSample/' . $outputName;
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

    public function UploadAudioSample($syllabaryId)
    {
        $targetDir = "audioSample/";
        $targetFile = $targetDir . basename($_FILES['audioSample']['name']);
        $uploadOk = true;
        $audioFileType = pathinfo($targetFile, PATHINFO_EXTENSION);

        // Check if file name is already in use.

        if (Storage::exists($targetFile))
        {
             echo "File already exists.";
             $uploadOK = false;
        }

        // Audio format check.

        if (($audioFileType != "audio/wav") || ($audioFileType != "audio/mpeg") ||
              ($audioFileType != "audio/ogg"))
        {
             echo "Unsupported audio format. Use wav, mpeg, or ogg.";
             $uploadOk = false;
        }

        // Audio file size check.

        if($_Files['audioSample']['size'] > 5242880) // Max size is 5MB.
        {
             echo "File size too large.";
             $uploadOK = false;
        }
        elseif($_Files['audioSample']['size'] == 0)
        {
             echo "File size too small.";
             $uploadOK = false;
        }

        if ($uploadOK == false)
        {
             echo "File was not uploaded.";
        }
        elseif(Storage::move($_FILE['audioSample']['tmpName'], $targetFile))
        {
             echo "The file" . basename($_FILE['audioSample']['name']) . " has been uploaded.";
        }
        else
        {
             echo "An unexpected error has occured while uploading file.";
        }
    }
}