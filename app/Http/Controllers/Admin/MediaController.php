<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    private const ALLOWED_DIRECTORIES = ['posts', 'courses', 'uploads'];

    public function index()
    {
        $files = [];
        $directories = self::ALLOWED_DIRECTORIES;

        foreach ($directories as $dir) {
            if (Storage::disk('public')->exists($dir)) {
                $dirFiles = Storage::disk('public')->files($dir);
                foreach ($dirFiles as $file) {
                    $lastModified = Storage::disk('public')->lastModified($file);
                    $files[] = [
                        'name' => basename($file),
                        'path' => $file,
                        'url' => Storage::url($file),
                        'size' => $this->formatBytes(Storage::disk('public')->size($file)),
                        'directory' => $dir,
                        'last_modified' => date('d/m/Y H:i', $lastModified),
                        'last_modified_ts' => $lastModified,
                    ];
                }
            }
        }

        // Sort by last modified
        usort($files, function ($a, $b) {
            return $b['last_modified_ts'] <=> $a['last_modified_ts'];
        });

        return view('admin.media.index', compact('files'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:5120', // 5MB
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads', 'public');

            return back()->with('success', 'Arquivo enviado com sucesso!');
        }

        return back()->with('error', 'Erro ao enviar arquivo.');
    }

    public function destroy($path)
    {
        $path = trim(urldecode($path), '/');
        $allowed = false;

        foreach (self::ALLOWED_DIRECTORIES as $directory) {
            if ($path === $directory || str_starts_with($path, $directory.'/')) {
                $allowed = true;
                break;
            }
        }

        if (! $allowed) {
            return back()->with('error', 'Caminho de arquivo inválido.');
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);

            return back()->with('success', 'Arquivo excluído com sucesso!');
        }

        return back()->with('error', 'Arquivo não encontrado.');
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision).' '.$units[$pow];
    }
}
