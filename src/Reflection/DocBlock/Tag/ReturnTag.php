<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Code\Reflection\DocBlock\Tag;

use function explode;
use function preg_match;
use function preg_replace;
use function trim;

class ReturnTag implements TagInterface, PhpDocTypedTagInterface
{
    /**
     * @var array
     */
    protected $types = [];

    /**
     * @var string
     */
    protected $description;

    public function getName() : string
    {
        return 'return';
    }

    /**
     * @param  string $tagDocBlockLine
     */
    public function initialize($tagDocBlockLine) : void
    {
        $matches = [];
        if (! preg_match('#((?:[\w|\\\]+(?:\[\])*\|?)+)(?:\s+(.*))?#s', $tagDocBlockLine, $matches)) {
            return;
        }

        $this->types = explode('|', $matches[1]);

        if (isset($matches[2])) {
            $this->description = trim(preg_replace('#\s+#', ' ', $matches[2]));
        }
    }

    /**
     * @deprecated 2.0.4 use getTypes instead
     */
    public function getType() : string
    {
        if (empty($this->types)) {
            return '';
        }

        return $this->types[0];
    }

    public function getTypes()
    {
        return $this->types;
    }

    public function getDescription() : ?string
    {
        return $this->description;
    }
}
