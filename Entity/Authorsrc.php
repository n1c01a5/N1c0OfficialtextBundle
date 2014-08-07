<?php

namespace N1c0\OfficialtextBundle\Entity;

use N1c0\OfficialtextBundle\Model\Authorsrc as AbstractAuthorsrc;

use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Hateoas\Relation(
 *     name = "self",
 *     href = @Hateoas\Route(
 *         "api_1_get_officialtext_authorsrc",
 *         parameters = { "id" = "expr(object.getOfficialtext().getId())", "authorsrcId" = "expr(object.getId())" },
 *         absolute = true
 *     )
 * )
 */
abstract class Authorsrc extends AbstractAuthorsrc
{
}
