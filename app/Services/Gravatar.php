<?php

namespace App\Services;

use InvalidArgumentException;

class Gravatar
{
    public const string NOT_FOUND = '404';
    public const string MYSTERY_PERSON = 'mp';
    public const string IDENTICON = 'identicon';
    public const string MONSTERID = 'monsterid';
    public const string WAVATAR = 'wavatar';
    public const string RETRO = 'retro';
    public const string ROBOHASH = 'robohash';
    public const string BLANK = 'blank';

    private const string BASE_URL = 'https://www.gravatar.com/avatar/';

    public function __construct(public int $size = 64, public string $default_image_type = Gravatar::IDENTICON)
    {
        //
    }

    public function setSize(int $size)
    {
        $this->size = $size;

        return $this;
    }

    public function setDefaultImageType(string $default_image_type)
    {
        if (! in_array($default_image_type, [Gravatar::NOT_FOUND, Gravatar::MYSTERY_PERSON, Gravatar::IDENTICON, Gravatar::MONSTERID, Gravatar::WAVATAR, Gravatar::RETRO, Gravatar::ROBOHASH, Gravatar::BLANK])) {
            throw new InvalidArgumentException('Invalid default image type');
        }
        $this->default_image_type = $default_image_type;

        return $this;
    }

    public function get(string $email)
    {
        return self::BASE_URL . $this->getHash($email) . '?' . http_build_query([
            's' => htmlentities($this->size),
            'd' => htmlentities($this->default_image_type),
        ]);
    }

    private function getHash($email)
    {
        return hash('sha256', strtolower(trim($email)));
    }
}
