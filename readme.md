## Laravel installer Japanese version

This is a fork from laravel/craft to get ZIP file from laravel-ja/laravel repository. Also added some more functionaries.

You can get phar file from <http://kore1server.com/laravelja.phar>.

Now before-unit-test version.

### Usage

Same as original Laravel installer basically. Except extended functionaries.

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


## 日本語版

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
    
