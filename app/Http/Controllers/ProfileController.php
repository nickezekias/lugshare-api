<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProfileController extends Controller
{
    public function verifyIDDocument(Request $request)
    {
        // Validate that the request contains an image file
        $request->validate([
            'IDDocument' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'userPic' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $idPath = $this->uploadImage($request->IDDocument);
        $picPath = $this->uploadImage($request->userPic);

        try {
            // Call Python script to compare the images
            $result = $this->compareImagesWithPython($idPath, $picPath);

            return response()->json([
                'similar' => $result
            ]);
        } catch (FileException $e) {
            return response()->json(['error' => 'Error storing the uploaded image: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error during comparison: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Compare the uploaded photo with the user's stored photo using Python.
     *
     * @param string $uploadedPhotoPath Path to the uploaded photo.
     * @param string $userImagePath Path to the user's stored photo.
     * @return bool True if the images are similar, false otherwise.
     */
    private function compareImagesWithPython($uploadedPhotoPath, $userImagePath)
    {
        // Build the Python command to compare the images using an AI model
        $command = escapeshellcmd("python3 " . base_path('resources/scripts/compare_images.py') . " " . $uploadedPhotoPath . " " . $userImagePath);

        // Execute the command and get the result (0 for similar, 1 for not similar)
        $result = shell_exec($command);

        return trim($result) == '1' ? false : true;
    }

    protected function uploadImage(UploadedFile $file): string
    {
        if ($file) {
            $resp = Storage::put('storage/user-ids', $file, 'public');
            return $resp;
        } else {
            return 'No File';
        }
    }
}
