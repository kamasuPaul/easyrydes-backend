<?php

namespace App\Models;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Filesystem\FilesystemManager;
use Plank\Mediable\UrlGenerators\BaseUrlGenerator;
use Plank\Mediable\UrlGenerators\TemporaryUrlGeneratorInterface;

class GcsUrlGenerator extends BaseUrlGenerator
{
    /**
     * Filesystem Manager.
     * @var FilesystemManager
     */
    protected $filesystem;

    /**
     * Constructor.
     * @param \Illuminate\Contracts\Config\Repository $config
     * @param \Illuminate\Filesystem\FilesystemManager $filesystem
     */
    public function __construct(Config $config, FilesystemManager $filesystem)
    {
        parent::__construct($config);
        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritdoc}
     */
    public function getAbsolutePath(): string
    {
        return $this->getUrl();
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl(): string
    {
        /** @var Cloud $filesystem */
        $filesystem = $this->filesystem->disk($this->media->disk);
        return $filesystem->url($this->media->getDiskPath());
    }

}
