<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use SplFileInfo;

class Documentation
{
    public function __construct(private Markdown $markdown)
    {
    }

    public function render(string $version, string $page): array
    {
        $index = Cache::remember(md5($version . $page . '-index-v1'), now()->addMinutes(5), fn () => $this->replaceIndexLinksWithTurboTarget(
            $this->markdown->convert(File::get(resource_path("docs/{$version}/index.md")), [
                'docs_version' => [
                    'current_version' => $version,
                ],
            ])
        ));

        $content = Cache::remember(md5($version . $page . '-content-v1'), now()->addMinutes(5), fn () => $this->markdown->convert(File::get(resource_path("docs/{$version}/{$page}.md")), [
            'docs_version' => [
                'current_version' => $version,
            ],
        ]));

        return [$index, $content];
    }

    private function replaceIndexLinksWithTurboTarget(string $content)
    {
        return str_replace(
            '<a ',
            '<a data-turbo-frame="docs-content" ',
            $content,
        );
    }

    public function isVersion(string $version)
    {
        return in_array($version, ['1.x'], true);
    }

    public function pageExistsInVersion(string $version, string $page)
    {
        return collect(File::files(resource_path('docs/' . $version)))
            ->filter(fn (SplFileInfo $file) => $file->getFilename() !== 'index.md')
            ->filter(fn (SplFileInfo $file) => $file->getFilename() === ($page . '.md'))
            ->isNotEmpty();
    }
}
