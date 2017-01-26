<?php
/**
 * Created by PhpStorm.
 * User: resation
 * Date: 26.01.17
 * Time: 14:08
 */

namespace App\Http\Controllers;


use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PostsController extends Controller
{
    public function get(Request $request)
    {
        $this->validate($request, [
            'on_page' => 'integer|min:1',
            'order_by' => 'in:item_id,title,created_at',
            'order_direction' => 'in:asc,desc',
            'post_type' => 'boolean'
        ]);
        $out = Post::whereUserId($this->user->id)
            ->whereIsDevelopmentMode($request->get('post_type') ?: 1)
            ->orderBy('item_id')
            ->take($request->get('on_page') ?: 15)
            ->get()
            ->map(function (Post $v) {
                return $v->prepareJsonData();
            });

        $orderBy = $request->get('order_by');
        if (!empty($orderBy)) {
            if ($request->get('order_direction') == 'desc') {
                $out = $out->sortByDesc($orderBy);
            } else {
                $out = $out->sortBy($orderBy);
            }
        }
        return $out;
    }

    public function add(Request $request)
    {
        $data = $this->validatePost($request);
        $post = new Post();
        $post->user_id = $this->user->id;
        $this->fillPost($data, $post);
        $post->saveOrFail();
        return ['status' => 'ok'];
    }

    /**
     * @param Request $request
     * @param int $id
     * @return array
     */
    public function edit(Request $request, $id)
    {
        $data = $this->validatePost($request);
        /** @var Post $post */
        $post = Post::whereItemId($id)->whereUserId($this->user->id)->firstOrFail();
        $this->fillPost($data, $post);
        $post->saveOrFail();
        return ['status' => 'ok'];
    }

    public function delete($id)
    {
        Post::whereItemId($id)->whereUserId($this->user->id)->firstOrFail()->delete();
        return ['status' => 'ok'];
    }

    /**
     * @param Request $request
     * @return Collection
     */
    private function validatePost(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'post_type' => 'required|boolean',
            'created_at' => 'date_format:Y-m-d H:i:s',
        ]);
        return collect($request->only('title', 'content', 'post_type', 'created_at'));
    }

    /**
     * @param Collection $data
     * @param Post $post
     */
    private function fillPost($data, &$post)
    {
        $post->props_json = $data->only('title', 'content')->toJson();
        $post->created_at = $data->get('created_at') ?: date('Y-m-d H:i:s');
        $post->is_development_mode = $data->get('post_type');
    }
}