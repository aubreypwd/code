<?php
/**
 * Get a line from a file.
 *
 * @package  aubreypwd/code
 * @since  Thursday, October 18, 2018
 */

// From https://joshtronic.com/2016/10/09/reading-a-specific-line-from-a-file-with-php/ .
$spl = new SplFileObject( '/path/to/huge/file.txt' );
$spl->seek( 1499 ); // Zero-based numbering.
$line_content = $spl->current();
