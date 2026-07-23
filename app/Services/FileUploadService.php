<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    private array $allowedMimes = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'application/pdf',
        'text/plain',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];

    private int $maxSize = 10240; // 10MB

    public function validate(UploadedFile $file): void
    {
        if (!in_array($file->getMimeType(), $this->allowedMimes, true)) {
            throw new \InvalidArgumentException('Unsupported file type.');
        }

        if ($file->getSize() > $this->maxSize * 1024) {
            throw new \InvalidArgumentException('File exceeds maximum allowed size.');
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $blocked = ['php', 'php3', 'php4', 'php5', 'phtml', 'exe', 'sh', 'bat', 'cmd', 'js', 'vbs', 'wsf'];

        if (in_array($extension, $blocked, true)) {
            throw new \InvalidArgumentException('File extension is not allowed.');
        }
    }

    public function store(UploadedFile $file, string $directory = 'chat'): array
    {
        $this->validate($file);

        $disk = config('filesystems.default', 'local');
        $path = $file->store($directory, $disk);

        return [
            'disk' => $disk,
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'file_hash' => hash_file('sha256', $file->getRealPath()),
        ];
    }
}