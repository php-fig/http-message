<?php

namespace Psr\Http\Message;

/**
 * Describes a late data stream.
 *
 * @see ./StreamInterface.php
 *
 * Typically, an instance of StreamInterface which doesn't requires an already
 * opened resource.
 *
 * It SHOULD be used in place of an simple StreamInterface to get an instance
 * (e.g. for an UploadedFileInterface), where the file is broken for any
 * reason, or just to avoid to open some files which aren't really used.
 */
interface LateStreamInterface
    extends StreamInterface
{
    /**
     * Returns a new stream built to open a resource, based on a filename,
     * with an optional mode.
     *
     * It doesn't know nor open any file, at this point.
     *
     * @param string $filename
     * @param string $mode
     * @return static
     */
    public function withFilename(string $filename, string $mode = 'r');

    /**
     * Returns a new stream built to open a temporary file resource.
     *
     * It doesn't know nor open any file, at this point.
     *
     * @return static
     */
    public function withTmpFile();

    /**
     * Returns a new stream built to wrap an opened resource handle.
     *
     * @param resource $resource
     * @return static
     */
    public function withResource(
        $resource
    );

    /**
     * Tries to open the resource (if needed)
     *
     * Implementers MUST define/override all the StreamInterface's methods to
     * call it before to do their job.
     *
     * @return $this
     */
    public function open();
}
