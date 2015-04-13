<?php namespace Sequoyah\Http\Controllers;

class AudioController extends Controller
{
    public function GenerateAudio($inputString)
    {

    }
    public function MergeAudio($clip1Path, $clip2Path)
    {

    }

    public function UploadAudioSample($syllabaryId)
    {
        $targetDir = "/tmp/sequoyah/audioSample/";
        $targetFile = $targetDir . basename($_FILES['audioSample']['name']);
        $uploadOk = true;
        $audioFileType = pathinfo($targetFile, PATHINFO_EXTENSION);

        // Check if file name is already in use.

        if (file_exists($targetFile))
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
        elseif(move_uploaded_file($_FILE['audioSample']['tmpName'], $targetFile))
        {
             echo "The file" . basename($_FILE['audioSample']['name']) . " has been uploaded.";
        }
        else
        {
             echo "An unexpected error has occured while uploading file.";
        }
    }
}