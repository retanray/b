<?php

namespace App\Services;

use App\Entities\PostsEntity;
use App\Models\Posts;

class PostService
{
    public function create($post_data, $memberId)
    {
        $postEntity = new PostsEntity();
        $postEntity->fill($post_data);
        $postEntity->author = $memberId;

        $postModel = new Posts();
        $post_id = $postModel->insert($postEntity);

        if ($post_id) {
            return [true, $post_id, []];
        }

        return [false, null, $postModel->errors()];
    }

    public function edit($post_id, $post_data)
    {
        $postEntity = new PostsEntity();
        $postEntity->fill($post_data);        

        $postModel = new Posts();
        $post_id = $postModel->update($post_id, $postEntity);

        if ($post_id) {
            return [true, $post_id, []];
        }

        return [false, null, $postModel->errors()];
    }

    private static $postService = null;

    public static function factory()
    {
        if (self::$postService === null) {
            self::$postService = new PostService();
        }

        return self::$postService;
    }
}