<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\Facades\Image as InterventionImage;

trait UploadTrait
{

    public function verifyAndStoreImage(Request $request, $inputname, $foldername, $disk, $imageable_id, $imageable_type)
    {

        if ($request->hasFile($inputname)) {

            // Check img
            if (!$request->file($inputname)->isValid()) {
                // flash('Invalid Image!')->error()->important();
                Alert::toast(__('site.invalid_image'), 'error')->timerProgressBar();
                return redirect()->back()->withInput();
            }

            $photo = $request->file($inputname);

            $name = Str::slug($request->input('name', 'file'));
            $filename = $name . '-' . uniqid() . '.' . $photo->getClientOriginalExtension();

            $path = $foldername . '/' . $filename;

            // insert Image
            $Image = new Image();
            $Image->file = $filename;
            $Image->imageable_id = $imageable_id;
            $Image->imageable_type = $imageable_type;
            $Image->save();

            // Resize & save with Intervention

            $fullPath = Storage::disk($disk)->path($path);

            InterventionImage::make($photo)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save($fullPath);

            // return $request->file($inputname)->storeAs($foldername, $filename, $disk);

            return $path;

        }

        return null;

    }

    public function verifyAndStoreImageForeach($file, $foldername, $disk, $imageable_id, $imageable_type)
    {
        // تأكد إن الملف فعلاً موجود وصحيح
        if (!$file->isValid()) {
            Alert::toast(__('site.invalid_image'), 'error')->timerProgressBar();
            return redirect()->back()->withInput();
        }

        // إنشاء اسم فريد للملف
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $name = Str::slug($name, '-');
        $filename = $name . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $foldername . '/' . $filename;

        // حفظ الصورة في قاعدة البيانات
        $Image = new Image();
        $Image->file = $filename;
        $Image->imageable_id = $imageable_id;
        $Image->imageable_type = $imageable_type;
        $Image->save();

        // عمل Resize للصورة باستخدام Intervention Image
        $fullPath = Storage::disk($disk)->path($path);

        InterventionImage::make($file)
            ->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($fullPath);

        return $path;
    }

    // public function verifyAndStoreImageForeach($varforeach, $foldername, $disk, $imageable_id, $imageable_type)
    // {
    //     // insert Image
    //     $Image = new Image();
    //     $Image->filename = $varforeach->getClientOriginalName();
    //     $Image->imageable_id = $imageable_id;
    //     $Image->imageable_type = $imageable_type;
    //     $Image->save();
    //     return $varforeach->storeAs($foldername, $varforeach->getClientOriginalName(), $disk);
    // }

    public function Delete_attachment($disk, $path, $id)
    {

        Storage::disk($disk)->delete($path);
        image::where('imageable_id', $id)->delete();
    }


}
