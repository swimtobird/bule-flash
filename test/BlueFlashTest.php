<?php
/**
 *
 * User: swimtobird
 * Date: 2020-10-23
 * Email: <swimtobird@gmail.com>
 */

namespace Swimtobird\BlueFlash;


use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use Swimtobird\BlueFlash;

class BlueFlashTest extends TestCase
{
    public function testGetMobile()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $blueFlash = new BlueFlash($_ENV['BULE_APP_ID'], $_ENV['BULE_APP_KEY'], 'A1-RWWvEh6xLpf6lpBmq_eUpUr1cwXQI80pmCtx3goRjaxmG0mNDExG_-G613293wI_Zjc_r17PYyVM3hs6-XKQJKpgqLWCvtd-Kw9OXU7cz8RYJYTctYnvYc2kwbjcaiRmribEbUtgfoI9ryUN-4yfJKyEbwBqn3Q25qORDPNQ2QNBz0hOYySlBMSILfkO8vCIkjs0Qc16XfQAkFwD-itOVnk5WRqc3lH4cvXfmjJNHY4=');

        $this->assertNotEmpty($blueFlash->getMobile());
    }
}