<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentFormRequest;
use App\Models\Comment;


class CommentController extends Controller
{
    public function add(CommentFormRequest $request)
    {
        $comment = new Comment();
        $comment->fill($request->all());
        $comment->save();
        return response()->json([
            'success' => true,
            'data' => $comment
        ]);
    }

    // cập nhật 1 sp
    public function update(CommentFormRequest $request, $id)
    {
        $comment = Comment::find($id);
        if ($comment) {
            $comment->fill($request->all());
            $comment->save();
            return response()->json([
                'success' => true,
                'data' => $comment
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'comment không tồn tại'
            ]);
        }
    }

    // xóa mềm 1 sp
    public function delete($id)
    {
        $comment = Comment::find($id);
        if ($comment) {
            $comment->delete();
            return response()->json([
                'success' => true,
                'data' => $comment
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'comment không tồn tại'
            ]);
        }
    }

    // xóa vĩnh viễn 1 sp
    public function forceDelete($id)
    {
        $comment = Comment::withTrashed()->find($id);
        if ($comment) {
            $comment->forceDelete();
            return response()->json([
                'success' => true,
                'data' => $comment
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'comment không tồn tại'
            ]);
        }
    }

    // xóa vĩnh viễn tất cả các sp đã bị xóa mềm
    public function forceDeleteAll()
    {

        $comments = Comment::onlyTrashed()->get();
        foreach ($comments as $comment) {
            $comment->forceDelete();
        }
        return response()->json([
            'success' => true,
            'data' => []
        ]);
    }

    // danh sách các sp chưa bị xóa mềm
    public function index()
    {
        $comment = Comment::all();
        if ($comment->all()) {
            return response()->json([
                'success' => true,
                'data' => $comment
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'chưa có comment nào trong dữ liệu'
            ]);
        }
    }

    // danh sách các sp đã bị xóa mềm
    public function deleted()
    {
        $comment = Comment::onlyTrashed()->get();
        if ($comment->all()) {
            return response()->json([
                'success' => true,
                'data' => $comment
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'chưa có comment bị xóa trong dữ liệu'
            ]);
        }
    }

    // chi tiết 1 sp
    public function detail($id)
    {
        $comment = Comment::withTrashed()->find($id);
        if ($comment) {
            return response()->json([
                'success' => true,
                'data' => $comment
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Comment chưa tồn tại'
            ]);
        }
    }

    // backup 1 sp đã xóa mềm
    public function backupOne($id)
    {
        $comment = Comment::onlyTrashed()->find($id);
        if ($comment) {
            $comment->restore();
            return response()->json([
                'success' => true,
                'data' => $comment
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Comment chưa tồn tại'
            ]);
        }
    }
    // backup tất cả các sp đã xóa mềm
    public function backupAll()
    {
        $comment = Comment::onlyTrashed()->get();
        foreach ($comment as $cate) {
            $cate->restore();
        }
        return response()->json([
            'success' => true,
            'data' => $comment
        ]);
    }
}