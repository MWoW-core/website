<?php

namespace App;

use function fclose;
use function fwrite;
use function stream_get_meta_data;
use function tmpfile;

class SecureShellKey
{
    /**
     * @var resource
     */
    private $resource;

    public function __construct(string $content)
    {
        $this->resource = tmpfile();

        fwrite(
            $this->resource,
            $content
        );
    }

    public static function make(string $content)
    {
        return new static($content);
    }

    public function path(): string
    {
        return stream_get_meta_data($this->resource)['uri'];
    }

    public function __destruct()
    {
        fclose($this->resource);
    }
}
