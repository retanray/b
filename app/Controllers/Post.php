<?php
namespace App\Controllers;

use App\helpers\LoginHelper;
use CodeIgniter\Controller;

use App\Models\Posts;
use App\Services\PostService;

class Post extends Controller
{
    public function create() {
      if (LoginHelper::isLogin() === false) { // (1)
        return $this->response->redirect("/post");
      }      

      if($this->request->getMethod() === "get"){
        return view("/post/create");
      }

      list($create_success, $post_id, $errors) =
        PostService::factory()
        ->create(
          $this->request->getPost(),
          LoginHelper::memberId()
        );
      if ($create_success){
        return $this->response->redirect("/post/show/$post_id");
      }

      $postEntity = new PostEntity();
      $postEntity->fill($this->request->getPost());
      return view("/post/create", [
        'post_data' => $postEntity,
        'errors' => $errors
      ]);
    }

    public function show($post_id){
      $model = new Posts();
      $post = $model->find($post_id);
      if(!$post){
        return $this->response->redirect("/post");
      }

      $isAuthor = LoginHelper::isLogin() && $post['author'] == LoginHelper::memberId();

      return view("/post/show", [
        'post' => $post,
        'isAuthor' => $isAuthor
      ]);
    }

    public function edit($post_id){
      if (LoginHelper::isLogin() === false) { // (1)
        return $this->response->redirect("/post");
      }

      $model = new Posts();
      $post = $model->find($post_id);
      
      if(!$post){
        return $this->response->redirect("/post");
      } 

      if ($post['author'] != LoginHelper::memberId()){ // (1)
          return $this->response->redirect("/post");
      }


      if($this->request->getMethod() === "get"){
        return view("/post/create", [
          'post_data' => $post
        ]);
      }

      //$isSuccess = $model->update($post_id, $this->request->getPost());
      
      //$data = $this->add_input_markdown();
      //$isSuccess = $model->update($post_id, $data);
      $isSuccess = PostService::factory()->edit($post_id, $this->request->getPost());
      if ($isSuccess[0]){
          $this->response->redirect("/post/show/$post_id");
      }else{
          return view("/post/create", [
              'post_data' => $this->request->getPost(),
              'errors' => $isSuccess[2]
          ]);
      }
    }

    public function delete(){
      if (LoginHelper::isLogin() === false) { // (1)
        return $this->response->redirect("/post");
      }

      if($this->request->getMethod() !== "post"){
        return $this->response->redirect("/post");
      }
      $post_id = $this->request->getPost('post_id');

      $model = new Posts();
      $post = $model->find($post_id);
      if(!$post){          
        return $this->response->redirect("/post");
      }        

      if ($post['author'] != LoginHelper::memberId()){
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
          'pager' => $pager,
          'isLogin' => LoginHelper::isLogin()
      ]);
    }

    // private function add_input_markdown(){ // (1)
    //     $data = $this->request->getPost();
    //     if (array_key_exists("content", $data)){  // (2)
    //         $content = $data['content'];
    //         $content = str_replace(PHP_EOL, "  " . PHP_EOL, $content); // (3)
    //         $data['html_content'] = Markdown::defaultTransform($content);  // (4)
    //     }

    //     return $data;
    // }
}
