<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Posts;

class Post extends BaseController
{
    public function create() {
      if($this->request->getMethod() === "get"){
        return view("/post/create");
      }

      $model = new Posts();
      $post_id = $model->insert($this->request->getPost());

      if($post_id) {
        $this->response->redirect("/post/show/$post_id");
      } else {
        return view("/post/create", [
          'post_data' =>  $this->request->getPost(),
          'errors' => $model->errors()
        ]);
      }
    }

    public function show($post_id){
      $model = new Posts();
      $post = $model->find($post_id);
      if(!$post){
        return $this->response->redirect("/post");
      }

      return view("/post/show", [
        'post' => $post
      ]);
    }

    public function edit($post_id){
      $model = new Posts();
      $post = $model->find($post_id);
      if(!$post){
        return $this->response->redirect("/post");
      } 

      if($this->request->getMethod() === "get"){
        return view("/post/create", [
          'post_data' => $post
        ]);
      }

      $isSuccess = $model->update($post_id, $this->request->getPost());
      if ($isSuccess){
          $this->response->redirect("/post/show/$post_id");
      }else{
          return view("/post/create", [
              'post_data' => $this->request->getPost(),
              'errors' => $model->errors()
          ]);
      }
    }

    public function delete(){
      if($this->request->getMethod() !== "post"){
        return $this->response->redirect("/post");
      }
      $post_id = $this->request->getPost('post_id');

      $model = new Posts();
      $post = $model->find($post_id);
      if(!$post){          
        return $this->response->redirect("/post");
      }        

      $model->delete($post_id);
      return $this->response->redirect("/post");      
    }

    public function index()
    {    
      $model = new Posts();
      $post_query = $model->orderBy("created_at", "desc");
      $post_list = $model->paginate(10); // (1)
      $pager = $post_query->pager;
      $pager->setPath("/post");

      return view("post/index", [
          'post_list' => $post_list,
          'pager' => $pager
      ]);
    }
}
