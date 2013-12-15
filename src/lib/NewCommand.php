<?php namespace Laravel\Craft;

use ZipArchive;
use Guzzle\Http\Client as HttpClient;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as BaseCommand;

class NewCommand extends BaseCommand {

	/**
	 * Configure the console command.
	 *
	 * @return void
	 */
	protected function configure()
	{
		$this->setName('new')
			 ->setDescription('Laravelアプリケーション作成')
			 ->addArgument('name', InputArgument::REQUIRED, 'The name of the application')
             ->addOption( 'set-mode', 's', InputOption::VALUE_NONE, 'ストレージのパーミッション設定', null);
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$directory = getcwd().'/'.$input->getArgument('name');

		if (is_dir($directory))
		{
			$output->writeln('<error>既にアプリケーションのフォルダーが存在します。</error>'); exit(1);
		}

		$output->writeln('<info>作成中…</info>');

		// Creaqte the ZIP file name...
		$zipFile = getcwd().'/laravel_'.md5(time().uniqid()).'.zip';

		// Download the latest Laravel archive...
		$client = new HttpClient;
		$client->get('http://kore1server.com/laravel-craft.zip')->setResponseBody($zipFile)->send();

		// Create the application directory...
		mkdir($directory);

		// Unzip the Laravel archive into the application directory...
		$archive = new ZipArchive;
		$archive->open($zipFile);
		$archive->extractTo($directory);
		$archive->close();

		// Delete the Laravel archive...
		@chmod($zipFile, 0777);
		@unlink($zipFile);

        // Set permissions to directories under app/storage directory.
        if ($input->getOption( 'set-mode'))
        {
            @chmod(rtrim($directory, '/').'/app/storage/cache', 0757);
            @chmod(rtrim($directory, '/').'/app/storage/logs', 0757);
            @chmod(rtrim($directory, '/').'/app/storage/meta', 0757);
            @chmod(rtrim($directory, '/').'/app/storage/sessions', 0757);
            @chmod(rtrim($directory, '/').'/app/storage/views', 0757);
            $output->writeln('<comment>app/storage下のディレクトリーのパーミッションを0757に設定しました。</comment>');
        }

        // Execute key generation command.
        $generateCommand = 'php '.rtrim($directory, '/').'/artisan key:generate';
        exec($generateCommand, $stdout, $return);
        if ($return != 0)
        {
            $output->writeln("<error>'php artisan key:generate'コマンドが実行できませんでした。</error>");
            $output->writeln($stdout);
        }
        else
        {
            $output->writeln('<comment>アプリケーションキーを生成しました。</comment>');
        }

		$output->writeln('<comment>準備完了！どうぞ、すごいものを作って下さい。</comment>');
	}

}
