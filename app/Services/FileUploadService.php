<?php

namespace App\Services;

use Mail;
use SMS;
use \Illuminate\Http\UploadedFile;

use App\Models\Log;
use App\Models\Message;

class FileUploadService
{
    /**
     * 將上傳的檔案儲存至指定路徑。
     *
     * @param \App\Models\User $recipient
     * @param \App\Models\Message $message
     * @return void
     */
    public function storeFile(UploadedFile $file, $path, $filename = null)
    {
        if ($file->isValid()) {
            $filename = $filename ?? $file->getClientOriginalName();

            $file->move($path, $filename);

            return true;
        }

        return false;
    }

    /**
     * Update the avatar for the given user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function uploadBanner(UploadedFile $file, Model $model)
    {
        if (($model instanceof Organizer) || ($model instanceof Activity)) {
            $filename = strtolower(get_class($model)) . '-' . $model->id;
            $filename .= '.' . $file->getClientOriginalExtension();

            Storage::put(
                'banners/' . $filename,
                file_get_contents($file->getRealPath())
            );

            $data = [
                'name' => $filename,
                'type' => $file->getMimeType(),
                'size' => $file->getClientSize(),
                'path' => 'banners/' . $filename,
                'category' => 'banner',
                'description' => ''
            ];

            if ($model->attachments()->where('category', 'banner')->count() > 0) {
                $attachment = $model->attachments()->where('category', 'banner')->first();

                $attachment->update($data);
            } else {
                $model->attachments()->create($data);
            }
        }
    }

    /**
     * 儲存單一活動訊息。
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadLog(UploadedFile $file, Log $log)
    {
        $stored_path = 'activities/' . $log->activity->id . '/' . $log->content_type . 's/';

        $data = [
            'name' => $file->getClientOriginalName(),
            'type' => $file->getMimeType(),
            'size' => $file->getClientSize(),
            'path' => $stored_path . $file->getClientOriginalName(),
            'category' => $log->content_type . '_content',
            'description' => ''
        ];

        $log->attachments()->create($data);

        Storage::put(
            $stored_path . $file->getClientOriginalName(),
            file_get_contents($file->getRealPath())
        );                    
    }

    /**
     * 儲存單一活動訊息。
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteLog(Log $log)
    {
        if ($log->attachments()->where('category', 'like', '%_content')->count() > 0) {
            $attachment = $log->attachments()->where('category', 'like', '%_content')->first();

            Storage::delete($attachment->path);

            $attachment->delete();
        }
    }
}
