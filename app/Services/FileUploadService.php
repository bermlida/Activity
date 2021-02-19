<?php

namespace App\Services;

use Mail;
use Storage;
use \Illuminate\Http\UploadedFile;

use App\Models\Activity;
use App\Models\Log;
use App\Models\Organizer;

class FileUploadService
{    
    /**
     * 上傳單一主辦單位的宣傳橫幅檔案。
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  \App\Models\Organizer  $organizer
     * @return void
     */
    public function uploadOrganizerBanner(UploadedFile $file, Organizer $organizer)
    {
        $stored_path = 'organizers/' . $organizer->id . '/';

        $filename = 'banner.' . $file->getClientOriginalExtension();

        Storage::put($stored_path . $filename, file_get_contents($file->getRealPath()));

        $resource = Storage::getDriver()->getAdapter()->getResource($stored_path . $filename);

        $data = [
            'name' => $filename,
            'type' => $file->getMimeType(),
            'size' => $file->getClientSize(),
            'path' => $stored_path . $filename,
            'url' => $resource['url'],
            'secure_url' => $resource['secure_url'],
            'category' => 'banner',
            'description' => ''
        ];

        if ($organizer->attachments()->where('category', 'banner')->count() > 0) {
            $attachment = $organizer->attachments()->where('category', 'banner')->first();

            $attachment->update($data);
        } else {
            $organizer->attachments()->create($data);
        }
    }

    /**
     * 上傳單一活動的宣傳橫幅檔案。
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  \App\Models\Log  $activity
     * @return void
     */
    public function uploadActivityBanner(UploadedFile $file, Activity $activity)
    {
        $stored_path = 'activities/' . $activity->id . '/';

        $filename = 'banner.' . $file->getClientOriginalExtension();

        Storage::put($stored_path . $filename, file_get_contents($file->getRealPath()));

        $resource = Storage::getDriver()->getAdapter()->getResource($stored_path . $filename);

        $data = [
            'name' => $filename,
            'type' => $file->getMimeType(),
            'size' => $file->getClientSize(),
            'path' => $stored_path . $filename,
            'url' => $resource['url'],
            'secure_url' => $resource['secure_url'],
            'category' => 'banner',
            'description' => ''
        ];

        if ($activity->attachments()->where('category', 'banner')->count() > 0) {
            $attachment = $activity->attachments()->where('category', 'banner')->first();

            $attachment->update($data);
        } else {
            $activity->attachments()->create($data);
        }
    }

    /**
     * 上傳單一活動日誌的內容。
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  \App\Models\Log  $log
     * @return void
     */
    public function uploadLog(UploadedFile $file, Log $log)
    {
        $stored_path = 'activities/' . $log->activity->id . '/' . $log->content_type . 's/';

        $filename = $log->id . '.' . $file->getClientOriginalExtension();

        Storage::put($stored_path . $filename, file_get_contents($file->getRealPath()));

        $resource = Storage::getDriver()->getAdapter()->getResource($stored_path . $filename);

        $data = [
            'name' => $filename,
            'type' => $file->getMimeType(),
            'size' => $file->getClientSize(),
            'path' => $stored_path . $filename,
            'url' => $resource['url'],
            'secure_url' => $resource['secure_url'],
            'category' => $log->content_type . '_content',
            'description' => ''
        ];

        $log->attachments()->create($data);
    }

    /**
     * 刪除單一活動日誌的內容。
     *
     * @param  \App\Models\Log  $log
     * @return void
     */
    public function deleteLog(Log $log)
    {
        foreach ($log->attachments()->where('category', 'like', '%_content')->get() as $attachment) {
            Storage::delete($attachment->path);
            
            $attachment->delete();
        }
    }
}
