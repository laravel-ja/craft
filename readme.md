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

    laravelja --lang ja new Install-path
    laravelja -l ja new Install-path

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

## 日本語版

### 使い方

**公式英語版のインストール**

    laravelja new インストールパス

**日本語版のインストール**

    laravelja -l ja new インストールパス

**757パーミッションをapp/storage下のディレクトリーに付加**

    laravelja -s new インストールバス

**routes.php、fileters.php、設定／言語ファイルのコメントを外す**

    laravelja -r new インストールパス

**vendorディレクトリー以外のPHPファイルからコメントを削除し、Markdownファイルを削除する**

    laravelja -minify new Install-path
    laravelja -m new Install-path

**ベテランさん向け**

日本語の言語ファイル（app/lang/jaを含む）を取り込み、mdファイルを削除、Vendor以外のPHPファイルのコメントを削除する。

    laravelja -l ja -s -m new インストールパス

**ZIPファイルの読み込み先指定**

オリジナルなZIPファイルを指定し、インストールすることも可能です。

    laravel new インストールパス -f ZIPファイル

例：

    laravel new new-project -f http://example.com/special.zip


