<?php

/**
 * This file is part of phpab/phpab. (https://github.com/phpab/phpab)
 *
 * @link https://github.com/phpab/phpab for the canonical source repository
 * @copyright Copyright (c) 2015-2016 phpab. (https://github.com/phpab/)
 * @license https://raw.githubusercontent.com/phpab/phpab/master/LICENSE.md MIT
 */

namespace PhpAb\Storage\Adapter;

use Aura\Session\SessionFactory;

/**
 * Storage adapter based in Aura sessions.
 *
 * @package PhpAb
 */
class AuraSession implements AdapterInterface
{
    const SEGMENT_NAME = 'phpab';
    const KEY = 'data';

    /**
     * Segment where all data will be stored
     *
     * @var \Aura\Session\Segment
     */
    private $segment;
    /**
     * Segment name
     *
     * @var string
     */
    private $segmentName;
    /**
     * Internal array where participation data is stored
     *
     * @var array
     */
    private $data;

    /**
     * Initializes Session Adapter
     *
     * @param array $cookies Super Global Array
     * @param array $options
     */
    public function __construct(array $cookies = [], array $options = null)
    {
        $sessionFactory = new SessionFactory();

        $initialValues = empty($cookies) ? filter_input_array(INPUT_COOKIE) : $cookies;

        $session = $sessionFactory->newInstance(
            !$initialValues ? [] : $initialValues
        );

        $this->segmentName = isset($options['namespace']) ? $options['namespace'] : static::SEGMENT_NAME;

        $this->segment = $session->getSegment($this->segmentName);

        $this->data = is_null(
                $this->segment->get(static::KEY)) ? [] : $this->segment->get(static::KEY
        );
    }

    /**
     * {@inheritDoc}
     */
    public function has($identifier)
    {

        return array_key_exists($identifier, $this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function set($identifier, $participation)
    {
        $this->data[$identifier] = $participation;

        return $this->segment->set(static::KEY, $this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * {@inheritDoc}
     */
    public function clear()
    {
        $removed = $this->data;
        $this->data = [];
        $this->segment->set(static::KEY, $this->data);

        return $removed;
    }

    /**
     * {@inheritDoc}
     */
    public function get($identifier)
    {
        return $this->data[$identifier];
    }

    /**
     * {@inheritDoc}
     */
    public function remove($identifier)
    {
        $value = $this->data[$identifier];
        unset($this->data[$identifier]);
        $this->segment->set(static::KEY, $this->data);

        return $value;
    }
}
