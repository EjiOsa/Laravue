# 写真投稿アプリケーション  
使用者はカメラマン（以下、Admin）と顧客（以下、User）を想定して作成しています。
Laravelの標準認証をマルチ認証に変更、AdminとUserを管理しています。各ページはvue .jsでSPAとしました。
Admin権限でUser登録や写真投稿、Userと写真のリレーションをします。
登録されたUserはUser用のページで認証後、紐付けされた写真一覧を閲覧可能になります。

## 環境設定
バックエンド： Laravel  
フロントエンド：Vue.js  
バリデーション：VeeValidate  
ルーティング：VueRouter  
UIコンポーネント：Vuetify  
データベース：MySQL

## ER図
schemespyで作成  
![](https://user-images.githubusercontent.com/4255233/56089520-2005c100-5ecf-11e9-8c1c-661d42f46815.jpg "")
## バックエンド
### マルチ認証

### API

## フロントエンドAdmin
Admin自体の登録・管理はアプリケーション提供者が実施しますのでphp tinkerで登録します。
ログイン後、右側ダイアログには各ページへのリンクがあります。
このダイアログはツールバーのハンバーガーアイコンで収納可能ですが、ログイン時は開いた状態で表示されます。


### User登録ページ
左にはNewUser（新規登録）ボタンがあり、登録されたUserは中央にカード形式でリスト表示されます。
Userリストは8Userづつページングされますが、8・16・32単位で変更可能です。
また、画面サイズによって表示単位が変更されます。

#### User登録・編集・削除ダイアログ
New Userボタン、または Userリスト内の編集アイコンを押すことで、画面右側にダイアログが開きます。  
NewUserでは空欄を、編集では編集対象のUser情報が記載されて開きます。  
入力内容に対しては必須項目やメール形式等のバリデーションが実装されています。
各ダイアログの登録・編集・削除ボタンを押すか、ダイアログ以外の場所をクリックすることでダイアログが閉じます。  

##### New Userダイアログ
新規登録となるため、ボタンは入力クリアボタンと登録ボタンが配置されています。
登録されるとUserリストにも自動で反映されます。
##### User編集ダイアログ
編集となるため、ボタンは入力クリアボタンと編集ボタン、User削除ボタンが配置されています。
編集途中でダイアログを閉じると編集内容はリセットされます。
編集または削除されるとUserリストにも自動で反映されます。

#### User詳細ダイアログ
Userリストのカードをダブルクリックすることで、画面中央にUser詳細ダイアログが開きます。
UserのID・名前・年齢・ユーザーに紐付いている写真が確認できます。
写真に関しては確認のみで、写真の登録や削除は別ページとなります。
ダイアログ閉鎖はcloseボタン、またはダイアログ以外をクリックすることで閉じます。

### イベント登録ページ
カメラマンと顧客を想定しています。
そのため撮影は結婚式や旅行等のイベント単位になると考えて、イベント単位での管理としました。イベント登録後にイベントへ写真の紐付けする流れとなっています。
User登録と同じ位置にNewEventボタンを配置しています。
イベントの削除はイベントリスト内の✖︎アイコンで削除可能です。削除は可能ですが、削除することで紐付けされた写真やUserとの紐付けも削除されます。

#### イベント登録・イベント名編集ダイアログ
イベントを新規登録、またはイベントリストにある編集アイコンを押すことでダイアログが開きます。
新規登録時には登録時の日付をデフォルトで入れてあります。
#### イベント詳細ダイアログ
イベントリストをダブルクリックすることで、イベントへの写真登録用のダイアログが全画面で開きます。
3エリアに分けられており、上から写真選択エリア、写真登録スタンバイエリア、保持写真エリアです。
##### 写真選択エリア
写真選択ボタンによってファイル選択ウィンドウが開きます。画像を選択することで中央の写真登録スタンバイエリアに表示されます。
また写真選択エリアに画像をドラッグ&ドロップすることでも、中央の写真登録スタンバイエリアに表示されます。
##### 写真登録スタンバイエリア
イベントへの写真登録の確認をしています。
不要な写真の削除を単独またはチェックボックスで複数選択が可能です。
##### 保持写真エリア
イベントが保持している写真一覧が表示されています。
イベントから写真削除が可能で、単独削除または複数の選択削除が可能です。
イベントから写真が削除されると、紐付いているUserの写真も削除されます。
### 写真リレーションページ
左側にUser一覧、右側にイベント一覧が表示されています。
User一覧、イベント一覧、ともにダブルクリックで紐付いている写真が表示されます。
イベント内の写真をUserリストにドラッグ&ドロップすることでUserへ写真を登録します。


## フロントエンドUser
### 写真一覧ページ
#### 写真詳細ダイアログ
