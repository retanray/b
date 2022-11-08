<?php

namespace service;

use App\Services\PostService;
use CodeIgniter\Test\CIDatabaseTestCase; // (1)

class PostTests extends CIDatabaseTestCase // (2)
{
    protected $migrate     = false;
    protected $migrateOnce = true;
    protected $refresh     = true;
    protected $namespace   = 'Tests\Support';

    public function setUp() :void // (3)
    {
        parent::setUp(); // (4)
    }

    public function tearDown() :void // (5)
    {
        parent::tearDown(); // (6)
    }

    public function test_글생성_성공(){ // (7)
        // given // (8)
        $post_data = [ // (9)
            'title' => '제목입니다.',
            'content' => '본문은 10글자 이상이죠?'
        ];

        $memberId = 1; // (10)

        // when // (11)
        list($result, $post_id, $errors) = PostService::factory()->create($post_data, $memberId); // (12)

        // then // (13)
        $this->assertTrue($result); // (14)
        $this->assertNotNull($post_id); // (15)
        $this->assertCount(0, $errors); // (16)
    }

    public function test_글수정_성공(){
        $post_data = [ // (9)
            'title' => '제목입니다.',
            'content' => '수정테스트11111111111?'
        ];
      
        // when // (11)
        list($result, $post_id, $errors) = PostService::factory()->edit(1, $post_data);
      
        // then // (13)
        $this->assertTrue($result); // (14)
        $this->assertNotNull($post_id); // (15)
        $this->assertCount(0, $errors); // (16)
    }
}