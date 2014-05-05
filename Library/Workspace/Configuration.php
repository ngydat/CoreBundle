<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\CoreBundle\Library\Workspace;

use \RuntimeException;
use Symfony\Component\Yaml\Yaml;
use Claroline\CoreBundle\Library\Transfert\Resolver;

class Configuration
{
    const TYPE_SIMPLE = 'Claroline\CoreBundle\Entity\Workspace\SimpleWorkspace';
    const TYPE_AGGREGATOR = 'Claroline\CoreBundle\Entity\Workspace\AggregatorWorkspace';

    private $workspaceType;
    private $workspaceName;
    private $workspaceCode;
    private $workspaceDescription;
    private $displayable = false;
    private $selfRegistration = false;
    private $selfUnregistration = false;
    private $templateFile;
    private $extractPath;

    public function __construct($path, $full = true)
    {
        if ($full) {
            $this->templateFile = $path;
            $this->workspaceType = self::TYPE_SIMPLE;
            $archive = new \ZipArchive();

            if (true === $code = $archive->open($path)) {

                $extractPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid();
                $this->setExtractPath($extractPath);
                $archive = new \ZipArchive();

                if ($archive->open($path) === TRUE) {
                    $archive->extractTo($extractPath);
                    $archive->close();
                }

                $resolver = new Resolver($extractPath);
                $this->data = $resolver->resolve();

            } else {
                throw new \Exception(
                    "Couldn't open template archive '{$path}' (error {$code})"
                );
            }
        }
    }

    /**
     * @todo this method is useless (constructor should be enough now)
     */
    public static function fromTemplate($templateFile)
    {
        return new self($templateFile);
    }

    public function getArchive()
    {
        return $this->templateFile;
    }

    public function setWorkspaceType($type)
    {
        $this->workspaceType = $type;
    }

    public function getWorkspaceType()
    {
        return $this->workspaceType;
    }

    public function setWorkspaceName($name)
    {
        $this->workspaceName = $name;
    }

    public function getWorkspaceName()
    {
        return $this->workspaceName;
    }



    public function check()
    {
        if ($this->workspaceType != self::TYPE_SIMPLE && $this->workspaceType != self::TYPE_AGGREGATOR) {
            throw new RuntimeException("Unknown workspace type '{$this->workspaceType}'");
        }

        if (!is_string($this->workspaceName) || 0 === strlen($this->workspaceName)) {
            throw new RuntimeException('Workspace name must be a non empty string');
        }
    }

    public function setWorkspaceCode($workspaceCode)
    {
        $this->workspaceCode = $workspaceCode;
    }

    public function getWorkspaceCode()
    {
        return $this->workspaceCode;
    }

    public function setWorkspaceDescription($workspaceDescription)
    {
        $this->workspaceDescription = $workspaceDescription;
    }

    public function getWorkspaceDescription()
    {
        return $this->workspaceDescription;
    }

    public function setArchive($templateFile)
    {
        $this->templateFile = $templateFile;
    }

    public function setDisplayable($displayable)
    {
        $this->displayable = $displayable;
    }

    public function isDisplayable()
    {
        return $this->displayable;
    }

    public function setSelfRegistration($selfRegistration)
    {
        $this->selfRegistration = $selfRegistration;
    }

    public function getSelfRegistration()
    {
        return $this->selfRegistration;
    }

    public function setSelfUnregistration($selfUnregistration)
    {
        $this->selfUnregistration = $selfUnregistration;
    }

    public function getSelfUnregistration()
    {
        return $this->selfUnregistration;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setExtractPath($path)
    {
        $this->extractPath = $path;
    }

    public function getExtractPath()
    {
        return $this->extractPath;
    }
}
