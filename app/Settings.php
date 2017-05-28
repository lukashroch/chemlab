<?php

namespace ChemLab;

use Exception;

class Settings
{
    /**
     * The User instance.
     *
     * @var User
     */
    protected $user;

    /**
     * The list of settings.
     *
     * @var array
     */
    protected $settings = [];

    /**
     * Create a new settings instance.
     *
     * @param array $settings
     * @param User $user
     */
    public function __construct(array $settings, User $user)
    {
        $this->settings = $settings;
        $this->user = $user;
    }

    /**
     * Get default list of settings.
     *
     * @return array
     */
    public static function defaults()
    {
        return [
            'lang' => 'en',
            'listing' => 25,
            'allow-nmr' => 0,
            'notifications' => [
                'nmr-uploaded' => 0
            ]
        ];
    }

    /**
     * Retrieve the given setting.
     *
     * @param  string $key
     * @return string
     */
    public function get($key)
    {
        return array_get($this->settings, $key);
    }

    /**
     * Create and persist a new setting.
     *
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $nKey => $nValue) {
                array_set($this->settings, $nKey, $nValue);
            }
        } else
            array_set($this->settings, $key, $value);

        $this->persist();
    }

    /**
     * Determine if the given setting exists.
     *
     * @param  string $key
     * @return boolean
     */
    public function has($key)
    {
        return array_key_exists($key, $this->settings);
    }

    /**
     * Retrieve an array of all settings.
     *
     * @return array
     */
    public function all()
    {
        return $this->settings;
    }

    /**
     * Merge the given attributes with the current settings.
     * But do not assign any new settings.
     *
     * @param  array $attributes
     * @return mixed
     */
    public function merge(array $attributes)
    {
        $this->settings = array_merge(
            $this->settings,
            array_only($attributes, array_keys($this->settings))
        );

        return $this->persist();
    }

    /**
     * Persist the settings.
     *
     * @return mixed
     */
    protected function persist()
    {
        return $this->user->update(['settings' => $this->settings]);
    }

    /**
     * Magic property access for settings.
     *
     * @param  string $key
     * @throws Exception
     * @return
     */
    public function __get($key)
    {
        if ($this->has($key)) {
            return $this->get($key);
        }

        throw new Exception("The {$key} setting does not exist.");
    }
}