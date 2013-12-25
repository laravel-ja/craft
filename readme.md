## Laravel installer Japanese version

This is a fork from laravel/craft to get ZIP file from laravel-ja/laravel repository. Also added some more functionaries.

You can get phar file from <http://laravel4.qanxen.info/laravelja.phar>.

Now beta version.

### Usage

Same as original Laravel installer basically. Do more also automatically...

* To generate application key, execute key:generate command.
* Set config(and language if you wanted) from '.laravel.install.conf.php' on your home directory.
* By using .laravel.install.conf.php, set automatically machine name to detect local environment.

To identify using 'laravelja', but you can rename to favored command name.

**Install offical English version**

    laravelja new Install-path

**Install Japanese version**

    laravelja new Install-path --lang ja
    laravelja new Install-path-l ja

**Set 757 permission with files on app/storage

    laravelja --set-mode new Install-path
    laravelja -s new Install-path

**Remove comments and empty lines from config/language files, routes.php and fileters.php**

    laravelja --remove-comments new Install-path
    laravelja -r new Install-path

**Remove comments from PHP files without vendor directory, and remove all md file.

    laravelja -minify new Install-path
    laravelja -m new Install-path

**Specify zip file**

    laravelja new Install-path --from http://example.com/some.zip
    laravelja new Install-path -f http://example.com/some.zip

**So, useful for experienced users**

    laravelja -s -r new Install-path

**Option -r -s -m can apllay to existed project folder**

By using set command.

    laravelja -s -r set Exist-Project
    laravelja -m set Exist-Project

**Self Update**

    laravelja selfupdate

#### .laravel.install.conf.php

See a sample :

~~~
<?php

return array(
    // Simply set.
    'app/config/app.php' => array(
        'locale' => 'ja',
    ),
    // All 'user' and 'password' set to 'root'
    // (We knew we must not.. but everyone love this.:D)
    // Then replace only mysql => password to 'OhMySQL'.
    'app/config/database.php' => array(
        'default' => 'sqlite',
        'user' => 'root',
        'password' => 'root',
        'mysql.password' => 'OhMySQL',
    ),
    // Simple one.
    'app/config/workbench.php' => array(
        'name' => 'HiroKws',
        'email' => 'hirokws@gmail.com',
    ),
    // Can cange lang item also.
    // This sample only for ja lang file.
    'app/lang/ja/reminders.php' => array(
        'sent' => 'パスワードリセットメールを送信しました。確認して下さい',
    ),
    // This is one of trick to set your machine name.
    'bootstrap/start.php' => array(
        'local' => "array('".gethostname()."')"
    )

);
~~~

First level key is file name. Second lelvel key is config/lang key.

This functinaly implimented by reglex replacement. So if you specify simple key item, replace all vaule matched. (As 'user' and 'password' above sample.) To specify more use comma sepereted syntax. (If use 'key1.key2', first try to find `'key1'=>`, then search `'key2' =>`, then replace fallowing strings. So this dosen't mean pure array structure, just only strings order.)

So this work for present config/lang files installed with Laravel4.1, but not for all kind of PHP setting files.

## 日本語版

公式と同じように使用できます。公式はインストールするだけですが、この拡張版は自動的に以下の設定を行います。

* アプリケーションキーを設定するために、Artisanコマンドラインでkey:generateを実行します。
* ホームディレクトリーに設置した`.laravel.install.conf.php`ファイルを読み込み、config/lang下のファイルを設定します。
* .laravel.install.conf.phpファイルの設定により、local動作環境を設定するための、マシン名を自動で指定できます。

### 使い方

**公式英語版のインストール**

    laravelja new インストールパス

**日本語版のインストール**

    laravelja new インストールパス -l ja

**757パーミッションをapp/storage下のディレクトリーに付加**

    laravelja -s new インストールバス

**routes.php、fileters.php、設定／言語ファイルのコメントを外す**

    laravelja -r new インストールパス

**vendorディレクトリー以外のPHPファイルからコメントを削除し、Markdownファイルを削除する**

    laravelja -minify new Install-path
    laravelja -m new Install-path

**ベテランさん向け**

日本語の言語ファイル（app/lang/jaを含む）を取り込み、mdファイルを削除、Vendor以外のPHPファイルのコメントを削除する。

    laravelja -s -m new インストールパス -l ja

**ZIPファイルの読み込み先指定**

オリジナルなZIPファイルを指定し、インストールすることも可能です。

    laravelja new インストールパス -f ZIPファイル

例：

    laravelja new new-project -f http://example.com/special.zip

**既存のプロジェクトに設定**

自前のリポからgit cloneしたり、手元にお気に入りの初期パッケージを持っている場合もあるでしょう。そうした、既存のプロジェクトからコメントを外したりできます。

    laravelja -s -m set 既存のディレクトリー -l ja
    laravelja -r set 既存のディレクトリー

`-l`オプションはメッセージの言語の指定になります。`-f`オプションは使用できません。


**インストーラーのアップデート**

この日本語版は自分自身をアップデートします。定期的に実行して下さい。（一度機能が落ち着いたら、もう頻繁にアップデートはしません。）

    laravelja selfupdate -l ja

####　.laravel.install.conf.php

ホームディレクトリーに設置して下さい。(Windowns環境のコードは入れてありますが、テストしていません。)


~~~
<?php

return array(
    // 単純な設定

    'app/config/app.php' => array(
        'locale' => 'ja',
    ),

    // 'user'と'password'は全アイテム'root'に設定。
    // そのあとに、mysql => passwordだけを'OhMySQL'に設定

    'app/config/database.php' => array(
        'default' => 'sqlite',
        'user' => 'root',
        'password' => 'root',
        'mysql.password' => 'OhMySQL',
    ),

    // これも単純な例です。
    'app/config/workbench.php' => array(
        'name' => 'HiroKws',
        'email' => 'hirokws@gmail.com',
    ),

    // 言語ファイルも設定ファイルと同じ形式なため、変更できます。
    'app/lang/ja/reminders.php' => array(
        'sent' => 'パスワードリセットメールを送信しました。確認して下さい',
    ),

    // 設定ファイルではありませんが、配列で指定しているため、
    // 'local'動作環境時のマシン名（ホスト名）を設定可能です。
       'bootstrap/start.php' => array(
        'local' => "array('".gethostname()."')"
    )
);
~~~~

アイテムの置換えは正規表現で行っています。そのためキーは純粋に配列のレベルを表すものではありません。例えば、`key1.key2`は、まず`'key1'=>`を探し、その後の`'key2'=>`を見つけ、そのアイテムを変更します。あくまでもファイル中に現れる順番で一致するものを探すだけです。コメントにコードが含まれていたりすると上手く動作しない場合もありますが、現在のLaravel4.1に含まれている設定／言語ファイルでは、それなりに使用できます。

キーに一致する項目全部を変更します。例えば上記では、database.phpの中の`root`と`password`を全部`root`に変更しています。その後に`mysql`の`password`だけを指定し、一つだけ変更しています。
