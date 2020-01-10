<?php

namespace App\Services;

use Mail;
use SMS;
use \Illuminate\Database\Eloquent\Model;
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
     * 上傳特定模型的宣傳橫幅檔案。
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function uploadBanner(UploadedFile $file, Model $model)
    {
        if (($model instanceof Organizer) || ($model instanceof Activity)) {            
            $stored_path = str_plural(strtolower(get_class($model))) . '/' . $model->id . '/';

            $filename = 'banner.' . $file->getClientOriginalExtension();

            Storage::put(
                $stored_path . $filename,
                file_get_contents($file->getRealPath())
            );

            $data = [
                'name' => $filename,
                'type' => $file->getMimeType(),
                'size' => $file->getClientSize(),
                'path' => $stored_path . $filename,
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
     * 上傳單一活動影音日誌的內容。
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  \App\Models\Log
     * @return void
     */
    public function uploadLog(UploadedFile $file, Log $log)
    {
        $stored_path = 'activities/' . $log->activity->id . '/' . $log->content_type . 's/';

        $filename = $log->id . '.' . $file->getClientOriginalExtension();

        $data = [
            'name' => $filename,
            'type' => $file->getMimeType(),
            'size' => $file->getClientSize(),
            'path' => $stored_path . $filename,
            'category' => $log->content_type . '_content',
            'description' => ''
        ];

        $log->attachments()->create($data);

        Storage::put(
            $stored_path . $filename,
            file_get_contents($file->getRealPath())
        );                    
    }

    /**
     * 刪除單一活動影音日誌的內容。
     *
     * @param  \App\Models\Log
     * @return void
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
