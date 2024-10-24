<?php

namespace App\Repositories;

use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Comment;
use App\Models\LikeArticle;

class LikeRepository
{
    protected $like;

    public function __construct(LikeArticle $like)
    {
        $this->like = $like;
    }

    public function getLike($id = null)
    {
        if ($id == null) {

            $response = ArticleResource::collection($this->like->all());
            // $response = BrandResource::collection($this->brand->withTrashed()->get());
            return $response;
        }
        $brands = $this->like->find($id);

        $response = new ArticleResource($brands);
        return $response;
    }

    // public function getArticlebyuser_id($user_id)
    // {

    //     $response = ArticleResource::collection($this->article->where('user_id', $user_id)->get());
    //     return $response;
    // }

    public function StoreorUpdate($request)
    {

        if ($request->id != null && !$this->like->find($request->id)) {
            throw new \Exception('Brand not found', 400);
        }
        $data = $this->like->updateOrCreate(
            [
                'like_id' => $request->id
            ],
            [
                'user_id' => $request->user_id,
                'article_id' => $request->article_id,
            ]
        );
        return $data;
    }

    public function delete($id)
    {
        $article = $this->like->find($id);
        if (!$article) {
            throw new \Exception('Article not found', 400);
        }
        $article->delete();
        return $article;
    }
}
