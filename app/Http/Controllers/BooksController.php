<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// 使うClassを宣言：自分で追加
use App\Models\Book; // Bookモデルを使えるようにする
use Illuminate\Support\Facades\Validator; // バリデーションを使えるようにする
use Illuminate\Support\Facades\Auth; //認証モデルを使用する

class BooksController extends Controller
{
    //コンストラクタ（サインイン後にのみ表示するロジック）追加
    //コンストラクタ （このクラスが呼ばれたら最初に処理をする）
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 本ダッシュボード表示
    public function index()
    {
        // $books = Book::orderBy('created_at', 'asc')->paginate(3);
        $books = Book::where('user_id', Auth::user()->id)->orderBy('created_at', 'asc')->paginate(3); //上の行を修正
        // ddd($books); //デバッグ用のddd関数
        return view('books', [
            'books' => $books
        ]);
    }

    //更新画面
    // public function edit(Book $books)
    // {
    //     return view('booksedit', [
    //         'book' => $books
    //     ]);
    // }

    //Auth実装後の更新画面（上記メソッドを修正）
    public function edit($book_id)
    {
        $books = Book::where('user_id', Auth::user()->id)->find($book_id);
        return view('booksedit', [
            'book' => $books
        ]);
    }

    //更新
    public function update(Request $request)
    {
        //バリデーション
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'item_name' => 'required|min:3|max:255',
            'item_number' => 'required|min:1|max:3',
            'item_amount' => 'required|max:6',
            'published' => 'required',
        ]);
        //バリデーション:エラー 
        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        //データ更新
        // $books = Book::find($request->id);
        $books = Book::where('user_id', Auth::user()->id)->find($request->id); //上の行を修正
        $books->item_name   = $request->item_name;
        $books->item_number = $request->item_number;
        $books->item_amount = $request->item_amount;
        $books->published   = $request->published;
        $books->save();
        return redirect('/');
    }

    //登録
    public function store(Request $request)
    {
        //バリデーション
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|min:3|max:255',
            'item_number' => 'required|min:1|max:3',
            'item_amount' => 'required|max:6',
            'published' => 'required',
        ]);
        //バリデーション:エラー 
        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        // ファイルアップロード処理
        $file = $request->file('item_img'); //file取得
        if (!empty($file)) {                //fileが空かチェック
            $filename = $file->getClientOriginalName();   //ファイル名を取得
            $move = $file->move('./upload/', $filename);  //ファイルを移動
        } else {
            $filename = "";
        }

        //Eloquentモデル（登録処理）
        $books = new Book;
        $books->user_id  = Auth::user()->id; //user_id用の追加コード
        $books->item_name = $request->item_name;
        $books->item_number = $request->item_number;
        $books->item_amount = $request->item_amount;
        $books->item_img = $filename; //画像ファイル
        $books->published = $request->published;
        $books->save();
        return redirect('/')->with('message', '本登録が完了しました'); // SESSION（Flashメッセージを追加）
    }

    //削除処理
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('/');
    }
}
