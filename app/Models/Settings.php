<?php

namespace ChemLab\Models;

use Exception;
use Illuminate\Support\Arr;

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
    protected $settings;

    /**
     * Create a new settings instance.
     *
     * @param array $settings
     * @param User $user
     */
    public function __construct(array $settings, User $user)
    {
        $this->settings = array_replace_recursive(static::defaults(), $settings);
        $this->user = $user;
    }

    /**
     * Get default list of settings.
     *
     * @return array
     */
    public static function defaults(): array
    {
        return [
            'lang' => 'en',
            'listing' => 25,
            'notifications' => []
        ];
    }

    /**
     * Create and persist a new setting.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $nKey => $nValue) {
                Arr::set($this->settings, $nKey, $nValue);
            }
        } else
            Arr::set($this->settings, $key, $value);

        $this->persist();
    }

    /**
     * Persist the settings.
     *
     * @return void
     */
    protected function persist()
    {
        $this->user->setAttribute('settings', $this->settings);
        $this->user->save();
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
     * @param array $attributes
     * @return void
     */
    public function merge(array $attributes)
    {
        $this->settings = array_merge(
            $this->settings,
            Arr::only($attributes, array_keys($this->settings))
        );

        $this->persist();
    }

    /**
     * Magic property access for settings.
     *
     * @param string $key
     * @return string
     * @throws Exception
     */
    public function __get($key)
    {
        if ($this->has($key)) {
            return $this->get($key);
        }

        throw new Exception("The {$key} setting does not exist.");
    }

    /**
     * Determine if the given setting exists.
     *
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        return array_key_exists($key, $this->settings);
    }

    /**
     * Retrieve the given setting.
     *
     * @param string $key
     * @return string
     */
    public function get($key)
    {
        return Arr::get($this->settings, $key);
    }
}
