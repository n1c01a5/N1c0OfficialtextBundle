<?php

/**
 * This file is chapter of the N1c0OfficieltextBundle package.
 *
 * (c)
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace N1c0\OfficialtextBundle\Markup;

/**
 * Interface to implement to bridge a Markup parser to
 * N1c0OfficieltextBundle.
 *
 * @author Wagner Nicolas <contact@wagner-nicolas.com>
 */
interface ParserInterface
{
    /**
     * Takes a markup string and returns raw html.
     *
     * @param  string $raw
     * @return string
     */
    public function parse($raw);
}
