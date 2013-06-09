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

/**
 * Wrapper
 *
 * @author Bertrand Zuchuat <bertrand.zuchuat@gmail.com>
 */
class Wrapper implements WrapperInterface
{
    protected $config;
    protected $document;

    public function __construct(ConfigurationInterface $config)
    {
        $this->config = $config;
    }

    public function getConfiguration()
    {
        return $this->config;
    }

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

    public function addDocument(DocumentInterface $doc)
    {
        $this->document[$doc->getName()] = $doc;

        return $this;
    }

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

    public function execute()
    {
        ob_start();
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
            $command = sprintf('%s %s', $command, $doc->getPath());
            passthru($command);
            $content = ob_get_clean();
            if (in_array($this->config->getOutputFormat(), array('xml', 'html'))) {
                $this->loadDocument($doc, $content);
            } else {
                $doc->setContent($content);
            }
        }
    }

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
            $command .= ' --'.$this->metadataFlag();
        }

        $command .= sprintf(' --encoding=%s', $this->config->getOutputEncoding());

        return $command;
    }

    private function metadataFlag()
    {
        $flag = $this->config->getOutputMetadataFormat();
        if ($flag == 'text') {
            $flag = 'metadata';
        }

        return $flag;
    }
    
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
}