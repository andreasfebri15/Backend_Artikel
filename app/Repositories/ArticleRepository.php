<?php

namespace App\Repositories;

use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticlesResource;
use App\Http\Resources\BrandResource;
use App\Models\Article;
use App\Models\Brand;

class ArticleRepository
{
    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function getArticleall($id = null)
    {
        if ($id == null) {
            // $response = ($this->article->all());
            $response = ArticlesResource::collection($this->article->withcount('comment')->withcount('like_article')->orderBy('created_at', 'desc')->get());
            // $response = ArticleResource::collection($this->article->withcount('comment')->withcount('like_article'))->get();
            // $response = BrandResource::collection($this->brand->withTrashed()->get());
            return $response;
        }
        $article = $this->article->withcount('comment')->withcount('like_article')->with('comment')->with('like_article')->find($id);

        $response = new ArticleResource($article);
        return $response;
    }


    public function getArticlebyuser_id($user_id = null)
    {

        $response = $this->article->where('user_id', $user_id)->withcount('comment')->withcount('like_article')->get();
        // $article = new ArticleResource($response);
        return $response;
    }

    public function StoreorUpdate($request)
    {

        if ($request->id !== null && !$this->article->find($request->id)) {
            throw new \Exception('Article not found', 404);
        }
        $data = $this->article->updateOrCreate(
            [
                'article_id' => $request->article_id
            ],
            [
                'user_id' => $request->user_id,
                'title' => $request->title,
                'description' => $request->description,
                'body' => $request->body
            ]
        );
        return $data;
    }

    public function delete($id)
    {
        $article = $this->article->find($id);
        if (!$article) {
            throw new \Exception('Article not found', 400);
        }
        $article->delete();
        return $article;
    }
}
