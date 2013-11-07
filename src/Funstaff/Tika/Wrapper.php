<?php

/*
 * This file is part of the Tika package.
 *
 * (c) Bertrand Zuchuat <bertrand.zuchuat@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Funstaff\Tika;

use Psr\Log\LoggerInterface;
use Symfony\Component\Process\Process;

/**
 * Wrapper
 *
 * @author Bertrand Zuchuat <bertrand.zuchuat@gmail.com>
 */
class Wrapper implements WrapperInterface
{
    protected $logger;
    protected $config;
    protected $document;

    /**
     * Constructor
     *
     * @param Funstaff\Tika\ConfigurationInterface $config
     */
    public function __construct(ConfigurationInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Get Configuration
     *
     * @return Funstaff\Tika\ConfigurationInterface
     */
    public function getConfiguration()
    {
        return $this->config;
    }

    /**
     * Set Logger
     *
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Set Parameter
     * Override default configuration
     *
     * @param string $name  configuration parameter
     * @param string $value
     *
     * @return Funstaff\Tika\Wrapper
     */
    public function setParameter($name, $value)
    {
        if (!isset($ref)) {
            $ref = new \ReflectionClass($this->config);
        }
        $function = sprintf('set%s', ucfirst($name));
        if (!$ref->hasMethod($function)) {
            throw new \InvalidArgumentException(sprintf(
                'The function "%s" does not exists on configuration',
                $name
            ));
        }
        $this->config->$function($value);

        return $this;
    }

    /**
     * Add document
     *
     * @param Funstaff\Tika\DocumentInterface
     *
     * @return Funstaff\Tika\Wrapper
     */
    public function addDocument(DocumentInterface $doc)
    {
        $this->document[$doc->getName()] = $doc;

        return $this;
    }

    /**
     * Get Document
     *
     * @param string|null $name name of document
     *
     * @return DocumentInterface or array
     */
    public function getDocument($name = null)
    {
        if ($name) {
            if (!array_key_exists($name, $this->document)) {
                throw new \InvalidArgumentException(sprintf(
                    'The document "%s" does not exist',
                    $name
                ));
            }

            return $this->document[$name];
        } else {
            return $this->document;
        }
    }

    /**
     * Execute
     *
     * @return Funstaff\Tika\Wrapper
     */
    public function execute()
    {
        $base = $this->generateCommand();
        foreach ($this->document as $name => $doc) {
            if ($doc->getPassword()) {
                $command = sprintf(
                            '%s --password=%s',
                            $base,
                            $doc->getPassword()
                );
            } else {
                $command = $base;
            }
            $command = sprintf('%s %s', $command, escapeshellarg($doc->getPath()));
            if ($this->logger) {
                $this->logger->addInfo(sprintf(
                'Tika command: "%s"',
                $command
                ));
            }

            $process = new Process($command);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new \InvalidArgumentException($process->getErrorOutput());
            }

            $content = $process->getIncrementalOutput();

            $doc->setRawContent($content);
            if ($this->config->getMetadataOnly()) {
                $this->loadMetadata($doc, $content);
            } else {
                if (in_array($this->config->getOutputFormat(), array('xml', 'html'))) {
                    $this->loadDocument($doc, $content);
                } else {
                    $doc->setContent($content);
                }
            }
        }

        return $this;
    }

    /**
     * Generate Command
     *
     * @return string $command
     */
    private function generateCommand()
    {
        $java = $this->config->getJavaBinaryPath() ? : 'java';
        $command = sprintf(
            '%s -jar %s',
            $java,
            $this->config->getTikaBinaryPath()
        );

        if (!$this->config->getMetadataOnly()) {
            $command .= ' --'.$this->config->getOutputFormat();
        } else {
            $command .= ' --json';
        }

        $command .= sprintf(' --encoding=%s', $this->config->getOutputEncoding());

        return $command;
    }

    /**
     * Load document
     *
     * @param DocumentInterface $doc
     * @param string $content
     */
    private function loadDocument($doc, $content)
    {
        $dom = new \DomDocument('1.0', $this->config->getOutputEncoding());
        if ($this->config->getOutputFormat() == 'xml') {
            $dom->loadXML($content);
        } else {
            $dom->loadHTML($content);
        }

        $metas = $dom->getElementsByTagName('meta');
        if ($metas) {
            $class = $this->config->getMetadataClass();
            $metadata = new $class();
            foreach ($metas as $meta) {
                $name = $meta->getAttribute('name');
                $value = $meta->getAttribute('content');
                $metadata->add($name, $value);
            }
            $doc->setMetadata($metadata);
        }

        $body = $dom->getElementsByTagName('body');
        if ($body) {
            $content = $body->item(0)->nodeValue;
            $doc->setContent($content);
        }
    }

    /**
     * load Metadata
     */
    private function loadMetadata($doc, $content)
    {
        $class = $this->config->getMetadataClass();
        $metadata = new $class();

        $metadatas = get_object_vars(json_decode($content));
        foreach ($metadatas as $name => $value) {
            $metadata->add($name, $value);
        }
        $doc->setMetadata($metadata);
    }
}
