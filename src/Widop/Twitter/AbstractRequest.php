<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\Twitter;

use Widop\Twitter\OAuth\OAuthRequest;
use Widop\Twitter\Options\OptionBag;
use Widop\Twitter\Options\OptionInterface;

/**
 * Abstract streaming request.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class AbstractRequest
{
    /** @var \Widop\Twitter\Options\OptionBag */
    private $optionBag;

    /**
     * Creates an abstract streaming request.
     */
    public function __construct()
    {
        $this->optionBag = new OptionBag();

        $this->configureOptionBag($this->optionBag);
    }

    /**
     * {@inheritdoc}
     */
    public function __call($method, $arguments)
    {
        switch (substr($method, 0, 3)) {
            case 'get':
                return $this->optionBag[$this->convertMethodToOption($method)];

            case 'set':
                if (!array_key_exists(0, $arguments)) {
                    throw new \InvalidArgumentException(sprintf(
                        'You must specify an argument to the method "%s".',
                        $method
                    ));
                }

                $this->optionBag[$this->convertMethodToOption($method)] = $arguments[0];
                break;

            default:
                throw new \Exception(sprintf('The method "%s" does not exist.', $method));
        }
    }

    /**
     * Creates an OAuth request according to the current request.
     *
     * @return \Widop\Twitter\OAuth\OAuthRequest The OAuth request.
     */
    public function createOAuthRequest()
    {
        $this->validateOptionBag($this->optionBag);

        $request = new OAuthRequest();
        $request->setPath($this->getPath());
        $request->setMethod($this->getMethod());

        foreach ($this->optionBag as $option) {
            if ($option->getValue() === null) {
                continue;
            }

            switch ($option->getType()) {
                case OptionInterface::TYPE_PATH:
                    $request->setPathParameter(':'.$option->getName(), $option->getValue());
                    break;

                case OptionInterface::TYPE_GET:
                    $request->setGetParameter($option->getName(), $option->getValue());
                    break;

                case OptionInterface::TYPE_POST:
                    $request->setPostParameter($option->getName(), $option->getValue());
                    break;
            }
        }

        return $request;
    }

    /**
     * Configures the option bag.
     *
     * @param \Widop\Twitter\Options\OptionBag $optionBag The option bag.
     */
    protected function configureOptionBag(OptionBag $optionBag)
    {

    }

    /**
     * Gets the request path.
     *
     * @return string The request path.
     */
    abstract protected function getPath();

    /**
     * Validates the option bag.
     *
     * @param \Widop\Twitter\Options\OptionBag $optionBag The option bag.
     */
    protected function validateOptionBag(OptionBag $optionBag)
    {

    }

    /**
     * Gets the request method.
     *
     * @return string The request method.
     */
    protected function getMethod()
    {
        return 'GET';
    }

    /**
     * Converts the method name to an option.
     *
     * @param string $method The method name.
     *
     * @return string The option.
     */
    private function convertMethodToOption($method)
    {
        return preg_replace_callback(
            '/[A-Z]/',
            function($match) { return '_'.strtolower($match[0]); },
            lcfirst(substr($method, 3))
        );
    }
}
