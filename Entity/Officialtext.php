<?php

namespace N1c0\OfficialtextBundle\Entity;

use N1c0\OfficialtextBundle\Model\Officialtext as AbstractOfficialtext;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Serializer\XmlRoot("officialtext")
 *
 * @Hateoas\Relation(
 *     name = "self",
 *     href = @Hateoas\Route(
 *         "api_1_get_officialtext",
 *         parameters = { "id" = "expr(object.getId())" },
 *         absolute = true
 *     )
 * )
 */
abstract class Officialtext extends AbstractOfficialtext
{
}
