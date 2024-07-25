<?php

use App\Services\Gravatar;

describe('Gravatar Unit Test', function () {

    $gravatar = new Gravatar;

    it('should return the correct gravatar url', function () use ($gravatar) {
        $email = fake()->email();

        $expected = 'https://www.gravatar.com/avatar/' . hash('sha256', strtolower(trim($email))) . '?' . http_build_query([
            's' => htmlentities($gravatar->size),
            'd' => htmlentities($gravatar->default_image_type),
        ]);

        expect($gravatar->get($email))->toBe($expected);
    });

    it('should throw invalid argument exception for invalid default image type', function () use ($gravatar) {
        $gravatar->setDefaultImageType('invalid');
    })->throws(\InvalidArgumentException::class);

    it('should set the default image type', function () use ($gravatar) {
        $default_image_type = Gravatar::NOT_FOUND;

        expect($gravatar->setDefaultImageType($default_image_type)->default_image_type)->toBe($default_image_type);
    });

    it('should return the correct gravatar url with custom size', function () use ($gravatar) {
        $email = fake()->email();
        $size = 100;

        $expected = 'https://www.gravatar.com/avatar/' . hash('sha256', strtolower(trim($email))) . '?' . http_build_query([
            's' => htmlentities($size),
            'd' => htmlentities($gravatar->default_image_type),
        ]);

        expect($gravatar->setSize($size)->get($email))->toBe($expected);
    });

});
