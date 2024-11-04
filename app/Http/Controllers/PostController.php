<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Stock;
use App\Models\Sales;
use DB;

//use Illuminate\Support\Facades\DB;


class PostController extends Controller
{
     # 投稿作成
    public function create(Request $request)
    {
        // リクエストからデータを取得
        $name = $request->input('name');
        $amount = $request->input('amount', 1);
        $price = 0;
    
        //Error check
        $name_check_resolt = ctype_alpha($name);
        
        if (strlen($name) > 8){
            return response()->json(['message' => 'ERROR']);
        }
    
        if (!$name_check_resolt) {
            return response()->json(['message' => 'ERROR']);
        }
    
        if (!is_int($amount)){
            return response()->json(['message' => 'ERROR']);
        }
        
        if ($amount <= 0){
            return response()->json(['message' => 'ERROR']);
        }

        /*
        // データの挿入または更新
        Post::updateOrCreate(
            ['name' => $name], // 検索条件
            ['amount' => $amount, 'price' => $price] // 更新または挿入するデータ
        );
        */
    
        DB::table('stock')->insert([
            'name' => $name,
            'amount' => $amount,
            'price' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        $results = DB::table('stock')
            ->select($name, DB::raw('SUM(amount) as total_amount'))
            ->groupBy('name')
            ->get();
    
        // 確認のため、全てのポストを取得
        //$afterposts = Post::all();

        // 各ポストをカスタマイズした形式で変換
        //$formattedPosts = $results->mapWithKeys(function ($post) {
        //    return [$post->name => $post->amount];
        //});

        // フォーマットされたデータを返す
        return response()->json($request);

        //return response()->json(['message' => 'Post saved successfully']);
        //return response()->json($aferdb);
    
        /*
    // リクエストから name を取得
    $name = $request->input('name');
    $newAmount = $request->input('amount');

    // 既存のレコードを name で検索
    $post = Post::where('name', $name)->first();

    if ($post) {
        $post = new Post();
        $post->name = $name;
        $post->amount = $newAmount;
        $post->price = 0; // priceを0に設定
        
        // レコードが存在する場合、amountを合計
        $post->amount = $newAmount;
        $post->updated_at = now();
    } else {
        // レコードが存在しない場合、新しいインスタンスを作成
        $post = new Post();
        $post->name = $name;
        $post->amount = $newAmount;
        $post->price = 0; // priceを0に設定
    }

    // レコードを保存
    $post->save();

    // 全てのポストを返す
    return response()->json($post);
    
    /*
    $post = new Post();
    $post->name = $request->input('name');
    $post->amount = $request->input('amount');
    //$post->name = 'A';
    //$post->amount = 10;
    $post->price = 0; // priceを0に設定
    $post->save();
    
    return response()->json(Post::all());
    /*
    // リクエストから `name`, `amount` を取得
    $name = $request->input('name');
    $amount = $request->input('amount');

    // `name` に基づいて既存の `Post` レコードを検索
    $post = Post::where('name', $name)->first();

    if ($post) {
        // レコードが存在する場合は、更新
        $post->amount = $amount;
        $post->price = 0; // `price` を 0 に設定
    } else {
        // レコードが存在しない場合は、新規作成
        $post = new Post();
        $post->name = $name;
        $post->amount = $amount;
        $post->price = 0; // `price` を 0 に設定
    }

    // レコードを保存
    $post->save();

    // 全ての `Post` レコードを返す
    return response()->json(Post::all());
    */
    }
 
    public function salescreate(Request $request)
    {
        /*
    $post = new Post();
    $post->name = $request->input('name');
    $post->amount = -1 * $request->input('amount');
    //$post->name = 'A';
    //$post->amount = 10;
    $post->price = $request->input('price');
    $post->save();
    
    $sales = new Sales();
    $sales->name = $request->input('name');
    $sales->sales = $request->input('price') * $request->input('amount');
    $sales->save();
    //$table->string('name');
    //$table->unsignedInteger('sales');
    
    return response()->json(Post::all());
    */
        // リクエストから `name` を取得
        $name = $request->input('name');
        // リクエストから `amount` と `price` を取得
        $amount = $request->input('amount',1);
        $price = $request->input('price',1);
    
        //Error check
        $name_check_resolt = ctype_alpha($name);
        
        if (strlen($name) > 8){
            return response()->json(['message' => 'ERROR']);
        }
    
        if (!$name_check_resolt) {
            return response()->json(['message' => 'ERROR']);
        }
    
        if (!is_int($amount)){
            return response()->json(['message' => 'ERROR']);
        }
        
        if ($amount <= 0){
            return response()->json(['message' => 'ERROR']);
        }
    
        if (!is_float($price) and !is_int($price) ){
            return response()->json(['message' => 'ERROR']);
        }
        
        if ($price <= 0){
            return response()->json(['message' => 'ERROR']);
        }
        
        $result = DB::table('stock')
            ->select('name', DB::raw('SUM(amount) as total_amount'))
            ->where('name', $name)
            ->groupBy('name')
            ->first();
            
        if ($result->total_amount < $amount){
            return response()->json(['message' => 'ERROR']);
        } 
        
    
        //DB::table('sales')->insert([
        DB::table('sales')->insert([
            'name' => $name,
            'sales' => $amount * $price,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        //DB::table('posts')->insert([
        DB::table('stock')->insert([
            'name' => $name,
            'amount' => $amount * -1,
            'price' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        // 現在の `Post` レコードを取得
        $sales = Sales::where('name', $name)->first();
        /*
    
    // 現在の `Post` レコードを取得
    $post = Post::where('name', $name)->first();
    
    if (!$post) {
        // レコードが存在しない場合の処理
        return response()->json(['message' => 'Post not found'], 404);
    }
    
    // 現在の `amount` から与えられた `amount` を引く
    $post->amount -= $amount;
    $post->price = $price; // `price` を更新
    $post->save();
    
    // `Sales` モデルのインスタンスを作成して保存
    $sales = new Sales();
    $sales->name = $name;
    $sales->sales = $price * $amount;
    $sales->save();
    */
        // 更新された `Post` レコードを返す
        return response()->json($request);
    }

    # 全件取得
    public function index()
    {
        // `posts` テーブルから `name` ごとに `amount` の合計を取得 
        //$results = DB::table('posts')
        $results = DB::table('stock')
            ->select('name', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('name')
            ->get();
    
        // `total_amount` が 0 でないポストだけをフィルタリング
        $filteredResults = $results->filter(function ($result) {
            return $result->total_amount > 0;
        });

        // 各ポストをカスタマイズした形式で変換
        $formattedResults = $filteredResults->mapWithKeys(function ($result) {
            return [$result->name => $result->total_amount];
        });

        // フォーマットされたデータを返す
        return response()->json($formattedResults);
    }
    
    # 全件取得
    public function salesIndex()
    {
        // `sales` テーブルから `sales` の合計を取得
        $totalSales = DB::table('sales')
            ->select(DB::raw('SUM(sales) as total_sales'))
            ->pluck('total_sales')
            ->first();
        
        #$formattedTotalSales = number_format($totalSales, $totalSales == floor($totalSales) ? 1 : 2);
        $formattedTotalSales = number_format($totalSales, $totalSales == floor($totalSales) ? 1 : 2, '.', '');


        // 合計額を返す
        return response()->json(['sales' => $formattedTotalSales]);
    }


    # 投稿表示
    public function show($name)
    {
        //Error check
        $name_check_resolt = ctype_alpha($name);
    
        if (!$name_check_resolt) {
            return response()->json(['message' => 'ERROR']);
        }
        
        
        // `posts` テーブルから `name` ごとに `amount` の合計を取得 
        //$result = DB::table('posts')
        $result = DB::table('stock')
            ->select('name', DB::raw('SUM(amount) as total_amount'))
            ->where('name', $name)
            ->groupBy('name')
            ->first();
    
        // レコードがない場合
        if (!$result) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        // 合計が 0 の場合
        //if ($result->total_amount == 0) {
        //    return response()->json(['message' => '0'], 404);
        //}

        // カスタマイズした形式でデータを返す
        $response = [
            $result->name => $result->total_amount
        ];

        return response()->json($response);
    }


    # 投稿編集
    public function update(Int $id, Request $request){
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->updated_at = now();
        $post->save();
        return response()->json($post);
    }

    # 投稿削除
    public function delete(){

        // すべてのレコードを取得
        //$posts = Post::all();

        // 取得したレコードが空でないか確認
        //if ($posts->isEmpty()) {
            // レコードがない場合のメッセージ
            //return response()->json(['message' => 'No posts to delete'], 200);
        //}

        //Stock::truncate(); // これで全レコードを削除
        //違う方法で検証
        DB::table('stock')->truncate();
        Sales::truncate();

        // 削除成功のメッセージを返す
        // 
        //return response()->json("");
    }
    
    //signup
    public function signup(Request $request)
    {
         // リクエストからデータを取得
        $name = $request->input('user_id');
        $pass = $request->input('password');
        
        DB::table('user')->insert([
            'user_id' => $name,
            'password' => $pass,
        ]);
        
        $response = [
        "message" => "Account successfully created",
            "user" => [
                "user_id" => $userId,
                "nickname" => $userId  // Nicknameはuser_idと同じ
            ]
        ];

            
        // フォーマットされたデータを返す
        return response()->json($response);
    
    }
    //getuserid
    //edituserid
    //close
}
