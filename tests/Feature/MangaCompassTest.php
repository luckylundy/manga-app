<?php

use App\Models\User;
use App\Models\Bookmark;
use App\Models\Manga;

// トップページが表示されるか確認
test('トップページが表示される', function() {
    $response = $this->get('/');
    $response->assertStatus(200);
});

// 未ログイン状態でマイページにアクセスするとログインページに飛ばされるか確認
test('未ログイン状態でマイページにアクセスするとログインページに飛ばされる', function() {
    // 未ログインで/mypageにアクセス
    $response = $this->get('/mypage');
    // ログインページにリダイレクトされる
    $response->assertRedirect('/login');
});

// ログイン済みであればマイページにアクセスできるか確認
test('ログイン済みであればマイページにアクセスできる', function() {
    // ダミーユーザーを作成
    $user = User::factory()->create();
    // ダミーユーザーをログイン状態にする
    $this->actingAs($user);
    $response = $this->get('/mypage');
    $response->assertStatus(200);
});

// ブックマークを登録できるか確認
test('ブックマークを登録できる', function() {
    $user = User::factory()->create();
    $this->actingAs($user);
    // 漫画データを作成
    $manga = Manga::create([
        'mal_id' => 1,
        'title' => 'テスト漫画',
        'image_url' => 'https://example.com/image.jpg',
    ]);
    // ダミーユーザーがお気に入りに追加
    $response = $this->post('/bookmarks', [
        'mal_id' => $manga->mal_id,
        'type' => 'favorite',
    ]);
    // リダイレクトされるか確認
    $response->assertRedirect();
    // user_idが$userのidで、manga_idが1のデータがDBに存在するか確認
    $this->assertDatabaseHas('bookmarks', [
        'user_id' => $user->id,
        'manga_id' => $manga->id,
    ]);
});

// ブックマークを削除できるか確認
test('ブックマークを削除できる', function() {
    $user = User::factory()->create();
    $this->actingAs($user);
    $manga = Manga::create([
        'mal_id' => 1,
        'title' => 'テスト漫画',
        'image_url' => 'https://example.com/image.jpg',
    ]);
    $bookmark = Bookmark::create([
        'manga_id' => $manga->id,
        'user_id' => $user->id,
        'type' => 'favorite',
    ]);
    $response = $this->delete("/bookmarks/{$bookmark->id}");
    $response->assertRedirect();
    // DBにidが$bookmarkのidと合致するオブジェクトがないことを確認
    $this->assertDatabaseMissing('bookmarks', [
        'id' => $bookmark->id,
    ]);
});