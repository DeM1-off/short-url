<?php

namespace App\Services\ShortLink;

/**
 * Interface ShortLinkServiceInterface
 * @package App\Service\ShortLink
 */
interface ShortLinkServiceInterface
{


    /**
     * @param  url $request
     */
    public function addLink( $id,$timer);


    /**
     * @param str $code
     */
    public function showLinkAndAddStats($code,$timer);



     /**
     * @param str $check
     */
    public function deleteLink($text);

}