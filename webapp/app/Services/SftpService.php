<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class SftpService
{
    public function uploadFile(UploadedFile $file, string $directory = '', ?string $fileName = null): string
    {
        $disk = Storage::disk('sftp');

        // Generate unique filename if not provided
        if ($fileName === null) {
            $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        }

        // Build full path
        $path = $directory ? rtrim($directory, '/').'/'.$fileName : $fileName;

        // Upload file to remote server with public visibility (uses permPublic config)
        $uploaded = $disk->put($path, file_get_contents($file->getRealPath()), 'public');

        if (! $uploaded) {
            throw new RuntimeException('Failed to upload file to remote server');
        }

        // Set file permissions to 777 explicitly
        try {
            $adapter = $disk->getAdapter();
            $connection = null;

            // Try to get connection using reflection (check different possible property names)
            $reflection = new \ReflectionClass($adapter);
            $possibleProperties = ['connection', 'connectionProvider', 'sftp'];

            foreach ($possibleProperties as $propName) {
                if ($reflection->hasProperty($propName)) {
                    $property = $reflection->getProperty($propName);
                    $property->setAccessible(true);
                    $value = $property->getValue($adapter);

                    // If it's a connection provider, try to get the connection from it
                    if (is_object($value) && method_exists($value, 'provideConnection')) {
                        $connection = $value->provideConnection();
                        break;
                    } elseif (is_object($value) && method_exists($value, 'chmod')) {
                        $connection = $value;
                        break;
                    }
                }
            }

            if ($connection) {
                // Get the full absolute path
                $root = config('filesystems.disks.sftp.root', '/');
                $fullPath = rtrim($root, '/').'/'.ltrim($path, '/');

                // Use phpseclib's chmod method
                if (method_exists($connection, 'chmod')) {
                    $connection->chmod($fullPath, 0777);
                } elseif (method_exists($connection, 'exec')) {
                    // Fallback: use SSH command
                    $connection->exec('chmod 777 '.escapeshellarg($fullPath));
                }
            }
        } catch (\Exception $e) {
            // Log but don't fail if chmod fails
            \Log::warning('Failed to set file permissions to 777', [
                'path' => $path,
                'error' => $e->getMessage(),
            ]);
        }

        return $fileName;
    }

    public function uploadMultipleFiles(array $files, string $directory = ''): array
    {
        $uploadedPaths = [];

        foreach ($files as $index => $file) {
            if ($file instanceof UploadedFile) {
                $fileName = 'android_'.time().'_'.uniqid().'_'.($index + 1).'.'.$file->getClientOriginalExtension();
                $path = $this->uploadFile($file, $directory, $fileName);
                $uploadedPaths[] = $path;
            }
        }

        return $uploadedPaths;
    }

    public function fileExists(string $path): bool
    {
        return Storage::disk('sftp')->exists($path);
    }
}
