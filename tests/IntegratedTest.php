<?php

namespace NetLinker\WideStore\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;

class IntegratedTest extends TestCase
{

    /**
     * Setup the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();
    }


    public function testDiskOvh()
    {
        Storage::disk('wide_store')->put('path/to/file.txt', 'content');
        $url = Storage::disk('wide_store')->url('path/to/file.txt');
        $this->assertTrue(true);
    }
}
