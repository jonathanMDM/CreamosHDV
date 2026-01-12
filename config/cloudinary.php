<?php

/*
 * This file is part of the Cloudinary Laravel package.
 *
 * (c) Cloudinary Labs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Cloudinary settings. Cloudinary is a cloud 
    | service that offers a solution to a web application's entire image 
    | management pipeline. 
    |
    */

    'cloud_url' => env('CLOUDINARY_URL'),

    /**
    | Upload Preset
    |
    */
    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),

    /**
    | Notification URL
    |
    */
    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL'),

];
