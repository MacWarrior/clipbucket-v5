<?php

namespace Tests\Video;

use PHPUnit\Framework\TestCase;

/**
 * Regression coverage for the authorization check that gates
 * plugins/editors_pick/front/ajax.php (and every other single-video display
 * path): `$vdetails && video_playable($vdetails)`. All scenarios run as an
 * anonymous, unauthenticated requester.
 */
class VideoPlayableAuthorizationTest extends TestCase
{
    protected function setUp(): void
    {
        $GLOBALS['__test_user_id'] = 0;
        $GLOBALS['__test_user_name'] = '';
        $GLOBALS['__test_configs'] = ['enable_age_restriction' => 'no'];
        $_POST = [];
    }

    private function makeVideo(array $overrides = []): array
    {
        return array_merge([
            'videoid' => 1,
            'userid' => 42,
            'status' => 'Successful',
            'broadcast' => 'public',
            'active' => 'yes',
            'video_password' => '',
            'video_users' => '',
        ], $overrides);
    }

    public function test_public_video_is_playable(): void
    {
        $video = $this->makeVideo(['broadcast' => 'public']);

        $this->assertTrue($video && video_playable($video));
    }

    public function test_private_video_denied_when_unauthenticated(): void
    {
        $video = $this->makeVideo(['broadcast' => 'private']);

        $this->assertFalse($video && video_playable($video));
    }

    public function test_logged_only_video_denied_when_unauthenticated(): void
    {
        $video = $this->makeVideo(['broadcast' => 'logged']);

        $this->assertFalse($video && video_playable($video));
    }

    public function test_inactive_video_denied(): void
    {
        $video = $this->makeVideo(['active' => 'no']);

        $this->assertFalse($video && video_playable($video));
    }

    public function test_nonexistent_video_short_circuits_before_playability_check(): void
    {
        // get_video_details() returns false for an id with no matching row,
        // which must short-circuit the endpoint's guard before video_playable() runs.
        $vdetails = false;

        $this->assertFalse($vdetails && video_playable($vdetails));
    }
}
