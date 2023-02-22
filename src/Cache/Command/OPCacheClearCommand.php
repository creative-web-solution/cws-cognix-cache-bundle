<?php

namespace Cws\Bundle\CognixCacheBundle\Cache\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Response;

class OPCacheClearCommand extends Command implements CommandInterface
{
    /** @var string */
    private $uri;

    public function __construct(string $uri, string $name = 'cognix:opcache:clear')
    {
        parent::__construct($name);

        $this->uri = $uri;
    }

    protected function configure(): void
    {
        $this
            ->addArgument(
                'php',
                InputArgument::OPTIONAL,
                'The php version (example: 8.2)',
                '8.2'
            )
            ->setDescription('Removing the cache of a Cognix-hosted server.')
            ->setHelp('This command allows you to clear opcache.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $phpVersion = $input->getArgument('php');
        $uri = sprintf('%s?%s', $this->uri, $phpVersion);

        $clearOpCache = $this->clearOpCacheFromUri($uri);

        if (self::COMMAND_FAILURE === $clearOpCache) {
            $output->writeln('<error>An error is occurred.</error>');

            return $clearOpCache;
        }

        $output->writeln('<info>OPCache is now cleared.</info>');

        return self::COMMAND_SUCCESS;
    }

    private function clearOpCacheFromUri(string $uri): int
    {
        try {
            $curlAction = curl_init($uri);
            curl_setopt($curlAction, CURLOPT_URL, $uri);
            curl_setopt($curlAction, CURLOPT_HEADER, 0);
            curl_setopt($curlAction, CURLOPT_RETURNTRANSFER, true);
            curl_exec($curlAction);
            $httpCode = curl_getinfo($curlAction, CURLINFO_HTTP_CODE);

            curl_close($curlAction);
        } catch (Exception $exception) {
            return self::COMMAND_FAILURE;
        }

        if (Response::HTTP_OK !== $httpCode) {
            return self::COMMAND_FAILURE;
        }

        return self::COMMAND_SUCCESS;
    }
}
